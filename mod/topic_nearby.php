<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='附近的事';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='index.php';

//shar
$signature=signature();
$apilist='openLocation,getLocation,onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';

require_once './include/function_user.php';
if($_S['uid']){
	$city=$_S['member']['city'];
}else{
	$_S['cookie']['lbs']=getcookies('lbs');
	if(!$_S['cookie']['lbs']){
		$need=true;
	}else{
		$lbs=dunserialize($_S['cookie']['lbs']);
		$city=$lbs['city'];
	}
}
if(!$city){
	if($_S['uid']){
		$user=getuser(array('common_user_setting'),$_S['uid']);
		if(!$user['lbs']){
			showmessage('您需要在您的隐私设置里公开您的地理定位','my.php?mod=profile');
		}			
	}

	if($_S['in_wechat']){
		showmessage('需要获取您的地理位置','javascript:SMS.WxPosition(\'topic.php?mod=nearby\')');
	}else{
		showmessage('需要获取您的地理位置','javascript:SMS.Position(\''.$_S['setting']['lbs_appkey'].'\',\''.$_S['setting']['lbs_appname'].'\',SMS.SetPosition)',array('param'=>'topic.php?mod=nearby'));
	}
}
if($_S['dz']){
	loaddiscuz();

	$sql['select'] = 'SELECT t.*';
	$sql['from'] ='FROM '.DZ::table('cis_smsot').' s';
	$wherearr[] = 's.lbs LIKE'."'%$city%'";
	
	$sql['left'] .=" LEFT JOIN ".DZ::table('forum_thread')." t ON t.`tid`=s.`tid`";
	if($_S['cache']['discuz']['discuz_common']['webpic']){
		$sql['select'] .= ',p.`pid`,p.`message`';
		$sql['left'] .=" LEFT JOIN ".DZ::table('forum_post')." p ON p.`tid`=t.`tid` AND p.first='1'";		
	}

	
  $sql['order']='ORDER BY t.`dateline` DESC';
	$select=select($sql,$wherearr,10,2);
	
	if($select[1]) {
		$query = DZ::query($select[0]);
		while($value = DZ::fetch($query)){
			if($value['attachment']=='2'){
				$pictab[]='forum_attachment_'.substr($value['tid'], -1);
				$tids[]=$value['tid'];
			}else{
				if(strpos($value['message'], '[/img]') !== FALSE && $_S['cache']['discuz']['discuz_common']['webpic']) {
					preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $value['message'], $matches);
					if(isset($matches[1])){
						$value['imgs']=$matches[1];
					}
				}				
			}
			$list[$value['tid']]=$value;	
		}
	}
	
	if($pictab){
		$pics=getlistpic($pictab,$tids);
	}

}else{
	$sql['select'] = 'SELECT v.*';
	$sql['from'] ='FROM '.DB::table('topic_themes').' v';
	
	$wherearr[] = 'v.lbs LIKE'."'%$city%'";
	
	$sql['select'] .= ',u.`username`,u.`groupid`,u.`dzuid`';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.`uid`=v.`uid`";
	
	$sql['select'] .= ',t.`name`';
	$sql['left'] .=" LEFT JOIN ".DB::table('topic')." t ON t.`tid`=v.`tid`";
		
	$sql['order'] = 'ORDER BY v.dateline DESC';
	
	$select=select($sql,$wherearr,10);
	
	
	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			if($value['username']){
				$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
				$value['imgs']=dunserialize($value['imgs']);
				$value['pics']=count($value['imgs']);
				$value['topic']=$value['name'];
				$value['topic_url']='topic.php?tid='.$value['tid'];
				
				$list[$value['vid']]=$value;	
			}
		}
	}	
}

$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'topic.php?mod=nearby&page='.$nextpage;

include temp(PHPSCRIPT.'/'.$_GET['mod']);

?>