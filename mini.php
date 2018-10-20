<?php
define('PHPSCRIPT', 'mini');

require_once './config.php';
require_once './include/core.php';
require_once './include/json.php';
require_once './include/function.php';

$S = new S();
$S -> star(1,true);

if($_S['setting']['mini_appid'] && $_S['setting']['mini_appsecret'] && $_GET['code']){
	$res=get_urlcontent('https://api.weixin.qq.com/sns/jscode2session?appid='.$_S['setting']['mini_appid'].'&secret='.$_S['setting']['mini_appsecret'].'&js_code='.$_GET['code'].'&grant_type=authorization_code');
	$res=JSON::decode($res);
	if($res['openid']){
		$mini = DB::fetch_first('SELECT * FROM '.DB::table('common_mini')." WHERE `mini`='".$res['openid']."'");
		if(!$mini){
			insert('common_mini',array('mini'=>$res['openid']));
		}
		echo($res['openid']);
	}else{
		if($_GET['showerr']){
			echo $res;
		}else{
			echo 'null';
		}
		//
	}
}else{
	echo 'null';
}





?>