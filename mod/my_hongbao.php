<?php
if(!defined('IN_SMSOT')) {
	exit;
}
require_once './include/function_user.php';
require_once './include/function_talk.php';
require_once './include/json.php';

$my=getuser(array('common_user_count'),$_S['uid']);

if($_GET['touid']){
	$navtitle='发红包';
	$title=$navtitle.'-'.$_S['setting']['sitename'];
	$backurl='my.php?mod=message';
	if(checksubmit('submit')){
		$s['hid']=makeid();
    $s['message']=trim($_GET['message']);
		$s['password']=trim($_GET['password']);
		$s['uid']=$_S['uid'];
		$s['surplus']=$s['money']=abs(intval($_GET['money']))*100;
		$s['touid']=$_GET['touid'];
		$s['dateline']=$_S['timestamp'];
		if($s['money']<0){
			showmessage('请输入正确的红包金额');
		}
		if($s['money']>$my['balance']*100){
			showmessage('您钱包余额不足请充值','my.php?mod=account&form=hongbao');
		}
		$tid=maketid(array($_S['uid'],$_GET['touid']));
		$checksend=checksend($_GET['tid']);
		$tousername=$checksend[0];
		$openid=$checksend[1];
		/*log*/
		$lid=makeid();
		$money=($my['balance']*100)-$s['money'];
		$relation=serialize(array('hid'=>$s['hid']));
		insert('common_user_count_log',array('lid'=>$lid,'uid'=>$_S['uid'],'fild'=>'balance','arose'=>-$s['money'],'title'=>'给好友发红包','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
		update('common_user_count',array('balance'=>$money),"uid='$_S[uid]'");
		
		insert('common_hongbao',$s);
		
		
    $message=serialize(array('hid'=>$s['hid'],'message'=>$s['message']));
		
		$mid=sendmessage($tid,5,'[红包]',$message);
		
		$userclass=' self';
		$typeclass=' message-red';
		$message='<a class="message-hongbao load cl" href="hongbao.php?hid='.$s['hid'].'"><span class="icon icon-red r"></span><div class="l"><h4>'.$s['message'].'</h4><p>查看红包</p></div></a><p class="b_c3 c4 s12 pl10">聊天红包</p>';
		$date=smsdate($_S['timestamp'],'m-d H:i:s');
		$time='';
		$form_avatar=head($_S['member'],2,'src');
		$to_avatar=head($checksend[2],2,'src');	
		//
		$ins['form']=$ins['to']=array();
		$ins['form']['mid']=$ins['to']['mid']=$mid;
		$ins['form']['userclass']=$userclass;
		$ins['form']['typeclass']=$typeclass;
		$ins['form']['touid']=$ins['to']['touid']=$_GET['touid'];
		$ins['form']['formuid']=$ins['to']['formuid']=$_S['uid'];
		$ins['form']['tousername']=$ins['to']['tousername']=$tousername;
		$ins['form']['formusername']=$ins['to']['formusername']=$_S['member']['username'];
		$ins['form']['toavatar']=$ins['to']['toavatar']=$to_avatar;
		$ins['form']['formavatar']=$ins['to']['formavatar']=$form_avatar;
		
		$ins['form']['tid']=$ins['to']['tid']=$tid;
		$ins['form']['summary']=$ins['to']['summary']='[红包]';
		$ins['form']['date']=$ins['to']['date']=$date;
		$ins['form']['time']=$time;

	
	  $return['form']= JSON::encode($ins['form']);
	  $return['to']= JSON::encode($ins['to']);
		if($_S['setting']['wxnotice_talk'] && $openid){
			$wxnotice=array(
				'first'=>array('value'=>'有人给你发了一个红包'),
				'keyword1'=>array('value'=>$_S['member']['username']),
				'keyword2'=>array('value'=>'[聊天红包]'),
				'keyword3'=>array('value'=>smsdate($_S['timestamp'],'Y-m-d H:i:s')),
				'remark'=>array('value'=>'点击立即领取红包','color'=>'#3399ff'),
			);
			sendwxnotice($_GET['touid'],$openid,$_S['setting']['wxnotice_talk'],$_S['setting']['siteurl'].'my.php?mod=talk&tid='.$tid,$wxnotice);					
		}
		showmessage('发送成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.deleteitem(\'my.php?mod=hongbao\',false);smsot.accountchange(\''.($money/100).'\',\'balance\');smsot.insertmessage(\''.$return['form'].'\',\''.$message.'\');sendnotice(\'touid='.$_GET['touid'].'+call=smsot.havenewmsg(\\\''.$return['to'].'\\\')\')},100)'));

	}
  include temp(PHPSCRIPT.'/hongbao_send');
}else{
	$navtitle='红包';
	$title=$navtitle.'-'.$_S['setting']['sitename'];
  $backurl='my.php';
	$sql = array();
	$wherearr = array();
  if($_GET['list']=='give'){
		//我发的
		$sql['select'] = 'SELECT * ';
		$sql['from'] ='FROM '.DB::table('common_hongbao');
		$wherearr[] = "`uid` ='$_S[uid]'";
		
		$sql['order']='ORDER BY dateline DESC';
	}elseif($_GET['list']=='receive'){
		//我领取的
		$sql['select'] = 'SELECT l.money as rec,l.logtime ';
		$sql['from'] ='FROM '.DB::table('common_hongbao_log').' l ';
		$wherearr[] = "l.`uid` ='$_S[uid]'";
		$wherearr[] = "l.`money` >'0'";
		
		$sql['select'] .= ',b.*';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_hongbao')." b ON b.hid=l.hid";
		
		$sql['select'] .= ',u.username,u.dzuid';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=b.uid";
		

		$sql['order']='ORDER BY l.logtime DESC';	
		
	}else{
		//我收到的
		$sql['select'] = 'SELECT b.* ';
		$sql['from'] ='FROM '.DB::table('common_hongbao').' b ';
		$wherearr[] = "b.`touid` ='$_S[uid]'";

		$sql['select'] .= ',u.username,u.dzuid';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=b.uid";
		
		$sql['select'] .= ',l.money as rec';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_hongbao_log')." l ON l.hid=b.hid AND l.money>0 AND l.uid='$_S[uid]'";

		$sql['order']='ORDER BY b.dateline DESC';	
	}
	
  $select=select($sql,$wherearr,10);
	
	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)) {
			if(!$_GET['list'] && !$value['rec']){
				$value['btn']='<span class="weui-btn weui-btn_mini weui-btn_primary">领取</span>';
			}elseif($_GET['list']=='receive' || (!$_GET['list'] && $value['rec']) || ($_GET['list']=='give' && ($value['dateline']+86400>$_S['timestamp'] || !$value['surplus']))){
				$value['btn']='<span class="weui-btn weui-btn_mini weui-btn_default">查看</span>';
			}else{
				$value['btn']='<span class="weui-btn weui-btn_mini weui-btn_warn">撤回</span>';
			}
			if($_GET['list']=='give'){
				$value['username']=$_S['member']['username'];
				$value['user']=array('uid'=>$_S['uid'],'dzuid'=>$_S['member']['dzuid']);
			}else{
				$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
			}
			
			$list[]=$value;
		}
	}

	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'my.php?mod=hongbao&page='.$nextpage.($_GET['list']?'&list='.$_GET['list']:'');
	
	$jsonvar=array($list);
  include temp(PHPSCRIPT.'/hongbao_list');
}
?>