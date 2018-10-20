<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='附近的人';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='search.php?mod=user';



if($_S['uid']){
	if(!$_S['member']['geohash']){
		$need=true;
	}else{
		$geohash=substr($_S['member']['geohash'],0,$_S['setting']['lbs_geohash']);
	}
	
}else{
	$_S['cookie']['lbs']=getcookies('lbs');
	if(!$_S['cookie']['lbs']){
		$need=true;
	}else{
		$lbs=dunserialize($_S['cookie']['lbs']);
		$geohash=substr($lbs['geohash'],0,$_S['setting']['lbs_geohash']);		
	}
}

if($need){
	if($_S['in_wechat']){
		showmessage('需要获取您的地理位置','javascript:SMS.WxPosition(\'user.php?mod=nearby\')');
	}else{
		showmessage('需要获取您的地理位置','javascript:SMS.Position(\''.$_S['setting']['lbs_appkey'].'\',\''.$_S['setting']['lbs_appname'].'\',SMS.SetPosition)',array('param'=>'user.php?mod=nearby'));
	}
}
if($_S['uid']){
	$user=getuser(array('common_user_setting'),$_S['uid']);
	if(!$user['lbs']){
		showmessage('您需要在您的隐私设置里公开您的地理定位','my.php?mod=profile');
	}	
}

//shar
$signature=signature();
$apilist='openLocation,getLocation,onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';

C::chche('usergroup');
$sql['select'] = 'SELECT u.*';
$sql['from'] =' FROM '.DB::table('common_user').' u';

$sql['select'] .= ',s.lbs';
$sql['left'] .=" LEFT JOIN ".DB::table('common_user_setting')." s ON s.uid=u.uid";

$sql['select'] .= ',p.*';
$sql['left'] .=" LEFT JOIN ".DB::table('common_user_profile')." p ON p.uid=u.uid";

$wherearr[] = "s.lbs ='1'";
$wherearr[] = 'p.geohash LIKE'."'%$geohash%'";
$sql['order']='ORDER BY u.lastactivity DESC';	
$select=select($sql,$wherearr,10);
		
if($select[1]) {
	$query = DB::query($select[0]);
	while($value = DB::fetch($query)){
		$value['age']=$value['birthday']?smsdate($_S['timestamp'],'Y')-smsdate($value['birthday'],'Y'):'';
		if($value['gender']==1){
			$value['gender']='icon-male';
		}elseif($value['gender']==2){
			$value['gender']='icon-female';
		}
		if($value['lat'] && $value['lng'] && $_S['member']['lat'] && $_S['member']['lng']){
			$value['dis']=distance($value['lat'],$value['lng'],$_S['member']['lat'],$_S['member']['lng']);
			if($value['dis']=='0m'){
				$value['dis']='在你身边';
			}
		}
		$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
		$value['group']=$_S['cache']['usergroup'][$value['groupid']]['name'];
		$list[$value['uid']]=$value;
	}
}

$maxpage = @ceil($select[1]/10);
$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
$nexturl = 'user.php?mod=nearby&page='.$nextpage;


include temp(PHPSCRIPT.'/'.$_GET['mod']);	
?>