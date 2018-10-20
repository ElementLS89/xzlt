<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle=$user['username'];
$title=$navtitle.'的个人空间-'.$_S['setting']['sitename'];
$metadescription=$user['bio'];
$keywords=$navtitle.','.$metakeywords;


//shar
$signature=signature();
$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
$_S['shar']['pic']=$_S['setting']['siteurl'].head($user,2,'src');
$_S['shar']['desc']=$metadescription;

$swiper=$_S['uid']==$uid?4:2;
if($_GET['get']!='ajax'){
	
	if($_S['uid'] && $swiper==2){
		$isfriend=isfriend($uid);
		$isfollow=isfollow($uid);
		$isblack=isblack($uid);
		$tid=maketid(array($_S['uid'],$uid));
		upuser(6,$_S['uid']);
	}
	C::chche('usergroup');
	C::chche('userfield');
	$user['group']=$_S['cache']['usergroup'][$user['groupid']]['name'];
	
	if($_S['uid']!=$uid){
		upuser(7,$user['uid']);
	}
	
	foreach($_S['cache']['userfield'] as $field=>$value){
		if($value['canuse']){
			if($user[$field]){
				if($value['type']=='date'){
					$user[$field]=smsdate($user[$field],$value['datetype']);
				}elseif($value['type']=='number'){
					$user[$field]=$user[$field].$value['unit'];
				}elseif($value['type']=='file'){
					$user[$field]='<img src="'.$_S['atc'].'/'.$user[$field].'">';
				}elseif(in_array($value['type'],array('select','radio'))){
					$user[$field]=$value['choises'][$user[$field]];
				}elseif($value['type']=='checkbox'){
					if($user[$field]){
						$user[$field]=@explode(',',$user[$field]);
						foreach($user[$field] as $v){
							$the[$field][]=$value['choises'][$v];
						}
						$user[$field]=@implode(',',$the[$field]);						
					}
				}				
			}else{
				$user[$field]=$_S['uid']==$uid?'<a href="my.php?mod=profile" class="load">前去完善</a>':'-';
			}
		}
	}
}

if($_S['dz'] && $user['dzuid'] && $_GET['show']!='sms'){

	loaddiscuz();
	$themetemp='threads_2';
	$sql['select'] = 'SELECT t.*';
	$sql['from'] ='FROM '.DZ::table('forum_thread').' t';
	
	$wherearr[] = "t.displayorder >=0";
	$wherearr[] = "t.`isgroup` ='0'";
	$sql['order']='ORDER BY t.`dateline` DESC';
	if($_GET['show']=='my' || $_S['uid']!=$uid){
		$wherearr[] = "t.authorid ='$user[dzuid]'";
		$select=select($sql,$wherearr,10,2);
	}elseif($_GET['show']=='follow'){
		$d_uids=array();
		$s_uids=array();
		$query = DZ::query("SELECT followuid FROM ".DZ::table('home_follow')." WHERE `uid` ='$user[dzuid]'");
		while($value = DZ::fetch($query)) {
			$d_uids[]=$value['followuid'];
		}
		$query = DB::query("SELECT u.dzuid FROM ".DB::table('common_follow')." f,".DB::table('common_user')." u WHERE f.`uid` ='$uid' AND u.uid=f.fuid");
		while($value = DB::fetch($query)) {
			$s_uids[]=$value['dzuid'];
		}
		$uids=array_unique(array_merge($d_uids,$s_uids));
		if($uids){
			$uidstr=implode(',',$uids);
			$wherearr[] = "t.`authorid` IN($uidstr)";
			$sql['order']='ORDER BY t.dateline DESC';
			$select=select($sql,$wherearr,10,2);
		}
	}else{
		$d_uids=array();
		$s_uids=array();
		$query = DZ::query("SELECT fuid FROM ".DZ::table('home_friend')." WHERE `uid` ='$user[dzuid]'");
		while($value = DZ::fetch($query)) {
			$d_uids[]=$value['fuid'];
		}
		$query = DB::query("SELECT u.dzuid FROM ".DB::table('common_friend')." f,".DB::table('common_user')." u WHERE f.`uid` ='$uid' AND f.state='1' AND u.uid=f.fuid");
		while($value = DB::fetch($query)) {
			$s_uids[]=$value['dzuid'];
		}
		$uids=array_unique(array_merge($d_uids,$s_uids));
		if($uids){
			$uidstr=implode(',',$uids);
			$wherearr[] = "t.`authorid` IN($uidstr)";
			$sql['order']='ORDER BY t.dateline DESC';
			
			$select=select($sql,$wherearr,10,2);
		}
	}
	if($select[1]) {
		$query = DZ::query($select[0]);
		while($value = DZ::fetch($query)){
			if($value['attachment']=='2'){
				$pictab[]='forum_attachment_'.substr($value['tid'], -1);
				$tids[]=$value['tid'];
			}
			$list[$value['tid']]=$value;
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

}else{
	if($_S['uid']==$uid){
		$sql['select'] = 'SELECT r.*';
		$sql['from'] =' FROM '.DB::table('common_record').' r';
		if($_GET['show']=='my' || $_GET['show']=='sms'){

			$sql['select'] .= ',u.username,u.groupid,u.dzuid';
			$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=r.uid";
				
			$wherearr[] = "r.`uid` ='$uid'";
			$sql['order']='ORDER BY r.dateline DESC';
			$select=select($sql,$wherearr,10);
		}elseif($_GET['show']=='follow'){
			
			$query = DB::query("SELECT f.fuid FROM ".DB::table('common_follow')." f,".DB::table('common_user_setting')." s WHERE f.`uid` ='$uid' AND s.uid=f.uid AND s.circle='1'");
			while($value = DB::fetch($query)) {
				$uids[]=$value['fuid'];
			}
			if($uids){
				$uidstr=implode(',',$uids);
				$wherearr[] = "r.`uid` IN($uidstr)";
	
				$sql['select'] .= ',u.username,u.groupid,u.dzuid';
				$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=r.uid";
				$sql['order']='ORDER BY r.dateline DESC';
				$select=select($sql,$wherearr,10);
			}

		}else{
			$query = DB::query("SELECT f.fuid FROM ".DB::table('common_friend')." f,".DB::table('common_user_setting')." s WHERE f.`uid` ='$uid' AND f.state='1' AND f.shield='0' AND s.uid=f.uid AND s.circle='1'");
			while($value = DB::fetch($query)) {
				$uids[]=$value['fuid'];
			}
			if($uids){
				$uidstr=implode(',',$uids);
				$wherearr[] = "r.`uid` IN($uidstr)";
				$sql['select'] .= ',u.username,u.groupid,u.dzuid';
				$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=r.uid";
				$sql['order']='ORDER BY r.dateline DESC';
				$select=select($sql,$wherearr,10);
			}
		}
	}else{
		if($user['circle']){
			$sql['select'] = 'SELECT r.*';
			$sql['from'] =' FROM '.DB::table('common_record').' r ';
			$sql['select'] .= ',u.username,u.groupid,u.dzuid ';
			$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=r.uid";
			$wherearr[] = " u.`uid` ='$uid'";
			$sql['order']=' ORDER BY r.dateline DESC';
			$select=select($sql,$wherearr,10);
		}
	}
	
	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			$value['pics']=dunserialize($value['pics']);
			foreach($value['pics'] as $pic){
				$value['images'][]=$pic['atc'];
			}
			$value['picnum']=count($value['images']);
			$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
			$list[$value['rid']]=$value;
		}
	}	
}




$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'user.php?uid='.$uid.($_GET['show']?'&show='.$_GET['show']:'').'&page='.$nextpage;

include temp('user/view');
?>