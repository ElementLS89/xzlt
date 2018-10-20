<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='发名片';
$title=$navtitle.'-'.$_S['setting']['sitename'];
if($_GET['uid']){
	if($_GET['uid'] == $_GET['touid']){
		showmessage('不给给对方发对方自己的名片');
	}
	require_once './include/function_user.php';
	require_once './include/function_talk.php';
	require_once './include/json.php';
	
	$mingpian=getuser(array('common_user','common_user_profile'),$_GET['uid']);
	
	if($_GET['send']){
		if(!$mingpian){
			showmessage('用户不存在');
		}
		$tid=maketid(array($_S['uid'],$_GET['touid']));
		
		$checksend=checksend($tid);
		$tousername=$checksend[0];
		$openid=$checksend[1];
		$message=dserialize($mingpian);
		$mid=sendmessage($tid,6,'[名片]',$message);

		$userclass=' self';
		$typeclass=' message-b';
		$message='<a class="message-mingpian load cl" href="user.php?uid='.$_GET['uid'].'"><div class="l"><img src="'.head($checksend[2],2,'src').'" class="avatar"></div><div class="l"><h4>'.$mingpian['username'].'的名片</h4><p>'.$mingpian['gender-text'].' '.$mingpian['age'].'岁</p></div></a><p class="b_c3 c4 s12 pl10">用户名片</p>';
		
		
		$date=smsdate($_S['timestamp'],'m-d H:i:s');
		$time='';
		$form_avatar=head($_S['member'],2,'src');
		$to_avatar=head($checksend[2],2,'src');
		//
		$ins['form']=$ins['to']=array();
		$ins['form']['mid']=$ins['to']['mid']=$mid;
		$ins['form']['userclass']=$userclass;
		$ins['form']['typeclass']=$typeclass;
		$ins['form']['touid']=$ins['to']['touid']=$_GET['touid'];
		$ins['form']['formuid']=$ins['to']['formuid']=$_S['uid'];
		$ins['form']['tousername']=$ins['to']['tousername']=$tousername;
		$ins['form']['formusername']=$ins['to']['formusername']=$_S['member']['username'];
		$ins['form']['toavatar']=$ins['to']['toavatar']=$to_avatar;
		$ins['form']['formavatar']=$ins['to']['formavatar']=$form_avatar;
		
		$ins['form']['tid']=$ins['to']['tid']=$tid;
		$ins['form']['summary']=$ins['to']['summary']='[名片]';
		$ins['form']['date']=$ins['to']['date']=$date;
		$ins['form']['time']=$time;

	
	  $return['form']= JSON::encode($ins['form']);
	  $return['to']= JSON::encode($ins['to']);
		if($_S['setting']['wxnotice_talk'] && $openid){
			$wxnotice=array(
				'first'=>array('value'=>'有人给你发了一张名片'),
				'keyword1'=>array('value'=>$_S['member']['username']),
				'keyword2'=>array('value'=>$mingpian['username'].'的名片'),
				'keyword3'=>array('value'=>smsdate($_S['timestamp'],'Y-m-d H:i:s')),
				'remark'=>array('value'=>'点击立即查看名片','color'=>'#3399ff'),
			);
			sendwxnotice($_GET['touid'],$openid,$_S['setting']['wxnotice_talk'],$_S['setting']['siteurl'].'my.php?mod=talk&tid='.$tid,$wxnotice);					
		}
		showmessage('发送成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.insertmessage(\''.$return['form'].'\',\''.$message.'\')},500);sendnotice(\'touid='.$_GET['touid'].'+call=smsot.havenewmsg(\\\''.$return['to'].'\\\')\');'));
	}else{
		showmessage('是否要将'.$mingpian['username'].'的名片发送给对方','my.php?mod=mingpian&uid='.$_GET['uid'].'&touid='.$_GET['touid'].'&send=true');
	}
}else{
	$typeid=$_GET['typeid']?$_GET['typeid']:'0';
	
	$sql = array();
	$wherearr = array();
	
	$sql['select'] = 'SELECT f.*';
	$sql['from'] ='FROM '.DB::table('common_friend').' f';

	$sql['select'] .= ',u.dzuid';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=f.fuid";
	
	$wherearr[] = "f.uid ='$_S[uid]'";
	$wherearr[] = "f.friendtype ='$typeid'";
	$wherearr[] = "f.state ='1'";
	$wherearr[] = "f.fuid !='$_GET[touid]'";
	
	$sql['order']='ORDER BY f.dateline DESC';	
	
	$select=select($sql,$wherearr,10);
	
	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)) {
			$value['user']=array('uid'=>$value['fuid'],'dzuid'=>$value['dzuid']);
			$list[$value['fuid']]=$value;
		}
	}	
	
	if($_S['page']==1 && $_GET['get']!='ajax'){
		$query = DB::query('SELECT * FROM '.DB::table('common_friend_type')." WHERE `uid` ='$_S[uid]'");
		while($value = DB::fetch($query)) {
			$friendtype[]=$value;
		}
		$friendnum = $select[1];
	}
	
	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'my.php?mod=mingpian&page='.$nextpage.'&get=ajax';
	
	$jsonvar=array($friendtype,$list);	
}


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>