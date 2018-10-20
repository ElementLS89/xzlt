<?php
$navtitle='点赞记录';

$sql['select'] = 'SELECT a.*';
$sql['from'] ='FROM '.DB::table('topic_action').' a';
$wherearr[] = "a.`type` ='$_GET[type]'";
$wherearr[] = "a.`id` ='$_GET[id]'";

$sql['select'] .= ',u.username,u.groupid,u.dzuid';
$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=a.uid";
$sql['order']='ORDER BY a.dateline DESC';

$select=select($sql,$wherearr,10);

if($select[1]) {
	$query = DB::query($select[0]);
	while($value = DB::fetch($query)){
		$list[$value['aid']]=$value;	
	}
}
$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'topic.php?mod='.$_GET['mod'].'&id='.$_GET['id'].'&page='.$nextpage;
	
include temp('topic/praise');
?>