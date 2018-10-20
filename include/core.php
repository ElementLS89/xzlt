<?php
error_reporting(0);
@define('ROOT', substr(dirname(__FILE__), 0, -7));
@define('IN_SMSOT', TRUE);
require_once './include/mysql.php';
require_once './include/cache.php';


class S{
	
	var $stared = false;
	
	function star($serverid='1',$robot=false) {
		global $_S;
		if(!$_S['db'][1]['user'] && !$_S['db'][1]['pw'] && !$_S['db'][1]['name']){
			header('location: install');
		}

		$_S['driver'] = function_exists('mysql_connect') ? 'db_driver_mysql' : 'db_driver_mysqli';
		$this -> star_db($serverid);
		$this -> star_input();
		$this -> phpscript();
		$this -> smsvalue();
		C::chche('hacks');
		if($_S['setting']['version']>=1.15){
			C::chche('icon');
		}
		if(!$robot){
			if($_GET['mini'] && $_GET['mini']!='null'){
				setcookies('mini', $_GET['mini'], 864000);
			}			
			$this -> upusersession();
			if(!$_S['usergroup']['allowvisit']){
				showmessage('您还未获得访问权限');
			}
			if($_S['setting']['close'] && $_S['usergroup']['gid']!='1'){
				showmessage('站点已关闭，请稍后再来访问');
			}
			$loginout=getcookies('loginout');
			if(PHPSCRIPT !='wechat' && !$_S['uid'] && $_S['in_wechat'] && $_S['wechat'] && !$loginout && $_S['setting']['wx_autologin']){
				$referer=referer();
				dheader('Location:'.'wechat.php?mod=login&referer='.$referer);
			}
		}else{
			if($_S['setting']['close']){
				showmessage('站点已关闭，请稍后再来访问');
			}			
		}
		$this -> navs();
	}
	
  function star_db($serverid) {
		global $_S;
		include_once ROOT.'./include/db/'.$_S['driver'].'.php';
		DB::star($_S['driver'], $_S['db'],$serverid);
	}
	
	function star_input() {
		global $_S;
		
		if (isset($_GET['GLOBALS']) ||isset($_POST['GLOBALS']) ||  isset($_COOKIE['GLOBALS']) || isset($_FILES['GLOBALS'])) {
			error('request_tainting');
		}
		if(MAGIC_QUOTES_GPC) {
			$_GET = dstripslashes($_GET);
			$_POST = dstripslashes($_POST);
		}
		
		$prelength = strlen($_S['cookie']['cookiepre']);
		
		if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
			$_GET = array_merge($_GET, $_POST);
		}

		if(isset($_GET['page'])) {
			$_GET['page'] = rawurlencode($_GET['page']);
		}
    return $_GET;
	}
	
	function smsvalue(){
		global $_S,$title;
		$_S['hash']=formhash();
		$_S['timestamp']=time();
		$_S['page']=$_GET['page']?$_GET['page']:'1';
    $_S['mobile']=checkmobile();
		$_S['atcdir']=ROOT.'./'.$_S['atc'];

		$cachefile=ROOT.'./data/cache/setting.php';
    
		if(!is_file($cachefile)) {
			$setting='$_S[\'setting\']=array('."\r\n";
			$query = DB::query('SELECT * FROM '.DB::table('common_setting'));
			while($value = DB::fetch($query)) {
				$setting .='\''.$value['k'].'\'=>'.'\''.$value['v'].'\','."\r\n";
			}
			$setting .=');';
			writefile(ROOT.'./data/cache/setting.php', $setting, 'php', 'w', 0);			
		}else{
			include_once $cachefile;
		}
		
		if($_S['setting']['aliyun-sms-key'] && $_S['setting']['aliyun-sms-secret'] && $_S['setting']['aliyun-sms-sign']){
			if($_S['setting']['sms_reg']){
				$_S['sms_reg']=true;
			}
			if($_S['setting']['sms_login']){
				$_S['sms_login']=true;
			}
			if($_S['setting']['sms_bind']){
				$_S['sms_bind']=true;
			}
		}

		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'miniProgram') !== false){
				$_S['miniProgram']=true;
			}
			$_S['bro']='wechat';
		}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MQQBrowser') !== false){
			$_S['bro']='qqbro';
		}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'UCBrowser') !== false){
			$_S['bro']='ucbro';
		}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/') !== false){
			$_S['bro']='qq';
		}else{
			$_S['bro']='other';
		}
		C::chche('apps');
		$_S['app']['header']='true';
		foreach($_S['cache']['apps'] as $value){
			if(strpos($_SERVER['HTTP_USER_AGENT'], $value['ua']) !== false){
				$value['header']=$value['hideheader']?'false':'true';
				if($value['hideheader'] && $value['hidefooter']){
					$value['body']='nohf';
				}elseif($value['hideheader'] && !$value['hidefooter']){
					$value['body']='noheader';
				}elseif(!$value['hideheader'] && $value['hidefooter']){
					$value['body']='nofooter';
				}
				$_S['app']=$value;
			}
		}
		
		C::chche('temp');
		$_S['temp']=$_S['mobile']?$_S['cache']['temp']['touch']:$_S['cache']['temp']['pc'];
		if(!$_S['temp']['dir']){
			$_S['temp']['dir']='default';
		}
		
		$_S['setting']['timezone']=$_S['setting']['timezone']?$_S['setting']['timezone']:'Asia/Shanghai';
		$_S['in_wechat']=strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false?true:false;
		$_S['wechat']= $_S['setting']['wx_appid'] && $_S['setting']['wx_appsecret']?true:false;
		$_S['shar']['desc']=$_S['setting']['description'];
		$_S['shar']['pic']=$_S['setting']['siteurl'].'ui/ico.png';
		
		$_S['wxpay']=$_S['setting']['wx_appid'] && $_S['setting']['wx_appsecret'] && $_S['setting']['wx_mchid'] && $_S['setting']['wx_apikey']?true:false;
		$_S['alipay']=false;
		if($_S['setting']['wsip'] && $_S['setting']['wsport'] && $_S['setting']['wscount'] && $_S['setting']['wslanip'] && $_S['setting']['wsstartport'] && $_S['setting']['wsregister'] && $_S['setting']['protocol']){
			$_S['setting']['websocket']=true;
		}
		if($_S['setting']['gzh_logo'] && $_S['setting']['gzh_text']){
			$_S['gzh']=true;
		}
		
		if($_S['setting']['qiniu_ak'] && $_S['setting']['qiniu_sk'] && $_S['setting']['qiniu_bucket'] && $_S['setting']['qiniu_domain'] && $_S['setting']['qiniu_resolution'] && $_S['setting']['qiniu_frame']){
			$_S['qiniu']=true;
		}
		if(!$_S['cache']['discuz']){
			C::chche('discuz');
		}
		if($_S['cache']['discuz']['discuz_common']['host'] && $_S['cache']['discuz']['discuz_common']['user'] && $_S['cache']['discuz']['discuz_common']['pw'] && $_S['cache']['discuz']['discuz_common']['name'] && $_S['cache']['discuz']['discuz_common']['pre']){
			$_S['dz']=true;
		}

	}
	function navs(){
		global $_S;
		
    C::chche('navs');
		foreach($_S['cache']['navs']['nav_bot'] as $id=>$value){
			$value['url'] = preg_replace_callback("/{#(.+?)}/is", 'echovar', $value['url']);
			if($_S['setting']['closebbs'] && in_array($value['url'],array('topic.php','topic.php?mod=forum','topic.php?mod=post','discuz.php'))){
				$value['close']=true;
			}
			if($value['canuse'] && !$value['close']){
				$_S['tabbar'][$id]=$value;
				$_S['botnavurl'][$id]=$value['url'];
			}
		}
		foreach($_S['cache']['navs']['nav_find'] as $id=>$value){
			$value['url'] = preg_replace_callback("/{#(.+?)}/is", 'echovar', $value['url']);
			$_S['cache']['navs']['nav_find'][$id]=$value;
		}
		foreach($_S['cache']['navs']['nav_write'] as $id=>$value){
			$value['url'] = preg_replace_callback("/{#(.+?)}/is", 'echovar', $value['url']);
			$_S['cache']['navs']['nav_write'][$id]=$value;
		}
		foreach($_S['cache']['navs']['nav_side'] as $id=>$value){
			$value['url'] = preg_replace_callback("/{#(.+?)}/is", 'echovar', $value['url']);
			$_S['cache']['navs']['nav_side'][$id]=$value;
		}
    $_S['currentkey']=getcurrentnav($_S['botnavurl']);		
	}
	

	function phpscript(){
		global $_S;
		foreach($_GET as $k=>$v){
			$urlarr[]=$k.'='.$v;
		}
		$urlstr=@implode('&',$urlarr);
		$_S['php']=PHPSCRIPT.'.php'.($urlstr?'?'.$urlstr:'');
	}
	
	function upusersession(){
		global $_S;
		// 0:sid 1:uid 2:username 3:settime
		$config = $_S['config']['cookie'];
		$cookieid = $config['cookiepre'] ? $config['cookiepre'].'cid' : 'cid';
    $usercookie=$_COOKIE[$cookieid];
		$miniopenid=$_COOKIE[$config['cookiepre'].'mini'];
		$lastactivity=time();
    
		
		if($usercookie){
			$user=explode('|',$usercookie);
			if($user[1]){
				$session=DB::fetch_first("SELECT s.sid,s.ip,s.lv,s.invisible,u.*,p.* FROM ".DB::table('common_session').' s LEFT JOIN '.DB::table('common_user')." u  ON u.uid=s.uid LEFT JOIN ".DB::table('common_user_profile')." p ON p.uid=s.uid WHERE s.sid='$user[0]'");
			}else{
				$session=DB::fetch_first("SELECT * FROM ".DB::table('common_session')." WHERE sid='$user[0]'");
			}
			

			if($session){
				if(($session['lv']+600)<$lastactivity){
					update('common_session',array('lv'=>$lastactivity),"sid='$user[0]'");
					if($user[1]){
						DB::query("UPDATE ".DB::table('common_user')." SET `lastactivity`='$lastactivity' WHERE `uid`='$user[1]'");
					}
				}
				$member=$session;
			}else{
				$_S['COOKIE']['auth']=getcookies('auth');

				if($_S['COOKIE']['auth']){
					$auth = explode("\t",authcode($_S['COOKIE']['auth'], 'DECODE'));

					if($auth[1]!=$user[1]){
						$sid=substr(md5(time()), 8, 10).'|||';
						setcookies('cid', array('sid'=>$sid), 2592000);
						setcookies('auth');
					
					}else{
						$thisuser=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE uid='$auth[1]'");
						if($thisuser['password']==$auth[0]){
							$verify=true;
							$sid=$user[0];	
						}else{
							$sid=substr(md5(time()), 8, 10).'|||';
							setcookies('cid', array('sid'=>$sid), 2592000);
							setcookies('auth');
						}
					}
				}else{
				  $sid=$user[0];	
				}

				$ip=get_client_ip();
				if($verify){
					$session=array('sid'=>$sid,'ip'=>$ip,'uid'=>$user[1] ,'username'=>$user[2],'lv'=>$lastactivity,'invisible'=>'0');
					insert('common_session',$session);					

					DB::query("UPDATE ".DB::table('common_user')." SET `lastactivity`='$lastactivity' WHERE `uid`='$user[1]'");
					$member=$thisuser;
					$member['sid']=$sid;
					$member['ip']=$ip;
					$member['lv']=$lastactivity;
					$member['invisible']='0';
				}else{
					$session=array('sid'=>$sid,'ip'=>$ip,'uid'=>'0' ,'username'=>'','lv'=>$lastactivity,'invisible'=>'0');
					insert('common_session',$session);
					$member=$session;
				}
			}
			if(($user[3]+864000)>$lastactivity){
				$cookies=$user[0].'|'.$user[1].'|'.$user[2].'|'.$lastactivity;
				setcookies('cid', $cookies, 2592000);
			}else{
				$cookies=$usercookie;
			}
			
		}else{
			$sid=substr(md5(time()), 8, 10);
			$ip=get_client_ip();
			
			$cookies=$sid.'|||';
			$member=array('sid'=>$sid,'ip'=>$ip,'uid'=>'0','username'=>'','groupid'=>'5','lv'=>$lastactivity,'invisible'=>'0');
			setcookies('cid', $cookies, 2592000);
			setcookies('auth');	
		}
		if(defined('ADMIN')){
			$deletetime=time()-1800;
			DB::query("DELETE FROM ".DB::table('common_adminsession')." WHERE `dateline` <'$deletetime'");
			$adminsession=DB::fetch_first("SELECT * FROM ".DB::table('common_adminsession')." WHERE sid='$member[sid]'");
			if($adminsession){
				DB::query("UPDATE ".DB::table('common_adminsession')." SET `dateline`='$lastactivity' WHERE `sid`='$member[sid]'");
			}
			$_S['admin']=$adminsession;
		}
    $member['style']=$member['style']?$member['style']:$_S['setting']['default_style'];
		$deletetime=time()-1800;
		DB::query("DELETE FROM ".DB::table('common_session')." WHERE `lv`<'$deletetime'");
		$_S['cookie']['cid']=$cookies;
		$_S['member']=$member;
		if($member['uid']){
			$_S['uid']=$member['uid'];
			
			if($miniopenid && !$member['mini']){
				$mini=DB::fetch_first("SELECT * FROM ".DB::table('common_mini')." WHERE mini='$miniopenid' AND uid='0'");
				if($mini){
					DB::query("UPDATE ".DB::table('common_mini')." SET `uid`='$member[uid]' WHERE `mini`='$miniopenid'");
				}
				DB::query("UPDATE ".DB::table('common_user')." SET `mini`='$miniopenid' WHERE `uid`='$member[uid]'");
			}
		}
		if($_GET['formuid'] && $_GET['formuid']!=$_S['uid']){
			if(!getcookies('formuid')){
				$forumuser=getuser(array('common_user'),$_GET['formuid']);
				if($forumuser){
					setcookies('formuid', $_GET['formuid'], 86400);
					upuser(13,$_GET['formuid']);
				}				
			}
		}

		$_S['member']['groupid']=$_S['member']['groupid']?$_S['member']['groupid']:'5';
		C::chche('usergroup');
		$_S['usergroup']=$_S['cache']['usergroup'][$_S['member']['groupid']];
		
	}
}
?>