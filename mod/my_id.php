<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle=$_S['member']['password']=='null'?'完善账号':'修改用户名';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='my.php';

require_once './include/function_user.php';
if(!$_S['setting']['alloweditusername'] && $_S['member']['password']!='null'){
	showmessage('您的账号已经完善过了');
}
if(checksubmit('submit')){
	
	$s['username']=trim($_GET['username']);

	checkusername($s['username']);
	
	if($s['username']!=$_S['member']['username'] && DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$s[username]'")){
		showmessage('用户名已存在，请换个用户名');
	}
	if($_S['member']['password']=='null'){
		$s['password']=trim($_GET['password']);
		$s['password2']=trim($_GET['password2']);
		if($s['password']!=$s['password2']){
			showmessage('两次输入密码不一致');
		}
		checkpassword($s['password']);
		$password = md5(md5($s['password']).$_S['member']['salt']);
		$update=array('username'=>$s['username'],'password'=>$password);
	}else{
		$update=array('username'=>$s['username']);
	}

	

	update('common_user',$update,"uid='$_S[uid]'");
	if($_GET['clear']){
		$fun='SMS.close();smsot.setlogin(\''.$_S['uid'].'@'.head($_S['member'],2,'src').'@'.$s['username'].'\')';
	}else{
		$fun='smsot.setid(\''.$s['username'].'\');SMS.deleteitem(\'my.php\');SMS.deleteitem(\'user.php\',false)';
	}
	showmessage('设置成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){'.$fun.'},100)'));

}
include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>