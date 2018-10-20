<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='联系人';
$backurl='my.php';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$typeid=$_GET['typeid']?$_GET['typeid']:'0';

$sql = array();
$wherearr = array();
if($typeid=='black'){
	$sql['select'] = 'SELECT b.fuid,b.dateline';
	$sql['from'] ='FROM '.DB::table('common_friend_blacklist').' b';

	$sql['select'] .= ',u.*';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=b.fuid";
	
	$sql['order']='ORDER BY b.dateline DESC';		
}else{
	$sql['select'] = 'SELECT f.*';
	$sql['from'] ='FROM '.DB::table('common_friend').' f';

	$sql['select'] .= ',u.dzuid';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=f.fuid";
	
	$wherearr[] = "f.uid ='$_S[uid]'";
	$wherearr[] = "f.friendtype ='$typeid'";
	$wherearr[] = "f.state ='1'";
	
	$sql['order']='ORDER BY f.dateline DESC';	
}


$select=select($sql,$wherearr,100);

if($select[1]) {
	$query = DB::query($select[0]);
	while($value = DB::fetch($query)) {
		$value['tid']=maketid(array($_S['uid'],$value['fuid']));
		$tidarr[]=$value['tid'];
		$value['user']=array('uid'=>$value['fuid'],'dzuid'=>$value['dzuid']);
		$list[$value['tid']]=$value;
	}
}	


if($tidarr){
	$tidstr=implode(',',$tidarr);
	$query = DB::query('SELECT i.*,t.newmessage FROM '.DB::table('common_talk_index').' i LEFT JOIN '.DB::table('common_talk')." t ON t.tid=i.tid  WHERE i.`tid` IN($tidstr) AND t.uid='$_S[uid]'");
	while($value = DB::fetch($query)) {
		$list_more[$value['tid']]=$value;
	}	
}
if($_S['page']==1 && $_GET['get']!='ajax'){
	$query = DB::query('SELECT * FROM '.DB::table('common_friend_type')." WHERE `uid` ='$_S[uid]'");
	while($value = DB::fetch($query)) {
		$friendtype[]=$value;
	}
  $friendnum = $select[1];
}


$jsonvar=array($friendtype,$friendnum,$blacknum,$list,$list_more);

include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>