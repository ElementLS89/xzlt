<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='社区';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='index.php';

//shar
$signature=signature();
$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
	
$_GET['show']=$_GET['show']?$_GET['show']:'forum';
C::chche('topic_groups');
if($_GET['show']=='forum'){
	C::chche('slider');
  foreach($_S['cache']['topic_groups'] as $group){
		$gids[]=$group['gid'];
	}
	if($gids){
		$gidstrs=implode(',',$gids);
		$query = DB::query("SELECT * FROM ".DB::table('topic')." WHERE `gid` IN($gidstrs) ORDER BY list ASC");
		while($value = DB::fetch($query)) {
			if($value['today'] && smsdate($_S['timestamp'],'Ymd')>smsdate($value['lastadd'],'Ymd')){
				$upcount[]=$value['tid'];
			}
			$value['cover']=$value['cover']?$value['cover']:'static/nocover.png';
			$forums[$value['gid']][$value['tid']]=$value;
		}
	}
	if($upcount){
		$tids=implode(',',$upcount);
		update('topic',array('today'=>0),"tid IN($tids)");
	}
	C::chche('announcement');
}else{

  $themetemp=$_GET['show']=='pics'?'themes_5':($_S['setting']['closebbs']?'themes_6':'themes_1');
	
	$sql['select'] = 'SELECT v.*';
	$sql['from'] ='FROM '.DB::table('topic_themes').' v';
  	
  if($_S['cache']['forumids']){
		$tids=implode(',',$_S['cache']['forumids']);
		$wherearr[] = "v.`tid` IN($tids)";
	}	
	if($_GET['show']=='pics'){
		$wherearr[] = "v.`imgs` !=''";
	}
	$sql['select'] .= ',u.`username`,u.`groupid`,u.`dzuid`';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.`uid`=v.`uid`";
	
	if($_GET['show']=='best'){
		$sql['order']='ORDER BY v.`praise` DESC';		
	}else{
		$sql['order']='ORDER BY v.`dateline` DESC';
	}
	
	$select=select($sql,$wherearr,10);

	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			if($value['username']){
				if($value['top']){
					$tops[]=$value;
				}else{
					$value['imgs']=dunserialize($value['imgs']);
					$value['pics']=count($value['imgs']);
					$value['topic']=$_S['cache']['forums'][$value['tid']]['name'];
					$value['topic_url']='topic.php?tid='.$value['tid'];
					$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
					$list[$value['vid']]=$value;			
				}				
			}
		}
	}

	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'topic.php?mod=forum&show='.$_GET['show'].'&page='.$nextpage;

}


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>