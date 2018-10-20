<?php
if(!defined('IN_SMSOT')) {
	exit;
}
function checksend($tid){
	global $_S;

	$touid=str_replace_limit($_S['uid'],'',$tid);
	
	$user=DB::fetch_first("SELECT u.uid,u.dzuid,u.username,u.openid,s.pm,f.fuid,b.fuid as buid FROM ".DB::table('common_user').' u LEFT JOIN '.DB::table('common_user_setting').' s  ON s.uid=u.uid LEFT JOIN '.DB::table('common_friend')." f  ON f.fuid=u.uid  AND f.uid='$_S[uid]' AND f.state='1' LEFT JOIN ".DB::table('common_friend_blacklist')." b  ON b.fuid=u.uid  AND b.uid='$_S[uid]' WHERE u.uid='$touid'");
	
	if(!$user){
		showmessage('用户不存在');
	}elseif($user['buid']){
		showmessage('对方拒绝接收');		
	}elseif(!$user['fuid'] && !$user['pm']){
	  showmessage('你们还不是好友');
	}else{
		return array($user['username'],$user['openid'],array('uid'=>$user['uid'],'dzuid'=>$user['dzuid']));
	}
}


function sendmessage($tid,$type,$summary,$message){
	global $_S;
	/*
	  1、普通消息
		2、图片
		3、语音
		4、视频
		5、红包
		6、名片
	
	*/
	$touid=str_replace_limit($_S['uid'],'',$tid);
	$table='common_talk_message_'.substr($tid,-1);
	
	$mid=insert($table,array('type'=>$type,'tid'=>$tid,'uid'=>$_S['uid'],'message'=>$message,'dateline'=>$_S['timestamp']));
	
	$talk=DB::fetch_first("SELECT i.tid,t.uid,t.newmessage FROM ".DB::table('common_talk_index').' i LEFT JOIN '.DB::table('common_talk')." t  ON t.tid=i.tid AND t.uid='$touid' WHERE i.tid='$tid'");
	
	if(!$talk['tid']){
		insert('common_talk_index',array('tid'=>$tid,'lastmessage'=>$summary,'lastdateline'=>$_S['timestamp']));
	}else{
		update('common_talk_index',array('lastmessage'=>$summary,'lastdateline'=>$_S['timestamp']),"tid='$tid'");
	}
	if(!$talk['uid']){
		insert('common_talk',array('tid'=>$tid,'uid'=>$touid,'newmessage'=>'1'));
		insert('common_talk',array('tid'=>$tid,'uid'=>$_S['uid'],'newmessage'=>'0'));
	}else{
		update('common_talk',array('newmessage'=>$talk['newmessage']+1),"tid='$tid' AND uid='$touid'");
	}
	DB::query("UPDATE ".DB::table('common_user')." SET `newmessage`=`newmessage`+'1' WHERE uid='$touid'");
	return $mid;
}

function maketalk($talk){
	global $_S;
  
	$talk['user']=array('uid'=>$talk['uid'],'dzuid'=>$talk['dzuid']);
	$talk['userclass']=$_S['uid']==$talk['uid']?'self':'friend';
	if($talk['type']==1){
		$talk['typeclass']=$_S['uid']==$talk['uid']?'message-d':'message-w';
		$talk['message']='<div class="message-content">'.smile($talk['message']).'</div>';
	}elseif($talk['type']==2){
		
		$talk['typeclass']='message-pic';
	}elseif($talk['type']==3){
		$talk['typeclass']=$_S['uid']==$talk['uid']?'message-d':'message-w';
		$talk['message']='<div class="message-content">'.$talk['message'][0].'</div>';
	}elseif($talk['type']==4){
		$talk['typeclass']='message-video';
	}elseif($talk['type']==5){
		$talk['message']=dunserialize($talk['message']);
		$talk['typeclass']='message-red';
		$btn=$_S['uid']==$talk['uid']?'查看红包':'领取红包';
		$talk['message']='<a class="message-hongbao load cl" href="hongbao.php?hid='.$talk['message']['hid'].'"><span class="icon icon-red r"></span><div class="l"><h4>'.$talk['message']['message'].'</h4><p>'.$btn.'</p></div></a><p class="b_c3 c4 s12 pl10">聊天红包</p>';
	}elseif($talk['type']==6){
		$talk['message']=dunserialize($talk['message']);
		$talk['typeclass']='message-b';
		$talk['message']='<a class="message-mingpian load cl" href="user.php?uid='.$talk['message']['uid'].'"><div class="l">'.head($talk['message'],2).'</div><div class="l"><h4>'.$talk['message']['username'].'的名片</h4><p>'.$talk['message']['gender-text'].' '.$talk['message']['age'].'岁</p></div></a><p class="b_c3 c4 s12 pl10">用户名片</p>';
		
	}else{
		
	}
	
	return $talk;
}
?>