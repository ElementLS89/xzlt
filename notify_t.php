<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
define('PHPSCRIPT', 'notify');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/wxpay.php';

$S = new S();
$S -> star(1,true);




$paylogs =DB::fetch_all('SELECT * FROM '.DB::table('common_paylog')." WHERE `state`='0' AND `ac`='shop:pay'");

foreach($paylogs as $v){
	$v['body']=dunserialize($v['body']);
	if(!$v['body']){
		$errs[]=$v;
	}
}
print_r($errs);
?>