<?php
define('PHPSCRIPT', 'user');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/function_user.php';
$backurl='index.php';

$S = new S();
$S -> star();

$_GET['mod']=$_GET['mod']?$_GET['mod']:'view';

if($_GET['mod']!='nearby'){
	if($_GET['dzuid']){
		$duser=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE dzuid='$_GET[dzuid]'");
		if($duser){
			$uid=$duser['uid'];
		}else{
			loaddiscuz();
			require './mod/discuz_user.php';
			exit;
		}
	}else{
		$uid=$_GET['uid']?$_GET['uid']:$_S['uid'];
	}
	if(!$uid){
		showmessage('你要查看的用户不存在');
	}else{
		$user=getuser(array('common_user','common_user_count','common_user_profile','common_user_setting'),$uid);
		if(!$user['uid']){
			showmessage('你要查看的用户不存在');
		}
	}	
}
require './mod/user_'.$_GET['mod'].'.php';
?>