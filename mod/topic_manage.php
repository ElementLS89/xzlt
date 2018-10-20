<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='管理话题';

$topic=DB::fetch_first("SELECT t.*,u.level,u.experience FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$_GET[tid]'");
$title=$navtitle.'-'.$topic['name'].'-'.$_S['setting']['sitename'];
$canmanage=getpower($topic);
if(!$topic){
	showmessage('话题不存在 ');
}
if(!$canmanage){
	showmessage('你没有权限进行此操作');
}
$_S['outback']=true;
$topic['usergroup']=dunserialize($topic['usergroup']);

foreach($_S['setting']['topicgroup'] as $id=>$group){
	$group['name']=$topic['usergroup'][$id]?$topic['usergroup'][$id]:$group['name'];
	$topicgroup[$id]=$group;
}

$backurl='topic.php?tid='.$_GET['tid'];

if($_GET['item']=='level'){
	if(checksubmit('submit')){
		foreach($_GET['name'] as $id=>$name){
			$names[$id]=$name?stringvar($name,16):$topicgroup[$id]['name'];
		}
		update('topic',array('usergroup'=>serialize($names)),"tid='$_GET[tid]'");
		showmessage('设置成功','',array('type'=>'toast','fun'=>'SMS.deleteitem(\'topic.php?tid='.$_GET['tid'].'&show=member\',false)'));
	}	
}elseif(in_array($_GET['item'],array('member','apply'))){
	if($_GET['aid']){
		$navtitle='申请信息';
		$apply=DB::fetch_first("SELECT a.*,u.username,t.level as lv,t.experience FROM ".DB::table('topic_apply')." a LEFT JOIN ".DB::table('common_user')." u ON u.uid=a.uid LEFT JOIN ".DB::table('topic_users')." t ON t.uid=a.uid AND t.tid=a.tid WHERE a.`aid` ='$_GET[aid]'");
		if(!$apply){
			showmessage('申请信息不存在');
		}
	}else{
		if($_GET['item']=='apply' && $canmanage){
			
			$query = DB::query("SELECT a.aid,a.uid,a.level,u.username,t.level as lv,t.experience FROM ".DB::table('topic_apply')." a LEFT JOIN ".DB::table('common_user')." u ON u.uid=a.uid LEFT JOIN ".DB::table('topic_users')." t ON t.uid=a.uid AND t.tid=a.tid WHERE a.`tid` ='$_GET[tid]'");
			while($value = DB::fetch($query)) {
				$applys[$value['aid']]=$value;
			}		
		}

		/*users*/
		$sql['select'] = 'SELECT t.*';
		$sql['from'] =' FROM '.DB::table('topic_users').' t';
		$wherearr[] = "t.tid ='$_GET[tid]'";
		if($_GET['item']=='apply'){
			$wherearr[] = "t.level ='0'";
		}else{
			$wherearr[] = "t.level >'0'";
		}
		$sql['select'] .= ',u.username,u.dzuid';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=t.uid";
	
		$sql['order']='ORDER BY t.level DESC,t.dateline DESC';
		
		
		$select=select($sql,$wherearr,10);

		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				if($value['username']){
					if($value['level']>125){
						$manager[$value['uid']]=$value;
					}else{
						$list[$value['uid']]=$value;			
					}					
				}
			}
		}
		$maxpage = @ceil($select[1]/10);
		$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
		$nexturl = 'topic.php?mod=manage&tid='.$_GET['tid'].'&item='.$_GET['item'].'&page='.$nextpage;		
	}
  
}elseif($_GET['item']=='action'){
	//1:拒绝用户申请
	//2:通过用户申请
	//3:拒绝用户加入管理团队申请
	//4:通过用户加入管理团队申请
	//5:删除用户
	//6:撤销用户管理权限
	if(in_array($_GET['ac'],array(1,2,5,6))){
		$user=DB::fetch_first("SELECT * FROM ".DB::table('topic_users')." WHERE `tid`='$_GET[tid]' AND uid='$_GET[uid]'");
    if(!$user){
			showmessage('用户不存在');
		}
	}else{
		$apply=DB::fetch_first("SELECT * FROM ".DB::table('topic_apply')." WHERE `tid`='$_GET[tid]' AND uid='$_GET[uid]'");
		if(!$apply){
			showmessage('申请信息不存在');
		}
	}
	if($_GET['ac']==1){
		if($user['level']){
			showmessage('用户不需要审核');
		}
		DB::query("DELETE FROM ".DB::table('topic_users')." WHERE tid='$_GET[tid]' AND uid='$_GET[uid]'");
		update('topic',array('users'=>$topic['users']+-1),"tid='$_GET[tid]'");
		sendnotice($_GET['uid'],'topic','您的申请已被['.$topic['name'].']小组的管理员拒绝');
		showmessage('操作成功','',array('type'=>'toast','fun'=>'topic.usermanage('.$_GET['ac'].','.$_GET['uid'].','.$_GET['tid'].','.($topic['users']+-1).');sendnotice(\'touid='.$_GET['uid'].'+call=smsot.newnotice();topic.uptopic('.$_GET['tid'].',false)\')'));	
	}elseif($_GET['ac']==2){
		if($user['level']){
			showmessage('用户不需要审核');SMS.deleteitem('topic.php?tid=');
		}
		update('topic_users',array('level'=>'1'),"tid='$_GET[tid]' AND uid='$_GET[uid]'");
		sendnotice($_GET['uid'],'topic','您的申请已被['.$topic['name'].']小组的管理员通过');
		showmessage('操作成功','',array('type'=>'toast','fun'=>'topic.usermanage('.$_GET['ac'].','.$_GET['uid'].');sendnotice(\'touid='.$_GET['uid'].'+call=smsot.newnotice();topic.uptopic('.$_GET['tid'].',false)\')'));	
	}elseif($_GET['ac']==3){
		if($user['level']>125){
			showmessage('用户不需要审核');
		}
		DB::query("DELETE FROM ".DB::table('topic_apply')." WHERE tid='$_GET[tid]' AND uid='$_GET[uid]'");
		sendnotice($_GET['uid'],'topic','您的申请已被['.$topic['name'].']小组的管理员拒绝');
		
		showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){topic.usermanage('.$_GET['ac'].','.$_GET['uid'].');sendnotice(\'touid='.$_GET['uid'].'+call=smsot.newnotice();topic.uptopic('.$_GET['tid'].',false)\')},500)'));	
	}elseif($_GET['ac']==4){
		if($user['level']>125){
			showmessage('用户不需要审核');
		}
		DB::query("DELETE FROM ".DB::table('topic_apply')." WHERE tid='$_GET[tid]' AND uid='$_GET[uid]'");
		update('topic_users',array('level'=>$apply['level']),"tid='$_GET[tid]' AND uid='$_GET[uid]'");
		sendnotice($_GET['uid'],'topic','您的申请已被['.$topic['name'].']小组的管理员拒绝');
		showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){topic.usermanage('.$_GET['ac'].','.$_GET['uid'].');sendnotice(\'touid='.$_GET['uid'].'+call=smsot.newnotice();topic.uptopic('.$_GET['tid'].',false)\')},500)'));	
	}elseif($_GET['ac']==5){
		DB::query("DELETE FROM ".DB::table('topic_users')." WHERE tid='$_GET[tid]' AND uid='$_GET[uid]'");
		update('topic',array('users'=>$topic['users']+-1),"tid='$_GET[tid]'");
		sendnotice($_GET['uid'],'topic','您已被['.$topic['name'].']小组的管理员从小组内请出');
		showmessage('操作成功','',array('type'=>'toast','fun'=>'topic.usermanage('.$_GET['ac'].','.$_GET['uid'].','.$_GET['tid'].','.($topic['users']+-1).');sendnotice(\'touid='.$_GET['uid'].'+call=smsot.newnotice();topic.uptopic('.$_GET['tid'].',false)\')'));	
	}elseif($_GET['ac']==6){
		foreach($topicgroup as $lv=> $group){
			if($group['experience'] && $topic['experience']>$group['experience']){
				$level=$lv;
			}
		}
		update('topic_users',array('level'=>$level),"tid='$_GET[tid]' AND uid='$_GET[uid]'");
		sendnotice($_GET['uid'],'topic','您已被['.$topic['name'].']小组的管理员从小组管理团队删除');
		showmessage('操作成功','',array('type'=>'toast','fun'=>'topic.usermanage('.$_GET['ac'].','.$_GET['uid'].');sendnotice(\'touid='.$_GET['uid'].'+call=smsot.newnotice();topic.uptopic('.$_GET['tid'].',false)\')'));	
	}
	
	
}else{
	$topic['types']=dunserialize($topic['types']);

	$typeids=array_keys($topic['types']);
	$maxid=array_search(max($typeids),$typeids);
	$typeid=$typeids[$maxid]?$typeids[$maxid]:'1';
	if(checksubmit('submit')){
		if($_GET['item']=='level'){
			foreach($_GET['name'] as $id=>$name){
				$names[$id]=$name?stringvar($name,16):$topicgroup[$id]['name'];
			}
			update('topic',array('usergroup'=>serialize($names)),"tid='$_GET[tid]'");
			showmessage('设置成功','',array('type'=>'toast'));
		}else{
			$s['cover']=$_GET['cover'];
			$s['banner']=$_GET['banner'];

			$s['name']=stringvar($_GET['name'],255);
			$s['about']=stringvar($_GET['about'],255);
			$s['open']=$_GET['open'];
			$s['show']=$_GET['show'];
			$s['price']=abs(intval($_GET['price']));
			$s['addtheme']=$_GET['addtheme'];
			$s['reply']=$_GET['reply'];
			$s['allowapply']=$_GET['allowapply'];
			$s['maxleaders']=$_GET['maxleaders']?abs(intval($_GET['maxleaders'])):'2';
			$s['maxmanagers']=$_GET['maxmanagers']?abs(intval($_GET['maxmanagers'])):'5';
			$s['liststype']=$_GET['liststype'];
			
			foreach($_GET['typename'] as $k => $name){
				if(trim($name)!=''){
					$types[$_GET['typeid'][$k]]=$name;
				}
			}
			$s['types']=serialize($types);
			if(!$s['name']){
				showmessage('话题名称没有填写');
			}
			if($s['price'] && !$_S['wxpay']){
				showmessage('网站暂未开启支付功能，无法设置付费加入');
			}	
			if($s['name']!=$topic['name']){
				if(DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE `name`='$s[name]'")){
					showmessage('已经有相同名称的话题，请换一个名字');
				}
			}
			update('topic',$s,"tid='$_GET[tid]'");
			showmessage('设置成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){SMS.deleteitem(\'topic.php?tid='.$_GET['tid'].'&show=member\',false);SMS.deleteitem(\'topic.php?tid='.$_GET['tid'].'\',false);SMS.reload(\'topic.php?tid='.$_GET['tid'].'\')},100)'));		
		}
	}	
}

include temp(PHPSCRIPT.'/'.$_GET['mod'].($_GET['item']?'_'.$_GET['item']:''));
?>