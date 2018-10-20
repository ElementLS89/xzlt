<?php
if(!defined('IN_SMSOT')) {
	exit;
}

function clearcache($dir) {
	$tpl = dir(ROOT.'./data/'.$dir);
	while($entry = $tpl->read()) {
		if(preg_match("/\.php$/", $entry)) {
			@unlink(ROOT.'./data/'.$dir.'/'.$entry);
		}
	}
	$tpl->close();
}
function chechdelete(){
	if(!$_GET['confirm']){
		showmessage('错误的操作，请点击这里返回，并刷新页面重新操作');
	}
}
	
function isappkey($key) {
	return preg_match("/^[a-z]+[a-z0-9_]*$/i", $key);
}

function gotocloud($id,$api){
	global $_S;
	$openurl='https://www.smsot.com/open/?mod=api&form=smsot&hack='.$id.'&api='.$api.($_S['setting']['openid']?'&openid='.$_S['setting']['openid']:'');
	dheader('Location:'.$openurl);
}
function openmod($mod,$item){
	global $_S;
	if($mod=='interface' && $item=='index'){
		$uri='navs';
	}elseif($mod=='interface' && $item=='app'){
		$uri='apps';
	}elseif($mod=='interface' && $item=='color'){
		$uri='colors';
	}elseif($mod=='user' && $item=='member'){
		$uri='usergroup';
	}elseif($mod=='user' && $item=='field'){
		$uri='userfield';
	}elseif($mod=='portal' && $item=='index'){
		$uri='portal';
	}elseif($mod=='portal' && $item=='mods'){
		$uri='portal&type=mods';
	}elseif($mod=='portal' && $item=='modsstore'){
		$uri='portal&type=mods&op=store';
	}elseif($mod=='topic' && $item=='index'){
		$uri='topic';
	}elseif($mod=='index' && $item=='websocket'){
		$uri='websocket';
	}elseif($mod=='index' && $item=='dz'){
		$uri='discuz';
	}
	if($uri){
		$iframe='https://www.smsot.com/open/?mod=api&form=smsot&api='.$uri.($_S['setting']['openid']?'&openid='.$_S['setting']['openid']:'');
		return $iframe;		
	}
}



?>