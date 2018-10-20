<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$forum=DZ::fetch_first("SELECT f.*,fl.* FROM ".DZ::table('forum_forum')." f LEFT JOIN ".DZ::table('forum_forumfield')." fl ON fl.fid=f.fid  WHERE f.`fid`='$_GET[fid]'");
if(!$forum){
	showmessage('板块不存在');
}
if($_GET['get']!='ajax'){
	$forum['icon']=$forum['icon']?(strstr($forum['icon'],'://')?$forum['icon']:$_S['dz']['atc'].'common/'.$forum['icon']):$_S['atc'].'/static/nocover.png';
	$forum['banner']=$forum['banner']?(strstr($forum['banner'],'://')?$forum['banner']:$_S['dz']['atc'].'common/'.$forum['banner']):'';
	
	if($forum['banner']){
		$forumskin['topbg']='transparent';
		$forumskin['body']='body_0';
		$forumskin['info']='c3';
		$forumskin['info_p']='';
	}else{
		$forumskin['topbg']='b_c1';
		$forumskin['body']='';
		$forumskin['info']='b_c3 bob o_c3';
		$forumskin['info_p']='c4';
	}
	$check=get_userpower($forum);
	
	if($check && !is_array($check)){
		$canmanage=true;
	}else{
		forumallow($check,$forum);
	}
	
	foreach($_S['cache']['discuz_forum'] as $v){
		if($v['fup']==$_GET['fid']){
			$subs[$v['fid']]=$v;
		}
	}
	$backurl='discuz.php?mod=index';
	
	$navtitle=$forum['name'];
	$title=$navtitle.'-'.$_S['setting']['sitename'];
	$metadescription=$forum['description'];
	$keywords=$forum['name'].','.$metakeywords;
	//shar
	$signature=signature();
	$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
	$_S['shar']['pic']=$forum['icon'];
	$_S['shar']['desc']=$forum['description'];
}
$forum['threadtypes']=dzusl($forum['threadtypes']);
$forum['threadsorts']=dzusl($forum['threadsorts']);



$thissort=getdzsort();

$forum['liststype']=$_S['setting']['closebbs']?'6':($_S['cache']['discuz']['discuz_forum'][$_GET['fid']]['skin']?$_S['cache']['discuz']['discuz_forum'][$_GET['fid']]['skin']:'1');
$forum['liststype']=$forum['threadsorts']?'sorts':$forum['liststype'];

$_GET['order']=$_GET['order']?$_GET['order']:'new';

$sql['select'] = 'SELECT t.*';
$sql['from'] ='FROM '.DZ::table('forum_thread').' t';

$wherearr[] = "t.fid ='$_GET[fid]'";
$wherearr[] = "t.displayorder >=0";

if($_GET['order']=='best'){
	$wherearr[] = "t.digest IN(1,2,3)";
}
if($_GET['typeid']){
	$wherearr[] = "t.typeid ='$_GET[typeid]'";
}
if($_GET['sortid']){
  $wherearr[] = "t.sortid ='$_GET[sortid]'";
	$sortsql=sortsql();
	if($sortsql){
		
		$sql['select'] .= ',s.value';
		$sql['from'] .=','.DZ::table('forum_typeoptionvar').' s ';
		$wherearr[] = "s.tid =t.tid";		
		$wherearr[] = $sortsql;
	}
	//
}
if($_S['cache']['discuz']['discuz_common']['webpic']){
	$sql['select'] .= ',p.`pid`,p.`message`';
	$sql['left'] .=" LEFT JOIN ".DZ::table('forum_post')." p ON p.`tid`=t.`tid` AND p.first='1'";	
}

	
if($_GET['order']=='hot'){
	$sql['order']='ORDER BY t.displayorder DESC,t.`replies` DESC';
}else{
	$sql['order']='ORDER BY t.displayorder DESC,t.`lastpost` DESC';
}



$select=select($sql,$wherearr,10,2);

if($select[1]) {
	$query = DZ::query($select[0]);
	while($value = DZ::fetch($query)){
		if($value['displayorder']){
			$tops[]=$value;
		}else{
			if($value['attachment']=='2'){
				$pictab[]='forum_attachment_'.substr($value['tid'], -1);
				
			}else{
				if(strpos($value['message'], '[/img]') !== FALSE && $_S['cache']['discuz']['discuz_common']['webpic']) {
					preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $value['message'], $matches);
					if(isset($matches[1])){
						$value['imgs']=$matches[1];
					}
				}				
			}
      $tids[]=$value['tid'];
			$list[$value['tid']]=$value;		
		}
		
	}
}


if($forum['threadsorts'] && $tids){
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
	$pics=getlistpic($pictab,$tids);
}





$urlstr='discuz.php?mod=forum&fid='.$_GET['fid'].'&order='.$_GET['order'];
foreach($_GET as $key => $value){
	if(!in_array($key,array('mod','fid','order','get','load','iosurl'))){
		$urlstr.='&'.$key.'='.$value;
	}
}
	
$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = $urlstr.'&page='.$nextpage;

include temp('discuz/forum');

?>