<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$topic=DB::fetch_first("SELECT t.*,u.level FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$_GET[tid]'");
if(!$topic){
	showmessage('话题不存在');
}

$navtitle=$topic['name'];
$ismember=($topic['level'] || $topic['level']=='0')?'1':'0';
$canmanage=getpower($topic);

$topic['types']=dunserialize($topic['types']);
$topic['cover']=$topic['cover']?$_S['atc'].'/'.$topic['cover']:'ui/nocover.jpg';

$topic['liststype']=$_S['setting']['closebbs']?'6':($topic['liststype']?$topic['liststype']:'1');
$themetemp=$_S['setting']['themestyle'][$topic['liststype']]['tpl'];

$topic['usergroup']=dunserialize($topic['usergroup']);


foreach($_S['setting']['topicgroup'] as $id=>$group){
	$group['name']=$topic['usergroup'][$id]?$topic['usergroup'][$id]:$group['name'];
	$topicgroup[$id]=$group;
}

$backurl=$topic['gid']?'topic.php?mod=forum':'topic.php';

$title=$topic['name'].'-'.$_S['setting']['sitename'];
$metadescription=$topic['about'];
$keywords=$topic['name'].','.$metakeywords;

//shar
$signature=signature();
$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone,chooseWXPay';
$_S['shar']['pic']=$_S['setting']['siteurl'].($topic['cover']?$topic['cover']:'ui/ico.png');
$_S['shar']['desc']=$topic['about'];

if($topic['today'] && smsdate($_S['timestamp'],'Ymd')>smsdate($topic['lastadd'],'Ymd')){
	update('topic',array('today'=>0),"tid ='$_GET[tid]'");
}

if($topic['banner']){
	$topicskin['topbg']='transparent';
	$topicskin['body']='body_0';
	$topicskin['info']='c3';
	$topicskin['info_p']='';
}else{
	$topicskin['topbg']='b_c1';
	$topicskin['body']='';
	$topicskin['info']='b_c3 bob o_c3';
	$topicskin['info_p']='c4';
}
if($_GET['show']=='member'){
	$sql['select'] = 'SELECT t.*';
	$sql['from'] =' FROM '.DB::table('topic_users').' t';
  
	$wherearr[] = "t.tid ='$_GET[tid]'";
	$wherearr[] = "t.level >'0'";
	
	$sql['select'] .= ',u.username,u.dzuid';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=t.uid";

	$sql['select'] .= ',p.bio';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user_profile')." p ON p.uid=t.uid";
	
	$sql['order']='ORDER BY t.level DESC,t.dateline DESC';
	
	$select=select($sql,$wherearr,10);
	$leaders=0;
	$managers=0;
	
	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			if($value['username']){
				if($value['level']>125){
					if($value['level']==126){
						$managers++;
					}else{
						$leaders++;
					}
					$manager[$value['uid']]=$value;
				}else{
					$list[$value['uid']]=$value;			
				}
			}

		}
	}
	$topic['maxleaders']=$topic['maxleaders']?$topic['maxleaders']-$leaders:'0';
	$topic['maxmanagers']=$topic['maxmanagers']?$topic['maxmanagers']-$leaders:'0';
	
	
}elseif($_GET['typeid']){
	$query = DB::query("SELECT * FROM ".DB::table('topic_tips')." WHERE tid=".$_GET['tid']);
	while($value = DB::fetch($query)) {
		$tipsList[$value['vid']]=$value;
	}
}else{

	//users
	if($topic['price'] && !$topic['level'] && !$canmanage){
		$query = DB::query('SELECT t.*.u.dzuid FROM '.DB::table('topic_users')." t LEFT JOIN ".DB::table('common_user')." u ON u.uid=t.uid WHERE t.`tid` ='$_GET[tid]' AND t.`level`>'0' ORDER BY t.dateline DESC LIMIT 10");
		while($value = DB::fetch($query)){
			$users[$value['uid']]=$value;
		}		
	}
	
	$_GET['order']=$_GET['order']?$_GET['order']:'new';
	$sql['select'] = 'SELECT v.*';
	$sql['from'] =' FROM '.DB::table('topic_themes').' v';
	
	if($_GET['typeid']){
		$wherearr[] = "v.typeid ='$_GET[typeid]'";
	}
	$wherearr[] = "v.tid ='$_GET[tid]'";
	$wherearr[] = "v.`top` >='0'";
	
	$sql['select'] .= ',u.username,u.groupid,u.dzuid';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=v.uid";
	if($_GET['order']=='new'){
		$sql['order']='ORDER BY v.top DESC,v.dateline DESC';		
	}else{
		$sql['order']='ORDER BY v.top DESC,v.replys DESC';		
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
					$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
					$value['topic']=$topic['types'][$value['typeid']]?$topic['types'][$value['typeid']]:$topic['name'];
					$value['topic_url']=$topic['types'][$value['typeid']]?'topic.php?tid='.$value['tid'].'&typeid='.$value['typeid']:'topic.php?tid='.$value['tid'];
					$list[$value['vid']]=$value;			
				}				
			}
		}
	}
}

$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'topic.php?tid='.$_GET['tid'].($_GET['show']?'&show='.$_GET['show']:'').($_GET['order']?'&order='.$_GET['order']:'').($_GET['typeid']?'&typeid='.$_GET['typeid']:'').'&page='.$nextpage;




$jsonvar=array($list);

include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>