<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if(!$_S['uid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
if($_S['setting']['sms_need'] && !$_S['member']['tel']){
	showmessage('您需要绑定手机号之后才能进行下面的操作','my.php?mod=profile&show=3');
}
$_S['outback']=true;
if($_GET['action']=='add'){
	$navtitle='添加好友';
	//检查是否是自己
	if($uid==$_S['uid']){
		showmessage('不能添加自己');
	}	
	//检查黑名单
	if(DB::result_first("SELECT * FROM ".DB::table('common_friend_blacklist')." WHERE uid='$uid' AND fuid='$_S[uid]'")){
		showmessage('对方拒绝');
	}
	//检查是否已经互相加过
	$query = DB::query("SELECT * FROM ".DB::table('common_friend')." WHERE (uid='$_S[uid]' AND fuid='$uid') OR (uid='$uid' AND fuid='$_S[uid]')");
	while($value = DB::fetch($query)) {
		$friend[$value['uid']]=$value;
	}
	$tid=maketid(array($_S['uid'],$uid));
	if($friend[$_S['uid']]){ 
		if($friend[$_S['uid']]['state']){
			showmessage('你们已经是好友了是否发起聊天','my.php?mod=talk&tid='.$tid,array('js'=>'smsot.isfriend('.$uid.','.$tid.')'));
		}else{
			showmessage('你已经提交过申请,对方还未通过验证');
		}
	}else{
		$query = DB::query('SELECT * FROM '.DB::table('common_friend_type')." WHERE `uid` ='$_S[uid]'");
		while($value = DB::fetch($query)) {
			$friendtypes[$value['typeid']]=$value;
		}		
	}
	if(checksubmit('submit')){
		$s['message']=trim($_GET['message']);
    
		$newfriendtype=trim($_GET['newfriendtype']);
		$s['shield']=$_GET['shield']?$_GET['shield']:'0';
		if($newfriendtype){
			$typeid=insert('common_friend_type',array('uid'=>$_S['member']['uid'],'name'=>$newfriendtype));
		}
		$s['friendtype']=$typeid?$typeid:$_GET['friendtype'];
		$typename=$newfriendtype?$newfriendtype:($friendtypes[$s['friendtype']]['name']?$friendtypes[$s['friendtype']]['name']:'我的好友');
		//对方加过自己
		if($friend[$uid]){
			insert('common_friend',array('uid'=>$_S['member']['uid'],'fuid'=>$uid,'friendname'=>$user['username'],'friendtype'=>$s['friendtype'],'shield'=>$s['shield'],'filter'=>'0','state'=>'1','dateline'=>$_S['timestamp']));
			if(!$newfriendtype && $s['friendtype']){
				DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'1' WHERE typeid='$s[friendtype]'");
			}
			if(!$friend[$uid]['state']){
				update('common_friend',array('state'=>'1'),"uid='$uid' AND fuid='$_S[uid]'");
				$ftypeid=$friend[$uid]['friendtype'];
				if($ftypeid){
					DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'1' WHERE typeid='$ftypeid'");
				}
			}
			upuser(15,$uid);
			showmessage('好友添加成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.isfriend('.$uid.','.$tid.');smsot.inserfriend(\''.$s['friendtype'].'\',\''.$typename.'\',\''.$uid.'\',\''.$user['username'].'\',\''.head($user,'2','src').'\')},100)'));
		}else{
			$state=$user['friend']?'1':'0';
			if(!$state){
				insert('common_friend_apply',array('uid'=>$_S['member']['uid'],'username'=>$_S['member']['username'],'touid'=>$uid,'message'=>$s['message'],'state'=>'0','dateline'=>$_S['timestamp']));
				$newfriend=$_S['member']['newfriend']+1;
				update('common_user',array('newfriend'=>$newfriend),"uid='$uid'");
				$fun='setTimeout(function(){smsot.addfriend('.$uid.');sendnotice(\'touid='.$uid.'+call=smsot.havenewfriend()\');},100)';
			}else{
				insert('common_friend',array('uid'=>$uid,'fuid'=>$_S['member']['uid'],'friendname'=>$_S['member']['username'],'friendtype'=>'0','shield'=>'0','filter'=>'0','state'=>'1','dateline'=>$_S['timestamp']));
				if($s['friendtype']){
					DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'1' WHERE typeid='$s[friendtype]'");
				}
				$fun='setTimeout(function(){smsot.isfriend('.$uid.','.$tid.');smsot.inserfriend(\''.$s['friendtype'].'\',\''.$typename.'\',\''.$uid.'\',\''.$user['username'].'\',\''.head($user,'2','src').'\')},100)';
			}
			insert('common_friend',array('uid'=>$_S['member']['uid'],'fuid'=>$uid,'friendname'=>$user['username'],'friendtype'=>$s['friendtype'],'shield'=>$s['shield'],'filter'=>'0','state'=>$state,'dateline'=>$_S['timestamp']));
			upuser(15,$uid);
			showmessage('好友添加成功','',array('type'=>'toast','fun'=>'SMS.closepage();'.$fun));
		}
	}
}elseif($_GET['action']=='adopt'){
	$navtitle='好友申请';
	
	$apply=DB::fetch_first("SELECT a.*,u.dzuid FROM ".DB::table('common_friend_apply')." LEFT JOIN ".DB::table('common_user')." u ON u.uid=a.uid WHERE a.aid='$_GET[aid]'");
	if($apply['state']){
		showmessage('你已经通过了对方的好友申请');
	}elseif(!$apply){
		showmessage('操作错误');
	}else{
		$newfriend=$_S['member']['newfriend']?$_S['member']['newfriend']-1:0;
		update('common_user',array('newfriend'=>$newfriend),"uid='$_S[uid]'");

		$query = DB::query("SELECT * FROM ".DB::table('common_friend')." WHERE (uid='$_S[uid]' AND fuid='$apply[uid]') OR (uid='$apply[uid]' AND fuid='$_S[uid]')");
		while($value = DB::fetch($query)) {
			$friend[$value['uid']]=$value;
		}
    if(!$friend){
			DB::query("DELETE FROM ".DB::table('common_friend_apply')." WHERE aid='$apply[aid]'");
		  showmessage('已过期');
		}else{
			//自己曾经加过对方
			if($friend[$_S['uid']]){
				//对方未通过
				if(!$friend[$_S['uid']]['state']){
					$upwhere="(uid='$_S[uid]' AND fuid='$apply[uid]') OR (uid='$apply[uid]' AND fuid='$_S[uid]')";
					$fun='smsot.inserfriend(\''.$friend['friendtype'].'\',\'\',\''.$friend['fuid'].'\',\''.$friend['friendname'].'\',\''.head($apply,'2','src').'\')';
				}else{
					$upwhere="uid='$apply[uid]' AND fuid='$_S[uid]'";
				}
				if($friend[$_S['uid']]['friendtype']){
					$stypeid=$friend[$_S['uid']]['friendtype'];
					DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'1' WHERE typeid='$stypeid'");
				}
				if($friend[$apply['uid']]['friendtype']){
					$ftypeid=$friend[$apply['uid']]['friendtype'];
					DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'1' WHERE typeid='$ftypeid'");
				}				
				update('common_friend',array('state'=>'1'),$upwhere);
				update('common_friend_apply',array('state'=>'1'),"aid='$_GET[aid]'");
				showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.adoptfriend(\''.$apply['aid'].'\');'.$fun.'},100)'));	
			}else{
				//自己未加过对方
				$query = DB::query('SELECT * FROM '.DB::table('common_friend_type')." WHERE `uid` ='$_S[uid]'");
				while($value = DB::fetch($query)) {
					$friendtypes[$value['typeid']]=$value;
				}
				if(checksubmit('submit')){
					$newfriendtype=trim($_GET['newfriendtype']);
					$s['shield']=$_GET['shield']?$_GET['shield']:'0';
					if($newfriendtype){
						$typeid=insert('common_friend_type',array('uid'=>$_S['member']['uid'],'name'=>$newfriendtype));
					}
					$s['friendtype']=$typeid?$typeid:$_GET['friendtype'];
					
					$typename=$newfriendtype?$newfriendtype:($friendtypes[$s['friendtype']]['name']?$friendtypes[$s['friendtype']]['name']:'我的好友');
					insert('common_friend',array('uid'=>$_S['uid'],'fuid'=>$apply['uid'],'friendname'=>$apply['username'],'friendtype'=>$s['friendtype'],'shield'=>$s['shield'],'filter'=>'0','state'=>'1','dateline'=>$_S['timestamp']));
					update('common_friend',array('state'=>'1'),"uid='$apply[uid]' AND fuid='$_S[uid]'");
					update('common_friend_apply',array('state'=>'1'),"aid='$_GET[aid]'");
					
					if(!$newfriendtype && $s['friendtype']){
						DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'1' WHERE typeid='$s[friendtype]'");
					}
					if($friend[$apply['uid']]['friendtype']){
						$ftypeid=$friend[$apply['uid']]['friendtype'];
						DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'1' WHERE typeid='$ftypeid'");
					}
					showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.adoptfriend(\''.$apply['aid'].'\');smsot.inserfriend(\''.$s['friendtype'].'\',\''.$typename.'\',\''.$apply['uid'].'\',\''.$apply['username'].'\',\''.head($apply,'2','src').'\')},100)'));
				}
			}
		}
	}
}elseif($_GET['action']=='ignore'){
	$apply=DB::fetch_first("SELECT * FROM ".DB::table('common_friend_apply')." WHERE aid='$_GET[aid]'");
	if($apply['state']){
	  showmessage('你已经通过了对方的好友申请');
	}elseif(!$apply){
		showmessage('操作错误');
	}else{
		DB::query("DELETE FROM ".DB::table('common_friend_apply')." WHERE aid='$_GET[aid]'");
		DB::query("DELETE FROM ".DB::table('common_friend')." WHERE uid='$apply[uid]' AND fuid='$apply[touid]'");		
		$newfriend=$_S['member']['newfriend']?$_S['member']['newfriend']-1:0;
		update('common_user',array('newfriend'=>$newfriend),"uid='$_S[uid]'");
		showmessage('已忽略','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.ignorefriend(\''.$_GET['aid'].'\')},100)'));
	}
}elseif($_GET['action']=='delete'){
	$friend=DB::fetch_first("SELECT * FROM ".DB::table('common_friend')." WHERE uid='$_S[uid]' AND fuid='$uid'");
	if(!$friend){
		showmessage('你们还不是好友');
	}else{
		if(!$_GET['confirm']){
			showmessage('确定要删除吗？','user.php?uid='.$uid.'&mod=action&action=delete&confirm=true');
		}else{
			DB::query("DELETE FROM ".DB::table('common_friend')." WHERE uid='$_S[uid]' AND fuid='$uid'");
			DB::query("DELETE FROM ".DB::table('common_friend_apply')." WHERE uid='$_S[uid]' AND touid='$uid'");
			if($friend['friendtype'] && $friend['state']){
				DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'-1' WHERE typeid='$friend[friendtype]'");
			}
			showmessage('操作成功','',array('type'=>'toast','fun'=>'smsot.removefriend(\''.$uid.'\')'));
		}		
	}
}elseif($_GET['action']=='addblack'){
	$black=DB::fetch_first("SELECT * FROM ".DB::table('common_friend_blacklist')." WHERE uid='$_S[uid]' AND fuid='$uid'");
	if($black){
		showmessage('对方已在黑名单内');
	}else{
		if(!$_GET['confirm']){
			showmessage('加入黑名单后自己将不会再出现在对方联系人列表内,对方也无法再添加自己为好友','user.php?uid='.$uid.'&mod=action&action=addblack&confirm=true',array('title'=>'确定要将Ta加入黑名单吗？'));
		}else{			
			$query = DB::query("SELECT * FROM ".DB::table('common_friend')." WHERE (uid='$_S[uid]' AND fuid='$uid') OR (uid='$uid' AND fuid='$_S[uid]')");
			while($value = DB::fetch($query)) {
				$friend[$value['uid']]=$value;
			}
			DB::query("DELETE FROM ".DB::table('common_friend_apply')." WHERE (uid='$_S[uid]' AND touid='$uid') OR (uid='$uid' AND touid='$_S[uid]')");
			if($friend){
				DB::query("DELETE FROM ".DB::table('common_friend')." WHERE (uid='$_S[uid]' AND fuid='$uid') OR (uid='$uid' AND fuid='$_S[uid]')");
				if($friend[$_S['uid']]['friendtype'] && $friend[$_S['uid']]['state']){
					$stypeid=$friend[$_S['uid']]['friendtype'];
					DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'-1' WHERE typeid='$stypeid'");
				}
				if($friend[$uid]['friendtype'] && $friend[$uid]['state']){
					$ftypeid=$friend[$uid]['friendtype'];
					DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'-1' WHERE typeid='$ftypeid'");
				}
			}
			$tid=maketid(array($_S['uid'],$uid));
			DB::query("DELETE FROM ".DB::table('common_talk')." WHERE tid='$tid'");
			insert('common_friend_blacklist',array('uid'=>$_S['member']['uid'],'fuid'=>$uid,'dateline'=>$_S['timestamp']));
			showmessage('操作成功','',array('type'=>'toast','fun'=>'smsot.addblack(\''.$uid.'\');smsot.inserfriend(\'black\',\'\',\''.$user['uid'].'\',\''.$user['username'].'\',\''.head($user,'2','src').'\');'));
		}
	}
}elseif($_GET['action']=='deletefriendtype'){
	$friendtype=DB::fetch_first("SELECT * FROM ".DB::table('common_friend_type')." WHERE typeid='$_GET[typeid]' AND uid='$_S[uid]'");
	if(!$friendtype){
		showmessage('分组不存在');
	}
	if(!$_GET['confirm']){
		showmessage('删除后本分组内的好友将转移到默认分组内','user.php?typeid='.$_GET['typeid'].'&mod=action&action=deletefriendtype&confirm=true',array('title'=>'确定要将分组删除吗?'));
	}else{
		DB::query("DELETE FROM ".DB::table('common_friend_type')." WHERE typeid='$_GET[typeid]'");
		DB::query("UPDATE ".DB::table('common_friend')." SET `friendtype`='0' WHERE friendtype='$_GET[typeid]'");
		showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.deletefriendtype(\''.$_GET['typeid'].'\');},100)'));
	}
}elseif($_GET['action']=='managefriendtype'){
	$navtitle='管理分组';
	$query = DB::query('SELECT * FROM '.DB::table('common_friend_type')." WHERE `uid` ='$_S[uid]'");
	while($value = DB::fetch($query)) {
		$friendtypes[$value['typeid']]=$value;
	}
	if(checksubmit('submit')){
		$newfriendtype=trim($_GET['newfriendtype']);
		if($newfriendtype){
			$typeid=insert('common_friend_type',array('uid'=>$_S['member']['uid'],'name'=>$newfriendtype));
			$addtype="setTimeout(function(){smsot.addfriendtype('$typeid','$newfriendtype');},100)";
		}
    foreach($_GET['typeid'] as $i=>$id){
			$newname=trim($_GET['typename'][$i]);
			if($newname!=$friendtypes[$id]['name']){
				update('common_friend_type',array('name'=>$newname),"typeid='$id'");
				$idarr[]=$id;
				$namearr[]=$newname;
			}
		}
		if($idarr){
			$idstr=implode(',',$idarr);
			$namestr=implode(',',$namearr);
			$upfunc="setTimeout(function(){smsot.upfriendtype('$idstr','$namestr');},100)";
		}
	  showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();'.$addtype.$upfunc));
	}
}elseif($_GET['action']=='deleteblack'){
	if(!$_GET['confirm']){
		showmessage('确定要将Ta从黑名单移除吗','user.php?uid='.$uid.'&mod=action&action=deleteblack&confirm=true');
	}else{
		DB::query("DELETE FROM ".DB::table('common_friend_blacklist')." WHERE uid='$_S[uid]' AND fuid='$uid'");
		showmessage('操作成功','',array('type'=>'toast','fun'=>'smsot.deleteblack(\''.$uid.'\');'));
	}
}elseif($_GET['action']=='friendtype'){
	$friend=DB::fetch_first("SELECT * FROM ".DB::table('common_friend')." WHERE uid='$_S[uid]' AND fuid='$uid'");
	if(!$friend){
		showmessage('你们还不是好友');
	}else{
		$query = DB::query('SELECT * FROM '.DB::table('common_friend_type')." WHERE `uid` ='$_S[uid]'");
		while($value = DB::fetch($query)) {
			$friendtypes[$value['typeid']]=$value;
		}
		if(checksubmit('submit')){
			$newfriendtype=trim($_GET['newfriendtype']);
			$s['shield']=$_GET['shield']?$_GET['shield']:'0';
			if($newfriendtype){
				$typeid=insert('common_friend_type',array('uid'=>$_S['member']['uid'],'name'=>$newfriendtype));
			}
			$s['friendtype']=$typeid?$typeid:$_GET['friendtype'];
			$typename=$newfriendtype?$newfriendtype:($friendtypes[$s['friendtype']]['name']?$friendtypes[$s['friendtype']]['name']:'我的好友');
			if($s['friendtype']!=$friend['friendtype']){
				if($s['friendtype']){
          DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'1' WHERE typeid='$s[friendtype]'");
				}
				if($friend['friendtype']){
					DB::query("UPDATE ".DB::table('common_friend_type')." SET `number`=`number`+'-1' WHERE typeid='$friend[friendtype]'");
				}
				update('common_friend',$s,"uid='$_S[uid]' AND fuid='$uid'");
				showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.inserfriend(\''.$s['friendtype'].'\',\''.$typename.'\',\''.$user['uid'].'\',\''.$user['username'].'\',\''.head($user,'2','src').'\')},100)'));				
			}else{
				showmessage('操作成功','',array('type'=>'toast'));
			}
		}
	}
	
}elseif($_GET['action']=='qrcode'){	
  $navtitle='二维码';
  
	$url=urlencode($_S['setting']['siteurl'].'user.php?uid='.$uid);
	
}elseif($_GET['action']=='follow'){
	$navtitle='关注';
	$fuid=$_S['member']['uid'];
	if($uid==$_S['uid']){
		showmessage('不能关注自己');
	}
	$follow=DB::fetch_first("SELECT * FROM ".DB::table('common_follow')." WHERE uid='$fuid' AND fuid='$uid'");
	
	if($follow){
		DB::query("DELETE FROM ".DB::table('common_follow')." WHERE uid='$fuid' AND fuid='$uid'");
		DB::query("UPDATE ".DB::table('common_user_count')." SET `follow`=`follow`+'-1' WHERE uid='$fuid'");
		DB::query("UPDATE ".DB::table('common_user_count')." SET `fans`=`fans`+'-1' WHERE uid='$uid'");
		upuser(16,$_S['uid']);
		upuser(17,$uid);
		
		showmessage('操作成功','',array('type'=>'toast','fun'=>'smsot.follow(\''.$uid.'\',\'关注\',\'gz\',\''.$_S['uid'].'\')'));
	}else{
		insert('common_follow',array('uid'=>$_S['member']['uid'],'fuid'=>$uid,'dateline'=>$_S['timestamp']));
		DB::query("UPDATE ".DB::table('common_user_count')." SET `follow`=`follow`+'1' WHERE uid='$fuid'");
		DB::query("UPDATE ".DB::table('common_user_count')." SET `fans`=`fans`+'1' WHERE uid='$uid'");
		showmessage('关注成功','',array('type'=>'toast','fun'=>'smsot.follow(\''.$uid.'\',\'取消\',\'qx\',\''.$_S['uid'].'\')'));
	}
}
$title=$navtitle.'-'.$_S['setting']['sitename'];

include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>