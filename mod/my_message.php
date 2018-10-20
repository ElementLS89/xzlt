<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='消息';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$sql = array();
$wherearr = array();

$sql['select'] = 'SELECT t.*';
$sql['from'] ='FROM '.DB::table('common_talk').' t';
$wherearr[] = "t.uid ='$_S[uid]'";

$sql['select'] .= ',i.*';
$sql['left'] .=" LEFT JOIN ".DB::table('common_talk_index')." i ON i.tid=t.tid";
	
$sql['order']='ORDER BY t.newmessage DESC';	
$select=select($sql,$wherearr,10);

if($select[1]) {
	$query = DB::query($select[0]);
	while($value = DB::fetch($query)) {
    $value['formuid']=str_replace_limit($_S['uid'],'',$value['tid']);
		$form[]=$value['formuid'];
		$list[$value['tid']]=$value;
	}
}	

if($form){
	$formstr=implode(',',$form);
	$query = DB::query('SELECT * FROM '.DB::table('common_user')." WHERE `uid` IN($formstr)");
	while($value = DB::fetch($query)) {
		$list_more[$value['uid']]=$value;
	}				
}

$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'my.php?mod=message&page='.$nextpage;

$jsonvar=array($list,$list_more);


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>