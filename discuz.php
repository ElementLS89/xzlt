<?php
define('PHPSCRIPT', 'discuz');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/function_user.php';


$S = new S();
$S -> star();

$_GET['mod']=$_GET['mod']?$_GET['mod']:'index';

loaddiscuz();

require './mod/discuz_'.$_GET['mod'].'.php';
?>