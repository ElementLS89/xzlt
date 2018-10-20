<?php
define('ADMIN', true);
require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './admin/function.php';

$S = new S();
$S -> star();

if(!$_S['admin']['uid'] || $_S['usergroup']['gid']!='1'){
	require_once './include/function_user.php';
	if(checksubmit('submit')){
		$s['username']=trim($_GET['username']);
		$s['password']=trim($_GET['password']);
		
		$user=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$s[username]'");
		if(!$user){
			$msg='账号不存在!';
		}elseif($user['groupid']!='1'){
			$msg='您没有权限访问后台!';
		}elseif($user['password']!=md5(md5($s['password']).$user['salt'])){
			$msg='密码输入错误!';
		}else{
			if(!$_S['uid']){
				setuserstate($user);
			}
			insert('common_adminsession',array('sid'=>$_S['member']['sid'],'uid'=>$user['uid'],'dateline'=>$_S['timestamp']));
			dheader('Location:admin.php');
		}
	}
	include temp('login');
	exit;
}
$_GET['mod']=$_GET['mod']?$_GET['mod']:'index';
$_GET['item']=$_GET['item']?$_GET['item']:'index';
$iframe=openmod($_GET['mod'],$_GET['item']);

if(!$iframe){
	$framearr = $_GET;	
	unset($framearr['page']);
	foreach ($framearr as $key => $value){
		$framestr.=$key.'='.$value.'&';
	}	
	$iframe='admin.php?'.substr($framestr,0,-1).($_GET['iframe']?'':'&iframe=yes');	
}
$mods=array(
  'index'=>'基础',
	'interface'=>'界面',
	'user'=>'用户',
	'portal'=>'频道',
	'forum'=>'社区',
	'topic'=>'话题',
	'data'=>'数据',
	'operate'=>'运营',
	'hacks'=>'应用',
	'service'=>'服务',
	'tool'=>'工具',
);
require ROOT.'./admin/mod_'.$_GET['mod'].'.php';
include temp('index');
?>