<?php
define('PHPSCRIPT', 'jsapi');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';

$S = new S();
$S -> star();

$_GET['mod']=$_GET['mod']?$_GET['mod']:'wechat';

require './mod/jsapi_'.$_GET['mod'].'.php';
?>