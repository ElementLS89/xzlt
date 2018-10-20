<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='详情';
$theme=getthemecontent($_GET['vid']);

if(!$theme){
	showmessage('帖子不存在');
}
$_S['poster']['api']='topic.php?vid='.$_GET['vid'].'&api=poster';
if($_GET['api']=='poster'){
	require_once './include/poster.php';
	$date=array(
		'title'=>$theme['subject'],
		'summary'=>stringvar($theme['abstract'],120),
		'pic'=>$theme['imgs'][0]['atc'],
		'url'=>$_S['setting']['siteurl'].'topic.php?vid='.$_GET['vid'].'&formuid='.$_S['uid'],
	);
	creatposter($date);
	exit;
}

$backurl=$theme['tid']?'topic.php?tid='.$theme['tid']:'topic.php';
C::chche('smile');

$title=$theme['subject'].'-'.$_S['setting']['sitename'];
$metadescription=$theme['abstract'];
$keywords=$theme['subject'].','.$metakeywords;

if($theme['tid']){
	$topic=DB::fetch_first("SELECT t.*,u.level FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$theme[tid]'");
	if($topic){
		$canmanage=getpower($topic);
		if(!$topic['show'] && !$topic['level']){
			showmessage('请先加入本小组之后才能看帖','topic.php?mod=action&ac=join&tid='.$theme['tid']);
		}		
	}
}else{
	$canmanage=$theme['uid']==$_S['uid']||$_S['usergroup']['power']>5?true:false;
}

if($_GET['get']!='ajax'){
	//shar
	$signature=signature();
	$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone,chooseWXPay';
	$_S['shar']['pic']=$_S['setting']['siteurl'].($theme['imgs'][0]['atc']?$_S['atc'].'/'.$theme['imgs'][0]['atc']:'ui/ico.png');
	$_S['shar']['desc']=$theme['abstract'];
	
	DB::query("UPDATE ".DB::table('topic_themes')." SET `views`=`views`+'1' WHERE vid='$_GET[vid]'");
	
  //pay
	if($theme['price'] && !$canmanage && $theme['uid']!=$_S['uid']){
		if($_S['uid']){
			$paylog=DB::fetch_first("SELECT * FROM ".DB::table('topic_theme_log')." WHERE `vid`='$theme[vid]' AND uid='$_S[uid]'");
			if(!$paylog){
				$needpay=true;
			}
		}else{
			$needpay=true;
		}
		if($needpay){
			$my=getuser(array('common_user_count'),$_S['uid']);
			if($theme['price']>$my['balance']){
				getopenid();
				$paybtn='<a href="javascript:callpay(\'topicpay\')" class="weui-btn weui-btn_primary load" loading="tab" id="primary">前往支付</a>';
			}else{
				$paybtn='<button type="button" class="weui-dialog__btn weui-dialog__btn_primary formpost">前往支付</button>';
			}		
		}
	}
	//rewards
	if($theme['gratuity_number']){
		$query = DB::query('SELECT g.*,u.dzuid FROM '.DB::table('common_gratuity')." g  LEFT JOIN ".DB::table('common_user')." u ON u.uid=g.uid WHERE g.`mod` ='topic' AND g.`vid`='$_GET[vid]' ORDER BY g.money DESC LIMIT 6");
		while($value = DB::fetch($query)){
			$rewards[$value['gid']]=$value;
		}		
	}
	//praise
	if($theme['praise']){
		$query = DB::query('SELECT a.*,u.dzuid FROM '.DB::table('topic_action')." a LEFT JOIN ".DB::table('common_user')." u ON u.uid=a.uid WHERE a.`type` ='topic' AND a.`id`='$_GET[vid]' ORDER BY a.dateline DESC LIMIT 5");
		while($value = DB::fetch($query)){
			$praise[$value['aid']]=$value;
		}		
	}

		
}



$table='common_replys_'.substr($_GET['vid'],-1);
if($theme['replys']>0){
	$sql['select'] = 'SELECT p.*';
	$sql['from'] ='FROM '.DB::table($table).' p';
	
	$wherearr[] = "p.mod ='topic'";
	$wherearr[] = "p.vid ='$_GET[vid]'";
	$wherearr[] = "p.upid ='0'";
	$wherearr[] = "p.top >='0'";
	
	$sql['select'] .= ',u.username,u.groupid,u.uid';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=p.uid";
	$sql['order']='ORDER BY p.top DESC,p.replys DESC,p.dateline DESC';
	
	$select=select($sql,$wherearr,10);
	
	
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
		$query = DB::query('SELECT r.*,u.username FROM '.DB::table($table).' r LEFT JOIN '.DB::table('common_user')." u ON u.uid=r.uid WHERE r.upid IN($rids) AND r.new='1' AND r.top >='0' ORDER BY r.dateline DESC");
		
		while($value = DB::fetch($query)) {
			$value['s']='n';
			$replys[$value['upid']][]=$value;
		}
	}

	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'topic.php?vid='.$_GET['vid'].'&page='.$nextpage;
	

}
$jsonvar=array($theme,$list);
include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>