<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('频道管理','admin.php?mod='.$_GET['mod'].'&item=index'),
	'mods'=>array('模块管理','admin.php?mod='.$_GET['mod'].'&item=mods'),
	'modsstore'=>array('模块商店','admin.php?mod='.$_GET['mod'].'&item=modsstore'),
);
?>