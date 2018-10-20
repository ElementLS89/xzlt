<?php
if(!defined('IN_SMSOT')) {
	exit;
}


function getnewname($username){
	global $_S;

	if(strlen($username)<3 || strlen($username)>20){
		$ban=1;
	}
	if($_S['setting']['sensitive']){
		$_S['setting']['sensitive']=explode(',',$_S['setting']['sensitive']);
		foreach($_S['setting']['sensitive'] as $sensitive){
			if(stristr($username,$sensitive)){
				$ban=2;
			}
		}
	}
	if($_S['setting']['retain']){
		$_S['setting']['retain']=explode(',',$_S['setting']['retain']);
		foreach($_S['setting']['retain'] as $retain){
			if(stristr($username,$retain)){
				$ban=3;
			}
		}
	}
	if(DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$username'")){
		$ban=4;
	}
	if($ban){
		$username='WE_'.strtolower(random(6));
	}else{
		$username=$username;
	}
	return $username;
}


function getapival($name='jsapi_ticket'){
	global $_S;
	$time=$_S['timestamp']-7200;
	$returnArr = array();
	C::chche('common');
	

	$cacheval=$_S['cache']['common'][$name];
	if($cacheval && $cacheval['dateline']>$time){
		return $cacheval['val'];
	}else{
		if($name=='access_token'){
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$_S['setting']['wx_appid']}&secret={$_S['setting']['wx_appsecret']}";
			$returnData = get_urlcontent($url);
			if($returnData){
				$returnArr=JSON::decode($returnData);
				if($returnArr['access_token']){
					$access_token = $returnArr['access_token'];
					if($cacheval){
						update('common_cache',array('val'=>$access_token,'dateline'=>$_S['timestamp']),"name='$name'");
					}else{
						DB::query("INSERT INTO ".DB::table('common_cache')." (`name`,`val`,`dateline`) VALUES ('access_token','$access_token','$_S[timestamp]')");
					}
					C::chche('common','update');
					return $access_token;
				}
			}
		}else{
			$access_token = getapival('access_token');
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$access_token&type=jsapi";
			$returnData = get_urlcontent($url);
			if($returnData){
				$returnArr=JSON::decode($returnData);
				if($returnArr['ticket']){
					$ticket = $returnArr['ticket'];
					if($cacheval){
						update('common_cache',array('val'=>$ticket,'dateline'=>$_S['timestamp']),"name='$name'");
					}else{
						DB::query("INSERT INTO ".DB::table('common_cache')." (`name`,`val`,`dateline`) VALUES ('jsapi_ticket','$ticket','$_S[timestamp]')");
					}
					C::chche('common','update');
					return $ticket;
				}
			}
		}
	}
}



?>