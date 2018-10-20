<?php
define('PHPSCRIPT', 'my');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';


$S = new S();
$S -> star();
$_GET['mod']=$_GET['mod']?$_GET['mod']:'index';
if(!$_S['member']['uid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
$_S['outback']=true;

require './mod/my_'.$_GET['mod'].'.php';

?>