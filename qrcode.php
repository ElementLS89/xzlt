<?php
@define('IN_SMSOT', TRUE);
require_once './include/qrcode.php';
$qrcode['url']=$_GET['url'];
$qrcode['size']=$_GET['size']?abs(intval($_GET['size'])):'4';
$qrcode['outfile']=$_GET['put']?$_GET['put'].'.png':false;
QRcode::png($qrcode['url'],$qrcode['outfile'],4,$qrcode['size']);
?>