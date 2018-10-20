<?php

define('PHPSCRIPT', 'send');
require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';

$S = new S();
$S -> star();

if($_GET['action']=='get'){
	require_once './sdk/aliyun/smsloader.php';
	$sms = new sms($_S['setting']['aliyun-sms-key'],$_S['setting']['aliyun-sms-secret']);	
	$phonenumber=trim($_GET['tel']);
	if(in_array($_GET['item'],array('bind','reg','login'))){
		
		if(in_array($_GET['item'],array('bind','reg'))){
			$user=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE tel='$phonenumber'");
			if($user){
				showmessage('本手机号已绑定其他账号');
			}
		}
		$key='sms_'.$_GET['item'];
		$tempid=$_S['setting'][$key];
		if($tempid){
			
			$code=rand(100000, 999999);
			$res = $sms->smssend($phonenumber,$_S['setting']['aliyun-sms-sign'],$tempid,$_GET['item'],array("number"=>"$code"));
			echo $res;
		}
	}
}elseif($_GET['lid'] && $_GET['code']){
	$log=DB::fetch_first("SELECT * FROM ".DB::table('common_sms_log')." WHERE lid='$_GET[lid]'");
	if($log){
		$log['code']=dunserialize($log['code']);
		if($log['isuse']){
			showmessage('验证码已被使用');
		}elseif($log['dateline']<($_S['timestamp']-300)){
			showmessage('验证码已过期');
		}elseif($_GET['code']!=$log['number']){
			showmessage('验证码错误');
		}else{
			update('common_sms_log',array('isuse'=>1),"lid='$_GET[lid]'");
			echo 'ok';
		}
	}else{
		showmessage('出现错误请重新获取验证码');
	}
}
?>