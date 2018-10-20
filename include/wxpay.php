<?php
if(!defined('IN_SMSOT')) {
	exit;
}

function getRandChar($length){
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;
   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];
   }
  return $str;
}

function createNoncestr( $length = 32 ){
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
	$str ="";
	for ( $i = 0; $i < $length; $i++ )  {  
		$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
	}  
	return $str;
}

function getSign($apikey,$Obj){
	foreach ($Obj as $k => $v){
		$Parameters[$k] = $v;
	}
	ksort($Parameters);
	$String = formatBizQueryParaMap($Parameters, false);
	$String = $String."&key=$apikey";
	$String = md5($String);
	$result_ = strtoupper($String);
	return $result_;
}

function formatBizQueryParaMap($paraMap, $urlencode){

	$buff = "";
	ksort($paraMap);
	foreach ($paraMap as $k => $v){
		if($urlencode){
		   $v = urlencode($v);
		}
		$buff .= $k . "=" . $v . "&";
	}
	$reqPar;
	if (strlen($buff) > 0) {
		$reqPar = substr($buff, 0, strlen($buff)-1);
	}
	return $reqPar;
}

function arrayToXml($arr){

	$xml = "<xml>";
	foreach ($arr as $key=>$val){
	 if (is_numeric($val)){
		$xml.="<".$key.">".$val."</".$key.">"; 
	 }
	 else
		$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
	}
	$xml.="</xml>";
	return $xml; 
}

function postXmlCurl($xml,$url,$second=30){	
  
	$ch = curl_init();
	curl_setopt($ch, CURLOP_TIMEOUT, $second);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	$data = curl_exec($ch);
	curl_close($ch);
	if($data){
		curl_close($ch);
		return $data;
	}else {
		/*
		$error = curl_errno($ch);
		echo "curl error:$error"."<br>"; 
		echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>error view</a></br>";
		*/
		curl_close($ch);
		return false;
	}
}

function xmlToArray($xml){	        
	$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
	return $array_data;
}

function checkSign($apikey,$xmlarray){
	$tmpData = $xmlarray;
	unset($tmpData['sign']);
	$sign = getSign($apikey,$tmpData);
	if ($xmlarray['sign'] == $sign) {
		return TRUE;
	}
	return FALSE;
}



?>