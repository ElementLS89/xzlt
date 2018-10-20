<?php
if(!defined('IN_SMSOT')) {
	exit;
}
//发帖disucz.php?mod=post&ac=addthread&fid=x
//编辑帖子disucz.php?mod=post&ac=editthread&tid=x
//编辑回帖disucz.php?mod=post&ac=editpost&pid=x
//回复主题disucz.php?mod=post&ac=replythread&tid=x
//回复回帖disucz.php?mod=post&ac=replypost&pid=x

if(!$_S['uid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
if(!$_S['myid']){
	showmessage('您需要绑定您的discuz账号','discuz.php?mod=bind');
}
if($_S['setting']['sms_need'] && !$_S['member']['tel']){
	showmessage('您需要绑定手机号之后才能进行下面的操作','my.php?mod=profile&show=3');
}

$havehack=DZ::result_first("SHOW TABLES LIKE '%".DZ::table('cis_smsot')."%'");
	
$fid=$_GET['fid'];
$tid=$_GET['tid'];
$pid=$_GET['pid'];
if($_GET['pid']){
	$post=DZ::fetch_first("SELECT p.*,t.maxposition FROM ".DZ::table('forum_post')." p LEFT JOIN ".DZ::table('forum_thread')." t ON t.tid=p.tid WHERE p.`pid`='$_GET[pid]'");
	if(!$post){
		showmessage('回帖不存在');
	}
	$tid=$post['tid'];
	$fid=$post['fid'];
}
if($_GET['tid']){
	$thread=DZ::fetch_first("SELECT t.*,p.pid,p.message FROM ".DZ::table('forum_thread')." t LEFT JOIN ".DZ::table('forum_post')." p ON p.tid=t.tid AND p.first=1  WHERE t.`tid`='$_GET[tid]'");
	if(!$thread){
		showmessage('帖子不存在');
	}
	if($havehack){
		$theme=DZ::fetch_first("SELECT * FROM ".DZ::table('cis_smsot')." WHERE `tid`='$_GET[tid]'");
	}
	
	$fid=$thread['fid'];
	$tid=$thread['tid'];
	$pid=$thread['pid'];
}
$forum=$_S['cache']['discuz_forum'][$fid];

$check=get_userpower($forum);
if($check && !is_array($check)){
	$canmanage=true;
}else{
	forumallow($check,$forum);
}

if($_GET['ac']=='editthread' || $_GET['ac']=='editpost'){
	$atctab='forum_attachment_'.substr($tid, -1);
	$query = DZ::query('SELECT * FROM '.DZ::table($atctab)." WHERE pid = '$pid' ORDER BY `dateline` DESC");
	while($value = DZ::fetch($query)){
		if($value['isimage']){
			if($value['remote']=='2'){
				$value['atc']=$_S['atc'].'/'.$value['attachment'].($value['thumb']?'.thumb.jpg':'');
			}else{
				$value['atc']=$_S['dz']['atc'].'forum/'.$value['attachment'].($value['thumb']?'.thumb.jpg':'');
			}
			$imgs[$value['aid']]=$value;
		}
	}
}

switch($_GET['ac']){
	case 'addthread':
	  $navtitle='发帖';
		//发帖权限检查
		$forum['threadtypes']=dzusl($forum['threadtypes']);
		if($forum['allowspecialonly']){
			showmessage('点击这里跳转到论坛发布特殊主题',$_S['dz']['url'].'forum.php?mod=post&action=newthread&fid='.$fid);
		}
		$forum['threadsorts']=dzusl($forum['threadsorts']);
		if($forum['threadsorts']['required']){
			showmessage('点击这里跳转到论坛发布分类信息',$_S['dz']['url'].'forum.php?mod=post&action=newthread&fid='.$fid);
		}
		if(!$canmanage && !$_S['cache']['discuz_usergroup'][$check['groupid']]['allowpost']){
			showmessage('您所在用户组无法发表帖子');
		}
		break;
	case 'editthread':
	  $navtitle='编辑帖子';
		//编辑权限检查
		if($thread['special']){
			showmessage('点击这里跳转到论坛编辑特殊主题',$_S['dz']['url'].'forum.php?mod=post&action=edit&fid='.$fid.'&tid='.$tid.'&pid='.$thread['pid'].'&page=1');
		}
		if($thread['sortid']){
			showmessage('点击这里跳转到论坛编辑分类信息帖子',$_S['dz']['url'].'forum.php?mod=post&action=edit&fid='.$fid.'&tid='.$tid.'&pid='.$thread['pid'].'&page=1');
		}
		if(!$canmanage && $thread['authorid']!=$_S['myid']){
			showmessage('你没有权限编辑本帖子');
		}
		break;
	case 'editpost':
	  $navtitle='编辑回帖';
		//编辑权限检查
		if(!$canmanage && $post['authorid']!=$_S['myid']){
			showmessage('你没有权限编辑本回帖');
		}
		break;
	case 'replythread':
	  $navtitle='参与回贴';
		//被关闭无法回帖
		if($thread['closed']){
			showmessage('本帖已关闭无法回复');
		}
		if(!$canmanage && !$_S['cache']['discuz_usergroup'][$check['groupid']]['allowreply']){
			showmessage('您所在用户组无法参与回帖');
		}
		break;
	case 'replypost':
	  $navtitle='回复';
		//回帖权限检查
		if(!$canmanage && !$_S['cache']['discuz_usergroup'][$check['groupid']]['allowreply']){
			showmessage('您所在用户组无法参与回帖');
		}
		break;
}
/*begin*/
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
if($_S['qiniu']){
	require_once './sdk/Qiniu/autoload.php';

	$accessKey = $_S['setting']['qiniu_ak'];
	$secretKey = $_S['setting']['qiniu_sk'];
	$auth = new Auth($accessKey, $secretKey);
	$bucket = $_S['setting']['qiniu_bucket'];
	
	$Mp4Fop = "avthumb/mp4/s/".$_S['setting']['qiniu_resolution']."/autoscale/1|saveas/".\Qiniu\base64_urlSafeEncode($bucket.":$(key).mp4");
	$JpgFop = "vframe/jpg/offset/".$_S['setting']['qiniu_frame']."|saveas/".\Qiniu\base64_urlSafeEncode($bucket.":$(key).jpg");
	
	$policy = array(
	  'persistentOps' => $Mp4Fop.";".$JpgFop,
		'persistentPipeline' => $_S['setting']['qiniu_pipeline'],
		'callbackBody' => '{"key":"$(key)"}',
		'callbackBodyType' => 'application/json'
	);
	$token = $auth->uploadToken($bucket, null, 3600, $policy);	
}
/*end*/

if(checksubmit('submit')){
	if(in_array($_GET['ac'],array('addthread','editthread'))){
		if($_S['setting']['freetitle']){
			$s['subject']=$e['subject']=$c['subject']=$ec['subject']=$_GET['subject']?stringvar($_GET['subject'],60):stringvar(strip_tags($_GET['content']),60);
		}else{
			$s['subject']=$e['subject']=$c['subject']=$ec['subject']=stringvar($_GET['subject'],60);
		}

		$s['typeid']=$e['typeid']=$_GET['typeid'];
		$s['authorid']=$c['authorid']=$thread?$thread['authorid']:$_S['myid'];
		$s['fid']=$c['fid']=$fid;
		$s['author']=$c['author']=$_S['member']['username'];
		$s['dateline']=$c['dateline']=$_S['timestamp'];
		$s['lastpost']=$_S['timestamp'];
		$s['lastposter']=$_S['member']['username'];
		$s['attachment']=$e['attachment']=$ec['attachment']=$c['attachment']=count($_GET['pics'])>0?'2':($thread['attachment']?$thread['attachment']:'0');
		$c['message']=$ec['message']=dzcontent($_GET['content']);
		
		if(!$s['subject']){
			showmessage('帖子标题不能为空');
		}
		if(!$c['message']){
			showmessage('帖子内容不能为空');
		}
		if($forum['threadtypes']['required'] && !$s['typeid']){
			showmessage('请选择主题分类');
		}
		if($_GET['ac']=='addthread'){
			if($forum['modnewposts'] && $_S['usergroup']['examinetheme']){
				$s['displayorder']=-2;
			}
			$c['tid']=$tid=dzinsert('forum_thread',$s);
			
			if($havehack){
				dzinsert('cis_smsot',array('tid'=>$tid,'lbs'=>$_GET['lbs']));
			}
			$c['pid']=$pid=dzinsert('forum_post_tableid',array('pid' => null));
			$c['position']='1';
			$c['first']=1;
			$c['status']=8;
			$c['useip']=get_client_ip();
      
			if($forum['modnewposts'] && $_S['usergroup']['examinetheme']){
				dzinsert('forum_thread_moderate',array('id'=>$c['tid'],'status'=>'0','dateline'=>$_S['timestamp']));
			}
			dzinsert('forum_post',$c);
			DZ::query("UPDATE ".DZ::table('forum_forum')." SET `threads`=`threads`+1,`posts`=`posts`+1,`todayposts`=`todayposts`+1 WHERE `fid`='$fid'");
			DZ::query("UPDATE ".DZ::table('common_member_count')." SET `threads`=`threads`+1,`posts`=`posts`+1 WHERE `uid`='$_S[myid]'");
			
		}elseif($_GET['ac']=='editthread'){
			dzupdate('forum_thread',$e,"tid='$tid'");
			dzupdate('forum_post',$ec,"pid='$pid'");
			if($havehack){
				dzupdate('cis_smsot',array('lbs'=>$_GET['lbs']),"tid='$tid'");
			}
		}
		if(count($_GET['pics'])>0){
			$atctable='forum_attachment_'.substr($tid, -1);
			$aidstr=implode(',',$_GET['pics']);
			$query = DZ::query('SELECT * FROM '.DZ::table('forum_attachment_unused')." WHERE aid IN ($aidstr)");
			while($value = DZ::fetch($query)){
				$value['tid']=$tid;
				$value['pid']=$pid;
				dzinsert($atctable,$value);
			}
			DZ::query("DELETE FROM ".DZ::table('forum_attachment_unused')." WHERE aid IN ($aidstr)");
			dzupdate('forum_attachment',array('tid'=>$tid,'pid'=>$pid,'tableid'=>substr($tid, -1)),"aid IN ($aidstr)");
		}
		if(count($_GET['delpics'])>0){
			$atctable='forum_attachment_'.substr($tid, -1);
			$aidstr=implode(',',$_GET['delpics']);
			DZ::query("DELETE FROM ".DZ::table($atctable)." WHERE aid IN ($aidstr)");
			DZ::query("DELETE FROM ".DZ::table('forum_attachment')." WHERE aid IN ($aidstr)");
		}		
		if($_GET['ac']=='addthread'){
			setdzcredit('post',$_S['myid']);
			showmessage('帖子发布成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){discuz.addthread(\''.$tid.'\',\''.$fid.'\')},300)'));
		}else{
			showmessage('帖子编辑成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){discuz.editthread(\''.$tid.'\',\''.$fid.'\',\''.$s['subject'].'\')},300)'));
		}
	}else{
		$c['message']=$ec['message']=strip_tags($_GET['content']);
		if($_GET['ac']=='editpost'){
			dzupdate('forum_post',$ec,"pid='$pid'");
			showmessage('编辑成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){discuz.editreply(\''.$pid.'\',\''.$tid.'\')},500)'));
		}else{
			$c['pid']=$pid=dzinsert('forum_post_tableid',array('pid' => null));
			$c['fid']=$fid;
			$c['tid']=$tid;
			$c['author']=$_S['member']['username'];
			$c['authorid']=$_S['myid'];
			$c['subject']='';
			$c['dateline']=$_S['timestamp'];
			$c['status']=8;
			if($forum['modnewposts']==2 && $_S['usergroup']['examinepost']){
				$c['invisible']=-2;
			}
			$c['useip']=get_client_ip();

			
			$lastposter=$_S['member']['username'];

			DZ::query("UPDATE ".DZ::table('forum_forum')." SET `posts`=`posts`+1,`todayposts`=`todayposts`+1 WHERE `fid`='$fid'");
			DZ::query("UPDATE ".DZ::table('forum_thread')." SET `replies`=`replies`+1,`maxposition`=`maxposition`+1,`lastpost`='$_S[timestamp]',`lastposter`='$lastposter' WHERE `tid`='$tid'");
			DZ::query("UPDATE ".DZ::table('common_member_count')." SET `posts`=`posts`+1 WHERE `uid`='$_S[myid]'");
			dzinsert('forum_post',$c);
			
			if($forum['modnewposts']==2 && $_S['usergroup']['examinetheme']){
				dzinsert('forum_post_moderate',array('id'=>$c['pid'],'status'=>'0','dateline'=>$_S['timestamp']));
			}
			if($thread){
				$wxnotice=array(
					'first'=>array('value'=>'您的帖子有新的回复'),
					'keyword1'=>array('value'=>$c['message']),
					'keyword2'=>array('value'=>smsdate($c['dateline'],'Y-m-d H:i:s')),
					'remark'=>array('value'=>$thread['subject'],'color'=>'#3399ff'),
				);
				sendwxnotice($thread['authorid'],'',$_S['setting']['wxnotice_reply'],$_S['setting']['siteurl'].'discuz.php?mod=view&tid='.$tid,$wxnotice);				
			}
      setdzcredit('reply',$_S['myid']);
			showmessage('回复成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){discuz.addreply(\''.$pid.'\',\''.$tid.'\')},500)'));
		}
	}
}



include temp('discuz/post');
?>