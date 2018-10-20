<?php

class SmsSenderUtil {
  /**/
	function getRandom(){
		return rand(100000, 999999);
	}
  /**/
  function calculateSig($appkey, $random, $curTime, $phoneNumbers) {
    $phoneNumbersString = $phoneNumbers[0];
    for ($i = 1; $i < count($phoneNumbers); $i++) {
      $phoneNumbersString .= ("," . $phoneNumbers[$i]);
    }
    return hash("sha256", "appkey=".$appkey."&random=".$random."&time=".$curTime."&mobile=".$phoneNumbersString);      
  }
  /**/
  function calculateSigForTemplAndPhoneNumbers($appkey, $random, $curTime, $phoneNumbers) {
    $phoneNumbersString = $phoneNumbers[0];
    for ($i = 1; $i < count($phoneNumbers); $i++) {
      $phoneNumbersString .= ("," . $phoneNumbers[$i]);
    }
    return hash("sha256", "appkey=".$appkey."&random=".$random."&time=".$curTime."&mobile=".$phoneNumbersString);       
  }
  /**/
  function phoneNumbersToArray($nationCode,$phoneNumbers) {
    $i = 0;
    $tel = array();
    do{
      $telElement = new stdClass();
      $telElement->nationcode = $nationCode;
      $telElement->mobile = $phoneNumbers[$i];
      array_push($tel, $telElement);
    }while(++$i < count($phoneNumbers));
    return $tel;
  }
	/**/
  function calculateSigForTempl($appkey, $random, $curTime, $phoneNumber) {
    $phoneNumbers = array($phoneNumber);
    return $this->calculateSigForTemplAndPhoneNumbers($appkey, $random, $curTime, $phoneNumbers);
  }
  /**/
  function sendCurlPost($url, $dataObj) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataObj));
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $ret = curl_exec($curl);
    if(false == $ret){
      $result = "{ \"result\":" . -2 . ",\"errmsg\":\"" . curl_error($curl) . "\"}";
    }else{
      $rsp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      if(200 != $rsp){
        $result = "{ \"result\":" . -1 . ",\"errmsg\":\"". $rsp . " " . curl_error($curl) ."\"}";
      }else{
        $result = $ret;
      }
    }
    curl_close($curl);
    return $result;
  }
}

class SmsSingleSender {
	var $url;
	var $appid;
	var $appkey;
	var $util;
	
	/**/
	function __construct($appid, $appkey) {
		$this->url = "https://yun.tim.qq.com/v5/tlssmssvr/sendsms";
		$this->appid =  $appid;
		$this->appkey = $appkey;
		$this->util = new SmsSenderUtil();
	}
	
	/**/
	function send($type, $nationCode, $phoneNumber, $msg, $extend = "", $ext = "") {
		$random = $this->util->getRandom();
		$curTime = time();
		$wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;
		$data = new stdClass();
		$tel = new stdClass();
		$tel->nationcode = "".$nationCode;
		$tel->mobile = "".$phoneNumber;

		$data->tel = $tel;
		$data->type = (int)$type;
		$data->msg = $msg;
		$data->sig = hash("sha256","appkey=".$this->appkey."&random=".$random."&time=".$curTime."&mobile=".$phoneNumber, FALSE);
		$data->time = $curTime;
		$data->extend = $extend;
		$data->ext = $ext;
		return $this->util->sendCurlPost($wholeUrl, $data);
	}
	/**/
	function sendWithParam($nationCode, $phoneNumber, $templId = 0, $params, $sign = "", $extend = "", $ext = "") {
		$random = $this->util->getRandom();
		$curTime = time();
		$wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;

		$data = new stdClass();
		$tel = new stdClass();
		$tel->nationcode = "".$nationCode;
		$tel->mobile = "".$phoneNumber;

		$data->tel = $tel;
		$data->sig = $this->util->calculateSigForTempl($this->appkey, $random, $curTime, $phoneNumber);
		$data->tpl_id = $templId;
		$data->params = $params;
		$data->sign = $sign;
		$data->time = $curTime;
		$data->extend = $extend;
		$data->ext = $ext;
		return $this->util->sendCurlPost($wholeUrl, $data);
		
	}
}

class SmsMultiSender {
	
	var $url;
	var $appid;
	var $appkey;
	var $util;
  /**/
	function __construct($appid, $appkey) {
		
		$this->url = "https://yun.tim.qq.com/v5/tlssmssvr/sendmultisms2";
		$this->appid =  $appid;
		$this->appkey = $appkey;
		$this->util = new SmsSenderUtil();
	}
	/**/
	function send($type, $nationCode, $phoneNumbers, $msg, $extend = "", $ext = "") {
		
		$random = $this->util->getRandom();
		$curTime = time();
		$wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;
		$data = new stdClass();
		$data->tel = $this->util->phoneNumbersToArray($nationCode, $phoneNumbers);
		$data->type = $type;
		$data->msg = $msg;
		$data->sig = $this->util->calculateSig($this->appkey, $random, $curTime, $phoneNumbers);
		$data->time = $curTime;
		$data->extend = $extend;
		$data->ext = $ext;
		return $this->util->sendCurlPost($wholeUrl, $data);
		
	}
	/**/
	function sendWithParam($nationCode, $phoneNumbers, $templId, $params, $sign = "", $extend ="", $ext = "") {
		
		$random = $this->util->getRandom();
		$curTime = time();
		$wholeUrl = $this->url . "?sdkappid=" . $this->appid . "&random=" . $random;
		$data = new stdClass();
		$data->tel = $this->util->phoneNumbersToArray($nationCode, $phoneNumbers);
		$data->sign = $sign;
		$data->tpl_id = $templId;
		$data->params = $params;
		$data->sig = $this->util->calculateSigForTemplAndPhoneNumbers(
		$this->appkey, $random, $curTime, $phoneNumbers);
		$data->time = $curTime;
		$data->extend = $extend;
		$data->ext = $ext;
		return $this->util->sendCurlPost($wholeUrl, $data);
	}
}


?>