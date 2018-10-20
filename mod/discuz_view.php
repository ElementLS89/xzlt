<?php
if(!defined('IN_SMSOT')) {
	exit;
}


$thread=DZ::fetch_first("SELECT * FROM ".DZ::table('forum_thread')." WHERE `tid`='$_GET[tid]'");
if(!$thread){
	showmessage('帖子不存在');
}
$forum=$_S['cache']['discuz_forum'][$thread['fid']];
$_S['poster']['api']='discuz.php?mod=view&tid='.$_GET['tid'].'&api=poster';

$check=get_userpower($forum);
if($check && !is_array($check)){
	$canmanage=true;
}else{
	$perm=forumallow($check,$forum);
}

if($_GET['get']!='ajax'){

	$navtitle='帖子详情';
	if(!$canmanage && $thread['author']!=$_S['myid']){
		//阅读权限
		if($thread['readperm'] && $_S['cache']['discuz_usergroup'][$check['groupid']]['readaccess']<$thread['readperm']){
			showmessage('您的阅读权限不足');
		}
		//付费内容
		if($thread['price'] && $thread['special']==0){
			$paylog=DZ::fetch_first("SELECT c.*,l.logid FROM ".DZ::table('common_member_count')." c LEFT JOIN ".DZ::table('common_credit_log')." l ON l.uid=c.uid AND l.relatedid='$_GET[tid]' AND l.`operation`='BTC' WHERE c.`uid`='$_S[myid]'");

			if(!$paylog['logid']){
				$extcredits=dzusl($_S['cache']['discuz_common']['extcredits']);
				$transextra=explode(',',$_S['cache']['discuz_common']['creditstrans']);
				showmessage('查看本帖需要支付'.$thread['price'].$extcredits[$transextra[0]]['title'].'，是否支付费用','discuz.php?mod=action&ac=paythread&tid='.$thread['tid']);
			}
		}		
	}
	//特殊主题
	if($thread['special']){
		showmessage('特殊主题请前往论坛查看',$_S['dz']['url'].'forum.php?mod=viewthread&tid='.$thread['tid']);
	}

	//被关闭无法回帖
	if($thread['closed']){
		
	}
	$title=$thread['subject'];
	$metadescription=$thread['subject'];
	$keywords=$forum['name'].','.$thread['subject'].','.$metakeywords;
	
	DZ::query("UPDATE ".DZ::table('forum_thread')." SET `views`=`views`+'1' WHERE tid='$_GET[tid]'");
	//shar
	$signature=signature();
	$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
	$_S['shar']['desc']=$thread['subject'];
	
	if($thread['sortid']){
		$query=DZ::query("SELECT * FROM ".DZ::table('forum_typeoptionvar')." WHERE tid ='$_GET[tid]'");
		while($value = DZ::fetch($query)){
			if($_S['cache']['discuz_typeoption'][$value['optionid']]['type']=='checkbox'){
				$value['value']=explode("\t",$value['value']);
			}elseif($_S['cache']['discuz_typeoption'][$value['optionid']]['type']=='image'){
				$value['value']=dzusl($value['value']);
			}
			$sorts[$value['optionid']]=$value;
		}
	}
	//rewards
	
  $gratuity=DB::fetch_first("SELECT * FROM ".DB::table('discuz_thread')." WHERE `tid`='$_GET[tid]'");
	if($gratuity){
		$gratuity['money']=$gratuity['money']/100;
		$query = DB::query('SELECT g.*,u.dzuid FROM '.DB::table('common_gratuity')." g LEFT JOIN ".DB::table('common_user')." u ON u.uid=g.uid WHERE g.`mod` ='discuz' AND g.`vid`='$_GET[tid]' ORDER BY g.money DESC LIMIT 6");
		while($value = DB::fetch($query)){
			$rewards[$value['gid']]=$value;
		}				
	}


	/*praise*/
	if($thread['recommend_add']){
		$query = DZ::query('SELECT * FROM '.DZ::table('forum_memberrecommend')." WHERE `tid`='$_GET[tid]' ORDER BY dateline DESC LIMIT 5");
		while($value = DZ::fetch($query)){
			$praise[]=$value;
		}
	}
	
	if(DZ::result_first("SHOW TABLES LIKE '%".DZ::table('cis_smsot')."%'")){
		$theme=DZ::fetch_first("SELECT * FROM ".DZ::table('cis_smsot')." WHERE `tid`='$_GET[tid]'");
	}
}
//回帖仅作者可见
if(getstatus($_G['forum_thread']['status'], 2) && !$canmanage && $thread['author']!=$_S['myid']){
	$hiddenreplies=true;
}

$attachs=getthreadatc($_GET['tid']);
$atcs=$attachs[0];
$firstpic=$attachs[1];


$_GET['order']=$_GET['order']?$_GET['order']:'new';

$table=$thread['posttableid']?'forum_post_'.$thread['posttableid']:'forum_post';

$sql['select'] = 'SELECT p.*';
$sql['from'] =' FROM '.DZ::table($table).' p ';

$wherearr[] = "p.tid ='$_GET[tid]'";
$wherearr[] = "p.status >=0";
$wherearr[] = "p.invisible =0";

if($_GET['show']=='author'){
	$wherearr[] = "p.authorid ='$thread[authorid]'";
}

$sql['select'] .= ',m.groupid';
$sql['left'] .=" LEFT JOIN ".DZ::table('common_member')." m ON m.uid=p.authorid";
					
if($_GET['order']=='desc'){
	$sql['order']='ORDER BY p.`dateline` DESC';
}else{
	$sql['order']='ORDER BY p.`dateline` ASC';
}



$select=select($sql,$wherearr,10,2);
if($select[1]) {
	$query = DZ::query($select[0]);
	while($value = DZ::fetch($query)){
		if(preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $value['message'], $matchaids)) {
			$attachtags[$value['pid']] = $matchaids[1];
		}
		if($value['first'] && strpos($value['message'], '[/img]') !== FALSE && $_S['cache']['discuz']['discuz_common']['webpic']) {
			preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $value['message'], $matches);
			if(isset($matches[1])){
				foreach($matches[1] as $v){
					if(strpos($v,'magcloud.net') == false){
						$webpics[]=$v;
					}
				}
			}
		}	
		$value['message']=dzbbcode($value['message'],$value['authorid'],$value['htmlon'],$value['bbcodeoff'],$value['smileyoff']);
		//tag
		if($value['first']){
			$thread['content']=$value;
			$tagarray_all = explode("\t", $value['tags']);
			if($tagarray_all) {
				foreach($tagarray_all as $var) {
					if($var) {
						$tag = explode(',', $var);
						$posttag_array[] = $tag;
						$tagids[] = $tag[0];
					}
				}
			}
			$thread['tags'] = $posttag_array;
		}else{
			$list[$value['pid']]=$value;
		}
		$pids[]=$value['pid'];
	}
}
/*relateitem*/
if($_GET['get']!='ajax' && $_S['page']==1){
	if($tagids){
		$tagids=implode(',',$tagids);
		$query = DZ::query('SELECT t.* FROM '.DZ::table('common_tagitem')." a,".DZ::table('forum_thread')." t WHERE a.idtype = 'tid' AND tagid IN($tagids) AND t.tid=a.itemid AND t.tid!='$_GET[tid]' GROUP BY t.tid ORDER BY t.`dateline` DESC LIMIT 5");
		while($value = DZ::fetch($query)){
			$relateitem[$value['tid']]=$value;
			$tids[]=$value['tid'];
			$pictab[]='forum_attachment_'.substr($value['tid'], -1);
		}
		if($pictab){
			$pictab=array_unique($pictab);
			$tidstr=implode(',',$tids);
			foreach($pictab as $table){
				$query=DZ::query("SELECT * FROM ".DZ::table($table)." WHERE tid IN($tidstr) AND isimage!=0 AND width>150 ORDER BY `dateline` ASC");
				while($value = DZ::fetch($query)){
					$relateitem_pics[$value['tid']][]=$value;
				}
			}
		}
	}	
}


$firstpic=$firstpic?$firstpic:$webpics[0];
if($_GET['api']=='poster'){
	require_once './include/poster.php';
	$date=array(
		'title'=>$thread['subject'],
		'summary'=>stringvar(strip_tags($thread['content']['message']),120),
		'pic'=>$firstpic?makelocal($firstpic,'poster',false):'',
		'url'=>$_S['setting']['siteurl'].'discuz.php?mod=view&tid='.$_GET['tid'].'&formuid='.$_S['uid'],
	);
	creatposter($date);
	exit;
}

$_S['shar']['pic']=$firstpic?$firstpic:$forum['icon'];


$urlstr='discuz.php?mod=view&tid='.$_GET['tid'];
foreach($_GET as $key => $value){
	if(!in_array($key,array('mod','tid','get','load','iosurl'))){
		$urlstr.='&'.$key.'='.$value;
	}
}
$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = $urlstr.'&page='.$nextpage;

include temp('discuz/view');
?>