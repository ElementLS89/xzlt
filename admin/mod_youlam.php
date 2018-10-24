<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('页面中心','admin.php?mod='.$_GET['mod'].'&item=index'),
  'tips'=>array('攻略页面','admin.php?mod='.$_GET['mod'].'&item=tips'),
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
				//数据库删除
				DB::query("DELETE FROM ".DB::table('common_feed')." WHERE `fid` IN($fids)");
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
	}
}elseif($_GET['item']=='tips'){
	/*查询话题分类，显示在后台——>永林——>攻略页面——>选择分类——>一级分类*/
	$query = DB::query("SELECT * FROM ".DB::table('topic_type')." ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		$types[$value['typeid']]=$value;
	}
}else{}
?>