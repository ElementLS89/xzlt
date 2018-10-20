<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if(!$_S['in_wechat']){
	showmessage('请通过微信访问');
}
$referer=referer();


require_once './include/function_user.php';
$wxligin=true;
$openid=getcookies('wx_openid');
$unionid=getcookies('wx_unionid');


if($openid){
	$user=DB::fetch_first('SELECT * FROM '.DB::table('common_user')." WHERE openid = '$openid'");
	if($user){
		$wxligin=false;
		setuserstate($user);
		upuser(8,$user['uid']);
		upusergroup($user['uid'],$user['groupid']);
		if($_GET['load']){
			showmessage('登录成功',$referer,array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));	
		}else{
			dheader('Location:'.$referer);
		}
	}else{
		loaddiscuz();
		if($_S['discuz']){
			$dzuser=getdzuser($openid,'openid');
			if($dzuser){
				$check=dzreg($dzuser);
				if($check){
					showmessage('登录成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.clear()},100);'));	
				}else{
					showmessage('DZ账号同步失败');
				}
			}else{
				setcookies('wx_openid');
				setcookies('wx_unionid');		
			}
		}else{
			setcookies('wx_openid');
			setcookies('wx_unionid');	
		}
	}
}



if($wxligin){
	$auto['code']=addslashes($_GET['code']);
  
	if($auto['code']){
		$auto['access_token']=get_urlcontent('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$_S['setting']['wx_appid'].'&secret='.$_S['setting']['wx_appsecret'].'&code='.$auto['code'].'&grant_type=authorization_code');
		$auto['access_token']=JSON::decode($auto['access_token']);

		if($auto['access_token']['access_token']){
			$openid=$auto['access_token']['openid'];
			$user=DB::fetch_first('SELECT * FROM '.DB::table('common_user')." WHERE openid = '$openid'");
			if($user){
				setuserstate($user);
				upuser(8,$user['uid']);
				upusergroup($user['uid'],$user['groupid']);
				setcookies('wx_openid', $user['openid'], 2592000);
				setcookies('wx_unionid', $user['unionid'], 2592000);
				dheader('Location:'.$referer);
			}else{
				loaddiscuz();
				if($_S['discuz']){
					$dzuser=getdzuser($openid,'openid');
					if($dzuser){
						$check=dzreg($dzuser);
						if($check){
							dheader('Location:'.$referer);
						}
					}else{
						$wxget=true;
					}
				}else{
					$wxget=true;		
				}
		    if($wxget){
					$auto['user']=get_urlcontent('https://api.weixin.qq.com/sns/userinfo?access_token='.$auto['access_token']['access_token'].'&openid='.$auto['access_token']['openid'].'&lang=zh_CN');
					$auto['user']=JSON::decode($auto['user']);
					if($auto['user']['openid']){
						$s['salt'] = substr(uniqid(rand()), -6);
						$s['regip']=$s['lastip']=get_client_ip();
						$s['password'] ='null';
						$s['username']=getnewname($auto['user']['nickname']);
						$s['openid']=$auto['user']['openid'];
						$s['unionid']=$auto['user']['unionid'];
						$s['subscribe']=$auto['user']['subscribe'];
						$s['groupid']=10;
						$s['regdate']=$s['lastactivity']=$_S['timestamp'];
						$s['state']=($_S['setting']['user_examine'] && !$_S['setting']['wx_examine'])?'0':'1';
						
						$uid=insert('common_user',$s);
						if($uid){
							insert('common_user_count',array('uid'=>$uid));
							insert('common_user_profile',array('uid'=>$uid));
							insert('common_user_setting',array('uid'=>$uid));
							if($auto['user']['headimgurl']){
								require_once './include/image.php';
								$img = new image;
								$folder=array();
								$folder[0]=ceil($uid/1000000);
								$folder[1]=ceil($uid/10000);
								$folder[2]=ceil($uid/100);
								$avatar='avatar/'.$folder[0].'/'.$folder[1].'/'.$folder[2].'/'.$uid;
								$img->Thumb($auto['user']['headimgurl'],$avatar.'_1.jpg',64, 64, 'fixwr');
								$img->Thumb($auto['user']['headimgurl'],$avatar.'_2.jpg',96, 96, 'fixwr');
								$img->Thumb($auto['user']['headimgurl'],$avatar.'_3.jpg',200, 200, 'fixwr');
							}					
							$user=array(
								'uid'=>$uid,
								'username'=>$s['username'],
								'password'=>$s['password'],
								'groupid'=>$s['groupid'],
								'ip'=>$s['regip']
							);
							setuserstate($user);
							upuser(9,$uid);
							$formuid=getcookies('formuid');
							if($formuid){
								$forumuser=getuser(array('common_user'),$formuid);
								upuser(14,$formuid);
							}
							if($_S['discuz']){
								require_once './include/discuz/emoji.php';
								$username = WeChatEmoji::clear($auto['user']['nickname']);
								insertdzuser($uid,$username,'','',$s['openid']);
							}
							setcookies('wx_openid', $auto['user']['openid'], 2592000);
							setcookies('wx_unionid', $auto['user']['unionid'], 2592000);
							dheader('Location:'.$referer);
						}else{
							echo"error";
						}
					}else{
						setcookies('wx_nouser', 'yes', 60);
						dheader('Location:'.$referer);
					}					
				}
			}
			
		}else{
			setcookies('wx_notoken', 'yes', 60);
			dheader('Location:'.$referer);
		}
	}else{
		$_S['COOKIE']['wx_nouser']=getcookies('wx_nouser');
		$_S['COOKIE']['wx_notoken']=getcookies('wx_notoken');
		if($_S['COOKIE']['wx_nouser'] || $_S['COOKIE']['wx_notoken']){
			showmessage('微信登录暂时无法使用请稍后再试',$referer);
		}else{
			$redirect=getredirect(urlencode($_S['setting']['siteurl'].'wechat.php?mod=login&referer='.urlencode($referer)));
			dheader('Location:'.$redirect);
		}
	}
	
}

?>