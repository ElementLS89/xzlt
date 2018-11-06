<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='youlam管理后台';

$menus=array(
	'index'=>array('页面介绍','admin.php?mod='.$_GET['mod'].'&item=index'),
	'topic'=>array('话题','admin.php?mod='.$_GET['mod'].'&item=topic'),
);

if($_GET['item']=='index'){
/*	if(in_array($_GET['ac'],array('add','edit'))){
    if($_GET['aid']){
			$announcement=DB::fetch_first("SELECT * FROM ".DB::table('common_announcement'." WHERE aid='$_GET[aid]'"));
		}
		if(checksubmit('submit')){
			$s['subject']=$_GET['subject']?cutstr(trim($_GET['subject']),80):'';
			$s['content']=striptags($_GET['content']);
			$s['term']=$_GET['term'];
			$s['dateline']=$_S['timestamp'];
						
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
			}else{
				$value['dateline']='0';
			}
			if($value['dateline'] && $value['dateline']<$_S['timestamp']){
				$value['dateline']='-1';
			}
			$announcements[$value['aid']]=$value;
		}
	}*/
}elseif($_GET['item']=='topic'){
	/*查询话题分类，显示在后台——>永林——>攻略页面——>选择分类——>一级分类*/
	$query = DB::query("SELECT * FROM ".DB::table('topic_type')." ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		$firstTypes[$value['typeid']]=$value;
	}
	/*查询系统中可以设定的“分栏项目”*/
	$query = DB::query("SELECT * FROM ".DB::table('topic_column'));
	while($value = DB::fetch($query)) {
		$columnList[$value['columnid']]=$value;
	}
/***********************************************************************************************************************/
	if(in_array($_GET['ac'],array('addTips','editTips'))){
		if($_GET['ac']=='editTips'){
			$slider=DB::fetch_first("SELECT * FROM ".DB::table('topic_tips')." WHERE vid='$_GET[vid]'");
		}
		if(checksubmit('submit')){
			require_once './include/upimg.php';
			if($_GET['ac']=='addTips'){
				$s['tid']=$_GET['selectSecondClass'];
			}
	//		echo "<script>alert('$s[tid]');</script>";
			$s['subject']=stringvar($_GET['name'],255);
			$s['link']=stringvar($_GET['url'],255);
			if($_FILES['pic']['name']){
				$pic = upload_img($_FILES['pic'],'topic',$_S['setting']['forum_slider_width'],$_S['setting']['forum_slider_height']);
				$s['pic']=$pic['attachment'].($pic['thumb']?'_'.$_S['setting']['forum_slider_width'].'_'.$_S['setting']['forum_slider_height'].'.jpg':'');
			}else{
				$s['pic']=$slider['pic'];
			}
			if($slider){
				update('topic_tips',$s,"vid='$_GET[vid]'");
			}else{
				insert('topic_tips',$s);
			}
			C::chche('slider','update');
		//	showmessage('幻灯设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
		}
	}
/********************************************************************************************************************/	
	if(in_array($_GET['ac'],array('addTopicTypes','editTopicTypes'))){
		if(checksubmit('submit')){
			foreach($_GET['typename'] as $k => $name){
				if(trim($name)!=''){
					$types[$_GET['typeid'][$k]]=$name;
				}else{
		//			$_GET['typeid'][$k+=1]--;
		//			$types[$_GET['typeid'][$k]]=$name;
				}
			}
			$s['types']=serialize($types);
		//	showmessage($s['types']);
			update('topic',$s,"tid='$_GET[selectSecondClass]'");
		}
	}
/**********************************************************************************************************************/
	
}elseif($_GET['item']=='topic_ajax'){
	if($_GET['selectSecondClass']){
		/*查询tips*/
		$query = DB::query("SELECT * FROM ".DB::table('topic_tips')." WHERE tid=".$_GET['selectSecondClass']);
		while($value = DB::fetch($query)) {
			$tipsList[$value['vid']]=$value;
		}
		/*查询话题内已存在的分栏*/
		$typesList = DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE tid=".$_GET['selectSecondClass']);
		$typesList['types']=dunserialize($typesList['types']);
	}else{
		if(checksubmit('dosubmit')){
			$vids=implode(',',$_GET['vid']);
			if($vids){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('topic_tips')." WHERE `vid` IN($vids)");
			}		
		}
	}	
}else{
/*	$query = DB::query("SELECT * FROM ".DB::table('topic_tips'));
	while($value = DB::fetch($query)) {
		$sliders[$value['sid']]=$value;
	}*/
	
}
?>