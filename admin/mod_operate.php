<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('公告管理','admin.php?mod='.$_GET['mod'].'&item=index'),
	/*'ad'=>array('广告系统','admin.php?mod='.$_GET['mod'].'&item=ad'),
	'link'=>array('友情链接','admin.php?mod='.$_GET['mod'].'&item=link'),*/
	'feedback'=>array('用户反馈','admin.php?mod='.$_GET['mod'].'&item=feedback'),
	'report'=>array('用户举报','admin.php?mod='.$_GET['mod'].'&item=report'),
);

if($_GET['item']=='index'){
	if(in_array($_GET['ac'],array('add','edit'))){
    if($_GET['aid']){
			$announcement=DB::fetch_first("SELECT * FROM ".DB::table('common_announcement'." WHERE aid='$_GET[aid]'"));
		}
		if(checksubmit('submit')){
			$s['subject']=$_GET['subject']?cutstr(trim($_GET['subject']),80):'';
			$s['content']=striptags($_GET['content']);
			$s['term']=$_GET['term'];
			$s['dateline']=$_S['timestamp'];
			
			if(!$s['subject'] || !$s['content']){
				showmessage('没有填写公告标题或公告内容');			
			}
			
			if($announcement){
				update('common_announcement',$s,"aid='$_GET[aid]'");
				C::chche('announcement','update');
				showmessage('公告修改成功','admin.php?mod='.$_GET['mod'].'&item=index');			
			}else{
				insert('common_announcement',$s);
				update('common_announcement',$s,"aid='$_GET[aid]'");
				C::chche('announcement','update');
				showmessage('公告发布成功','admin.php?mod='.$_GET['mod'].'&item=index');				
			}
		}
	}else{
		$query = DB::query("SELECT * FROM ".DB::table('common_announcement'));
		while($value = DB::fetch($query)) {
			if($value['term']=='1'){
				$value['dateline']=$value['dateline']+86400*7;
			}elseif($value['term']=='2'){
				$value['dateline']=$value['dateline']+86400*14;
			}elseif($value['term']=='3'){
				$value['dateline']=$value['dateline']+86400*30;
			}elseif($value['term']=='4'){
				$value['dateline']=$value['dateline']+86400*90;
			}else{
				$value['dateline']='0';
			}
			if($value['dateline'] && $value['dateline']<$_S['timestamp']){
				$value['dateline']='-1';
			}
			$announcements[$value['aid']]=$value;
		}
		if(checksubmit('dosubmit')){
			$aids=implode(',',$_GET['aid']);
			if($aids){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('common_announcement')." WHERE `aid` IN($aids)");
				C::chche('announcement','update');
				showmessage('所选公告已被删除','admin.php?mod='.$_GET['mod'].'&item=index');
			}else{
				showmessage('您还没选中任何公告');				
			}
		}
	}
}elseif($_GET['item']=='ad'){
	
}elseif($_GET['item']=='link'){
	
}elseif($_GET['item']=='feedback' || $_GET['item']=='report'){
	
	$sql['select'] = 'SELECT f.*';
	$sql['from'] =' FROM '.DB::table('common_feed').' f';
	if($_GET['item']=='feedback'){
		$wherearr[] = "f.type !='3'";
	}else{
		$wherearr[] = "f.type ='3'";
	}
	
	
	$sql['select'] .= ',u.username';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=f.uid";

	$sql['order']='ORDER BY f.dateline DESC';	
	$select=select($sql,$wherearr,30);

	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			$list[$value['fid']]=$value;
		}
	}
	$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'];

	$pages=page($select[1],30,$_S['page'],$urlstr);
	if(checksubmit('deletesubmit')){
		$fids=implode(',',$_GET['fid']);
		if($fids){
			chechdelete();
			DB::query("DELETE FROM ".DB::table('common_feed')." WHERE `fid` IN($fids)");
			showmessage('所选信息已被删除',$urlstr.'&page='.$_S['page']);				
		}else{
			showmessage('您还没选中任何信息');				
		}
	}
 
	
}
?>