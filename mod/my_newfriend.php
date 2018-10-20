<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='新朋友';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='my.php?mod=friend';
$sql = array();
$wherearr = array();
$sql['select'] = 'SELECT a.*';
$sql['from'] ='FROM '.DB::table('common_friend_apply').' a';

$sql['select'] .= ',u.dzuid';
$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=a.uid";

$wherearr[] = "a.touid ='$_S[uid]'";	
$sql['order']='ORDER BY a.dateline DESC';

$select=select($sql,$wherearr,10);



if($select[1]) {
	$query = DB::query($select[0]);
	while($value = DB::fetch($query)) {
		$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
		$list[$value['aid']]=$value;
	}
}	

$urlstr='my.php?mod=newfriend';
$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'my.php?mod=newfriend&page='.$nextpage.'&get=ajax';

$jsonvar=$list;

include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>