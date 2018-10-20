<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if($_GET['get']!='ajax'){
	$navtitle='分类信息';
	$title=$navtitle.'-'.$_S['setting']['sitename'];
	$keywords=$metakeywords;
	$backurl='discuz.php';

	//shar
	$signature=signature();
	$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
	$_S['shar']['desc']=$metadescription;
	
}
if($_S['cache']['discuz']['discuz_common']['sortids']){
	$sortids=$_S['cache']['discuz']['discuz_common']['sortids'];
	$sortarr=explode(',',$sortids);
}
if($_S['cache']['discuz']['discuz_common']['filterfids']){
	$filterfids=$_S['cache']['discuz']['discuz_common']['filterfids'];
}

if($sortarr){
	foreach($_S['cache']['discuz_types'] as $k=>$v){
		if(in_array($k,$sortarr)){
			$sorttypes[$k]=$v;
		}
	}	
}else{
	$sorttypes=$_S['cache']['discuz_types'];
}
$thissort=getdzsort();

$sql['select'] = 'SELECT t.*';
$sql['from'] ='FROM '.DZ::table('forum_thread').' t';

$wherearr[] = "t.displayorder >=0";

if($_GET['sortid']){
  $wherearr[] = "t.sortid ='$_GET[sortid]'";
	$sortsql=sortsql();
	if($sortsql){
		
		$sql['select'] .= ',s.value';
		$sql['from'] .=','.DZ::table('forum_typeoptionvar').' s ';
		$wherearr[] = "s.tid =t.tid";		
		$wherearr[] = $sortsql;
	}
}elseif($sortids){
	$wherearr[] = "t.sortid IN($sortids)";
}else{
	$wherearr[] = "t.sortid !='0'";
}
if($filterfids){
	$wherearr[] = "t.fid NOT IN ($filterfids)";
}


$sql['order']='ORDER BY t.displayorder DESC,t.`dateline` DESC';


$select=select($sql,$wherearr,10,2);

if($select[1]) {
	$query = DZ::query($select[0]);
	while($value = DZ::fetch($query)){
		if($value['attachment']=='2'){
			$pictab[]='forum_attachment_'.substr($value['tid'], -1);	
		}
		$tids[]=$value['tid'];
		$list[$value['tid']]=$value;	
	}
}
if($tids){
	$tidstr=implode(',',$tids);
	$query=DZ::query("SELECT * FROM ".DZ::table('forum_typeoptionvar')." WHERE tid IN($tidstr)");
	while($value = DZ::fetch($query)){
		if($_S['cache']['discuz_typeoption'][$value['optionid']]['type']=='checkbox'){
			$value['value']=explode("\t",$value['value']);
		}
		$sorts[$value['tid']][$value['optionid']]=$value;
	}
}

if($pictab){
	$pictab=array_unique($pictab);
	$tidstr=implode(',',$tids);
	foreach($pictab as $table){
		$query=DZ::query("SELECT * FROM ".DZ::table($table)." WHERE tid IN($tidstr) AND isimage!=0 AND width>150 ORDER BY `dateline` ASC");
		while($value = DZ::fetch($query)){
			$pics[$value['tid']][]=$value;
		}
	}
}

$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'discuz.php?mod=sort'.($_GET['sortid']?'&sortid='.$_GET['sortid']:'').'&page='.$nextpage;

include temp('discuz/sort');
?>