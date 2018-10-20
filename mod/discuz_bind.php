<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle=$title='绑定论坛账号';


$referer=urlencode(referer());
if(checksubmit('submit')){
	$s['username']=trim($_GET['username']);
	$s['password']=trim($_GET['password']);
	$s['synchronization']=$_GET['synchronization'];
	
	$dzuser=getdzuser($s['username']);
	
	if(!$dzuser){
		showmessage('账号不存在');
	}elseif($dzuser['password']!=md5(md5($s['password']).$dzuser['salt'])){
		showmessage('密码输入错误');
	}else{
		$user=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE dzuid='$dzuser[uid]'");
		if($user){
			showmessage('本账号已经与其他账号绑定过了');
		}
		$e=array();
		$e['dzuid']=$dzuser['uid'];
		if($s['synchronization']){
			if(!DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$s[username]'")){
				$e['username']=$s['username'];
			}
		}
		update('common_user',$e,"`uid`='$_S[uid]'");
		showmessage('绑定成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));
	}
	
}






include temp('discuz/bind');
?>