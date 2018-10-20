<?php
if(!defined('IN_SMSOT')) {
	exit;
}
function setuserstate($user){
	global $_S;
  
	$sid=$_S['member']['sid'];
	
	$cookies=$sid.'|'.$user['uid'].'|'.$user['username'].'|'.$_S['timestamp'];
	setcookies('cid', $cookies, 2592000);
	if($user['uid']){
		setcookies('auth', authcode("$user[password]\t$user[uid]", 'ENCODE'), 2592000);
		synchronizationlogin($user['dzuid']);
	}else{
		setcookies('auth');
		synchronizationlogin('out');
	}
	update('common_session',array('uid'=>$user['uid'] ,'username'=>$user['username'],'lv'=>$_S['timestamp'],'invisible'=>'0'),"sid='$sid'");
}

function synchronizationlogin($uid){
	global $_S;
	if($uid){
		if(!$_S['cache']['discuz']){
			C::chche('discuz');
		}
		if($_S['cache']['discuz']['discuz_common']['cookiepre']){
		  if(!$_S['cache']['discuz_common']){
				require_once './include/discuz/function.php';
				C::chche('discuz_common');
			}
			setcookies('synchronization', authcode("$uid", 'ENCODE',$_S['cache']['discuz_common']['authkey']), 2592000,$_S['cache']['discuz']['discuz_common']['cookiepre']);
		}		
	}
}

function insertdzuser($uid,$username,$pass,$tel='',$openid=''){
	global $_S;
	if(strlen($username)>16){
		$username=cutstr($username, 16,'');
	}
	if(DZ::fetch_first("SELECT * FROM ".DZ::table('ucenter_members')." WHERE username='$username'")){
		$username='wx_'.strtolower(random(6));
	}
	$groupid=$_S['cache']['discuz']['discuz_common']['usergroup']?$_S['cache']['discuz']['discuz_common']['usergroup']:'10';
	$salt = substr(uniqid(rand()), -6);
	$user=array(
	  'username'=>$username,
		'password'=>md5(md5($pass).$salt),
		'email'=>'null@null',
		'regip'=>get_client_ip(),
		'regdate'=>$_S['timestamp'],
		'salt'=>$salt,
	);
	$dzuid=dzinsert('ucenter_members',$user);
	dzinsert('ucenter_memberfields',array('uid'=>$dzuid));
	dzinsert('common_member',array('uid'=>$dzuid,'email'=>'null@null','username'=>$username,'password'=>md5(md5($pass)),'groupid'=>$groupid,'regdate'=>$_S['timestamp'],'timeoffset'=>9999));
	dzinsert('common_member_count',array('uid'=>$dzuid));
	dzinsert('common_member_field_forum',array('uid'=>$dzuid));
	dzinsert('common_member_field_home',array('uid'=>$dzuid));
	dzinsert('common_member_profile',array('uid'=>$dzuid));
	dzinsert('common_member_status',array('uid'=>$dzuid));
	if($tel && $_S['cache']['discuz']['discuz_aliyun']['table'] && $_S['cache']['discuz']['discuz_aliyun']['field']){
		$tel_table=$_S['cache']['discuz']['discuz_aliyun']['table'];
		$tel_field=$_S['cache']['discuz']['discuz_aliyun']['field'];
		$tel_uid=$_S['cache']['discuz']['discuz_aliyun']['uid']?$_S['cache']['discuz']['discuz_aliyun']['uid']:'uid';
		if(in_array($tel_table,array('ucenter_members','ucenter_memberfields','common_member','common_member_count','common_member_field_forum','common_member_field_home','common_member_profile','common_member_status'))){
			DZ::query("UPDATE ".DZ::table($tel_table)." SET `$tel_field`='$tel' WHERE `uid`='$dzuid'");
		}else{
			dzinsert($tel_table,array($tel_uid=>$dzuid,$tel_field=>$tel));
		}
	}
	if($openid && $_S['cache']['discuz']['discuz_wechat']['table'] && $_S['cache']['discuz']['discuz_wechat']['field']){
		$wx_table=$_S['cache']['discuz']['discuz_wechat']['table'];
		$wx_field=$_S['cache']['discuz']['discuz_wechat']['field'];
		$wx_uid=$_S['cache']['discuz']['discuz_wechat']['uid']?$_S['cache']['discuz']['discuz_wechat']['uid']:'uid';
		if(in_array($wx_table,array('ucenter_members','ucenter_memberfields','common_member','common_member_count','common_member_field_forum','common_member_field_home','common_member_profile','common_member_status',$tel_table))){
			DZ::query("UPDATE ".DZ::table($wx_table)." SET `$wx_field`='$openid' WHERE `uid`='$dzuid'");
		}else{
			dzinsert($wx_table,array($wx_uid=>$dzuid,$wx_field=>$openid));
		}
	}
	update('common_user',array('dzuid'=>$dzuid),"`uid`='$uid'");
	synchronizationlogin($dzuid);
}

function dzreg($dzuser,$password=''){
	global $_S;

	$field=array();
	$field['wechat']=$_S['cache']['discuz']['discuz_wechat']['field'];
	$field['aliyun']=$_S['cache']['discuz']['discuz_aliyun']['field'];
					
	$ip=get_client_ip();
	$salt = substr(uniqid(rand()), -6);
	$password = $password?md5(md5($password).$salt):'null';
	
	$openid=$field['wechat']?$dzuser[$field['wechat']]:'';
	$tel=$field['aliyun']?$dzuser[$field['aliyun']]:'';							
	$insert=array(
		'dzuid'=>$dzuser['uid'],
		'username'=>$dzuser['username'],
		'groupid'=>10,
		'openid'=>$openid,
		'salt'=>$salt,
		'password'=>$password,
		'tel'=>$tel,
		'regdate'=>$_S['timestamp'],
		'lastactivity'=>$_S['timestamp'],
		'regip'=>$ip,
		'lastip'=>$ip,
	);
	$uid=insert('common_user',$insert);
	if($uid){
		insert('common_user_count',array('uid'=>$uid,'experience'=>$dzuser['credits']));
		insert('common_user_profile',array('uid'=>$uid));
		insert('common_user_setting',array('uid'=>$uid));
		$user=array(
			'uid'=>$uid,
			'dzuid'=>$dzuser['uid'],
			'username'=>$username,
			'password'=>$password,
			'ip'=>$ip
		);
		setuserstate($user);
		$formuid=getcookies('formuid');
		if($formuid){
			$forumuser=getuser(array('common_user'),$formuid);
			upuser(14,$formuid);
		}
		upuser(9,$uid);
		return true;
	}else{
		return false;
	}
}
function smsmember(){
	global $_S;
	$s['tel']=trim($_GET['tel']);
	$s['code']=trim($_GET['code']);
	$s['lid']=trim($_GET['lid']);
	if(!checktel($s['tel'])){
		showmessage('手机号码错误');
	}
	if(checksmscode($s['lid'],$s['code'])){
		$member=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE tel='$s[tel]'");
		if($member){
			setuserstate($member);
			upuser(8,$member['uid']);
			upusergroup($member['uid'],$member['groupid']);
			showmessage('登录成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));			
		}else{
			loaddiscuz();
			if($_S['discuz']){
				$dzuser=getdzuser($s['tel'],'tel');
				if($dzuser){
          $check=dzreg($dzuser);
					if($check){
						showmessage('登录成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));	
					}else{
						showmessage('DZ账号同步失败');
					}
				}else{
					$smsreg=true;
				}
			}else{
				$smsreg=true;
			}
			if($smsreg){
				$salt = substr(uniqid(rand()), -6);
				$ip=get_client_ip();
				$password ='null';
				$username='MB_'.strtolower(random(6));
				$state=($_S['setting']['user_examine'] && !$_S['setting']['sms_examine'])?'0':'1';
				$uid=insert('common_user',array('username'=>$username,'groupid'=>'10','salt'=>$salt,'password'=>$password,'tel'=>$s['tel'],'regdate'=>$_S['timestamp'],'lastactivity'=>$_S['timestamp'],'regip'=>$ip,'lastip'=>$ip,'state'=>$state));
				if($uid){
					insert('common_user_count',array('uid'=>$uid));
					insert('common_user_profile',array('uid'=>$uid));
					insert('common_user_setting',array('uid'=>$uid));
					$user=array(
						'uid'=>$uid,
						'username'=>$username,
						'password'=>$password,
						'groupid'=>10,
						'ip'=>$ip
					);
					setuserstate($user);
					upuser(9,$user['uid']);
					upuser(11,$user['uid']);
					if($_S['discuz']){
						insertdzuser($uid,$username,'',$s['tel']);
					}
					/*
					showmessage('设置用户名称和登录密码，完成注册','my.php?mod=id&clear=true',array('title'=>'就剩最后一步了','default'=>'跳过','primary'=>'开始设置','clear'=>true,'js'=>'SMS.closepage();setTimeout(function(){smsot.setlogin(\''.$user['uid'].'@ui/avatar_2.jpg@'.$user['username'].'\');SMS.setlimittime(true)},100)'));
					*/
					showmessage('登录成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));
						
				}else{
					showmessage('注册失败请联系管理员');
				}				
			}
		}
	}

}

function checkusername($username){
	global $_S;
	if(strlen($username)<3 || strlen($username)>20){
		showmessage('用户名允许的长度为3-20个字节');
	}
	
	if($_S['setting']['sensitive']){
		$_S['setting']['sensitive']=explode(',',$_S['setting']['sensitive']);
		foreach($_S['setting']['sensitive'] as $sensitive){
			if(stristr($username,$sensitive)){
				showmessage('用户名种包含敏感词"'.$sensitive.'"');
			}
		}
	}
	if($_S['setting']['retain']){
		$_S['setting']['retain']=explode(',',$_S['setting']['retain']);
		foreach($_S['setting']['retain'] as $retain){
			if(stristr($username,$retain)){
				showmessage('用户名不能包含"'.$retain.'"');
			}
		}
	}
	
	return true;
}

function checkpassword($password){
	if(strlen($password)<6){
		showmessage('密码不能小于6位');
	}else{
		return true;
	}
}

function isfriend($uid){
	global $_S;
	$isfriend=DB::result_first("SELECT state FROM ".DB::table('common_friend')." WHERE uid='$_S[uid]' AND fuid='$_GET[uid]'");
	if(!$isfriend){
		return 0;
	}elseif($isfriend['state']==1){
		return 1;
	}else{
		return '-1';
	}
}

function isfollow($uid){
	global $_S;
	
	$isfollow=DB::result_first("SELECT * FROM ".DB::table('common_follow')." WHERE uid='$_S[uid]' AND fuid='$_GET[uid]'");
	if(!$isfollow){
		return false;
	}else{
		return true;
	}
}

function isblack($uid){
	global $_S;
	$isblack=DB::result_first("SELECT * FROM ".DB::table('common_friend_blacklist')." WHERE uid='$_S[uid]' AND fuid='$_GET[uid]'");
	if(!$isblack){
		return false;
	}else{
		return true;
	}
}

function setmoney($surplus,$receive){
	if($receive<=1){
		return $surplus;
	}else{
		return(rand($surplus*0.1,$surplus*0.9));
	}
}


function verifypassword($password,$uid){
	$member=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE uid='$uid'");
	$input=md5(md5($password).$member['salt']);
	if($input==$member['password']){
		return true;
	}else{
		return false;
	}
}

?>