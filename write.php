<?php
define('PHPSCRIPT', 'write');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';


$S = new S();
$S -> star();

$navtitle='发布';
$title=$navtitle.'-'.$_S['setting']['sitename'];



include temp(PHPSCRIPT);
?>