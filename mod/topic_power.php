<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if($theme['tid']){
	$topic=DB::fetch_first("SELECT t.*,u.uid,u.level,u.experience FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$theme[tid]'");
	$canmanage=getpower($topic);
}else{
	$canmanage=$theme['uid']==$_S['uid']||$_S['usergroup']['power']>5?true:false;
}


?>