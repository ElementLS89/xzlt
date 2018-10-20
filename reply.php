<?php
define('PHPSCRIPT', 'reply');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
$backurl='topic.php?vid='.$_GET['vid'];

$S = new S();
$S -> star();
C::chche('smile');
$table='common_replys_'.substr($_GET['vid'],-1);
$_GET['mod']=$_GET['mod']?$_GET['mod']:'topic';
$_S['setting']['mods']=dunserialize($_S['setting']['mods']);
$themetable=$_S['setting']['mods'][$_GET['mod']]['table'];
$modurl=$_S['setting']['mods'][$_GET['mod']]['viewurl'].$_GET['vid'];

$theme=DB::fetch_first("SELECT t.*,u.openid,u.dzuid FROM ".DB::table($themetable)." t LEFT JOIN ".DB::table('common_user')." u ON u.uid=t.uid WHERE t.`vid`='$_GET[vid]'");

if(!$theme){
	showmessage('要回复的信息不存在或已被删除');
}
$theme['imgs']=dunserialize($theme['imgs']);

if($_GET['mod']=='topic'){
	require_once './include/function_topic.php';
}
if($_S['setting']['mods'][$_GET['mod']]['ishack']){
	require_once ROOT.'./hack/'.$_GET['mod'].'/power.php';
}else{
	require_once ROOT.'./mod/'.$_GET['mod'].'_power.php';
}
	
if(!$_GET['ac'] || in_array($_GET['ac'],array('rp','ed','dl','top','best','praise'))){
	if($_GET['mod']=='topic'){
		$reply=DB::fetch_first("SELECT p.*,u.username,u.dzuid,u.openid,t.level,t.tid,t.experience FROM ".DB::table($table)." p LEFT JOIN ".DB::table('common_user')." u ON u.uid=p.uid LEFT JOIN ".DB::table('topic_users')." t ON t.tid='$theme[tid]' AND t.uid=p.uid WHERE p.`pid`='$_GET[pid]'");
	}else{
		$reply=DB::fetch_first("SELECT p.*,u.username,u.dzuid,u.openid FROM ".DB::table($table)." p LEFT JOIN ".DB::table('common_user')." u ON u.uid=p.uid WHERE p.`pid`='$_GET[pid]'");
	}
	if(!$reply){
		showmessage('回复不存在');
	}
	
}

if(!$_GET['ac']){
	
	$navtitle='查看评论';
	$title=$theme['subject'].'的全部评论-'.$_S['setting']['sitename'];

	//shar
	$signature=signature();
	$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
	$_S['shar']['pic']=$_S['setting']['siteurl'].($theme['imgs'][0]['atc']?$_S['atc'].'/'.$theme['imgs'][0]['atc']:'ui/ico.png');
	$_S['shar']['desc']=$theme['abstract'];

	$reply['content']=smile($reply['content']);
	$reply['user']=array('uid'=>$reply['uid'],'dzuid'=>$reply['dzuid']);
	$value=$reply;
	if($_GET['s']){
		$value['s']=$_GET['s'];
	}else{
		$sql['select'] = 'SELECT p.*';
		$sql['from'] ='FROM '.DB::table($table).' p';
		$wherearr[] = "p.top >='0'";
		$wherearr[] = "p.upid ='$_GET[pid]'";
		
		$sql['select'] .= ',u.username,u.groupid,u.dzuid';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=p.uid";
		$sql['order']='ORDER BY p.top DESC,p.replys DESC,p.dateline DESC';
		
		$select=select($sql,$wherearr,100);
		
		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
				$value['content']=smile($value['content']);
				if(!$value['praise']){
					unset($value['praise']);
				}
				if($value['replys']){
					$upids[]=$value['pid'];
				}else{
					unset($value['replys']);
				}
				$value['s']='l';
				$list[$value['pid']]=$value;
			}
		}
			
		if($upids){
			$rids=implode(',',$upids);
			$query = DB::query('SELECT r.*,u.username,u.dzuid FROM '.DB::table($table).' r LEFT JOIN '.DB::table('common_user')." u ON u.uid=r.uid WHERE r.upid IN($rids) AND r.new='1' AND r.top>='0'  ORDER BY r.dateline DESC");
			while($value = DB::fetch($query)) {
				$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
				$value['s']='n';
				$replys[$value['upid']][]=$value;
			}
		}
		$maxpage = @ceil($select[1]/10);
		$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
		$nexturl = 'reply.php?mod='.$_GET['mod'].'&vid='.$_GET['vid'].'pid='.$_GET['pid'].'&page='.$nextpage;		
		
	}
}else{
  $_S['outback']=true;
	if($_GET['ac']=='dl'){
		if($_S['uid']!=$reply['uid'] && !$canmanage){
			showmessage('您没有权限删除本评论');
		}
		
		if(!$_GET['confirm']){
			showmessage('确定要删除本评论吗?','reply.php?mod=topic&ac=dl&vid='.$_GET['vid'].'&pid='.$_GET['pid'].'&confirm=true');
		}else{
			DB::query("DELETE FROM ".DB::table($table)." WHERE pid='$_GET[pid]'");
			if($reply['upid']){
				DB::query("UPDATE ".DB::table($table)." SET `replys`=`replys`+'-1' WHERE pid='$reply[upid]'");
			}else{
				DB::query("UPDATE ".DB::table($themetable)." SET `replys`=`replys`+'-1' WHERE vid='$_GET[vid]'");
				$viewurl=$modurl;
			}
			if($_GET['mod']=='topic'){
				upuserlevel($reply,-1);
			}
			upuser(18,$reply['uid']);
			showmessage('删除成功','',array('type'=>'toast','fun'=>'smsot.deletereply(\''.$_GET['pid'].'\',\''.$viewurl.'\');'));			
		}
	}elseif($_GET['ac']=='top'){
		if(!$canmanage){
			showmessage('您没有权限进行置顶操作');
		}		
		$top=$reply['top']?'0':'1';
		$viewurl=!$reply['upid']?$modurl:'';
		update($table,array('top'=>$top),"pid='$_GET[pid]'");
		showmessage('设置成功','',array('type'=>'toast','fun'=>'smsot.topreply(\''.$_GET['vid'].'\',\''.$_GET['pid'].'\',\''.$top.'\',\''.$reply['best'].'\',\''.$viewurl.'\');'));
	}elseif($_GET['ac']=='best'){
		if(!$canmanage){
			showmessage('您没有权限进行推荐操作');
		}
		$best=$reply['best']?'0':'1';
		$viewurl=!$reply['upid']?$modurl:'';
		
		update($table,array('best'=>$best),"pid='$_GET[pid]'");
		showmessage('设置成功','',array('type'=>'toast','fun'=>'smsot.bestreply(\''.$_GET['vid'].'\',\''.$_GET['pid'].'\',\''.$best.'\',\''.$reply['top'].'\',\''.$viewurl.'\');'));
	}elseif($_GET['ac']=='praise'){
		if(!$_S['usergroup']['allowpraise']){
			showmessage('您所在用户组无法点赞');
		}
		$praise=DB::fetch_first("SELECT * FROM ".DB::table('topic_action')." WHERE `type`='reply' AND `id`='$_GET[pid]' AND uid='$_S[uid]'");
		if($praise){
			showmessage('您已经点过赞了');
		}
		insert('topic_action',array('type'=>'reply','id'=>$_GET['pid'],'uid'=>$_S['uid'],'dateline'=>$_S['timestamp']));
		update($table,array('praise'=>$reply['praise']+1),"pid='$_GET[pid]'");
		showmessage('操作成功','',array('type'=>'toast','fun'=>'smsot.praisereply(\''.$_GET['pid'].'\',\''.($reply['praise']+1).'\',\''.$_GET['po'].'\',\''.$modurl.'\');'));
	}elseif($_GET['ac']=='ed'){
		if($_S['uid']!=$reply['uid'] && !$canmanage){
			showmessage('您没有权限进行编辑');
		}
	}else{
		
		if(!$_S['usergroup']['allowreply']){
			if(!$_S['member']['uid']){
				showmessage('您需要登录后才能继续操作','member.php');
			}else{
				showmessage('您所在用户组无法评论');
			}
    }
		if($_GET['mod']=='topic' && $topic){
			if(!$topic['reply'] && !$topic['level'] && !$canmanage){
				showmessage('本小组只允许成员回帖评论');
			}
		}
		if($_S['setting']['sms_need'] && !$_S['member']['tel']){
	    showmessage('您需要绑定手机号之后才能进行下面的操作','my.php?mod=profile&show=3');
    }
	}
  $navtitle=$_GET['ac']=='ed'?'编辑评论':'发表评论';
	$title=$navtitle.'-'.$_S['setting']['sitename'];

				
	if(checksubmit('submit')){
		$s['content']=striptags($_GET['content']);
		if(!$s['content']){
			showmessage('评论内容还没填写');
		}
		if($_GET['ac']=='ed'){
			update($table,array('content'=>$s['content']),"pid='$_GET[pid]'");
			showmessage('编辑成功','',array('type'=>'toast','fun'=>'SMS.closepage();smsot.editreply(\''.$reply['upid'].'\',\''.$_GET['vid'].'\',\''.$_GET['pid'].'\',\''.$_GET['mod'].'\')'));
		}else{
			
			$s['mod']=$_GET['mod'];
			$s['vid']=$_GET['vid'];
			$s['uid']=$_S['uid'];
			$s['upid']=$_GET['ac']=='rp'?$_GET['pid']:'0';
			$s['dateline']=$_S['timestamp'];
			$s['top']=$_S['usergroup']['examinepost']?-1:0;
			
			
			$pid=insert($table,$s);
			if($_GET['mod']=='topic'){
				upuserlevel($topic,1);
			}
			if($_GET['ac']=='rt'){
				$replys=$theme['replys']+1;
				$upid=0;
				update($themetable,array('replys'=>$replys),"vid='$_GET[vid]'");
				sendnotice($theme['uid'],'reply','您的帖子<a href="'.$modurl.'" class="c8 load">'.$theme['subject'].'</a>有新的回复',$_GET['vid']);
				if($_S['setting']['wxnotice_reply'] && $theme['openid']){
					$wxnotice=array(
						'first'=>array('value'=>'您的帖子有新的回复'),
						'keyword1'=>array('value'=>$s['content']),
						'keyword2'=>array('value'=>smsdate($s['dateline'],'Y-m-d H:i:s')),
						'remark'=>array('value'=>$theme['subject'],'color'=>'#3399ff'),
					);
					sendwxnotice($theme['uid'],$theme['openid'],$_S['setting']['wxnotice_reply'],$_S['setting']['siteurl'].$modurl,$wxnotice);					
				}

				
				$JSNOTICE=';sendnotice(\'touid='.$theme['uid'].'+call=smsot.newnotice()\')';
				if($theme['uid']!=$_S['uid']){
					upuser(2,$theme['uid']);
				}
				
			}else{
				$replys=$reply['replys']+1;
				$upid=$_GET['pid'];
				/*setnew*/
				$query = DB::query('SELECT * FROM '.DB::table($table)." WHERE upid='$upid' AND new='1' ORDER BY dateline DESC");
				while($value = DB::fetch($query)) {
					$reps[]=$value['pid'];
				}
				if(count($reps)>5){
					$last=end($reps);
					DB::query("UPDATE ".DB::table($table)." SET `new` = '0' WHERE pid='$last'");
				}
				update($table,array('replys'=>$replys),"pid='$upid'");
				
				if($_S['setting']['wxnotice_reply'] && $reply['openid']){
					$wxnotice=array(
						'first'=>array('value'=>'您发表的评论有人回复了'),
						'keyword1'=>array('value'=>$s['content']),
						'keyword2'=>array('value'=>smsdate($s['dateline'],'Y-m-d H:i:s')),
						'remark'=>array('value'=>$reply['content'],'color'=>'#3399ff'),
					);
					sendwxnotice($reply['uid'],$reply['openid'],$_S['setting']['wxnotice_reply'],$_S['setting']['siteurl'].'reply.php?mod='.$reply['mod'].'&vid='.$reply['vid'].'&pid='.$reply['pid'],$wxnotice);					
				}
			}
			$viewurl=!$upid?$modurl:'';
			if($theme['uid']!=$_S['uid']){
				upuser(1,$_S['uid']);
			}
			showmessage('评论成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.addreply(\''.$_GET['s'].'\',\''.$_GET['vid'].'\',\''.$pid.'\',\''.$upid.'\',\''.$replys.'\',\''.$viewurl.'\',\''.$_GET['mod'].'\')'.$JSNOTICE.'},500)'));	
		}
	}			
}


include temp(PHPSCRIPT.'/reply');
?>