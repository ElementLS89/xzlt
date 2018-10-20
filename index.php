<?php
define('PHPSCRIPT', 'index');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';





$S = new S();
$S -> star();

$_GET['mod']=$_GET['mod']?$_GET['mod']:PHPSCRIPT;


require './mod/'.$_GET['mod'].'.php';
?>