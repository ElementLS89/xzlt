<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='全部话题';
$title=$navtitle.'-'.$_S['setting']['sitename'];
//shar
$signature=signature();
$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';

$backurl='topic.php';
C::chche('topic_types');

$first=current($_S['cache']['topic_types']);
$_GET['typeid']=$_GET['typeid']?$_GET['typeid']:$first['typeid'];

$sql['select'] = 'SELECT *';
$sql['from'] ='FROM '.DB::table('topic');

$wherearr[] = "typeid ='$_GET[typeid]'";
$wherearr[] = "gid ='0'";
$wherearr[] = "state ='1'";

$sql['order']='ORDER BY dateline DESC';	


$select=select($sql,$wherearr,10);


if($select[1]) {
	$query = DB::query($select[0]);
	while($value = DB::fetch($query)){
		if(!$value['cover']){
			$value['cover']='ui/nocover.jpg';
		}else{
			$value['cover']=$_S['atc'].'/'.$value['cover'];
		}
		$list[$value['tid']]=$value;
	}
}

$maxpage = @ceil($select[1]/10);

$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'topic.php?mod=list'.($_GET['typeid']?'&typeid='.$_GET['typeid']:'').'&page='.$nextpage;


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>