<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$info=array();
$data=array();

$API['appid']=$_GET['mini']?$_S['setting']['mini_appid']:$_S['setting']['wx_appid'];
$API['mchid']=$_S['setting']['wx_mchid'];
$API['apikey']=$_S['setting']['wx_apikey'];

$data['paytype']=$_S['in_wechat']?($_GET['mini']?'mini':'jsapi'):'h5pay';
$data['openid']=$_GET['mini']?$_S['member']['mini']:$_S['member']['openid'];
$data['uid']=$_S['uid'];
$data['dateline']=$_S['timestamp'];
$data['ac']=$_GET['ac'];
$data['state']='0';
/*
if(!$data['openid']){
	echo "{\"error\":\"当前账号还没绑定微信无法进行支付\"}";
	exit;
}
*/
if($_GET['ac']=='recharge'){
	$info['Body']=$_S['setting']['sitename'].' - '.'充值';	
	$s['money']=$_GET['othermoney']?$_GET['othermoney']:$_GET['money'];
	$data['money']=abs(intval($s['money']))*100;
	$data['body']=serialize(array('form'=>$_GET['form']));
	if(!$data['money']){
		echo "{\"error\":\"请输入正确的充值金额\"}";
		exit;
	}
	$url=urlencode('my.php?mod=account');
}elseif($_GET['ac']=='gratuity'){
	$info['Body']=$_S['setting']['sitename'].' - '.'打赏';	
	$s['money']=$_GET['money'];
	if(!$s['money']){
		echo "{\"error\":\"请选择正确的打赏金额\"}";
		exit;
	}
	$data['money']=$s['money'];
	$data['body']=serialize(array('vid'=>$_GET['vid'],'mod'=>$_GET['modid'],'form'=>$_S['member']['username']));
	if($_GET['modid']=='discuz'){
		$url=urlencode('discuz.php?mod=view&tid='.$_GET['vid']);
	}else{
		$url=urlencode('topic.php?vid='.$_GET['vid']);
	}
}elseif($_GET['ac']=='topicpay'){
	if($_GET['tid']){
		$info['Body']=$_S['setting']['sitename'].' - '.'付费加入小组';	
		$data['body']=serialize(array('tid'=>$_GET['tid'],'form'=>$_S['member']['username']));
		$topic=DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE `tid`='$_GET[tid]'");
		$data['money']=$topic['price']*100;
		$url=urlencode('topic.php?tid='.$_GET['tid']);
	}else{
		$info['Body']=$_S['setting']['sitename'].' - '.'付费阅读';	
		$data['body']=serialize(array('vid'=>$_GET['vid'],'form'=>$_S['member']['username']));
		$theme=DB::fetch_first("SELECT * FROM ".DB::table('topic_themes')." WHERE `vid`='$_GET[vid]'");
		$data['money']=$theme['price']*100;
		$url=urlencode('topic.php?vid='.$_GET['vid']);
	}
	if(!$data['money']){
		echo "{\"error\":\"价格有误\"}";
		exit;
	}
}else{
	$ac=explode('_',$_GET['ac']);
	require_once "./hack/".$ac[0]."/jsapi.php";
}
if($_GET['mini']){
	$payurl=",\"payurl\":\"$url\"";
}	

require_once "./include/wxpay.php";

/*parameters*/
$parameters['openid']=$data['openid'];
$parameters["appid"] = $API['appid'];
$parameters["mch_id"] = $API['mchid'];
$parameters["nonce_str"] = createNoncestr();
$parameters["body"] = $info['Body'];
$parameters["out_trade_no"] = getRandChar(20);
$parameters["total_fee"] = $data['money'];
$parameters["spbill_create_ip"] = $_S['member']['ip'];
$parameters["notify_url"] = $_S['setting']['siteurl'].'notify_wx.php';
$parameters["trade_type"] = $_S['in_wechat']?'JSAPI':'MWEB';
$parameters["sign"] = getSign($API['apikey'],$parameters);


//post
$xmldata = arrayToXml($parameters);
$prepaystr = postXmlCurl($xmldata,"https://api.mch.weixin.qq.com/pay/unifiedorder");

$postObj = xmlToArray($prepaystr);

if($_GET['debug']){
	print_r($postObj);
}else{
	//order
	$order=array();
	$order['appId'] = $API['appid'];
	$order['timeStamp'] = $_S['timestamp'];
	$order['nonceStr'] = createNoncestr();
	$order['package'] = "prepay_id=".$postObj['prepay_id'];
	$order['signType']="MD5";
	$order['paySign'] = getSign($API['apikey'],$order);
	
	$data['tradeno']=$parameters["out_trade_no"];
	$data['prepayid']=$postObj["prepay_id"];
	
	
	insert('common_paylog',$data,true);
	
	if($_S['in_wechat']){
		echo "{\"appId\":\"$order[appId]\",\"timeStamp\":\"$order[timeStamp]\",\"nonceStr\":\"$order[nonceStr]\",\"package\":\"$order[package]\",\"signType\":\"$order[signType]\",\"paySign\":\"$order[paySign]\"".$payurl."}";
	}else{
		echo "{\"appId\":\"$order[appId]\",\"timeStamp\":\"$order[timeStamp]\",\"nonceStr\":\"$order[nonceStr]\",\"package\":\"$order[package]\",\"signType\":\"$order[signType]\",\"paySign\":\"$order[paySign]\",\"url\":\"$postObj[mweb_url]\"}";
	}
	
	
}


?>