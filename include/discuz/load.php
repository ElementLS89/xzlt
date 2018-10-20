<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if(!$_S['cache']['discuz']){
	C::chche('discuz');
}
$_S['db']['2']['host'] = $_S['cache']['discuz']['discuz_common']['host'];
$_S['db']['2']['user'] = $_S['cache']['discuz']['discuz_common']['user'];
$_S['db']['2']['pw'] = $_S['cache']['discuz']['discuz_common']['pw'];
$_S['db']['2']['charset'] = 'utf8';
$_S['db']['2']['pconnect'] = '0';
$_S['db']['2']['name'] = $_S['cache']['discuz']['discuz_common']['name'];
$_S['db']['2']['pre'] = $_S['cache']['discuz']['discuz_common']['pre'];


if($_S['db']['2']['host'] && $_S['db']['2']['user'] && $_S['db']['2']['pw'] && $_S['db']['2']['name'] && $_S['db']['2']['pre']){
	require_once ROOT.'./include/discuz/mysql.php';
	DZ::star();
	require_once './include/discuz/function.php';
	$_S['discuz']=true;
}

if($_S['discuz']){
	$_S['dz']=array();
	$_S['dz']['atc']=strstr($_S['cache']['discuz']['discuz_common']['atc'],'://')?$_S['cache']['discuz']['discuz_common']['atc']:$_S['cache']['discuz']['discuz_common']['url'].$_S['cache']['discuz']['discuz_common']['atc'];
	$_S['dz']['remote']=$_S['cache']['discuz']['discuz_common']['remote'];
	$_S['dz']['url']=$_S['cache']['discuz']['discuz_common']['url'];
	C::chche('discuz_common');
	C::chche('discuz_forum','get',3600);
	C::chche('discuz_smile');
	C::chche('discuz_usergroup');
	C::chche('discuz_types');
	C::chche('discuz_typeoption');
	C::chche('discuz_typevar');
	C::chche('discuz_credit_rule');
	$_S['myid']=$_S['member']['dzuid']?$_S['member']['dzuid']:0;
}

?>