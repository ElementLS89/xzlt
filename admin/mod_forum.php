<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('板块管理','admin.php?mod='.$_GET['mod'].'&item=index'),
	'slider'=>array('论坛幻灯片','admin.php?mod='.$_GET['mod'].'&item=slider'),
	
);

if($_GET['item']=='index'){
	C::chche('topic_groups');
	C::chche('topic_types');
	if(in_array($_GET['ac'],array('add','edit'))){

		if(($_GET['ac']=='add' && !$_GET['gid']) || ($_GET['ac']=='edit' && $_GET['gid'])){
			if($_GET['gid']){
				$group=DB::fetch_first("SELECT * FROM ".DB::table('topic_group')." WHERE gid='$_GET[gid]'");
				if(!$group){
					showmessage('分区不存在');
				}
			}
			if(checksubmit('submit')){
				$s['name']=stringvar($_GET['name'],255);
				$s['about']=stringvar($_GET['about'],255);
				$s['manager']=trim($_GET['manager']);
				$s['hidden']=$_GET['hidden'];
        if(!$s['name']){
					showmessage('分区名称没有填写');			
				}
				if($group){
					update('topic_group',$s,"gid='$_GET[gid]'");
				}else{
					insert('topic_group',$s);
				}
				C::chche('topic_groups','update');
				showmessage('分区设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
			}
			
		}else{
			require_once './include/upimg.php';
			if($_GET['tid']){
				$forum=DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE tid='$_GET[tid]'");
				if(!$forum){
					showmessage('板块不存在');
				}
			}
			if(checksubmit('submit')){
				$s['name']=stringvar($_GET['name'],255);
				$s['about']=stringvar($_GET['about'],255);
				if($_GET['settopic']){
					$s['typeid']=$_GET['typeid'];
					$s['gid']=0;
				}else{
					$s['gid']=$_GET['groupid'];
					$s['typeid']=0;
				}
				if($_FILES['cover']['name']){
					$cover = upload_img($_FILES['cover'],'common','140','140');
					$s['cover']=$cover['attachment'].($cover['thumb']?'_140_140.jpg':'');
				}else{
					$s['cover']=$forum['cover'];
				}
				if($_FILES['banner']['name']){
					$banner = upload_img($_FILES['banner'],'topic','640','320');
					$s['banner']=$banner['attachment'].($banner['thumb']?'_640_320.jpg':'');
				}else{
					$s['banner']=$forum['banner'];
				}
				
				if($forum){
					update('topic',$s,"tid='$_GET[tid]'");
				}else{
					insert('topic',$s);
				}
				C::chche('topic_groups','update');
				showmessage('板块设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
			}
		}
	}else{
		$query = DB::query("SELECT * FROM ".DB::table('topic_group')." ORDER BY list ASC");
		while($value = DB::fetch($query)) {
			$groups[$value['gid']]=$value;
			$gids[]=$value['gid'];
		}		
    if($_GET['show']=='other'){
			if($gids){
				$gidstrs=implode(',',$gids);
				$query = DB::query("SELECT * FROM ".DB::table('topic')." WHERE `gid` NOT IN($gidstrs) AND `gid`!='0' ORDER BY list ASC");
				while($value = DB::fetch($query)) {
					$others[$value['tid']]=$value;
				}
			}
			if($_POST['dosubmit']){
				$tids=implode(',',$_GET['tid']);
				if($tids){
					chechdelete();
					DB::query("DELETE FROM ".DB::table('topic')." WHERE `tid` IN($tids)");
					DB::query("DELETE FROM ".DB::table('topic_apply')." WHERE `tid` IN($tids)");
					DB::query("DELETE FROM ".DB::table('topic_users')." WHERE `tid` IN($tids)");
					showmessage('板块删除成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&show=other');			
				}else{
					showmessage('请选择您要删除的板块');
				}
			}
		}else{

			if($gids){
				$gidstrs=implode(',',$gids);
				$query = DB::query("SELECT * FROM ".DB::table('topic')." WHERE `gid` IN($gidstrs) ORDER BY list ASC");
				while($value = DB::fetch($query)) {
					$forums[$value['gid']][$value['tid']]=$value;
				}
			}
			if(checksubmit('dosubmit')){
				$gid=implode(',',$_GET['gid']);
				if($gid){
					chechdelete();
					DB::query("DELETE FROM ".DB::table('topic_group')." WHERE `gid` IN($gid)");
				}
				foreach($_GET['gids'] as $key => $gid){
					$list=abs(intval($_GET['grouplist'][$key]));
					update('topic_group',array('list'=>$list),"gid='$gid'");
				}		
				foreach($_GET['tids'] as $key => $tid){
					$list=abs(intval($_GET['forumlist'][$key]));
					update('topic',array('list'=>$list),"tid='$tid'");
				}	
				C::chche('topic_groups','update');
				showmessage('板块设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);
			}			
		}
	}
}else{
	if(in_array($_GET['ac'],array('add','edit'))){
		if($_GET['sid']){
			$slider=DB::fetch_first("SELECT * FROM ".DB::table('common_slider')." WHERE sid='$_GET[sid]'");
		}
		if(checksubmit('submit')){
			require_once './include/upimg.php';
			$s['name']=stringvar($_GET['name'],255);
			$s['url']=stringvar($_GET['url'],255);
			$s['type']=$_GET['type'];
			if($_FILES['pic']['name']){
				$pic = upload_img($_FILES['pic'],'common',$_S['setting']['forum_slider_width'],$_S['setting']['forum_slider_height']);
				$s['pic']=$pic['attachment'].($pic['thumb']?'_'.$_S['setting']['forum_slider_width'].'_'.$_S['setting']['forum_slider_height'].'.jpg':'');
			}else{
				$s['pic']=$slider['pic'];
			}
			if($slider){
				update('common_slider',$s,"sid='$_GET[sid]'");
			}else{
				insert('common_slider',$s);
			}
			C::chche('slider','update');
			showmessage('幻灯设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
		}
	}elseif($_GET['ac']=='size'){
		if(checksubmit('submit')){
			$s['forum_slider_width']=abs(intval($_GET['width']));
			$s['forum_slider_height']=abs(intval($_GET['height']));
			if(!$s['forum_slider_width'] || !$s['forum_slider_height']){
				showmessage('请设置正确的宽度和高度');
			}
			update('common_setting',array('v'=>$s['forum_slider_width']),"k='forum_slider_width'");
			update('common_setting',array('v'=>$s['forum_slider_height']),"k='forum_slider_height'");
			upsetting();
			showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&ac='.$_GET['ac']);	
		}
	}else{
		$query = DB::query("SELECT * FROM ".DB::table('common_slider')." WHERE type='forum' ORDER BY list ASC");
		while($value = DB::fetch($query)) {
			$sliders[$value['sid']]=$value;
		}
		if(checksubmit('dosubmit')){
			$sids=implode(',',$_GET['sid']);
			if($sids){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('common_slider')." WHERE `sid` IN($sids)");
			}
			foreach($_GET['sids'] as $key => $sid){
				$list=abs(intval($_GET['list'][$key]));
				update('common_slider',array('list'=>$list),"sid='$sid'");
			}
			C::chche('slider','update');
			showmessage('幻灯设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
		}
		
	}
}

?>