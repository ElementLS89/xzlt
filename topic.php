<?php
define('PHPSCRIPT', 'topic');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/function_topic.php';



$S = new S();
$S -> star();
if(!$_GET['mod']){
	if($_GET['tid']){
		$_GET['mod']='viewtopic';
	}elseif($_GET['vid']){
		$_GET['mod']='viewtheme';
	}	
}
$_GET['mod']=$_GET['mod']?$_GET['mod']:'index';
$_S['setting']['themestyle']=dunserialize($_S['setting']['themestyle']);
$_S['setting']['topicgroup']=dunserialize($_S['setting']['topicgroup']);


require './mod/topic_'.$_GET['mod'].'.php';
?>