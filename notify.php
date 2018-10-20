<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
define('PHPSCRIPT', 'notify');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/wxpay.php';

$S = new S();
$S -> star(1,true);

if(!$_GET['echostr']){
	$_GET['formhash'] = $_S['hash'];
}

if(function_exists('file_get_contents')){
	$xml=file_get_contents("php://input");
}else{
	$xml=$GLOBALS["HTTP_RAW_POST_DATA"];
}
$post = xmlToArray($xml);




?>