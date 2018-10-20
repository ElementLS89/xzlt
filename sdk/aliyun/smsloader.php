<?php
define('ENABLE_HTTP_PROXY', FALSE);
define('HTTP_PROXY_IP', '127.0.0.1');
define('HTTP_PROXY_PORT', '8888');

require_once ROOT . './include/json.php';
require_once ROOT . './sdk/aliyun/Core/Profile/DefaultProfile.php';
include_once ROOT . './sdk/aliyun/Core/DefaultAcsClient.php';
require_once ROOT . './sdk/aliyun/Core/Regions/EndpointConfig.php';
require_once ROOT . './sdk/aliyun/Api/SendSmsRequest.php';

class sms{
	public $accesskeyid;
	public $accesskeysecret;
	
	public function __construct($accesskeyid = "",$accesskeysecret = ""){
		$this->accesskeyid = $accesskeyid;
		$this->accesskeysecret = $accesskeysecret ;
	}
	public function smssend($phoneNumbers = "",$signName = "",$templateCode = "",$item,$templatearr = array()){
		global $_S;
		
		$templateParam= JSON::encode($templatearr);
		if(empty($phoneNumbers) || empty($signName) || empty($templateCode) || empty($templateParam)){
			return;
		}
    date_default_timezone_set($_S['setting']['timezone']);
		try{
			$accessKeyId = $this->accesskeyid;
			$accessKeySecret = $this->accesskeysecret;
			$product = "Dysmsapi";
			$domain = "dysmsapi.aliyuncs.com";
			$region = "cn-hangzhou";
			
			$profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
			DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
			$acsClient= new DefaultAcsClient($profile);
			$request = new SendSmsRequest();
			$request->setPhoneNumbers($phoneNumbers);
			$request->setSignName($signName);
			$request->setTemplateCode($templateCode);
			$request->setTemplateParam($templateParam);
			$acsResponse = $acsClient->getAcsResponse($request);
			
			if($acsResponse->Code=='OK'){
				$code=serialize($templatearr);
				$lid=insert('common_sms_log',array('phonenumber'=>$phoneNumbers,'item'=>$item,'code'=>$code,'dateline'=>$_S['timestamp']));
				$acsResponse->Lid=$lid;
				setcookies('lid', $lid, 60);
			}
			
			return JSON::encode($acsResponse);
		}catch (Exception $e) {   
			return  $e->getMessage(); 
		}
	}
}
?>