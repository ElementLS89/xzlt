<?php
define('PHPSCRIPT', 'send');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/function_talk.php';
require_once './include/json.php';

$S = new S();
$S -> star();

if(!$_S['member']['uid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
$_S['outback']=true;
			
C::chche('smile');

$checksend=checksend($_GET['tid']);
$tousername=$checksend[0];
$openid=$checksend[1];
if(checksubmit('submit')){
	$touid=str_replace_limit($_S['uid'],'',$_GET['tid']);
	$userclass=' self';
	$userclass_2=' friend';
	
	$date=smsdate($_S['timestamp'],'m-d H:i:s');
	$time='';
	$form_avatar=head($_S['member'],2,'src');	
	$to_avatar=head($checksend[2],2,'src');	
	if($_FILES['talk']){
		require_once './include/upimg.php';
		$pic = upload_img($_FILES['talk'],'talk','200','300');
		if($pic['thumb']){
			$s['message']='<img src="'.$_S['atc'].'/'.$pic['attachment'].'_200_300.jpg'.'" thumb="_200_300.jpg" class="viewpic" />';
		}else{
			$s['message']='<img src="'.$_S['atc'].'/'.$pic['attachment'].'" class="viewpic" />';
		}
		$s['summary']='[图片]';

		$mid=sendmessage($_GET['tid'],2,$s['summary'],$s['message']);
		$typeclass=$typeclass_2=' message-pic';
		$message=$s['message'];
		$func='$(\'.moreadd\').toggle();';
		
	}else{
		$s['message']=trim($_GET['message']);
		$s['summary']=cutstr($s['message'],20);
		if(!$s['message']){
			showmessage('消息为空');
		}else{
			$mid=sendmessage($_GET['tid'],1,$s['summary'],$s['message']);
			$typeclass=' message-d';
			$typeclass_2=' message-w';
			$message='<div class="message-content">'.smile($s['message']).'</div>';
			$func='SMS.openlayer(\'sendmessage\');';
		}	
	}
	$ins['form']=$ins['to']=array();
	$ins['form']['mid']=$ins['to']['mid']=$mid;
	$ins['form']['userclass']=$userclass;
	$ins['form']['typeclass']=$typeclass;
	$ins['form']['touid']=$ins['to']['touid']=$touid;
	$ins['form']['formuid']=$ins['to']['formuid']=$_S['uid'];
	$ins['form']['tousername']=$ins['to']['tousername']=$tousername;
	$ins['form']['formusername']=$ins['to']['formusername']=$_S['member']['username'];
	$ins['form']['toavatar']=$ins['to']['toavatar']=$to_avatar;
	$ins['form']['formavatar']=$ins['to']['formavatar']=$form_avatar;
	
	$ins['form']['tid']=$ins['to']['tid']=$_GET['tid'];
	$ins['form']['summary']=$ins['to']['summary']=$s['summary'];
	$ins['form']['date']=$ins['to']['date']=$date;
	$ins['form']['time']=$time;

	
	$return['form']= JSON::encode($ins['form']);
	$return['to']= JSON::encode($ins['to']);
	if($_S['setting']['wxnotice_talk'] && $openid){
		$wxnotice=array(
			'first'=>array('value'=>'有人给你发了新的消息快来看看吧'),
			'keyword1'=>array('value'=>$_S['member']['username']),
			'keyword2'=>array('value'=>$s['summary']),
			'keyword3'=>array('value'=>smsdate($_S['timestamp'],'Y-m-d H:i:s')),
			'remark'=>array('value'=>'点击立即查看消息详情','color'=>'#3399ff'),
		);
		sendwxnotice($touid,$openid,$_S['setting']['wxnotice_talk'],$_S['setting']['siteurl'].'my.php?mod=talk&tid='.$_GET['tid'],$wxnotice);					
	}
  showmessage('发送成功','',array('type'=>'toast','fun'=>$func.'smsot.insertmessage(\''.$return['form'].'\',\''.$message.'\');sendnotice(\'touid='.$touid.'+call=smsot.havenewmsg(\\\''.$return['to'].'\\\')\');'));
}

?>


