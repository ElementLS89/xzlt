<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('服务清单','admin.php?mod='.$_GET['mod'].'&item=index'),
	'service-market'=>array('服务市场','admin.php?mod='.$_GET['mod'].'&item=service-market'),
);

?>