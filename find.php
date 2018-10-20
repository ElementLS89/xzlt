<?php
define('PHPSCRIPT', 'find');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';


$S = new S();
$S -> star();
$_GET['mod']=$_GET['mod']?$_GET['mod']:PHPSCRIPT;

$navtitle='发现';
$title=$navtitle.'-'.$_S['setting']['sitename'];

include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>