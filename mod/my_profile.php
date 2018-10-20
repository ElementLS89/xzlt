<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='个人设置';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='my.php';
require_once './include/function_user.php';
C::chche('userfield');	

$swiper=$_S['sms_bind']?4:3;
$swiper=$_S['member']['password']=='null'?$swiper-1:$swiper;

$uid=$_S['member']['uid'];
$my=getuser(array('common_user','common_user_count','common_user_profile','common_user_setting'),$uid);
if($my['tel']){
	$my['tel']='*******'.substr($my['tel'],7,4);
}

if(checksubmit('submit')){
	if($_GET['action']=='index'){
		require_once './include/upimg.php';
		
		foreach($_S['cache']['userfield'] as $field=>$value){
			if($value['canuse']){
				if($value['need'] && $_GET[$field]==''){
					showmessage($value['name'].'没有填写');
				}
				if($_GET[$field]!=''){
					if($value['type']=='date'){
						$s[$field]=$_GET[$field]?strtotime($_GET[$field]):'';
					}elseif($value['type']=='checkbox'){
						$s[$field]=$_GET[$field]?implode(',',$_GET[$field]):'';
					}elseif($value['type']=='number'){
						$s[$field]=is_numeric($_GET[$field])?$_GET[$field]:'';
						if($value['max'] && $s[$field]>$value['max']){
							showmessage($value['name'].'不能超过'.$value['max']);
						}
						if($value['min'] && $s[$field]<$value['min']){
							showmessage($value['name'].'不能小于'.$value['min']);
						}
					}elseif(in_array($value['type'],array('text','textarea'))){
						if($value['max']){
							$s[$field]=stringvar($_GET[$field],$value['max']);
						}else{
							$s[$field]=trim($_GET[$field]);
						}
						if($value['min'] && strlen($s[$field])<$value['min']){
							showmessage($value['name'].'不能小于'.$value['min'].'个字节');
						}
					}elseif($value['type']=='file'){
						if($_FILES[$field]['name']){
							$file = upload_img($_FILES[$field],'common',$value['width'],$value['height']);
							$s[$field]=$file['attachment'].($file['thumb']?'_'.$value['width'].'_'.$value['height'].'.jpg':'');
						}
					}else{
						$s[$field]=$_GET[$field];
					}
				}
			}
		}
		if($s){
			update('common_user_profile',$s,"uid='$uid'");
			showmessage('设置成功','',array('type'=>'toast','fun'=>'SMS.deleteitem(\'my.php?mod=profile\',false);SMS.deleteitem(\'user.php\',false)'));			
		}
	}elseif($_GET['action']=='security'){
		$s['password_old']=trim($_GET['password_old']);
		$s['password1']=trim($_GET['password1']);
		$s['password2']=trim($_GET['password2']);
		
		if($_S['member']['password']!=md5(md5($s['password_old']).$_S['member']['salt'])){
			showmessage('原始密码输入错误');
		}elseif($s['password1']!=$s['password2']){
			showmessage('两次密码输入不一致');
		}else{
			$password=md5(md5($s['password1']).$_S['member']['salt']);
			$update=array('password'=>$password);
			update('common_user',$update,"uid='$uid'");
      if($_S['dz'] && $_S['member']['dzuid']){
				$dzuid=$_S['member']['dzuid'];
				loaddiscuz();
				dzupdate('ucenter_members',array('password'=>$password,'salt'=>$_S['member']['salt']),"uid='$dzuid'");
			}
			DB::query("DELETE FROM ".DB::table('common_session')." WHERE `uid`='$uid'");
			$user=array();
			setuserstate($user);
			showmessage('新密码设置成功，您现在需要重新登录','member.php?clear=true',array('clear'=>true,'must'=>true,'js'=>'smsot.setlogin(\'0@ui/avatar_2.jpg@登录\');'));

		}
	}elseif($_GET['action']=='privacy'){
		$s['lbs']=$_GET['lbs'];
		$s['profile']=$_GET['profile'];
		$s['pm']=$_GET['pm'];
		$s['friend']=$_GET['friend'];
		$s['circle']=$_GET['circle'];
		
		update('common_user_setting',$s,"uid='$uid'");
		showmessage('设置成功','',array('type'=>'toast','fun'=>'SMS.deleteitem(\'my.php?mod=profile\',false);SMS.deleteitem(\'user.php?mod=nearby\',false);'));
		
	}elseif($_GET['action']=='tel'){
		$s['lid']=$_GET['lid'];
		$s['tel']=trim($_GET['tel']);
		$s['code']=trim($_GET['code']);
		$s['password']=trim($_GET['password']);

		if($_S['member']['password']!='null' && $_S['member']['password']!=md5(md5($s['password']).$_S['member']['salt'])){
			showmessage('密码输入错误');
		}elseif(!checksmscode($s['lid'],$s['code'])){
			showmessage('验证码错误');			
		}else{
			update('common_user',array('tel'=>$s['tel']),"uid='$uid'");
			upuser(11,$uid);
			showmessage('绑定成功','',array('type'=>'toast','fun'=>'SMS.deleteitem(\'my.php?mod=profile\',false);'));
		}
	}
}


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>