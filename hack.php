<?php
define('PHPSCRIPT', 'hack');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';

$S = new S();
$S -> star();



		
$id=trim($_GET['id']);
if(!$_S['cache']['hacks'][$id]){
	showmessage('当前应用不存在或没有开启');
}
$_GET['mod']=$_GET['mod']?$_GET['mod']:'index';
$hack=$_S['cache']['hacks'][$id];

if($_GET['api']!='poster'){
	include ROOT.'./hack/'.$id.'/hack.inc.php';	
}
include ROOT.'./hack/'.$id.'/include.inc.php';

?>