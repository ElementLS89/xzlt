<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('基础设置','admin.php?mod='.$_GET['mod'].'&item=index'),
	'type'=>array('话题分类','admin.php?mod='.$_GET['mod'].'&item=type'),
	'manage'=>array('话题管理','admin.php?mod='.$_GET['mod'].'&item=manage'),
	'theme'=>array('帖子管理','admin.php?mod='.$_GET['mod'].'&item=theme'),
	'post'=>array('审核回帖','admin.php?mod='.$_GET['mod'].'&item=post'),
	
);

$_S['setting']['topicgroup']=dunserialize($_S['setting']['topicgroup']);
C::chche('topic_types');

if($_GET['item']=='type'){
	if(in_array($_GET['ac'],array('add','edit'))){
    if($_GET['typeid']){
			$type=DB::fetch_first("SELECT * FROM ".DB::table('topic_type'." WHERE `typeid`='$_GET[typeid]'"));
		}
		if(checksubmit('submit')){
			$s['name']=stringvar($_GET['name'],40);
			
			if(!$s['name']){
				showmessage('分类名称没有填写');			
			}
			if($type){
				update('topic_type',$s,"typeid='$_GET[typeid]'");
				C::chche('topic_types','update');
				showmessage('分类修改成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);			
			}else{
				insert('topic_type',$s);
				C::chche('topic_types','update');
				showmessage('分类添加成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);				
			}
		}
	}else{
		$query = DB::query("SELECT * FROM ".DB::table('topic_type')." ORDER BY list ASC");
		while($value = DB::fetch($query)) {
			$types[$value['typeid']]=$value;
		}
		if(checksubmit('dosubmit')){
			$typeids=implode(',',$_GET['typeid']);
			if($typeids){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('topic_type')." WHERE `typeid` IN($typeids)");
			}
			foreach($_GET['typeids'] as $key => $typeid){
				$list=abs(intval($_GET['list'][$key]));
				update('topic_type',array('list'=>$list),"typeid='$typeid'");
			}
			C::chche('topic_types','update');
			showmessage('分类设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
		}
	}
}elseif($_GET['item']=='manage'){
	if(in_array($_GET['ac'],array('add','edit'))){
    $_S['setting']['themestyle']=dunserialize($_S['setting']['themestyle']);
		require_once './include/upimg.php';
		if($_GET['tid']){
			$topic=DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE tid='$_GET[tid]'");
			$topic['usergroup']=dunserialize($topic['usergroup']);
			foreach($_S['setting']['topicgroup'] as $id=>$group){
				$group['name']=$topic['usergroup'][$id]?$topic['usergroup'][$id]:$group['name'];
				$topicgroup[$id]=$group;
			}
		}else{
			$topicgroup=$_S['setting']['topicgroup'];
		}
		if(checksubmit('submit')){
			$s['name']=stringvar($_GET['name'],255);
			$s['about']=stringvar($_GET['about'],255);
			$s['typeid']=$_GET['typeid'];
			$s['open']=$_GET['open'];
			$s['show']=$_GET['show'];
			$s['addtheme']=$_GET['addtheme'];
			$s['reply']=$_GET['reply'];
			$s['allowapply']=$_GET['allowapply'];
			$s['maxleaders']=$_GET['maxleaders'];
			$s['maxmanagers']=$_GET['maxmanagers'];
			$s['liststype']=$_GET['liststype'];
			
			if($_FILES['cover']['name']){
				$cover = upload_img($_FILES['cover'],'common','140','140');
				$s['cover']=$cover['attachment'].($cover['thumb']?'_140_140.jpg':'');
			}else{
				$s['cover']=$topic['cover'];
			}
			if($_FILES['banner']['name']){
				$banner = upload_img($_FILES['banner'],'topic','640','320');
				$s['banner']=$banner['attachment'].($banner['thumb']?'_640_320.jpg':'');
			}else{
				$s['banner']=$topic['banner'];
			}
			if($topic){
				update('topic',$s,"tid='$_GET[tid]'");
			}else{
				$s['state']='1';
				insert('topic',$s);
			}
			$ref=$_GET['ref']?$_GET['ref']:'admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'];
			showmessage('话题设置成功',$ref);		
		}
	}else{
		if($_GET['searchsubmit']){
			$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'];
			foreach($_GET as $key => $value){
				if(!in_array($key,array('mod','item'))){
					$urlstr.='&'.$key.'='.$value;
				}
			}
			
			$sql['select'] = 'SELECT *';
			$sql['from'] ='FROM '.DB::table('topic');
			if($_GET['typeid']){
				$wherearr[] = "typeid ='$_GET[typeid]'";
			}
			if($_GET['name']){
				$name=trim($_GET['name']);
				$wherearr[] = 'name LIKE'."'%$name%'";
			}
			$wherearr[] = "state ='$_GET[state]'";
			$wherearr[] = "gid ='0'";
			
			$sql['order']='ORDER BY dateline DESC';	
			
			
			$select=select($sql,$wherearr,30);
			
			
			if($select[1]) {
				$query = DB::query($select[0]);
				while($value = DB::fetch($query)){
					if(!$value['cover']){
						$value['cover']='ui/nocover.jpg';
					}else{
						$value['cover']=$_S['atc'].'/'.$value['cover'];
					}
					
					$list[$value['tid']]=$value;
				}
			}
      $ref=urlencode($urlstr);
			$pages=page($select[1],30,$_S['page'],$urlstr);
			if($_POST['deletesubmit'] || $_POST['examinesubmit']){
				$tids=implode(',',$_GET['tid']);
				if($_POST['deletesubmit']){
					chechdelete();
					DB::query("DELETE FROM ".DB::table('topic')." WHERE `tid` IN($tids)");
					DB::query("DELETE FROM ".DB::table('topic_apply')." WHERE `tid` IN($tids)");
					DB::query("DELETE FROM ".DB::table('topic_users')." WHERE `tid` IN($tids)");
				}elseif($_POST['examinesubmit']){
					update('topic',array('state'=>'1'),"tid IN($tids)");
				}
				showmessage('话题管理成功',$urlstr);		
			}
		}		
	}
}elseif($_GET['item']=='post'){
  $urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].($_GET['t']?'&t='.$_GET['t']:'');
	$table=$_GET['t']?'common_replys_'.$_GET['t']:'common_replys_0';
	
	$sql['select'] = 'SELECT p.*';
	$sql['from'] ='FROM '.DB::table($table).' p';
	
	$wherearr[] = "p.`mod` ='topic'";
	$wherearr[] = "p.`top` <0";
	

	$sql['select'] .= ',u.`username`,u.`groupid`';
	$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.`uid`=p.`uid`";

	$sql['select'] .= ',t.`subject`';
	$sql['left'] .=" LEFT JOIN ".DB::table('topic_themes')." t ON t.`vid`=p.`vid`";

	$sql['order']='ORDER BY p.dateline DESC';	
	
	
	$select=select($sql,$wherearr,30);

	
	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)){
			$list[$value['pid']]=$value;
		}
	}

	$pages=page($select[1],30,$_S['page'],$urlstr);
	if($_POST['deletesubmit']){
		$pids=implode(',',$_GET['pid']);
		if($pids){
			chechdelete();
			DB::query("DELETE FROM ".DB::table($table)." WHERE `pid` IN($pids)");
			showmessage('所选回帖已被删除',$urlstr);						
		}
	}
	if($_POST['examinesubmit']){
		$pids=implode(',',$_GET['pid']);
		if($pids){
			DB::query("UPDATE ".DB::table($table)." SET `top`='0' WHERE `pid` IN($pids)");
			showmessage('所选回帖已被审核',$urlstr);					
		}
	}
}elseif($_GET['item']=='theme'){
	if($_GET['searchsubmit']){
		C::chche('topic_groups');
		$tids=implode(',',$_S['cache']['forumids']);
		
		$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'];
		foreach($_GET as $key => $value){
			if(!in_array($key,array('mod','item'))){
				$urlstr.='&'.$key.'='.$value;
			}
		}
		
		$sql['select'] = 'SELECT v.*';
		$sql['from'] ='FROM '.DB::table('topic_themes').' v';
		
		if($_GET['state']==1){
			$wherearr[] = "v.`top` <0";
		}else{
			$wherearr[] = "v.`top` >=0";
		}
    if($_GET['form']==1 && $tids){
			$wherearr[] = "v.`tid` IN($tids)";
		}elseif($_GET['form']==2){
			if($tids){
				$wherearr[] = "v.`tid` NOT IN($tids)";
			}else{
				$wherearr[] = "v.tid !='0'";
			}
		}elseif($_GET['form']==3){
			$wherearr[] = "v.tid ='0'";
		}
		if($_GET['subject']){
			$subject=trim($_GET['subject']);
			$wherearr[] = 'v.subject LIKE'."'%$subject%'";
		}
		if($_GET['user']){
			$user=implode(',',explode(' ',trim($_GET['user'])));
			$wherearr[] = "v.uid IN($user)";
		}		
		if($_GET['topic']){
			$topic=implode(',',explode(' ',trim($_GET['topic'])));
			$wherearr[] = "v.tid IN($topic)";
		}

		$sql['select'] .= ',u.`username`,u.`groupid`';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.`uid`=v.`uid`";
	
		$sql['select'] .= ',t.`name`';
		$sql['left'] .=" LEFT JOIN ".DB::table('topic')." t ON t.`tid`=v.`tid`";
	
		$sql['order']='ORDER BY v.dateline DESC';	
		
		
		$select=select($sql,$wherearr,30);

		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				$list[$value['vid']]=$value;
			}
		}
		$pages=page($select[1],30,$_S['page'],$urlstr);
		
		if($_POST['deletesubmit']){
			$vids=implode(',',$_GET['vid']);
			if($vids){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('topic_themes')." WHERE `vid` IN($vids)");
				DB::query("DELETE FROM ".DB::table('topic_theme_content')." WHERE `vid` IN($vids)");
				DB::query("DELETE FROM ".DB::table('common_record')." WHERE `vid` IN($vids) AND `mod`='topic'");
				DB::query("DELETE FROM ".DB::table('common_collection')." WHERE `vid` IN($vids) AND `mod`='topic'");
				showmessage('所选帖子已被删除',$urlstr);						
			}
		}
		if($_POST['movesubmit'] && $_GET['moveto']){
			$vids=implode(',',$_GET['vid']);
			if($vids){
				$topic=DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE tid='$_GET[moveto]'");
				if(!$topic){
					showmessage('所选板块或小组不存在');		
				}else{
					DB::query("UPDATE ".DB::table('topic_themes')." SET `tid`='$_GET[moveto]' WHERE `vid` IN($vids)");
					showmessage('所选帖子已被转移',$urlstr);							
				}
			
			}else{
				showmessage('没有选择任何帖子');		
			}
		}
		if($_POST['examinesubmit']){
			$vids=implode(',',$_GET['vid']);
			if($vids){
				DB::query("UPDATE ".DB::table('topic_themes')." SET `top`='0' WHERE `vid` IN($vids)");
				showmessage('所选帖子已被审核',$urlstr);					
			}
		}
	}
}else{
	if(checksubmit('submit')){
		$s['topiccreat']=$_GET['topiccreat'];
		$s['replyshow']=$_GET['replyshow'];
		foreach($_GET['name'] as $id=>$name){
			$names[$id]=$name?stringvar($name,16):$_S['setting']['topicgroup'][$id]['name'];
			$experience[$id]=abs(intval($_GET['experience'][$id]));
			$topicgroup[$id]=array('name'=>$names[$id],'experience'=>$experience[$id]);
		}
		update('common_setting',array('v'=>serialize($topicgroup)),"k='topicgroup'");
		update('common_setting',array('v'=>$_GET['topiccreat']),"k='topiccreat'");
		update('common_setting',array('v'=>$_GET['replyshow']),"k='replyshow'");

		upsetting();
		showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	
	}
}
?>