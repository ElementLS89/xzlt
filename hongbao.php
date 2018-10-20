<?php
define('PHPSCRIPT', 'hongbao');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './include/function_user.php';

$S = new S();
$S -> star();

if(!$_S['member']['uid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
$_S['outback']=true;
$hongbao=DB::fetch_first("SELECT h.*,u.username,u.dzuid,l.money as rec FROM ".DB::table('common_hongbao')." h LEFT JOIN ".DB::table('common_user')." u ON u.uid=h.uid LEFT JOIN ".DB::table('common_hongbao_log')." l ON l.hid=h.hid AND l.uid='$_S[uid]' WHERE h.hid='$_GET[hid]'");
$hongbao['rec']=$hongbao['rec']?$hongbao['rec']/100:'';



if(!$hongbao['hid']){
	showmessage('红包不存在或已被撤回');
}
$my=getuser(array('common_user_count'),$_S['uid']);

if($hongbao['uid']==$_S['uid']){

	$navtitle='红包';
	if($hongbao['surplus'] && $hongbao['dateline']+86400<$_S['timestamp']){
		$canwithdraw=true;
	}
	if(!$hongbao['surplus'] && !$hongbao['receive']){
		$withdrawed=true;
	}
	if(!$hongbao['surplus'] && $hongbao['receive']){
		$receiveed=true;
	}
	
	if($canwithdraw && $_GET['withdraw']){
		update('common_hongbao',array('surplus'=>'0'),"hid='$_GET[hid]'");

		/*log*/
		$lid=makeid();
		$money=($my['balance']*100)+$hongbao['surplus'];
		$relation=serialize(array('hid'=>$hongbao['hid']));
		insert('common_user_count_log',array('lid'=>$lid,'uid'=>$_S['uid'],'fild'=>'balance','arose'=>$hongbao['surplus'],'title'=>'红包撤回','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
		update('common_user_count',array('balance'=>$money),"uid='$_S[uid]'");
		showmessage('操作成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.accountchange(\''.($money/100).'\',\'balance\');smsot.hongbaowithdraw(\''.$hongbao['hid'].'\');},100)'));
	}
}elseif($hongbao['touid']==$_S['uid']){
	$navtitle='领取红包';

	
  if($_GET['receive']){
		if(!$hongbao['surplus']){
			showmessage('红包已被领完');
		}
		if($hongbao['rec']){
			showmessage('您已经领过了');
		}
		if($hongbao['password']){
			if(checksubmit('submit')){
				$s['message']=trim($_GET['password']);
				if($s['message']!=$hongbao['password']){
					showmessage('口令输入错误');
				}
				$canreceive=true;
			}
		}else{
			$canreceive=true;
		}
		
		if($canreceive){
			$log['lid']=makeid();
			$log['hid']=$_GET['hid'];
			$log['uid']=$_S['uid'];
			$log['money']=setmoney($hongbao['surplus'],$hongbao['number']-$hongbao['receive']);
			$log['logtime']=$_S['timestamp'];
			insert('common_hongbao_log',$log);
			DB::query("UPDATE ".DB::table('common_hongbao')." SET `receive`=`receive`+'1',`surplus`=`surplus`+'-$log[money]' WHERE hid='$_GET[hid]'");
			/*log*/
			$lid=makeid();
			$money=($my['balance']*100)+$log['money'];
			$relation=serialize(array('hid'=>$hongbao['hid']));
			insert('common_user_count_log',array('lid'=>$lid,'uid'=>$_S['uid'],'fild'=>'balance','arose'=>$log['money'],'title'=>'领取红包','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
			update('common_user_count',array('balance'=>$money),"uid='$_S[uid]'");
			$tid=maketid(array($_S['uid'],$hongbao['uid']));
		  if($hongbao['password']){
				//send
				require_once './include/function_talk.php';
				require_once './include/json.php';
				
				$message='<div class="message-content">'.$s['message'].'</div>';
		    $s['summary']=cutstr($s['message'],20);
				$mid=sendmessage($tid,1,$s['summary'],$s['message']);
				
				$ins['form']=$ins['to']=array();
				$ins['form']['mid']=$ins['to']['mid']=$mid;
				$ins['form']['userclass']=' self';
				$ins['form']['typeclass']=' message-d';
				$ins['form']['touid']=$ins['to']['touid']=$hongbao['uid'];
				$ins['form']['formuid']=$ins['to']['formuid']=$_S['uid'];
				$ins['form']['tousername']=$ins['to']['tousername']=$hongbao['username'];
				$ins['form']['formusername']=$ins['to']['formusername']=$_S['member']['username'];
				$ins['form']['toavatar']=$ins['to']['toavatar']=head($hongbao,2,'src');
				$ins['form']['formavatar']=$ins['to']['formavatar']=head($_S['member'],2,'src');
				$ins['form']['tid']=$ins['to']['tid']=$tid;
				$ins['form']['summary']=$ins['to']['summary']=$s['summary'];
				$ins['form']['date']=$ins['to']['date']=smsdate($_S['timestamp'],'m-d H:i:s');
				$ins['form']['time']='';
				
				$return['form']= JSON::encode($ins['form']);
	      $return['to']= JSON::encode($ins['to']);
				
				$fun='smsot.insertmessage(\''.$return['form'].'\',\''.$message.'\');sendnotice(\'touid='.$hongbao['uid'].'+call=smsot.havenewmsg(\\\''.$return['to'].'\\\');smsot.talknotice(\\\''.$_S['member']['username'].'领取了红包\\\',\\\''.$tid.'\\\')\')';
			}else{
				$fun='sendnotice(\'touid='.$hongbao['uid'].'+call=smsot.talknotice(\\\''.$_S['member']['username'].'领取了红包\\\',\\\''.$tid.'\\\')\')';
			}
			showmessage('领取成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.accountchange(\''.($money/100).'\',\'balance\');smsot.hongbaoreceive(\''.$hongbao['hid'].'\');'.$fun.'},100)'));
		}
	}
}else{
	showmessage('没有权限领取');
}
$title=$navtitle.'-'.$_S['setting']['sitename'];

if($hongbao['receive']){
	$sql = array();
	$wherearr = array();
	$sql['select'] = 'SELECT l.*';
	$sql['from'] ='FROM '.DB::table('common_hongbao_log').' l';

	$sql['select'] .= ',u.*';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=l.uid";
		
	$wherearr[] = "l.hid ='$_GET[hid]'";
	$sql['order']='ORDER BY l.logtime ASC';	
	$select=select($sql,$wherearr,10);
	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)) {
			$value['money']=$value['money']/100;
			$list[]=$value;
		}
	}
	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'hongbao.php?hid='.$_GET['hid'].'&page='.$nextpage;

	$jsonvar=array($list);
}


include temp('hongbao');
?>