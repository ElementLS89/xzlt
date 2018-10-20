<?php
define('PHPSCRIPT', 'member');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/function_user.php';

$S = new S();
$S -> star();
$_GET['mod']=$_GET['mod']?$_GET['mod']:'login';
$navtitle=$_GET['mod']=='login'?'登录':'注册账号';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='index.php';

$_S['COOKIE']['lid']=getcookies('lid');
$referer=urlencode(referer());
if($_GET['mod']=='out'){
	$uid=$_S['member']['uid'];
	DB::query("DELETE FROM ".DB::table('common_session')." WHERE `uid`='$uid'");
	$user=array();
	setuserstate($user);
	setcookies('loginout', '1', 86400);
	$fun=$_GET['closepage']?'SMS.closepage();':'';
	showmessage('已退出','',array('type'=>'toast','fun'=>$fun.'setTimeout(function(){SMS.clear()},100);'));
}else{
	if($_S['uid']){
		showmessage('您已经登录过了',referer());
	}
	$_S['outback']=true;
	if(checksubmit('submit')){
		if($_GET['mod']=='login'){
			$s['logintype']=$_GET['logintype']?$_GET['logintype']:'comm';
			if($s['logintype']=='tel'){
				smsmember();
			}else{
				$s['username']=trim($_GET['username']);
				$s['password']=trim($_GET['password']);
				$user=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$s[username]'");
				
				if(!$user){
					loaddiscuz();
					if($_S['discuz']){
						$dzuser=getdzuser($s['username']);
						if(!$dzuser){
							showmessage('账号不存在');
						}elseif($dzuser['password']!=md5(md5($s['password']).$dzuser['salt'])){
							showmessage('密码输入错误');
						}else{
							$check=dzreg($dzuser,$s['password']);
							if($check){
								showmessage('登录成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));	
							}else{
								showmessage('DZ账号同步失败');
							}
						}
					}else{
						showmessage('账号不存在');
					}
				}elseif($user['password']!=md5(md5($s['password']).$user['salt'])){
					showmessage('密码输入错误');
				}else{
					setuserstate($user);
					upuser(8,$user['uid']);
					upusergroup($user['uid'],$user['groupid']);
					showmessage('登录成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));	          
				}						
			}
		}else{
			if($_S['setting']['agreement_open'] && !$_GET['agree']){
				showmessage('您没有同意用户注册协议,无法进行注册');
			}
			$ip=get_client_ip();
			if($_S['setting']['ip_limit_hour']){
				$dateline=$_S['timestamp']-3600;
				$limit="AND `regdate`>'$dateline'";
				
				$count=DB::result_first('SELECT COUNT(*) FROM '.DB::table('common_user')." WHERE regip='$ip' AND `regdate`>'$dateline'");
				if($count>=$_S['setting']['ip_limit_hour']){
					showmessage('同一IP地址每小时只允许注册'.$_S['setting']['ip_limit_hour'].'个账号');
				}
			}
			if($_S['setting']['ip_limit_day']){
				$dateline=$_S['timestamp']-86400;
				$limit="AND `regdate`>'$dateline'";
				
				$count=DB::result_first('SELECT COUNT(*) FROM '.DB::table('common_user')." WHERE regip='$ip' AND `regdate`>'$dateline'");
				if($count>=$_S['setting']['ip_limit_hour']){
					showmessage('同一IP地址每天只允许注册'.$_S['setting']['ip_limit_day'].'个账号');
				}
			}
			if($_S['sms_reg']){
				smsmember();
			}else{
				$salt = substr(uniqid(rand()), -6);
				$username=trim($_GET['username']);
				$s['password']=trim($_GET['password']);
				$s['password2']=trim($_GET['password2']);
				checkusername($username);
				checkpassword($s['password']);	
				if(DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$username'")){
					showmessage('用户名已存在，请换个用户名');
				}elseif($s['password']!=$s['password2']){
					showmessage('两次输入密码不一致');
				}else{
					$password = md5(md5($s['password']).$salt);	
					$state=$_S['setting']['user_examine']?'0':'1';
					$uid=insert('common_user',array('username'=>$username,'groupid'=>'10','salt'=>$salt,'password'=>$password,'regdate'=>$_S['timestamp'],'lastactivity'=>$_S['timestamp'],'regip'=>$ip,'lastip'=>$ip,'state'=>$state));	
				}
				if($uid){
					insert('common_user_count',array('uid'=>$uid));
					insert('common_user_profile',array('uid'=>$uid));
					insert('common_user_setting',array('uid'=>$uid));
					$user=array(
						'uid'=>$uid,
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
					loaddiscuz();
					if($_S['discuz']){
						insertdzuser($uid,$username,$s['password']);
					}
					showmessage('注册成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));
				}else{
					showmessage('注册失败');
				}	
			}
		}	
	}	
}
include temp('member');
?>