<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='创建话题';
$title=$navtitle.'-'.$_S['setting']['sitename'];
$backurl='topic.php';
C::chche('topic_types');


if(!$_S['usergroup']['allowcreattopic']){
	showmessage('您所在用户组不允许创建话题');
}

$_S['outback']=true;
$count = DB::result_first('SELECT COUNT(*) FROM '.DB::table('topic_users')." WHERE uid='$_S[uid]' AND level='127'");

if($count>=$_S['usergroup']['allowcreattopic']){
	showmessage('您所在用户组只允许创建或者管理'.$_S['usergroup']['allowcreattopic'].'个话题');
}
if($_S['setting']['sms_need'] && !$_S['member']['tel']){
	showmessage('您需要绑定手机号之后才能进行下面的操作','my.php?mod=profile&show=3');
}

if(checksubmit('submit')){
	$s['name']=stringvar($_GET['name'],255);
	$topic=DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE `name`='$s[name]'");
	if($topic){
		showmessage('您要创建的话题已经存在，是否过去看看','topic.php?tid='.$topic['tid'],array('js'=>'SMS.closepage();'));
	}	
	$s['cover']=$_GET['cover'];
	$cover=$s['cover']?$s['cover']:'ui/nocover.jpg';
	$s['typeid']=$_GET['typeid'];
	$s['about']=stringvar($_GET['about'],255);
	$s['dateline']=$_S['timestamp'];
	$s['state']=$mygroup['examinetopic']?'0':'1';

	if(!$s['name']){
		showmessage('话题名称没有填写');
	}
	if(!$s['typeid']){
		showmessage('话题所属类别没有选择');
	}
	$tid=insert('topic',$s);
	$level=$_S['setting']['topiccreat']==1?'127':'1';
	insert('topic_users',array('tid'=>$tid,'uid'=>$_S['uid'],'dateline'=>$_S['timestamp'],'level'=>$level));
	DB::query("UPDATE ".DB::table('topic_type')." SET `topics`=`topics`+'1' WHERE `typeid`='$s[typeid]'");
	showmessage('话题创建完成，点击进入','topic.php?tid='.$tid,array('js'=>'SMS.closepage();setTimeout(function(){topic.creattopic(\''.$tid.'\',\''.$cover.'\',\''.$s['name'].'\',\''.$s['about'].'\');},100)'));
}


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>