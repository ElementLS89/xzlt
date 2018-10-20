<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='用户组';
$backurl='my.php';
C::chche('usergroup');

$gid=$_GET['gid']?$_GET['gid']:$_S['member']['groupid'];
$mygroup=$_S['cache']['usergroup'][$gid];

require_once './include/function_user.php';
$my=getuser(array('common_user_count'),$_S['uid']);

if($_GET['showlog']){
	$navtitle='经验记录';
	$sql = array();
	$wherearr = array();

	$sql['select'] = 'SELECT * ';
	$sql['from'] ='FROM '.DB::table('common_user_count_log');
  $wherearr[] = "`uid` ='$_S[uid]'";
	$wherearr[] = "`fild` ='experience'";
  
	$sql['order']='ORDER BY logtime DESC';
  $select=select($sql,$wherearr,10);

	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)) {
			$value['relation']=dunserialize($value['relation']);
			$value['arose_before']=$value['arose']>0?'+':'';
			$list[$value['lid']]=$value;
		}
	}
	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'my.php?mod=group&showlog=true&page='.$nextpage;	
}
$title=$navtitle.'-'.$_S['setting']['sitename'];

include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>