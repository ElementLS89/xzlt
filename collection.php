<?php
define('PHPSCRIPT', 'collection');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';

$S = new S();
$S -> star();
$_GET['mod']=$_GET['mod']?$_GET['mod']:($_S['dz'] && $_S['member']['dzuid']?'discuz':'topic');

$_S['setting']['mods']=dunserialize($_S['setting']['mods']);
$themetable=$_S['setting']['mods'][$_GET['mod']]['table'];
$vid=$_S['setting']['mods'][$_GET['mod']]['vid']?$_S['setting']['mods'][$_GET['mod']]['vid']:'vid';
$modurl=$_S['setting']['mods'][$_GET['mod']]['viewurl'].$_GET['vid'];


if(!$_S['uid']){
	showmessage('您需要登录后才能继续操作','member.php');
}
$_S['outback']=true;
if($_GET['vid']){

	$theme=DB::fetch_first("SELECT v.*,c.cid FROM ".DB::table($themetable)." v LEFT JOIN ".DB::table('common_collection')." c ON c.vid=v.$vid AND c.`mod`='$_GET[mod]' AND c.uid='$_S[uid]' WHERE v.`$vid`='$_GET[vid]'");
	
	
	if(!$theme){
		showmessage('要收藏的主题不存在');
	}
	if($theme['cid']){
		DB::query("DELETE FROM ".DB::table('common_collection')." WHERE cid='$theme[cid]'");
	}else{
		insert('common_collection',array('mod'=>$_GET['mod'],'vid'=>$_GET['vid'],'uid'=>$_S['uid'],'dateline'=>$_S['timestamp']));
	}
	showmessage('操作成功','',array('type'=>'toast','fun'=>'smsot.collection(\''.$_GET['vid'].'\',\''.$theme['cid'].'\',\''.$modurl.'\');'));
}elseif($_GET['ac']=='delete'){
	$collection=DB::fetch_first("SELECT * FROM ".DB::table('common_collection')." WHERE `cid`='$_GET[cid]'");
	if(!$collection){
		showmessage('要删除的收藏不存在');
	}
	if($collection['uid']!=$_S['uid']){
		showmessage('没有权限进行本操作');
	}
	DB::query("DELETE FROM ".DB::table('common_collection')." WHERE cid='$_GET[cid]'");
	showmessage('操作成功','',array('type'=>'toast','fun'=>'$(\'.currentbody #theme_'.$collection[$vid].'\').remove();SMS.deleteitem(\'collection.php\')'));
}else{
	$navtitle='我的收藏';
	$title=$navtitle.'-'.$_S['setting']['sitename'];
	$backurl='my.php';

	if($_GET['mod']=='discuz'){
		loaddiscuz();
		
		$sql['select'] = 'SELECT f.*';
		$sql['from'] =' FROM '.DZ::table('home_favorite').' f';
		$wherearr[] = "f.`uid` ='$_S[myid]'";
		$wherearr[] = "f.`idtype` ='tid'";
		
		$sql['select'] .= ',t.authorid,t.author,t.views,t.replies,t.attachment';
		$sql['left'] .=" LEFT JOIN ".DZ::table('forum_thread')." t ON t.tid=f.id";
    if($_S['cache']['discuz']['discuz_common']['webpic']){
			$sql['select'] .= ',p.`pid`,p.`message`';
			$sql['left'] .=" LEFT JOIN ".DZ::table('forum_post')." p ON p.`tid`=t.`tid` AND p.first='1'";
			$sql['order']='ORDER BY f.dateline DESC';
		}
    
		$select=select($sql,$wherearr,10,2);
	 
		if($select[1]) {
			$query = DZ::query($select[0]);
			while($value = DZ::fetch($query)){
				$value['tid']=$value['id'];
				if($value['attachment']=='2'){
					$pictab[]='forum_attachment_'.substr($value['tid'], -1);
					$tids[]=$value['tid'];
				}else{
					if(strpos($value['message'], '[/img]') !== FALSE && $_S['cache']['discuz']['discuz_common']['webpic']) {
						preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $value['message'], $matches);
						if(isset($matches[1])){
							$value['imgs']=$matches[1];
						}
					}				
				}
				$value['subject']=$value['title'];
				
				$list[$value['id']]=$value;					
		
			}
		}
		if($pictab){
			$pics=getlistpic($pictab,$tids);
		}
		
	}else{
		$sql['select'] = 'SELECT c.cid';
		$sql['from'] =' FROM '.DB::table('common_collection').' c';
		$wherearr[] = "c.`uid` ='$_S[uid]'";
		$wherearr[] = "c.`mod` ='$_GET[mod]'";
		if($_GET['mod']=='topic'){
			require_once './include/function_topic.php';
			$sql['select'] .= ',v.*';
			$sql['left'] .=" LEFT JOIN ".DB::table($themetable)." v ON v.vid=c.vid";
			
			$sql['select'] .= ',t.name as topic';
			$sql['left'] .=" LEFT JOIN ".DB::table('topic')." t ON t.tid=v.tid";
			
			$sql['select'] .= ',u.username,u.groupid,u.dzuid';
			$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=v.uid";		
		}else{
			require_once './hack/'.$_GET['mod'].'/collection.php';
		}
	
		
		$sql['order']='ORDER BY c.dateline DESC';

		$select=select($sql,$wherearr,10);
		
		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				if($_GET['mod']=='topic'){
					$value['imgs']=dunserialize($value['imgs']);
					$value['pics']=count($value['imgs']);
					$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
					$value['topic_url']='topic.php?tid='.$value['tid'];		
				}
				$list[$value[$vid]]=$value;	
			}
		}		
	}

	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'collection.php?mod='.$_GET['mod'].'&page='.$nextpage;
	
	include temp('collection');
}
?>