<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='话题';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='topic.php';

//shar
$signature=signature();
$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';

$query = DB::query('SELECT u.tid,t.* FROM '.DB::table('topic_users').' u LEFT JOIN '.DB::table('topic')." t ON t.tid=u.tid AND t.gid=0 AND t.state ='1' WHERE u.uid='$_S[uid]'");
while($value = DB::fetch($query)){
	if($value['tid']){
		if(!$value['cover']){
			$value['cover']='ui/nocover.jpg';
		}else{
			$value['cover']=$_S['atc'].'/'.$value['cover'];
		}
		$mytopic[$value['tid']]=$value;
		$mytids[]=$value['tid'];		
	}
}

if($mytids){
	$tidstr=implode(',',$mytids);
	$notin="tid NOT IN($tidstr) AND ";
}

if($_S['setting']['besttopic']){
	$bset=$_S['setting']['besttopic'];
	$in="tid IN($bset) AND ";
}
$query = DB::query('SELECT * FROM '.DB::table('topic')." WHERE $in $notin gid='0' AND state ='1' ORDER BY `themes` DESC LIMIT 10");
while($value = DB::fetch($query)){
	if($value['tid']){
		if(!$value['cover']){
			$value['cover']='ui/nocover.jpg';
		}else{
			$value['cover']=$_S['atc'].'/'.$value['cover'];
		}
		$hotopic[$value['tid']]=$value;
	}
}


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>