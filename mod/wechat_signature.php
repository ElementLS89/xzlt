<?php
$url=$_GET['url'];
$ticket=getapival();
$signature=sha1('jsapi_ticket='.$ticket.'&noncestr='.$_S['hash'].'&timestamp='.$_S['timestamp'].'&url='.$url);
$return=array(
  'appid'=>$_S['setting']['wx_appid'],
	'timestamp'=>$_S['timestamp'],
	'noncestr'=>$_S['hash'],
	'signature'=>$signature,
);
header('Content-type: application/json');
echo JSON::encode($return);
?>