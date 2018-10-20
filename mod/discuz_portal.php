<?php
if(!defined('IN_SMSOT')) {
	exit;
}
//回复文章discuz.php?mod=portal&ac=comment&aid=x
//回复评论discuz.php?mod=portal&ac=replycomment&cid=x
//编辑评论discuz.php?mod=portal&ac=edit&cid=x
//删除评论discuz.php?mod=portal&ac=del&cid=x
//点赞discuz.php?mod=portal&ac=click3&aid=x
//收藏discuz.php?mod=portal&ac=fav&aid=x

if(!$_S['myid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
if($_S['setting']['sms_need'] && !$_S['member']['tel']){
	showmessage('您需要绑定手机号之后才能进行下面的操作','my.php?mod=profile&show=3');
}

if($_GET['aid']){
	$news=DZ::fetch_first("SELECT * FROM ".DZ::table('portal_article_title')." WHERE `aid`='$_GET[aid]'");
	if(!$news){
		showmessage('文章不存在');
	}
	if($_GET['ac']=='comment' && !$news['allowcomment']){
		showmessage('文章不允许评论');
	}
	$aid=$_GET['aid'];
}
if($_GET['cid']){
	$comment=DZ::fetch_first("SELECT * FROM ".DZ::table('portal_comment')." WHERE `cid`='$_GET[cid]'");
	if(!$comment){
		showmessage('评论不存在');
	}
	if($_GET['ac']=='edit' && ($_S['usergroup']['power']<6 && $_S['myid']!=$comment['uid'])){
		showmessage('您没有权限进行本操作');
	}
	if($_GET['ac']=='replycomment'){
		$comment['summary']=strip_tags($comment['message']);
	}
	
	$aid=$comment['id'];
}

if(in_array($_GET['ac'],array('comment','replycomment','edit'))){
	$navtitle=$_GET['ac']=='edit'?'编辑评论':'添加评论';
	if(checksubmit('submit')){
		if(in_array($_GET['ac'],array('comment','replycomment'))){
			$s['uid']=$_S['myid'];
			$s['username']=$_S['member']['username'];
			$s['id']=$aid;
			$s['idtype']='aid';
			
			$s['postip']=$_S['member']['ip'];
			$s['port']='';
			$s['dateline']=$_S['timestamp'];
			$s['status']=0;			
		}
		$s['message']=parsesmiles(trim($_GET['message']),'add');
		$s['message'] = preg_replace_callback("/\s?\[quote\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s?/is", 'tpl_quote', $s['message']);
		
		if($_GET['ac']=='edit'){
			dzupdate('portal_comment',$s,"cid='$_GET[cid]'");
			showmessage('编辑成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){discuz.editcomment(\''.$_GET['cid'].'\',\''.$comment['id'].'\')},500)'));
		}else{
			$cid=dzinsert('portal_comment',$s);
			DZ::query("UPDATE ".DZ::table('portal_article_count')." SET `commentnum`=`commentnum`+ 1 WHERE `aid`='$aid'");
			showmessage('评论成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){discuz.addcomment(\''.$cid.'\',\''.$aid.'\')},500)'));
		}
	}	
	
	include temp('discuz/portal');
}elseif($_GET['ac']=='click3'){
	$click3=DZ::fetch_first("SELECT * FROM ".DZ::table('home_clickuser')." WHERE `idtype`='aid' AND `id`='$aid' AND `uid`='$_S[uid]'");
	if($click3){
		showmessage('您已参与过评分');
	}else{
		DZ::query("UPDATE ".DZ::table('portal_article_title')." SET `click3`=`click3`+ 1 WHERE `aid`='$aid'");
		$s=array(
			'uid'=>$_S['uid'],
			'username'=>$_S['member']['username'],
			'id'=>$aid,
			'idtype'=>'aid',
			'clickid'=>3,
			'dateline'=>$_S['timestamp'],
		);
		dzinsert('home_clickuser',$s);
		$recommends=$news['click3']+1;
		showmessage('操作成功','',array('type'=>'toast','fun'=>'discuz.click3(\''.$news['aid'].'\');'));
	}
}elseif($_GET['ac']=='fav'){
	$favorite=DZ::fetch_first("SELECT * FROM ".DZ::table('home_favorite')." WHERE `idtype`='aid' AND `uid`='$_S[myid]' AND `id`='$aid'");
	
	
	if($favorite){
		showmessage('已收藏');
	}
	$fav=array(
		'uid'=>$_S['myid'],
		'id'=>$aid,
		'idtype'=>'aid',
		'spaceuid'=>0,
		'title'=>$news['title'],
		'description'=>'',
		'dateline'=>$_S['timestamp'],
	);
	dzinsert('home_favorite',$fav);
	showmessage('操作成功','',array('type'=>'toast','fun'=>'discuz.fav(\''.$aid.'\',\'aid\');'));
}elseif($_GET['ac']=='del'){
	if($_S['usergroup']['power']<6){
		showmessage('没有权限');
	}
	DZ::query("DELETE FROM ".DZ::table('portal_comment')." WHERE cid='$_GET[cid]'");
	DZ::query("UPDATE ".DZ::table('portal_article_count')." SET `commentnum`=`commentnum`+ -1 WHERE `aid`='$comment[id]'");
	showmessage('删除成功','',array('type'=>'toast','fun'=>'discuz.deletecomment(\''.$comment['id'].'\',\''.$_GET['cid'].'\');'));		
}

?>