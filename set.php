<?php
define('PHPSCRIPT', 'set');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';



$S = new S();
$S -> star();

if(!$_S['member']['uid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
$_S['outback']=true;
$_GET['type']=in_array($_GET['type'],array('spacecover'))?$_GET['type']:'preference';

if($_GET['type']=='spacecover'){
	
	$navtitle='设置封面图片';
	C::chche('spacecover');
	$backurl='user.php';
	if(checksubmit('submit')){
		if($_FILES['cover']['name']){
			require_once './include/upimg.php';
			$pic = upload_img($_FILES['cover'],'common','640','320');
			$spacecover=$_S['atc'].'/'.$pic['attachment'].($pic['thumb']?'_640_320.jpg':'');
			
		}elseif($_S['cache']['spacecover'][$_GET['tid']][$_GET['cid']]['path']){
			$spacecover='ui/spacecover/'.$_S['cache']['spacecover'][$_GET['tid']][$_GET['cid']]['path'];
		}
		if($spacecover){
			update('common_user_profile',array('spacecover'=>$spacecover),"uid='$_S[uid]'");
			showmessage('设置成功','',array('type'=>'toast','fun'=>'SMS.openlayer(\'setspacecover\');smsot.setspacecover(\''.$_S['uid'].'\',\''.$spacecover.'\');'));
		}
	}else{
		require_once './include/json.php';
		$spacecover=JSON::encode($_S['cache']['spacecover']);
	}

}elseif($_GET['type']=='preference'){
	$navtitle='系统信息';
	$cid=$_S['member']['style'];
	C::chche('colors');
  $backurl='my.php';
	
	if(checksubmit('submit')){
		$s['style']=$_GET['style'];
		if(!is_file(ROOT.'./data/cache/style_'.$s['style'].'.css')){
			upcss($s['style']);
		}
		update('common_user',$s,"uid='$_S[uid]'");
		showmessage('设置成功','',array('type'=>'toast','fun'=>'SMS.openlayer(\'setstyle\');smsot.setstyle(\''.$s['style'].'\',\''.$_S['cache']['colors'][$s['style']]['name'].'\');'));
	}
}
$title=$navtitle.'-'.$_S['setting']['sitename'];
include temp(PHPSCRIPT.'/'.$_GET['type']);
?>