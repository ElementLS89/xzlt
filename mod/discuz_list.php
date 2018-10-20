<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if($_GET['get']!='ajax'){
	if($_GET['catid']){
		$cat=DZ::fetch_first("SELECT * FROM ".DZ::table('portal_category')." WHERE `catid`='$_GET[catid]'");
		if(!$cat){
			showmessage('频道不存在');
		}
		if($cat['closed'] && $_S['usergroup']['power']<6){
			showmessage('当前频道没有启用');
		}		
		$backurl='discuz.php?mod=list';
		$navtitle=$cat['catname'];
		$title=$cat['seotitle']?$cat['seotitle']:$navtitle.'-'.$_S['setting']['sitename'];
		$keywords=$cat['keyword']?$cat['keyword']:$cat['catname'].','.$metakeywords;
		$metadescription=$cat['description']?$cat['description']:$cat['catname'];		
	}else{
		$navtitle='资讯';
		$title=$navtitle.'-'.$_S['setting']['sitename'];
		$keywords=$metakeywords;
		$backurl='index.php';
	}

	$query = DZ::query("SELECT * FROM ".DZ::table('portal_category')." WHERE `closed` ='0' AND `disallowpublish`='0' ORDER BY displayorder DESC");
	while($value = DZ::fetch($query)) {
		$cats[$value['catid']]=$value;
	}

	//shar
	$signature=signature();
	$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
	$_S['shar']['desc']=$metadescription;
	
}


$sql['select'] = 'SELECT a.*';
$sql['from'] ='FROM '.DZ::table('portal_article_title').' a';
if($_GET['catid']){
	$wherearr[] = "a.catid ='$_GET[catid]'";
}
$wherearr[] = "a.status >=0";
$sql['select'] .= ',c.*';
$sql['left'] .=" LEFT JOIN ".DZ::table('portal_article_count')." c ON c.`aid`=a.`aid`";
	
$sql['order']='ORDER BY a.dateline DESC';

$select=select($sql,$wherearr,10,2);

if($select[1]) {
	$query = DZ::query($select[0]);
	while($value = DZ::fetch($query)){
		if($value['remote']){
			$value['pic']=$value['pic']?$_S['dz']['remote'].$value['pic'].($value['thumb']?'.thumb.jpg':''):'';
		}else{
			$value['pic']=$value['pic']?$_S['dz']['atc'].$value['pic'].($value['thumb']?'.thumb.jpg':''):'';
		}
		$list[$value['aid']]=$value;
	}
}

$urlstr='discuz.php?mod=list'.($_GET['catid']?'&catid='.$_GET['catid']:'');

$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = $urlstr.'&page='.$nextpage;

include temp('discuz/list');
?>