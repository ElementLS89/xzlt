<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='论坛';
if($_GET['tid']){
	$thread=DZ::fetch_first("SELECT * FROM ".DZ::table('forum_thread')." WHERE `tid`='$_GET[tid]'");
	if(!$thread){
		showmessage('帖子不存在');
	}
	$urladd='&tid='.$_GET['tid'];
	$fid=$thread['fid'];
}
if($_GET['pid']){
	$post=DZ::fetch_first("SELECT p.*,h.support,h.against,h.total FROM ".DZ::table('forum_post')." p LEFT JOIN ".DZ::table('forum_hotreply_number')." h ON h.pid=p.pid WHERE p.`pid`='$_GET[pid]'");
	if(!$post){
		showmessage('回帖不存在');
	}
	$urladd='&pid='.$_GET['pid'];
	$fid=$post['fid'];
}
if($_GET['fid']){
	$fid=$_GET['fid'];
}
$forum=DZ::fetch_first("SELECT f.*,fl.* FROM ".DZ::table('forum_forum')." f LEFT JOIN ".DZ::table('forum_forumfield')." fl ON fl.fid=f.fid WHERE f.`fid`='$fid'");;
if(!$forum){
	showmessage('板块不存在');
}


if(in_array($_GET['ac'],array('delete','settop','setbest'))){
	$check=get_userpower($forum);
	if($check && !is_array($check)){
		$canmanage=true;
	}else{
		showmessage('你没有权限进行本操作');
	}
}else{
	if(!$_S['myid'] && $_GET['ac']!='passforum'){
		showmessage('您需要登录后才能继续操作','member.php');
	}
}
switch($_GET['ac']){
	case 'delete':
    //删除帖子与回复
		if(!$_GET['confirm']){
			showmessage('确定要删除吗?','discuz.php?mod=action&ac=delete'.$urladd.'&confirm=true');
		}
		if($_GET['tid']){
			DZ::query("DELETE FROM ".DZ::table('forum_thread')." WHERE tid='$_GET[tid]'");
			DZ::query("DELETE FROM ".DZ::table('forum_post')." WHERE tid='$_GET[tid]' AND first='1'");
			if($thread['attachment']){
				$atctable='forum_attachment_'.substr($thread['tid'], -1);
				DZ::query("DELETE FROM ".DZ::table($atctable)." WHERE tid='$_GET[tid]'");
			}
			DZ::query("UPDATE ".DZ::table('forum_forum')." SET `threads`=`threads` + -1,`posts`=`posts`+ -$thread[replies] WHERE `fid`='$thread[fid]'");
			DZ::query("UPDATE ".DZ::table('common_member_count')." SET `threads`=`threads`+ -1 WHERE `uid`='$thread[authorid]'");
			showmessage('删除成功','',array('type'=>'toast','fun'=>'discuz.deletethread(\''.$thread['fid'].'\',\''.$_GET['tid'].'\');'));		
		}else{
			DZ::query("DELETE FROM ".DZ::table('forum_post')." WHERE pid='$_GET[pid]'");
			if($post['attachment']){
				$atctable='forum_attachment_'.substr($post['tid'], -1);
				DZ::query("DELETE FROM ".DZ::table($atctable)." WHERE pid='$_GET[pid]'");
			}
			DZ::query("UPDATE ".DZ::table('forum_thread')." SET `replies`=`replies`+ -1 WHERE `tid`='$post[tid]'");
			DZ::query("UPDATE ".DZ::table('forum_forum')." SET `posts`=`posts`+ -1 WHERE `fid`='$post[fid]'");
			DZ::query("UPDATE ".DZ::table('common_member_count')." SET `posts`=`posts`+ -1 WHERE `uid`='$post[authorid]'");
			showmessage('删除成功','',array('type'=>'toast','fun'=>'discuz.deletepost(\''.$post['tid'].'\',\''.$_GET['pid'].'\');'));		
		}
		break;
	case 'settop':
    //置顶帖子与回复
		if($_GET['tid']){
			if($thread['displayorder']){
				dzupdate('forum_thread',array('displayorder'=>0),"tid='$_GET[tid]'");
				$top=0;
			}else{
				dzupdate('forum_thread',array('displayorder'=>1),"tid='$_GET[tid]'");
				$top=1;
			}
			showmessage('操作成功','',array('type'=>'toast','fun'=>'discuz.settop(\''.$thread['tid'].'\',\''.$top.'\',\'thread\');'));	
		}else{
			$stick=DZ::fetch_first("SELECT * FROM ".DZ::table('forum_poststick')." WHERE `pid`='$_GET[pid]'");
			if($stick){
				DZ::query("DELETE FROM ".DZ::table('forum_poststick')." WHERE pid='$_GET[pid]'");
				$top=0;
			}else{
				$poststick=array(
					'tid'=>$post['tid'],
					'pid'=>$_GET['pid'],
					'position'=>$post['position'],
					'dateline'=>$_S['timestamp'],
				);
				$top=1;
				dzinsert('forum_poststick',$poststick);
			}
			showmessage('操作成功','',array('type'=>'toast','fun'=>'discuz.settop(\''.$post['pid'].'\',\''.$top.'\',\'post\');'));	
		}
		break;
	case 'setbest':
    //设置帖子精华		
		if($thread['digest']){
			dzupdate('forum_thread',array('digest'=>0),"tid='$_GET[tid]'");
			DZ::query("UPDATE ".DZ::table('common_member_count')." SET `digestposts`=`digestposts`+-1 WHERE `uid`='$thread[authorid]'");
			$best=0;
		}else{
			dzupdate('forum_thread',array('digest'=>1),"tid='$_GET[tid]'");
			DZ::query("UPDATE ".DZ::table('common_member_count')." SET `digestposts`=`digestposts`+1 WHERE `uid`='$thread[authorid]'");
			$best=1;
		}
		showmessage('操作成功','',array('type'=>'toast','fun'=>'discuz.setbest(\''.$thread['tid'].'\',\''.$best.'\');'));	
		break;
	case 'fav':
    //点赞帖子与回复
		$idtype=$_GET['tid']?'tid':'fid';
		$id=$_GET['tid']?$_GET['tid']:$_GET['fid'];
		$title=$_GET['tid']?$thread['subject']:$forum['name'];
		$favorite=DZ::fetch_first("SELECT * FROM ".DZ::table('home_favorite')." WHERE `idtype`='$idtype' AND `uid`='$_S[myid]' AND `id`='$id'");

		if($favorite){
			showmessage('已收藏');
		}
		$fav=array(
			'uid'=>$_S['myid'],
			'id'=>$id,
			'idtype'=>$idtype,
			'spaceuid'=>0,
			'title'=>$title,
			'description'=>'',
			'dateline'=>$_S['timestamp'],
		);
		dzinsert('home_favorite',$fav);
		showmessage('操作成功','',array('type'=>'toast','fun'=>'discuz.fav(\''.$id.'\',\''.$idtype.'\');'));
	case 'payforum':
	  if(!$forum['price']){
			showmessage('本版块无需支付费用');
		}
		$member=DZ::fetch_first("SELECT c.*,l.credits FROM ".DZ::table('common_member_count')." c LEFT JOIN ".DZ::table('common_member_forum_buylog')." l ON l.uid=c.uid AND l.fid='$_GET[fid]' WHERE c.`uid`='$_S[myid]'");
    if($member['credits']>=$forum['price']){
			showmessage('您已经支付过');
		}
		$extcredits=dzusl($_S['cache']['discuz_common']['extcredits']);
		$transextra=explode(',',$_S['cache']['discuz_common']['creditstrans']);
		$ext='extcredits'.$transextra[0];
		if($member[$ext]<$forum['price']){
			showmessage('您账户内的'.$extcredits[$transextra[0]]['title'].'不足');
		}else{
			if($member['credits']){
				DZ::query("UPDATE ".DZ::table('common_member_forum_buylog')." SET `credits`='$forum[price]' WHERE `uid`='$_S[myid]' AND fid='$forum[fid]'");
			}else{
				$buylog=array(
				  'uid'=>$_S['myid'],
					'fid'=>$_GET['fid'],
					'credits'=>$forum['price'],
				);
				dzinsert('common_member_forum_buylog',$buylog);
				$paylog=array(
					'uid'=>$_S['myid'],
					'operation'=>'FCP',
					'relatedid'=>$forum['fid'],
					'dateline'=>$_s['timestamp'],
					$ext=>-$forum['price'],
				);
				dzinsert('common_credit_log',$paylog);
				DZ::query("UPDATE ".DZ::table('common_member_count')." SET `$ext`=`$ext` + '-$forum[price]' WHERE uid='$_S[myid]'");
			}
			showmessage('付费成功点击进入板块','discuz.php?mod=forum&fid='.$forum['fid']);		
		}
    break;
	case 'paythread':
	  if(!$thread['price']){
			showmessage('本贴无需支付费用');
		}
		$member=DZ::fetch_first("SELECT c.*,l.logid FROM ".DZ::table('common_member_count')." c LEFT JOIN ".DZ::table('common_credit_log')." l ON l.uid=c.uid AND l.relatedid='$_GET[tid]' AND l.`operation`='BTC' WHERE c.`uid`='$_S[myid]'");
    if($member['logid']){
			showmessage('您已经支付过');
		}
		$extcredits=dzusl($_S['cache']['discuz_common']['extcredits']);
		$transextra=explode(',',$_S['cache']['discuz_common']['creditstrans']);
		$ext='extcredits'.$transextra[0];
		if($member[$ext]<$thread['price']){
			showmessage('您账户内的'.$extcredits[$transextra[0]]['title'].'不足');
		}else{
			$paylog=array(
				'uid'=>$_S['myid'],
				'operation'=>'BTC',
				'relatedid'=>$thread['tid'],
				'dateline'=>$_S['timestamp'],
				$ext=>-$thread['price'],
			);
			dzinsert('common_credit_log',$paylog);
			DZ::query("UPDATE ".DZ::table('common_member_count')." SET `$ext`=`$ext` + '-$thread[price]' WHERE uid='$_S[myid]'");
			$clog=array(
				'uid'=>$thread['authorid'],
				'operation'=>'STC',
				'relatedid'=>$thread['tid'],
				'dateline'=>$_S['timestamp'],
				$ext=>$thread['price'],
			);
			dzinsert('common_credit_log',$clog);
			DZ::query("UPDATE ".DZ::table('common_member_count')." SET `$ext`=`$ext` + '$thread[price]' WHERE uid='$thread[authorid]'");
			showmessage('付费成功点击进入帖子','discuz.php?mod=view&tid='.$thread['tid']);		
		}
    break;
	case 'passforum':
	  if(checksubmit('submit')){
			$pass=trim($_GET['pass']);
			if($pass==$forum['password']){
				setcookies('dzforum_'.$forum['fid'], '1', 648000);
				showmessage('验证成功点击进入板块','discuz.php?mod=forum&fid='.$forum['fid']);
				
			}else{
				showmessage('密码不正确');
			}
		}
	  break;
	case 'praise':
    //点赞帖子与回复
		if($_GET['tid']){
			$recommend=DZ::fetch_first("SELECT * FROM ".DZ::table('forum_memberrecommend')." WHERE `tid`='$_GET[tid]' AND `recommenduid`='$_S[myid]'");
			if($recommend){
				showmessage('您已参与过评分');
			}else{
				DZ::query("UPDATE ".DZ::table('forum_thread')." SET `recommends`=`recommends`+ 1,`recommend_add`=`recommend_add`+ 1 WHERE `tid`='$_GET[tid]'");
				$threadmod=array(
					'tid'=>$_GET['tid'],
					'recommenduid'=>$_S['myid'],
					'dateline'=>$_S['timestamp'],
				);
				dzinsert('forum_memberrecommend',$threadmod);
				$recommends=$thread['recommend_add']+1;
				showmessage('操作成功','',array('type'=>'toast','fun'=>'discuz.praise(\''.$thread['tid'].'\',\''.$recommends.'\');'));
			}
		}else{
			$member=DZ::fetch_first("SELECT * FROM ".DZ::table('forum_hotreply_member')." WHERE `pid`='$_GET[pid]' AND `uid`='$_S[myid]'");
			
			if($member){
				showmessage('您已参与过评分');
			}else{
				if($post['total']){
					
					DZ::query("UPDATE ".DZ::table('forum_hotreply_number')." SET `support`=`support`+ 1,`total`=`total`+ 1 WHERE `pid`='$_GET[pid]'");
					$support=$post['support']+1;
				}else{
					$number=array(
					  'pid'=>$_GET['pid'],
						'tid'=>$_GET['tid'],
						'support'=>1,
						'against'=>0,
						'total'=>1,
					);
					dzinsert('forum_hotreply_number',$number);
					$support=1;
				}
				$reply=array(
					'tid'=>$_GET['tid'],
					'pid'=>$_GET['pid'],
					'uid'=>$_S['myid'],
					'attitude'=>1,
				);
				dzinsert('forum_hotreply_member',$reply);
				showmessage('操作成功','',array('type'=>'toast','fun'=>'discuz.praise(\''.$post['pid'].'\',\''.$support.'\',\''.$post['tid'].'\');'));	
			}
		}
		break;
}




include temp('discuz/action');
?>