<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$announcement=DB::fetch_first("SELECT * FROM ".DB::table('common_announcement'." WHERE aid='$_GET[aid]'"));
if(!$announcement){
	showmessage('公告不存在');
}

if($announcement['term']=='1'){
	$announcement['term']=$announcement['dateline']+86400*7;
}elseif($announcement['term']=='2'){
	$announcement['term']=$value['announcement']+86400*14;
}elseif($announcement['term']=='3'){
	$announcement['term']=$announcement['dateline']+86400*30;
}elseif($announcement['term']=='4'){
	$announcement['term']=$announcement['dateline']+86400*90;
}


if($announcement['term'] && $announcement['term']<$_S['timestamp']){
	showmessage('公告已过期');
}
			
$navtitle='公告';
$backurl='topic.php?mod=forum';
$title=$announcement['subject'].'-'.$_S['setting']['sitename'];

$announcement['content'] = preg_replace(array("#\n\r+#","#\r\n+#","#\n+#"), "\n", $announcement['content']);
$announcement['content'] = str_replace(array("\n"),array("<br>"),$announcement['content']);
$announcement['content'] = preg_replace_callback("/\[h\=(.+?)]/s", 'puttitle', $announcement['content']);

//shar
$signature=signature();
$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
	
include temp('mod_announcement');
?>