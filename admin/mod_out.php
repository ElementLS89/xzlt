<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$sid=$_S['admin']['sid'];
DB::query("DELETE FROM ".DB::table('common_adminsession')." WHERE `sid` ='$sid'");
dheader('Location:index.php');
?>