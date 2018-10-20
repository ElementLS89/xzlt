<?php
define('PHPSCRIPT', 'index');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/poster.php';

$S = new S();
$S -> star();

$date=array(
	'url'=>$_GET['url']?urldecode($_GET['url']):$_S['setting']['siteurl'],
);
creatposter($date);
?>