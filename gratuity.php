<?php
define('PHPSCRIPT', 'gratuity');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/function_user.php';
$S = new S();
$S -> star();

if(!$_S['uid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
$_S['outback']=true;
$_GET['mod']=$_GET['mod']?$_GET['mod']:'topic';

$_S['setting']['mods']=dunserialize($_S['setting']['mods']);
if($_GET['mod']=='discuz'){
	loaddiscuz();
	
	$themetable='discuz_thread';
	$modurl='discuz.php?mod=view&tid='.$_GET['vid'];
	$modname='帖子';
	$theme=DZ::fetch_first("SELECT * FROM ".DZ::table('forum_thread')." WHERE `tid`='$_GET[vid]'");
	$log=DB::fetch_first("SELECT * FROM ".DB::table($themetable)." WHERE `tid`='$_GET[vid]'");
	
}else{
	$themetable=$_S['setting']['mods'][$_GET['mod']]['table'];
	$modurl=$_S['setting']['mods'][$_GET['mod']]['viewurl'].$_GET['vid'];
	$modname=$_S['setting']['mods'][$_GET['mod']]['name'];
	$theme=DB::fetch_first("SELECT * FROM ".DB::table($themetable)." WHERE `vid`='$_GET[vid]'");
	
}

if(!$theme){
	showmessage('要打赏的主题不存在');
}
if($_GET['ac']=='gratuity'){
	$navtitle='打赏';
	$my=getuser(array('common_user_count'),$_S['uid']);
	if($_GET['mod']=='discuz'){
		if(!$theme['authorid']){
			showmessage('对方为匿名不可打赏');
		}
		if($_S['member']['dzuid']==$theme['authorid']){
			showmessage('不能打赏自己');
		}
		$thisuser=DB::fetch_first("SELECT u.*,c.balance FROM ".DB::table('common_user')." u LEFT JOIN ".DB::table('common_user_count')." c ON c.uid=u.uid WHERE `dzuid`='$theme[authorid]'");	
		if(!$thisuser){
			showmessage('对方还未在小程序内激活账号无法收赏');
		}
	}else{
		if(!$theme['uid']){
			showmessage('对方为匿名不可打赏');
		}
		if($theme['uid']==$_S['uid']){
			showmessage('不能打赏自己');
		}
		$thisuser=getuser(array('common_user','common_user_count'),$theme['uid']);
	}
 
	getopenid();
	$signature=signature();
	$apilist='chooseWXPay';
	$noshar=true;


			
	if(checksubmit('submit')){
		if($_GET['payment']=='balance'){
			$s['money']=$_GET['money'];
			if(!$s['money']){
				showmessage('请选择打赏金额');
			}
			if($s['money']>$my['balance']*100){
				showmessage('您钱包余额不足,请更换其他支付方式');
			}
			$gid=insert('common_gratuity',array('mod'=>$_GET['mod'],'vid'=>$_GET['vid'],'uid'=>$_S['uid'],'money'=>$s['money'],'dateline'=>$_S['timestamp']));
			/*打赏*/
			$lid=makeid();
			$money=($my['balance']*100)-$s['money'];
			$relation=serialize(array('gid'=>$gid));
			insert('common_user_count_log',array('lid'=>$lid,'uid'=>$_S['uid'],'fild'=>'balance','arose'=>-$s['money'],'title'=>'打赏','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
			update('common_user_count',array('balance'=>$money),"uid='$_S[uid]'");
			/*收赏*/
			
			$lid=makeid();
			$money=($thisuser['balance']*100)+$s['money'];
			$relation=serialize(array('gid'=>$gid));
			insert('common_user_count_log',array('lid'=>$lid,'uid'=>$thisuser['uid'],'fild'=>'balance','arose'=>$s['money'],'title'=>$_S['member']['username'].'的打赏','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
			update('common_user_count',array('balance'=>$money),"uid='$thisuser[uid]'");
			/*count*/
			if($_GET['mod']=='discuz'){
				
				if($log){
					$number=$log['number']+1;
					$money=$log['money']+$s['money'];
					update($themetable,array('number'=>$number,'money'=>$money),"tid='$_GET[vid]'");
				}else{
					$number=1;
					$money=$s['money'];
					insert($themetable,array('tid'=>$_GET['vid'],'number'=>$number,'money'=>$money));
				}
			}else{
				$number=$theme['gratuity_number']+1;
				$money=$theme['gratuity_money']+$s['money'];
				update($themetable,array('gratuity_number'=>$number,'gratuity_money'=>$money),"vid='$_GET[vid]'");
			}
			sendnotice($thisuser['uid'],'gratuity','您发布的'.$modname.'<a href="'.$modurl.'" class="c8 load">'.$theme['subject'].'</a>被人打赏了',$_GET['vid']);
			upuser(4,$_S['uid']);
			//微信消息
			if($_S['setting']['wxnotice_shang'] && $thisuser['openid']){
				$wxnotice=array(
					'first'=>array('value'=>'您发表的文章被人打赏了'),
					'keyword1'=>array('value'=>$theme['subject']),
					'keyword2'=>array('value'=>($s['money']/100).'元'),
					'keyword3'=>array('value'=>smsdate($_S['timestamp'],'Y-m-d H:i:s')),
					'remark'=>array('value'=>'点击查看详情','color'=>'#3399ff'),
				);
				sendwxnotice($thisuser['uid'],$thisuser['openid'],$_S['setting']['wxnotice_shang'],$_S['setting']['siteurl'].'gratuity.php?mod='.$_GET['mod'].'&vid='.$_GET['vid'],$wxnotice);					
			}
			showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.gratuity(\''.$_GET['vid'].'\',\''.$number.'\',\''.$money.'\',\''.$_GET['mod'].'\');sendnotice(\'touid='.$thisuser['uid'].'+call=smsot.newnotice()\')},500);'));			
		}else{
			showmessage('错误的操作');
		}
	}	
}else{
  $navtitle='打赏记录';

	$sql['select'] = 'SELECT g.*';
	$sql['from'] ='FROM '.DB::table('common_gratuity').' g';
	$wherearr[] = "g.mod ='$_GET[mod]'";
	$wherearr[] = "g.vid ='$_GET[vid]'";
	
	$sql['select'] .= ',u.username,u.groupid,u.dzuid';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=g.uid";
	$sql['order']='ORDER BY g.dateline DESC';
	
	$select=select($sql,$wherearr,10);
	
	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			$value['money']=$value['money']/100;
			$list[$value['gid']]=$value;	
		}
	}
	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'gratuity.php?mod='.$_GET['mod'].'&vid='.$_GET['vid'].'&page='.$nextpage;
		
}
$title=$navtitle.'-'.$_S['setting']['sitename'];

include temp('gratuity');

?>