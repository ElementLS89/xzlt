<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='用户协议';
$backurl='set.php';
$title=$navtitle.'-'.$_S['setting']['sitename'];

$_S['setting']['agreement'] = preg_replace(array("#\n\r+#","#\r\n+#","#\n+#"), "\n", $_S['setting']['agreement']);
$_S['setting']['agreement'] = str_replace(array("\n"),array("<br>"),$_S['setting']['agreement']);
$_S['setting']['agreement'] = preg_replace_callback("/\[h\=(.+?)]/s", 'puttitle', $_S['setting']['agreement']);

include temp('mod_agreement');
?>