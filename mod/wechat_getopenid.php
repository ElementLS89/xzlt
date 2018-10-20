<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$referer=referer();
if(!$_S['in_wechat']){
	showmessage('请通过微信访问',$referer);
}
if(!$_S['uid']){
	showmessage('您还没有登录',$referer);
}
if($_S['member']['openid']){
	showmessage('您的账号已经与微信绑定无需再绑定',$referer);
}
$auto['code']=addslashes($_GET['code']);
if($auto['code']){
	$auto['access_token']=get_urlcontent('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$_S['setting']['wx_appid'].'&secret='.$_S['setting']['wx_appsecret'].'&code='.$auto['code'].'&grant_type=authorization_code');
  $auto['access_token']=JSON::decode($auto['access_token']);
	if($auto['access_token']['access_token']){
		$openid=$auto['access_token']['openid'];
		$unionid=$auto['access_token']['unionid'];
		$user=DB::fetch_first('SELECT * FROM '.DB::table('common_user')." WHERE openid = '$openid'");
		if($user){
			showmessage('您当前登录的微信账号已经绑定过['.$user['username'].']这个账号','wechat.php?mod=login&referer='.urlencode($referer),array('primary'=>'切换到'.$user['username'],'go'=>'index.php'));
		}else{
			update('common_user',array('openid'=>$openid,'unionid'=>$unionid),"uid='$_S[uid]'");
			setcookies('wx_openid', $openid, 2592000);
			setcookies('wx_unionid', $unionid, 2592000);
			dheader('Location:'.$referer);
		}
		
	}else{
		setcookies('wx_notoken', 'yes', 60);
		dheader('Location:'.$referer);
	}
}else{
	$_S['COOKIE']['wx_notoken']=getcookies('wx_notoken');
	if($_S['COOKIE']['wx_notoken']){
		showmessage('微信绑定暂时无法使用请稍后再试',$referer);
	}else{
		$redirect=getredirect(urlencode($_S['setting']['siteurl'].'wechat.php?referer=').urlencode($referer),'snsapi_base');
		dheader('Location:'.$redirect);
	}
}

?>