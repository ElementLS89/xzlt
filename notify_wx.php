<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
define('PHPSCRIPT', 'notify');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/wxpay.php';

$S = new S();
$S -> star(1,true);

if(!$_GET['echostr']){
	$_GET['formhash'] = $_S['hash'];
}

if(function_exists('file_get_contents')){
	$xml=file_get_contents("php://input");
}else{
	$xml=$GLOBALS["HTTP_RAW_POST_DATA"];
}
$post = xmlToArray($xml);

if($post['out_trade_no']){

	
	$paylog = DB::fetch_first('SELECT * FROM '.DB::table('common_paylog')." WHERE `tradeno`='".$post['out_trade_no']."'");
	
	$API['appid']=$paylog['paytype']=='mini'?$_S['setting']['mini_appid']:$_S['setting']['wx_appid'];
	$API['mchid']=$_S['setting']['wx_mchid'];
	$API['apikey']=$_S['setting']['wx_apikey'];
	
	
	if(checkSign($API['apikey'],$post) && $paylog){
		if($post['result_code'] == 'SUCCESS'){
			if($paylog['state']!='1'){
				$paylog['body']=dunserialize($paylog['body']);
				if($paylog['ac']=='recharge'){
					$user=getuser(array('common_user_count'),$paylog['uid']);
					$s['money']=$paylog['money']/100;
					$s['payment']='wechat';
					$relation=serialize(array('payment'=>$s['payment']));
					$lid=makeid();					
					if($paylog['body']['form']=='hongbao'){
						insert('common_user_count_log',array('lid'=>$lid,'uid'=>$paylog['uid'],'fild'=>'balance','arose'=>$s['money'],'title'=>'充值','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
						$money=$s['money']+$user['balance'];
						update('common_user_count',array('balance'=>$money),"uid='$paylog[uid]'");	
					}else{
						if($_S['setting']['recharge']){
							foreach(explode("\n",$_S['setting']['recharge']) as $v){
								list($chong,$song)=explode("=",$v);
								if($s['money']>=$chong){
									$per=trim($song)/trim($chong);
								}
							}
							if($per){
								$s['money']=round($s['money']*(1+$per),2);
							}		
						}

						insert('common_user_count_log',array('lid'=>$lid,'uid'=>$paylog['uid'],'fild'=>'gold','arose'=>$s['money'],'title'=>'充值','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
						$money=$s['money']+$user['gold'];
						update('common_user_count',array('gold'=>$money),"uid='$paylog[uid]'");						
					}

				}elseif($paylog['ac']=='topicpay'){
					if($paylog['body']['tid']){
						require_once './include/function_topic.php';
						$tid=$paylog['body']['tid'];
						$touid=getmanager($tid);
						if($touid){
							$thisuser=getuser(array('common_user_count'),$touid);
							$lid=makeid();
							$money=($thisuser['balance']*100)+$paylog['money'];
							$relation=serialize(array('idtye'=>'tid','id'=>$tid));
							insert('common_user_count_log',array('lid'=>$lid,'uid'=>$touid,'fild'=>'balance','arose'=>$paylog['money'],'title'=>$paylog['body']['form'].'付费加入小组','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
							update('common_user_count',array('balance'=>$money),"uid='$touid'");
							sendnotice($touid,'notice','<a href="user.php?uid='.$paylog['uid'].'" class="load c8">'.$paylog['body']['form'].'</a>申请加入小组，支付了'.($paylog['money']/100).'元');
						}
						//结果
						insert('topic_users',array('tid'=>$tid,'uid'=>$paylog['uid'],'level'=>1,'dateline'=>$_S['timestamp']));
						DB::query("UPDATE ".DB::table('topic')." SET `users`=`users`+'1' WHERE tid='$tid'");
					}else{
						$vid=$paylog['body']['vid'];
						$theme=DB::fetch_first("SELECT * FROM ".DB::table('topic_themes')." WHERE `vid`='$vid'");
						$thisuser=getuser(array('common_user_count'),$theme['uid']);
						$lid=makeid();
						$money=($thisuser['balance']*100)+$paylog['money'];
						$relation=serialize(array('idtye'=>'vid','id'=>$vid));
						insert('common_user_count_log',array('lid'=>$lid,'uid'=>$theme['uid'],'fild'=>'balance','arose'=>$paylog['money'],'title'=>$paylog['body']['form'].'付费阅读','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
						update('common_user_count',array('balance'=>$money),"uid='$theme[uid]'");
						//结果
						sendnotice($theme['uid'],'notice','<a href="user.php?uid='.$paylog['uid'].'" class="load c8">'.$paylog['body']['form'].'</a>付费阅读了您的文章，支付了'.($paylog['money']/100).'元');
						insert('topic_theme_log',array('vid'=>$vid,'uid'=>$paylog['uid'],'price'=>$paylog['money']/100,'dateline'=>$_S['timestamp']));
					}
				}elseif($paylog['ac']=='gratuity'){
					$vid=$paylog['body']['vid'];
					$mod=$paylog['body']['mod'];
					$gid=insert('common_gratuity',array('mod'=>$mod,'vid'=>$vid,'uid'=>$paylog['uid'],'money'=>$paylog['money'],'dateline'=>$_S['timestamp']));
					if($mod=='discuz'){
						loaddiscuz();
						$themetable='discuz_thread';
						$modurl='discuz.php?mod=view&tid='.$vid;
						$modname='帖子';
						$theme=DZ::fetch_first("SELECT * FROM ".DZ::table('forum_thread')." WHERE `tid`='$vid'");
						$thisuser=DB::fetch_first("SELECT u.*,c.balance FROM ".DB::table('common_user')." u LEFT JOIN ".DB::table('common_user_count')." c ON c.uid=u.uid WHERE `dzuid`='$theme[authorid]'");
						$thisuser['balance']=$thisuser['balance']/100;
					}else{
						/*打赏*/
						$_S['setting']['mods']=dunserialize($_S['setting']['mods']);
						$themetable=$_S['setting']['mods'][$mod]['table'];
						$modurl=$_S['setting']['mods'][$mod]['viewurl'].$vid;
						$modname=$_S['setting']['mods'][$mod]['name'];
						$theme=DB::fetch_first("SELECT * FROM ".DB::table($themetable)." WHERE `vid`='$vid'");
						$thisuser=getuser(array('common_user','common_user_count'),$theme['uid']);
					}
					$lid=makeid();
					$money=($thisuser['balance']*100)+$paylog['money'];
					$relation=serialize(array('gid'=>$gid));
					insert('common_user_count_log',array('lid'=>$lid,'uid'=>$thisuser['uid'],'fild'=>'balance','arose'=>$paylog['money'],'title'=>$paylog['body']['form'].'的打赏','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
					update('common_user_count',array('balance'=>$money),"uid='$thisuser[uid]'");	

					/*count*/
					if($mod=='discuz'){
						$log=DB::fetch_first("SELECT * FROM ".DB::table('discuz_thread')." WHERE `tid`='$vid'");
						if($log){
							$number=$log['number']+1;
							$money=$log['money']+$paylog['money'];
							update('discuz_thread',array('number'=>$number,'money'=>$money),"tid='$vid'");
						}else{
							$number=1;
							$money=$paylog['money'];
							insert('discuz_thread',array('tid'=>$vid,'number'=>$number,'money'=>$money));
						}
					}else{
						$number=$theme['gratuity_number']+1;
						$money=$theme['gratuity_money']+$paylog['money'];
						update('topic_themes',array('gratuity_number'=>$number,'gratuity_money'=>$money),"vid='$vid'");	
					}
					/*notice*/
			    sendnotice($thisuser['uid'],'gratuity','您发布的'.$modname.'<a href="'.$modurl.'" class="c8 load">'.$theme['subject'].'</a>被人打赏了',$vid);
					//微信消息
					if($_S['setting']['wxnotice_shang'] && $thisuser['openid']){
						$wxnotice=array(
							'first'=>array('value'=>'您发表的文章被人打赏了'),
							'keyword1'=>array('value'=>$theme['subject']),
							'keyword2'=>array('value'=>($paylog['money']/100).'元'),
							'keyword3'=>array('value'=>smsdate($_S['timestamp'],'Y-m-d H:i:s')),
							'remark'=>array('value'=>'点击查看详情','color'=>'#3399ff'),
						);
						sendwxnotice($thisuser['uid'],$thisuser['openid'],$_S['setting']['wxnotice_shang'],$_S['setting']['siteurl'].'gratuity.php?mod='.$mod.'&vid='.$vid,$wxnotice);					
					}
					upuser(4,$paylog['uid']);
				}elseif(stripos($paylog['ac'],":")!== false){
					$hack=explode(':',$paylog['ac']);
					require_once './hack/'.$hack[0].'/notify.php';
				}
				update('common_paylog',array('state'=>'1'),"tradeno='$post[out_trade_no]'");
			}
			$return = array();
			$return['return_code'] = 'SUCCESS';
			$return['return_msg'] = 'ok';
		}else{
			$return = array();
			$return['return_code'] = 'FAIL';
			$return['return_msg'] = 'ERROR';
		}
		echo arrayToXml($return);
	}else{
		//error log
	}
}else{
	//insert('test',array('content'=>'没有接收到数据'));
}
?>