<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if($_GET['loc']){
	require_once './include/json.php';
	$loc=JSON::decode($_GET['loc']);
	
	if($loc['lat'] && $loc['lng']){
		include ROOT.'./include/geohash.php';
		$geo = new Geohash();
		$lbs['geohash']=$geo->encode($loc['lat'],$loc['lng']);
		foreach($loc as $k=>$v){
			if(in_array($k,array('lat','lng','nation','province','city','district','addr'))){
				$lbs[$k]=$v;
			}
		}
		
	  if($_S['uid']){
			update('common_user_profile',$lbs,"`uid`='$_S[uid]'");
		}else{
			$lbs=serialize($lbs);
			setcookies('lbs', $lbs, 2592000);
		}
	}
}
?>