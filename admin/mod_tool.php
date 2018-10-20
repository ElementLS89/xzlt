<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('更新缓存','admin.php?mod='.$_GET['mod'].'&item=index'),
	'db'=>array('数据库','admin.php?mod='.$_GET['mod'].'&item=db'),
	
);




if($_GET['item']=='db'){
	
	
	
}else{
	if(checksubmit('submit')){
		foreach($_GET['cache'] as $cache){
			clearcache($cache);
		}
		showmessage('缓存清理完成','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);
	}

}

?>