<?php
if(!defined('IN_SMSOT')) {
	exit;
}

if($_GET['get']!='ajax'){
	$news=DZ::fetch_first("SELECT a.*,c.*,n.content,n.content,n.pageorder,t.catname FROM ".DZ::table('portal_article_title')." a LEFT JOIN ".DZ::table('portal_article_count')." c ON c.aid=a.aid LEFT JOIN ".DZ::table('portal_article_content')." n ON n.aid=a.aid LEFT JOIN ".DZ::table('portal_category')." t ON t.catid=a.catid WHERE a.`aid`='$_GET[aid]'");
	if(!$news){
		showmessage('文章不存在');
	}
	$_S['poster']['api']='discuz.php?mod=news&aid='.$_GET['aid'].'&api=poster';
	
	$news['content']=striptags($news['content'],false);

	if(!$news['remote']){
		$news['content'] = str_replace(array("data/attachment/"),array($_S['dz']['atc'],),$news['content']);
	}
	if(strpos($news['content'], '[/attach]') !== FALSE) {
    $attachs=getthreadatc($news['id']);
		$atcs=$attachs[0];
		$news['content'] = preg_replace_callback("/\s?\[attach\](.+?)\[\/attach\]\s?/i", 'putatc', $news['content']);
	}
	$news['content']=gethtmlcontent($news['content']);
	
	$backurl='discuz.php?mod=list&catid='.$news['catid'];
	$navtitle='文章详情';
	$title=$news['title'];
  $keywords=$news['title'].','.$news['catname'];
	$metadescription=$news['summary'];
	//shar
	$signature=signature();
	$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
	
	$_S['shar']['desc']=$metadescription;
	$_S['shar']['pic']=$news['pic']?$_S['dz']['atc'].$news['pic']:'';

	if($_GET['api']=='poster'){
		require_once './include/poster.php';
		$date=array(
			'title'=>$news['title'],
			'summary'=>stringvar(strip_tags($news['summary']),120),
			'pic'=>$_S['shar']['pic']?makelocal($_S['shar']['pic'],'poster',false):'',
			'url'=>$_S['setting']['siteurl'].'discuz.php?mod=news&aid='.$_GET['aid'].'&formuid='.$_S['uid'],
		);
		creatposter($date);
		exit;
	}
	/*related*/
	$query = DZ::query('SELECT r.*,a.title,a.summary,a.pic,a.thumb,a.remote FROM '.DZ::table('portal_article_related')." r LEFT JOIN ".DZ::table('portal_article_title')." a ON a.aid=r.raid WHERE r.`aid` ='$_GET[aid]' ORDER BY r.displayorder DESC LIMIT 0,5");
	while($value = DZ::fetch($query)){
		$value['pic']=$value['pic']?$_S['dz']['atc'].$value['pic'].($value['thumb']?'.thumb.jpg':''):'';
		$related[]=$value;
	}
		
}



$sql['select'] = 'SELECT c.*';
$sql['from'] ='FROM '.DZ::table('portal_comment').' c';

$wherearr[] = "c.idtype ='aid'";
$wherearr[] = "c.id ='$_GET[aid]'";
$wherearr[] = "c.status >=0";
	
$sql['order']='ORDER BY c.dateline DESC';

$select=select($sql,$wherearr,10,2);

if($select[1]) {
	$query = DZ::query($select[0]);
	while($value = DZ::fetch($query)){
		$value['message'] = str_replace(array("static/image/","class=\"vm\">&nbsp;&nbsp;"),array($_S['dz']['url'].'static/image/',"class=\"vm\">"),$value['message']);
		$list[$value['cid']]=$value;
	}
}

$urlstr='discuz.php?mod=news&aid='.$_GET['aid'];

$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = $urlstr.'&page='.$nextpage;

include temp('discuz/news');
?>