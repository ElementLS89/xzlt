<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('管理中心首页','admin.php?mod='.$_GET['mod'].'&item=index'),
	'basic'=>array('站点信息','admin.php?mod='.$_GET['mod'].'&item=basic'),
	'access'=>array('注册控制','admin.php?mod='.$_GET['mod'].'&item=access'),
	'money'=>array('充值与提现','admin.php?mod='.$_GET['mod'].'&item=money'),
	'credits'=>array('积分策略','admin.php?mod='.$_GET['mod'].'&item=credits'),
	'seo'=>array('SEO设置','admin.php?mod='.$_GET['mod'].'&item=seo'),
	'upload'=>array('上传设置','admin.php?mod='.$_GET['mod'].'&item=upload'),
	'imgwater'=>array('水印设置','admin.php?mod='.$_GET['mod'].'&item=imgwater'),
	'sms'=>array('手机短信','admin.php?mod='.$_GET['mod'].'&item=sms'),
	'wechat'=>array('微信相关','admin.php?mod='.$_GET['mod'].'&item=wechat'),
	'lbs'=>array('地理位置','admin.php?mod='.$_GET['mod'].'&item=lbs'),
	'dz'=>array('Discuz','admin.php?mod='.$_GET['mod'].'&item=dz'),
	'poster'=>array('分享海报','admin.php?mod='.$_GET['mod'].'&item=poster'),
	'websocket'=>array('Websocket','admin.php?mod='.$_GET['mod'].'&item=websocket'),
);

if($_GET['item']=='credits'){
	$query = DB::query("SELECT * FROM ".DB::table('common_credits')." ORDER BY cid ASC");
	while($value = DB::fetch($query)) {
		$credits[$value['cid']]=$value;
	}	
  if($_GET['ac']=='edit' && $_GET['cid']){
		$credit=$credits[$_GET['cid']];
		if(!$credit){
			showmessage('积分策略不存在');
		}
		if(checksubmit('submit')){
	    $s['cycle']=$_GET['cycle'];
			$s['rewardnum']=abs(intval($_GET['rewardnum']));
			$s['experience']=intval($_GET['experience']);
			$s['gold']=intval($_GET['gold']);
			update('common_credits',$s,"cid='$_GET[cid]'");
			C::chche('credits','update');
			showmessage('积分策略设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
		}	
	}else{
		if(checksubmit('submit')){
			foreach($_GET['cids'] as $key => $cid){
				$experience=intval($_GET['experience'][$cid]);
				$gold=intval($_GET['gold'][$cid]);
				
				update('common_credits',array('experience'=>$experience,'gold'=>$gold),"cid='$cid'");
			}
			C::chche('credits','update');
			showmessage('积分策略设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
		}		
	}
}elseif($_GET['item']=='money'){
	$_S['setting']['banks']=implode("\n",dunserialize($_S['setting']['banks']));
	$_S['setting']['withdrawals']=dunserialize($_S['setting']['withdrawals']);
	
	
	if(checksubmit('submit')){
		if($_GET['withdrawals']){
			foreach($_GET['withdrawals'] as $t){
				$withdrawals[$t]=1;
			}
			$s['withdrawals']=serialize($withdrawals);
		}
		if($_GET['commission']){
			$s['commission']=abs(intval($_GET['commission']));
		}
		if($_GET['banks']){
			$s['banks']=serialize(explode("\n",trim($_GET['banks'])));
		}
		if($_GET['recharge']){
			$s['recharge']=trim($_GET['recharge']);
		}
		if($_GET['txed']){
			$s['txed']=trim($_GET['txed']);
		}

		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].($_GET['op']?'&op='.$_GET['op']:''));	
	}
}elseif($_GET['item']=='lbs'){
	if(checksubmit('submit')){
		$s['lbs_appkey']=trim($_GET['lbs_appkey']);
		$s['lbs_appname']=trim($_GET['lbs_appname']);
		$s['lbs_geohash']=$_GET['lbs_geohash'];
		$s['getposition']=$_GET['getposition'];
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
	}
}elseif($_GET['item']=='wechat'){
	
	if(checksubmit('submit')){
		if($_GET['op']=='gzh'){
			if($_FILES['gzh_logo']['name']){
				require_once './include/upimg.php';
				$gzh_logo = upload_img($_FILES['gzh_logo'],'common','300','300');
				
				$s['gzh_logo']=$gzh_logo['attachment'].($gzh_logo['thumb']?'_300_300.jpg':'');
			}else{
				$s['gzh_logo']=$_S['setting']['gzh_logo'];
			}
			$s['gzh_show']=$_GET['gzh_show'];
			$s['gzh_text']=trim($_GET['gzh_text']);
		}elseif($_GET['op']=='xx'){
			$s['wxnotice_reply']=trim($_GET['wxnotice_reply']);
			$s['wxnotice_talk']=trim($_GET['wxnotice_talk']);
			$s['wxnotice_shang']=trim($_GET['wxnotice_shang']);
		}else{
			$s['wx_appid']=trim($_GET['wx_appid']);
			$s['wx_appsecret']=trim($_GET['wx_appsecret']);
			$s['mini_appid']=trim($_GET['mini_appid']);
			$s['mini_appsecret']=trim($_GET['mini_appsecret']);
			$s['wx_mchid']=trim($_GET['wx_mchid']);
			$s['wx_apikey']=trim($_GET['wx_apikey']);
			$s['wx_autologin']=$_GET['wx_autologin'];
			$s['wx_examine']=$_GET['wx_examine'];	
		}
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&op='.$_GET['op']);	
	}
}elseif($_GET['item']=='seo'){
	if(checksubmit('submit')){
		$s['keywords']=trim($_GET['keywords']);
		$s['description']=trim($_GET['description']);
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
	}
}elseif($_GET['item']=='functions'){
	
}elseif($_GET['item']=='upload'){
	if(checksubmit('submit')){
		if($_GET['op']=='qiniu'){
		  $s['qiniu_ak']=trim($_GET['qiniu_ak']);
			$s['qiniu_sk']=trim($_GET['qiniu_sk']);
			$s['qiniu_bucket']=trim($_GET['qiniu_bucket']);
			$s['qiniu_endpoint']=$_GET['qiniu_endpoint'];
			$s['qiniu_domain']=trim($_GET['qiniu_domain']);
			$s['qiniu_resolution']=trim($_GET['qiniu_resolution']);
			$s['qiniu_pipeline']=trim($_GET['qiniu_pipeline']);
			$s['qiniu_frame']=$_GET['qiniu_frame']?intval($_GET['qiniu_frame']):'5';
			$s['qiniu_play']=$_GET['qiniu_play'];
			if(!$s['qiniu_ak'] || !$s['qiniu_sk'] || !$s['qiniu_bucket'] || !$s['qiniu_domain'] || !$s['qiniu_resolution'] || !$s['qiniu_frame'] || !$s['qiniu_endpoint'] || !$s['qiniu_pipeline']){
				showmessage('表单填写不完整');
			}
		}else{
			$s['attach']=trim($_GET['attach']);
			$s['imagelib']=$_GET['imagelib'];
			$s['thumbquality']=intval($_GET['thumbquality']);
			if($s['thumbquality']>100 || $s['thumbquality']<0){
				showmessage('缩略图的质量参数，范围为 0～100 的整数');
			}				
		}
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
	}
}elseif($_GET['item']=='sms'){
	if(checksubmit('submit')){
		$s['aliyun-sms-sign']=trim($_GET['aliyun-sms-sign']);
		$s['aliyun-sms-key']=trim($_GET['aliyun-sms-key']);
		$s['aliyun-sms-secret']=trim($_GET['aliyun-sms-secret']);
		$s['sms_bind']=trim($_GET['sms_bind']);
		$s['sms_reg']=trim($_GET['sms_reg']);
		$s['sms_login']=trim($_GET['sms_login']);
		$s['sms_need']=$_GET['sms_need'];
    $s['sms_examine']=$_GET['sms_examine'];
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
		
	}
	
}elseif($_GET['item']=='imgwater'){
	if(checksubmit('submit')){
		$s['watermarkstatus']=$_GET['watermarkstatus'];
		$s['watermarkminwidth']=intval($_GET['watermarkminwidth']);
		$s['watermarkminheight']=intval($_GET['watermarkminheight']);
		$s['watermarktrans']=intval($_GET['watermarktrans']);
		$s['watermarkquality']=intval($_GET['watermarkquality']);
		if($s['watermarktrans']>100 || $s['watermarktrans']<0){
			showmessage('水印融合度，范围为 0～100 的整数');
		}
		if($s['watermarkquality']>100 || $s['watermarkquality']<0){
			showmessage('水印质量，范围为 0～100 的整数');
		}
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
		
	}
}elseif($_GET['item']=='access'){
	if(checksubmit('submit')){
		$s['ip_limit_hour']=intval($_GET['ip_limit_hour']);
		$s['ip_limit_day']=intval($_GET['ip_limit_day']);
		$s['user_examine']=$_GET['user_examine'];
		$s['agreement_open']=$_GET['agreement_open'];
		$s['agreement']=striptags($_GET['agreement']);
		$s['retain']=str_replace('，',',',$_GET['retain']);
		$s['alloweditusername']=$_GET['alloweditusername'];
		$s['alloweditusername']=$_GET['alloweditusername'];
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
		
	}
}elseif($_GET['item']=='basic'){

	if(checksubmit('submit')){
		if($_FILES['qrcode']['name']){
			require_once './include/upimg.php';
			$qrcode = upload_img($_FILES['qrcode'],'common','300','300');
			$s['qrcode']=$qrcode['attachment'].($qrcode['thumb']?'_300_300.jpg':'');
		}else{
			$s['qrcode']=$_S['setting']['qrcode'];
		}
		$s['sitename']=trim($_GET['sitename']);
		$s['siteurl']=trim($_GET['siteurl']);
		$s['sensitive']=str_replace('，',',',$_GET['sensitive']);
		$s['close']=$_GET['close'];
		$s['pc']=$_GET['pc'];
		$s['closebbs']=$_GET['closebbs'];

		if(!$s['sitename']){
			showmessage('站点名称不能为空');
		}
		if(!$s['siteurl']){
			showmessage('站点URL地址不能为空');
		}
		if(substr($s['siteurl'],-1)!='/'){
			showmessage('站点URL最后应该包含"/"');
		}		
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
	}
}elseif($_GET['item']=='poster'){

	if(checksubmit('submit')){
		if($_FILES['poster_pic']['name']){
			require_once './include/upimg.php';
			$poster_pic = upload_img($_FILES['poster_pic'],'common','640','600');
			$s['poster_pic']=$poster_pic['attachment'].($poster_pic['thumb']?'_640_600.jpg':'');
		}else{
			$s['poster_pic']=$_S['setting']['poster_pic'];
		}
		$s['poster_title']=trim($_GET['poster_title']);
		$s['poster_summary']=trim($_GET['poster_summary']);
		$s['poster_name']=trim($_GET['poster_name']);
		$s['poster_info']=trim($_GET['poster_info']);


		if(!$s['poster_title']){
			showmessage('默认宣传标题不能为空');
		}
		if(!$s['poster_summary']){
			showmessage('默认海报描述不能为空');
		}
		if(!$s['poster_pic']){
			showmessage('默认海报图片没有上传');
		}
		foreach($s as $fild=>$value){
			update('common_setting',array('k'=>$fild,'v'=>$value),'',true);
		}
		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
	}
}else{
	
	$serverinfo = PHP_OS;
  $serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
	$phpinfo = 'PHP v'.PHP_VERSION;
	//$mysqlinfo=mysql_get_server_info();
	$magic_quote_gpc = get_magic_quotes_gpc() ? 'On' : 'Off';
	$allow_url_fopen = ini_get('allow_url_fopen') ? 'On' : 'Off';
	if(@ini_get('file_uploads')) {
		$fileupload = ini_get('upload_max_filesize');
	} else {
		$fileupload = '<font color="red">'.$lang['no'].'</font>';
	}
	/**/
	require_once './include/json.php';
	$noticelist=get_urlcontent('https://www.smsot.com/open/?mod=notice');
  $noticelist=JSON::decode($noticelist);
	foreach($noticelist as $value){
		if(($value['v'] && $value['v']>$_S['setting']['version']) || !$value['v']){
			$notice[]=$value;
		}
	}
}
?>