<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='我的';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='index.php';


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>