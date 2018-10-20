<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
	'index'=>array('支付记录','admin.php?mod='.$_GET['mod'].'&item=index'),
	'smslog'=>array('短信记录','admin.php?mod='.$_GET['mod'].'&item=smslog'),
  'txlog'=>array('提现申请','admin.php?mod='.$_GET['mod'].'&item=txlog'),
	'count'=>array('账户变动记录','admin.php?mod='.$_GET['mod'].'&item=count'),
);

if($_GET['item']=='index'){

	if($_GET['searchsubmit']){
		$sql['select'] = 'SELECT p.*';
		$sql['from'] =' FROM '.DB::table('common_paylog').' p';
	
		$sql['select'] .= ',u.username';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=p.uid";
		if($_GET['uid']){
			$wherearr[] = "p.uid ='$_GET[uid]'";
		}
		if(isset($_GET['state'])){
			$wherearr[] = "p.state ='$_GET[state]'";
		}
		if($_GET['ac']){
			$wherearr[] = "p.ac ='$_GET[ac]'";
		}
		if($_GET['openid']){
			$wherearr[] = "p.openid ='$_GET[openid]'";
		}
		
		$sql['order']='ORDER BY p.dateline DESC';	
		$select=select($sql,$wherearr,30);
	
		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				$value['money']=$value['money']/100;
				$list[$value['tradeno']]=$value;
			}
		}
		$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&uid='.$_GET['uid'].'&state='.$_GET['state'].'&ac='.$_GET['ac'].'&openid='.$_GET['openid'].'&searchsubmit=true';
	
		$pages=page($select[1],30,$_S['page'],$urlstr.'&iframe=yes');
		if(checksubmit('deletesubmit')){
			if($_GET['tradeno']){
				foreach($_GET['tradeno'] as $tradeno){
					$s['tradeno'][]="'".$tradeno."'";
				}
				$tradenos=implode(',',$s['tradeno']);			
			}
	
			if($tradenos){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('common_paylog')." WHERE `tradeno` IN($tradenos)");
				showmessage('所选支付记录已被删除',$urlstr);				
			}else{
				showmessage('您还没选中任何支付记录');				
			}
		}		
	}

	
}elseif($_GET['item']=='smslog'){
	$sql['select'] = 'SELECT l.*';
	$sql['from'] =' FROM '.DB::table('common_sms_log').' l';

	$sql['select'] .= ',u.uid,u.username';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.tel=l.phonenumber";
	
	$sql['order']='ORDER BY l.dateline DESC';	
	$select=select($sql,$wherearr,30);

	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			$value['code']=dunserialize($value['code']);
			$list[$value['lid']]=$value;
		}
	}
	$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'];

	$pages=page($select[1],30,$_S['page'],$urlstr.'&iframe=yes');
	if(checksubmit('deletesubmit')){
    $lids=implode(',',$_GET['lid']);
		if($lids){
			chechdelete();
			DB::query("DELETE FROM ".DB::table('common_sms_log')." WHERE `lid` IN($lids)");
			showmessage('所选短信记录已被删除',$urlstr);				
		}else{
			showmessage('您还没选中任何短信记录');				
		}
	}
}elseif($_GET['item']=='count'){
	if($_GET['searchsubmit']){
		$sql['select'] = 'SELECT l.*';
		$sql['from'] =' FROM '.DB::table('common_user_count_log').' l';
	
		$sql['select'] .= ',u.username';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=l.uid";
		if($_GET['uid']){
			$wherearr[] = "l.uid ='$_GET[uid]'";
		}
		if($_GET['fild']){
			$wherearr[] = "l.fild ='$_GET[fild]'";
		}
		
		$sql['order']='ORDER BY l.logtime DESC';	
		$select=select($sql,$wherearr,30);
	
		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				if($value['fild']=='balance'){
					$value['arose']=$value['arose']/100;
				}
				$list[$value['lid']]=$value;
			}
		}
		$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&uid='.$_GET['uid'].'&fild='.$_GET['fild'].'&searchsubmit=true';
		$pages=page($select[1],30,$_S['page'],$urlstr.'&iframe=yes');
		if(checksubmit('deletesubmit')){
			if($_GET['lid']){
				foreach($_GET['lid'] as $lid){
					$s['lid'][]="'".$lid."'";
				}
				$lids=implode(',',$s['lid']);			
			}
	
			if($lids){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('common_user_count_log')." WHERE `lid` IN($lids)");
				showmessage('所选账户变动记录已被删除',$urlstr.'&page='.$_S['page']);				
			}else{
				showmessage('您还没选中任何记录');				
			}
		}	
	}
	
}elseif($_GET['item']=='txlog'){
	
	$sql['select'] = 'SELECT l.*';
	$sql['from'] =' FROM '.DB::table('common_user_count_log').' l';
  $wherearr[] = "l.title ='提现'";
	$sql['select'] .= ',u.username';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=l.uid";

	$sql['order']='ORDER BY l.logtime DESC';	
	$select=select($sql,$wherearr,30);

	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			$value['arose']=abs($value['arose']/100);
			$value['relation']=dunserialize($value['relation']);
			$value['commission']=round($value['relation']['commission']*$value['arose']/100,2);
			$value['actual']=$value['arose']-$value['commission'];
			
			$list[$value['lid']]=$value;
		}
	}
	$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'];

	$pages=page($select[1],30,$_S['page'],$urlstr.'&iframe=yes');
	if($_POST['deletesubmit'] || $_POST['handlesubmit']){
		if($_GET['lid']){
			foreach($_GET['lid'] as $lid){
				$s['lid'][]="'".$lid."'";
			}
			$lids=implode(',',$s['lid']);			
		}
		if(!$lids){
			showmessage('您还没选中任何提现申请');			
		}
		if(checksubmit('deletesubmit')){
			chechdelete();
			DB::query("DELETE FROM ".DB::table('common_user_count_log')." WHERE `lid` IN($lids)");
			showmessage('所选提现申请已被删除',$urlstr);						
		}else{
			update('common_user_count_log',array('state'=>'1'),"lid IN($lids)");
			foreach($_GET['uids'] as $lid=>$uid){
				if(in_array($lid,$_GET['lid'])){
					sendnotice($uid,'tx','您的提现申请已被处理');
				}
			}
			showmessage('所选提现申请已被处理',$urlstr);
		}
		
	}
}

?>