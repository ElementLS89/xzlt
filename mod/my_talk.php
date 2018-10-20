<?php
if(!defined('IN_SMSOT')) {
	exit;
}



$touid=str_replace_limit($_S['uid'],'',$_GET['tid']);
$user=DB::fetch_first("SELECT u.uid,u.username,u.dzuid,t.newmessage FROM ".DB::table('common_user')." u LEFT JOIN ".DB::table('common_talk')." t ON t.uid='$_S[uid]' AND t.tid='$_GET[tid]' WHERE u.uid='$touid'");


$user['newmessage']=$user['newmessage']?$user['newmessage']:'0';

$navtitle=$user['username'];
$title='与'.$navtitle.'的聊天-'.$_S['setting']['sitename'];
if(!$user['uid']){
	showmessage('用户不存在');
}
if($user['newmessage']){
	$newmessage=$_S['member']['newmessage']-$user['newmessage']<0?0:$_S['member']['newmessage']-$user['newmessage'];
	update('common_talk',array('newmessage'=>'0'),"tid='$_GET[tid]' AND uid='$_S[uid]'");
	update('common_user',array('newmessage'=>$newmessage),"uid='$_S[uid]'");
}

C::chche('smile');
$navtitle=$user['username'];
$table='common_talk_message_'.substr($_GET[tid],-1);

$sql = array();
$wherearr = array();

$sql['select'] = 'SELECT t.*';
$sql['from'] ='FROM '.DB::table($table).' t';
$wherearr[] = "t.tid ='$_GET[tid]'";
$sql['select'] .= ',u.dzuid';
$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=t.uid";


$sql['order']='ORDER BY t.dateline DESC';	

$select=select($sql,$wherearr,10);
require_once './include/function_talk.php';
if($select[1]) {
	$query = DB::query($select[0]);
	while($value = DB::fetch($query)) {
		$value=maketalk($value);
		$list[]=$value;
	}
}	


if($select[1]>1){
	$arrsort = array();  
	foreach($list as $uniqid => $row){  
	 foreach($row as $key=>$value){  
		 $arrsort[$key][$uniqid] = $value;  
	 }  
	}
	array_multisort($arrsort['dateline'],SORT_ASC, $list);  			
}

$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'my.php?mod=talk&tid='.$_GET['tid'].'&page='.$nextpage;

$jsonvar=array($list);





include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>