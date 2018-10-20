<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$_S['outback']=true;
$sql = array();
$wherearr = array();

$sql['select'] = 'SELECT f.fuid,f.dateline';
$sql['from'] ='FROM '.DB::table('common_follow').' f';
$sql['select'] .= ',u.*';

if($_GET['show']=='fans'){
	$navtitle='粉丝';
	$wherearr[] = "f.fuid ='$uid'";
	$now=2;
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=f.uid";
}else{
	$_GET['show']='follow';
	$navtitle='关注';
	$wherearr[] = "f.uid ='$uid'";
	$now=1;
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=f.fuid";
}
$sql['order']='ORDER BY f.dateline DESC';
$select=select($sql,$wherearr,10);
$title=$navtitle.'-'.$_S['setting']['sitename'];

if($select[1]) {
	$query = DB::query($select[0]);
	while($value = DB::fetch($query)) {
		if($value['uid']){
			$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
			$list[$value['uid']]=$value;
			$uidarr[]=$value['uid'];			
		}

	}
}

if($uidarr && $_S['uid']){
	$uidstr=implode(',',$uidarr);
	$query = DB::query('SELECT * FROM '.DB::table('common_follow')." WHERE `uid`=$_S[uid] AND fuid IN($uidstr)");
	while($value = DB::fetch($query)) {
		$list_more[$value['fuid']]=$value;
	}	
}


$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'user.php?mod=follow&page='.$nextpage;

$jsonvar=array($list,$list_more);

include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>