<?php
$navtitle='点赞记录';

$sql['select'] = 'SELECT a.*';
$sql['from'] ='FROM '.DZ::table('forum_memberrecommend').' a';
$wherearr[] = "a.`tid` ='$_GET[tid]'";

$sql['select'] .= ',u.username,u.groupid';
$sql['left'] .=" LEFT JOIN ".DZ::table('common_member')." u ON u.uid=a.recommenduid";
$sql['order']='ORDER BY a.dateline DESC';

$select=select($sql,$wherearr,10,2);

if($select[1]) {
	$query = DZ::query($select[0]);
	while($value = DZ::fetch($query)){
		$list[]=$value;	
	}
}
$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'discuz.php?mod=praise&tid='.$_GET['tid'].'&page='.$nextpage;
	
include temp('discuz/praise');
?>