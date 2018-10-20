<?php
define('PHPSCRIPT', 'get');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';


$S = new S();
$S -> star();

if($_GET['type']=='talk'){
	if(!$_S['member']['uid']){
		showmessage('您需要登录后才能继续操作','member.php');
	}
	$formuid=str_replace_limit($_S['uid'],'',$_GET['tid']);
	if($_GET['show']=='list'){
	  $message=DB::fetch_first("SELECT t.newmessage,i.lastmessage,i.lastdateline,u.username,u.dzuid FROM ".DB::table('common_talk')." t,".DB::table('common_talk_index')." i,".DB::table('common_user')." u WHERE t.`tid`='$_GET[tid]' AND t.`uid`='$_S[uid]' AND i.tid=t.tid AND u.uid='$formuid'");
		$message['user']=array('uid'=>$message['uid'],'dzuid'=>$message['dzuid']);
	}else{
		require_once './include/function_talk.php';
		C::chche('smile');
		$table='common_talk_message_'.substr($_GET['tid'],-1);
		$message=DB::fetch_first("SELECT m.*,t.newmessage FROM ".DB::table($table)." m LEFT JOIN ".DB::table('common_talk')." t ON t.tid=m.tid AND t.uid='$_S[uid]' WHERE m.`mid`='$_GET[mid]'");
		
		if($message){
			if($message['newmessage']){
				$newmessage=$_S['member']['newmessage']-$message['newmessage']<0?0:$_S['member']['newmessage']-$message['newmessage'];
				update('common_talk',array('newmessage'=>'0'),"tid='$message[tid]' AND uid='$_S[uid]'");
				update('common_user',array('newmessage'=>$newmessage),"uid='$_S[uid]'");
			}
			$message=maketalk($message);
		}			
	}
}elseif($_GET['type']=='account'){
	$account=getuser(array('common_user_count'),$_S['uid']);
	if($_GET['show']=='json'){
		header('Content-type: application/json');
		$result=array('balance'=>$account['balance'],'gold'=>$account['gold']);
		require_once './include/json.php';
		$result=JSON::encode($result);
		echo $result;
		exit;
	}
}elseif($_GET['type']=='topic'){
	$topic=DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE `tid`='$_GET[tid]'");
	if(!$topic['cover']){
		$topic['cover']='ui/nocover.jpg';
	}else{
		$topic['cover']=$_S['atc'].'/'.$topic['cover'];
	}
}elseif($_GET['type']=='theme'){
	require_once './include/function_topic.php';
	
	$theme=getthemecontent($_GET['vid']);
	
	if($theme){
		if($_GET['show']=='view'){

		}else{
			$_S['setting']['themestyle']=dunserialize($_S['setting']['themestyle']);
			$themetemp=$_S['setting']['themestyle'][$_GET['liststyle']]['tpl'];
			$theme['pics']=count($theme['imgs']);
			
			$list[$theme['vid']]=$theme;
		}		
	}

}

include temp(PHPSCRIPT.'/'.$_GET['type']);
?>