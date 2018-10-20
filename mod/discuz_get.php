<?php
if($_GET['tid'] || $_GET['pid']){
	if($_GET['tid']){
		$thread=DZ::fetch_first("SELECT t.*,p.pid,p.message,p.htmlon,p.bbcodeoff,p.smileyoff FROM ".DZ::table('forum_thread')." t LEFT JOIN ".DZ::table('forum_post')." p ON p.tid=t.tid AND p.first=1  WHERE t.`tid`='$_GET[tid]'");
		if(!$thread){
			exit;
		}
		$tid=$_GET['tid'];
		$pid=$thread['pid'];
	}else{
		$post=DZ::fetch_first("SELECT * FROM ".DZ::table('forum_post')." WHERE `pid`='$_GET[pid]'");
		if(!$post){
			exit;
		}
		$post['message']=dzbbcode($post['message'],$post['authorid'],$post['htmlon'],$post['bbcodeoff'],$post['smileyoff']);
		
		$tid=$post['tid'];
		$pid=$post['pid'];
	}
	$atctab='forum_attachment_'.substr($tid, -1);
	$query = DZ::query('SELECT * FROM '.DZ::table($atctab)." WHERE pid = '$pid' ORDER BY `dateline` DESC");
	while($value = DZ::fetch($query)){
		if($value['isimage']){
			$atcs['img'][$value['aid']]=$value['pid'];
			if($value['remote']=='2'){
				$value['atc']=$_S['atc'].'/'.$value['attachment'].($value['thumb']?'.thumb.jpg':'');
			}else{
				$value['atc']=$_S['dz']['atc'].'forum/'.$value['attachment'].($value['thumb']?'.thumb.jpg':'');
			}
			$atcs[$value['pid']]['img'][$value['aid']]=$value;
		}else{
			$atcs['atc'][$value['aid']]=$value['pid'];
			$value['atc']=$_S['dz']['atc'].'forum/'.$value['attachment'];
			$value['filesize']=sizecount($value['filesize']);
			$atcs[$value['pid']]['atc'][$value['aid']]=$value;
		}
	}
	
	if($_GET['show']=='c'){
		if($_GET['tid']){
			if(preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $thread['message'], $matchaids)) {
				$attachtags[$pid] = $matchaids[1];
			}	
			$thread['message']=dzbbcode($thread['message'],$thread['authorid'],$thread['htmlon'],$thread['bbcodeoff'],$thread['smileyoff']);
		}else{
			if(preg_match_all("/\[attach\](\d+)\[\/attach\]/i", $post['message'], $matchaids)) {
				$attachtags[$pid] = $matchaids[1];
			}
			$post['message']=dzbbcode($post['message'],$post['authorid'],$post['htmlon'],$post['bbcodeoff'],$post['smileyoff']);
		}	
	}
}else{
	$comment=DZ::fetch_first("SELECT * FROM ".DZ::table('portal_comment')." WHERE `cid`='$_GET[cid]'");
	
	if($comment){
		$comment['message'] = str_replace(array("static/image/","class=\"vm\">&nbsp;&nbsp;"),array($_S['dz']['url'].'static/image/',"class=\"vm\">&nbsp;"),$comment['message']);
	}
}
include temp('discuz/get');
?>