<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='反馈';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='index.php';
if(checksubmit('submit')){
	$s['content']=trim($_GET['content']);
	$s['type']=$_GET['type'];
	if($s['type']=='3'){
		$s['link']=$_GET['ref'];
	}
	if(!$s['type']){
		showmessage('没有选择反馈类型');
	}elseif(!$s['content']){
		showmessage('反馈内容没有填写');
	}else{
		$feed=array('type'=>$s['type'],'uid'=>$_S['member']['uid'],'link'=>$s['link'],'content'=>$s['content'],'dateline'=>$_S['timestamp']);
		$fid=insert('common_feed',$feed);
		if($fid){
			showmessage('反馈成功','',array('type'=>'toast','fun'=>'SMS.closepage()'));
		}else{
			showmessage('系统错误请联系管理员');
		}
	}
}

include temp('mod_feed');
?>