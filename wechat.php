<?php
define('PHPSCRIPT', 'wechat');
require_once './config.php';
require_once './include/core.php';
require_once './include/json.php';
require_once './include/function.php';
require_once './include/function_wechat.php';

$S = new S();
$S -> star();
$_GET['mod']=$_GET['mod']?$_GET['mod']:'getopenid';

if(!$_S['wechat']){
	showmessage('本站尚未设置微信接口请联系网站管理员');
}

require './mod/wechat_'.$_GET['mod'].'.php';
?>