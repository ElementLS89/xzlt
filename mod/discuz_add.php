<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='发帖';
$filterfids=$_S['cache']['discuz']['discuz_common']['filterfids']?explode(',',$_S['cache']['discuz']['discuz_common']['filterfids']):array();
foreach($_S['cache']['discuz_forum'] as $value){
	if($value['status']>0 && $value['status']!=3 && $value['fid'] && !in_array($value['fid'],$filterfids)){
		if($value['type']=='group'){
			$groups[$value['fid']]=$value;
		}
		if($value['type']=='forum'){
			$forums[$value['fup']][$value['fid']]=$value;
		}
	}
}

include temp('discuz/add');
?>