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
if($_GET['ac']=='join' || $_GET['ac']=='out'){
	$topic=DB::fetch_first("SELECT t.*,u.level FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$_GET[tid]'");
	$ismember=($topic['level'] || $topic['level']=='0')?'1':'0';
	if(!$topic){
		showmessage('小组不存在');
	}
	if($topic['open']=='-1'){
		showmessage('本小组拒绝申请加入');
	}
  if(!$ismember){
		if($topic['price']){
			$my=getuser(array('common_user_count'),$_S['uid']);
			if($topic['price']>$my['balance']){
				getopenid();
				$signature=signature();
				$apilist='chooseWXPay';
				$noshar=true;
				$paybtn='<a href="javascript:callpay(\'topicpay\')" class="weui-dialog__btn weui-dialog__btn_primary load" loading="tab" id="primary">支付</a>';
			}else{
				$paybtn='<button type="button" class="weui-dialog__btn weui-dialog__btn_primary formpost">支付</button>';
			}
			include temp('topic/topicpay');
		}else{
			$level=$topic['open']==1?1:'0';
			insert('topic_users',array('tid'=>$_GET['tid'],'uid'=>$_S['uid'],'level'=>$level,'dateline'=>$_S['timestamp']));
			update('topic',array('users'=>$topic['users']+1),"tid='$_GET[tid]'");
			if($level=='1'){
				$msg='加入成功';
			}else{
				$msg='提交提成，请等待审核';
			}
			showmessage($msg,'',array('type'=>'toast','fun'=>'topic.jotopic(\'join\',\''.$_GET['tid'].'\',\''.($topic['users']+1).'\')'));			
		}
	}else{
		if($topic['level']==127){
			showmessage('您是小组所有者，需要先将小组转让之后才能退出');
		}
		if($topic['price']){
			if(!$_GET['confirm']){
				showmessage('本小组是收费小组退出后再加入需要重新付费,您确定要退出吗?','topic.php?mod=action&ac=out&tid='.$_GET['tid'].'&confirm=true');
			}else{
				$out=true;	
			}
		}else{
			$out=true;
		}
		if($out){
			DB::query("DELETE FROM ".DB::table('topic_users')." WHERE uid='$_S[uid]' AND tid='$_GET[tid]'");
			update('topic',array('users'=>$topic['users']+-1),"tid='$_GET[tid]'");
			showmessage('您已退出','',array('type'=>'toast','fun'=>'topic.jotopic(\'out\',\''.$_GET['tid'].'\',\''.($topic['users']-1).'\')'));					
		}
	}
}elseif($_GET['ac']=='pay'){
	$navtitle='支付费用';
	if($_GET['tid']){
		$topic=DB::fetch_first("SELECT t.*,u.level FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$_GET[tid]'");
		if(!$topic){
			showmessage('小组不存在');
		}
		if($topic['level']){
			showmessage('您已是小组成员');
		}
		if(!$topic['price']){
			showmessage('加入本小组无需付费');
		}
		$s['money']=$topic['price'];
		$idtype='tid';
		$id=$_GET['tid'];
		$subtitle='加入小组';
		$touid=getmanager($_GET['tid']);
	}
	if($_GET['vid']){
		$theme=DB::fetch_first("SELECT * FROM ".DB::table('topic_themes')." WHERE `vid`='$_GET[vid]'");
		if(!$theme){
			showmessage('帖子不存在');
		}
		if(!$theme['price']){
			showmessage('阅读本帖子无需付费');
		}
		if($theme['uid']==$_S['uid']){
			showmessage('您是作者无需付费');
		}
		$paylog=DB::fetch_first("SELECT * FROM ".DB::table('topic_theme_log')." WHERE `vid`='$theme[vid]' AND uid='$_S[uid]'");
		if($paylog){
			showmessage('您已经支付过费用');
		}
		$s['money']=$theme['price'];
		$idtype='vid';
		$id=$_GET['vid'];
		$subtitle='付费阅读';
		$touid=$theme['uid'];
	}
	if($touid){
		$user=getuser(array('common_user','common_user_count'),$touid);
		if(!$user){
			showmessage('作者或者小组管理员已被删除，无法支付');
		}		
	}
	
	$my=getuser(array('common_user_count'),$_S['uid']);
	
	if(checksubmit('submit')){
		if($s['money']>$my['balance']*100){
			showmessage('您钱包余额不足,请更换其他支付方式');
		}
		$lid=makeid();
		$money=($my['balance']*100)-($s['money']*100);
		$relation=serialize(array('idtye'=>$idtype,'id'=>$id));
		/*支付*/
		insert('common_user_count_log',array('lid'=>$lid,'uid'=>$_S['uid'],'fild'=>'balance','arose'=>-$s['money']*100,'title'=>$subtitle,'relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
		update('common_user_count',array('balance'=>$money),"uid='$_S[uid]'");
		/*收款*/
		if($touid){
			$lid=makeid();
			$money=($user['balance']*100)+($s['money']*100);
			insert('common_user_count_log',array('lid'=>$lid,'uid'=>$touid,'fild'=>'balance','arose'=>$s['money']*100,'title'=>$_S['member']['username'].$subtitle,'relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
			update('common_user_count',array('balance'=>$money),"uid='$touid'");			
		}
		/*结果*/
		if($_GET['tid']){
			if($touid){
				sendnotice($touid,'notice','<a href="user.php?uid='.$_S['uid'].'" class="load c8">'.$_S['member']['username'].'</a>申请加入小组，支付了'.($s['money']).'元');
			}
			insert('topic_users',array('tid'=>$_GET['tid'],'uid'=>$_S['uid'],'level'=>1,'dateline'=>$_S['timestamp']));
			update('topic',array('users'=>$topic['users']+1),"tid='$_GET[tid]'");
			showmessage('加入成功','',array('type'=>'toast','fun'=>'SMS.closepage();topic.jotopic(\'join\',\''.$_GET['tid'].'\',\''.($topic['users']+1).'\')'));		
		}else{
			sendnotice($touid,'notice','<a href="user.php?uid='.$_S['uid'].'" class="load c8">'.$_S['member']['username'].'</a>付费阅读了您的文章，支付了'.($s['money']).'元');
			insert('topic_theme_log',array('vid'=>$_GET['vid'],'uid'=>$_S['uid'],'price'=>$s['money'],'dateline'=>$_S['timestamp']),true);
			showmessage('支付成功','',array('type'=>'toast','fun'=>'setTimeout(function(){SMS.deleteitem(\'topic.php?vid='.$_GET['vid'].'\');SMS.reload(\'topic.php?vid='.$_GET['vid'].'\')},100)'));
		}
	}
}elseif($_GET['ac']=='apply'){
	$navtitle='申请加入管理团队';
	
  $topic=DB::fetch_first("SELECT t.*,u.level FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$_GET[tid]'");
	$backurl='topic.php?tid='.$_GET['tid'];
	$title=$navtitle.'-'.$topic['name'].'-'.$_S['setting']['sitename'];
	if(!$topic){
		showmessage('话题不存在');
	}
	if(!$topic['level']){
		showmessage('只有正式成员才能申请');
	}
	if($topic['level']<$topic['allowapply']){
		showmessage('只有级别达到'.$topic['allowapply'].'级的才能申请');
	}
	if($topic['level']>125){
		showmessage('您已经是管理团队成员,不需要再次申请');
	}
	$apply=DB::fetch_first("SELECT * FROM ".DB::table('topic_apply')." WHERE `tid`='$_GET[tid]' AND uid='$_S[uid]'");
	if($apply && $apply['state']==0){
		showmessage('您已经申请过了，请耐心等待审核');
	}
	if($apply['state']==-1){
		showmessage('您不符合申请条件，申请已经被拒');
	}
	$s['level']=in_array($_GET['level'],array(126,127))?$_GET['level']:'126';
	$count = DB::result_first('SELECT COUNT(*) FROM '.DB::table('topic_users')." WHERE tid='$_GET[tid]' AND level='$s[level]'");
	$max=$s['level']=='126'?$topic['maxmanagers']:$topic['maxleaders'];
	if($count>=$max){
		showmessage('已经没有名额了，请以后再来试试');
	}
	
	if(checksubmit('submit')){

		$s['name']=$_GET['name'];
		$s['tel']=$_GET['tel'];
		$s['qq']=$_GET['qq'];
		$s['about']=stringvar($_GET['about'],255);
		
		$s['dateline']=$_S['timestamp'];
		$s['tid']=$_GET['tid'];
		$s['uid']=$_S['uid'];

		$aid=insert('topic_apply',$s);
		showmessage('您的申请已提交,请等待审核','',array('js'=>'SMS.closepage();'));
	}

	include temp(PHPSCRIPT.'/'.$_GET['mod']);
}else{

  $theme=DB::fetch_first("SELECT v.*,u.level,u.experience FROM ".DB::table('topic_themes')." v LEFT JOIN ".DB::table('topic_users')." u ON u.tid=v.tid AND u.uid=v.uid WHERE v.`vid`='$_GET[vid]'");
	if(!$theme){
		showmessage('帖子不存在');
	}
	if($theme['tid']){
		$topic=DB::fetch_first("SELECT t.*,u.level FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$theme[tid]'");
		$canmanage=getpower($topic);
	}else{
		$canmanage=$_S['usergroup']['power']>5?true:false;
	}
	
	if($_GET['ac']=='praise'){
		if($_S['setting']['sms_need'] && !$_S['member']['tel']){
	    showmessage('您需要绑定手机号之后才能进行下面的操作','my.php?mod=profile&show=3');
    }
		//赞
		$praise=DB::fetch_first("SELECT * FROM ".DB::table('topic_action')." WHERE `type`='topic' AND `id`='$_GET[vid]' AND uid='$_S[uid]'");
		if(!$_S['usergroup']['allowpraise']){
			showmessage('您所在用户组无法点赞');
		}
		if($praise){
			showmessage('您已经点过赞了');
		}
		insert('topic_action',array('type'=>'topic','id'=>$_GET['vid'],'uid'=>$_S['uid'],'dateline'=>$_S['timestamp']));
		update('topic_themes',array('praise'=>$theme['praise']+1),"vid='$_GET[vid]'");
		upuserlevel($theme,1);
		sendnotice($theme['uid'],'praise','您的帖子<a href="topic.php?vid='.$_GET['vid'].'" class="c8 load">'.$theme['subject'].'</a>被人点赞了',$_GET['vid']);
		if($theme['uid']!=$_S['uid']){
			upuser(3,$_S['uid']);
			upuser(20,$theme['uid']);
		}
		showmessage('操作成功','',array('type'=>'toast','fun'=>'topic.setpraise(\''.$_GET['vid'].'\');sendnotice(\'touid='.$theme['uid'].'+call=smsot.newnotice()\')'));
		
	}elseif($_GET['ac']=='delete'){
    if($canmanage){
			
		}
		
		if(($theme['tid'] && ((!$canmanage && !$_S['setting']['deletethread']) || (!$canmanage && $_S['setting']['deletethread'] && $theme['uid']!=$_S['uid']))) || (!$theme['tid'] && $theme['uid']!=$_S['uid'] && !$canmanage)){
			showmessage('您没有权限删除本帖');
		}
		//删除
		$table='common_replys_'.substr($_GET['vid'],-1);
		if(!$_GET['confirm']){
			showmessage('确定要删除本帖子吗?','topic.php?mod=action&ac=delete&vid='.$_GET['vid'].'&confirm=true');
		}else{
			DB::query("DELETE FROM ".DB::table('topic_themes')." WHERE vid='$_GET[vid]'");
			DB::query("DELETE FROM ".DB::table($table)." WHERE vid='$_GET[vid]' AND `mod`='topic'");
			DB::query("DELETE FROM ".DB::table('common_record')." WHERE `mod`='topic' AND vid='$_GET[vid]'");
			DB::query("UPDATE ".DB::table('topic')." SET `themes`=`themes`+'-1' WHERE tid='$theme[tid]'");
			upuserlevel($theme,-5);
			upuser(19,$theme['uid']);
			sendnotice($theme['uid'],'topic','您的帖子['.$theme['subject'].'被删除了');
			showmessage('删除成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){topic.deletetheme(\''.$_GET['vid'].'\',\''.$theme['tid'].'\');sendnotice(\'touid='.$theme['uid'].'+call=smsot.newnotice()\')},500);'));		
		}
	}elseif($_GET['ac']=='settop'){
		if(!$canmanage){
			showmessage('您没有权限置顶本帖');
		}
		//置顶
		$top=$theme['top']?'0':'1';
		update('topic_themes',array('top'=>$top),"vid='$_GET[vid]'");
		showmessage('设置成功','',array('type'=>'toast','fun'=>'topic.settheme(\''.$_GET['vid'].'\',\''.$top.'\',\''.$_GET['ac'].'\');'));
		
	}elseif($_GET['ac']=='setbest'){
		if(!$canmanage){
			showmessage('您没有权限推荐本帖');
		}
		//推荐
		$best=$theme['best']?'0':'1';
		update('topic_themes',array('best'=>$best),"vid='$_GET[vid]'");
		if($best){
			upuserlevel($theme,10);
			upuser(12,$theme['uid']);
			sendnotice($theme['uid'],'topic','您的帖子<a href="topic.php?vid='.$_GET['vid'].'" class="c8 load">'.$theme['subject'].'</a>被推荐了');
			$JSNOTICE=';sendnotice(\'touid='.$theme['uid'].'+call=smsot.newnotice()\')';			
		}else{
      upuserlevel($theme,-10);
		}
		showmessage('设置成功','',array('type'=>'toast','fun'=>'topic.settheme(\''.$_GET['vid'].'\',\''.$best.'\',\''.$_GET['ac'].'\')'.$JSNOTICE));
	}
}



?>