<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$backurl='find.php';
$k=trim($_GET['k']);
if($k){
	if($_S['dz']){
		loaddiscuz();
    $themetemp='threads_1';
		$sql['select'] = 'SELECT t.*';
		$sql['from'] ='FROM '.DZ::table('forum_thread').' t';
		$wherearr[] = "t.displayorder >=0";
		
		$wherearr[] = 't.subject LIKE'."'%$k%'";

		$sql['select'] .= ',f.name';
		$sql['left'] .=" LEFT JOIN ".DZ::table('forum_forum')." f ON f.fid=t.fid";
		$sql['order']='ORDER BY t.dateline DESC';	
		if($_S['cache']['discuz']['discuz_common']['webpic']){
			$sql['select'] .= ',p.`pid`,p.`message`';
			$sql['left'] .=" LEFT JOIN ".DZ::table('forum_post')." p ON p.`tid`=t.`tid` AND p.first='1'";			
		}

		
		$select=select($sql,$wherearr,10,2);
		
		if($select[1]) {
			$query = DZ::query($select[0]);
			while($value = DZ::fetch($query)){
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
	
				$list[$value['tid']]=$value;	
			}
		}
		
		if($pictab){
			$pics=getlistpic($pictab,$tids);
		}

	}else{
		if($_GET['t']=='topic'){
			$sql['select'] = 'SELECT *';
			$sql['from'] ='FROM '.DB::table('topic');
			$wherearr[] = 'name LIKE'."'%$k%'";		
			$wherearr[] = "gid ='0'";
			$wherearr[] = "state ='1'";
			$sql['order']='ORDER BY themes DESC,users DESC,dateline DESC';	
		}else{
			$themetemp='themes_1';
			require_once './include/function_topic.php';
			
			$sql['select'] = 'SELECT v.*';
			$sql['from'] ='FROM '.DB::table('topic_themes').' v';
			$wherearr[] = "v.tid !='0'";
			$wherearr[] = "v.`top` >='0'";
			
			$wherearr[] = 'v.subject LIKE'."'%$k%'";
			$sql['select'] .= ',u.username,u.groupid,u.dzuid';
			$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.uid=v.uid";
			$sql['select'] .= ',t.name as topic';
			$sql['left'] .=" LEFT JOIN ".DB::table('topic')." t ON t.tid=v.tid";
			$sql['order']='ORDER BY v.top DESC,v.dateline DESC';	
		}
		
		$select=select($sql,$wherearr,10);
	
		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				if($_GET['t']=='topic'){
					$value['cover']=$value['cover']?$_S['atc'].'/'.$value['cover']:'ui/nocover.jpg';
					$list[$value['tid']]=$value;			
				}else{
					$value['imgs']=dunserialize($value['imgs']);
					$value['pics']=count($value['imgs']);
					$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
					if($value['topic']){
						$value['topic_url']='topic.php?tid='.$value['tid'];
					}
					$list[$value['vid']]=$value;
				}
			}
	
		}		
	}

	
	
	$maxpage = @ceil($select[1]/10);
	
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'search.php?mod='.$_GET['mod'].($_GET['t']?'&t='.$_GET['t']:'').'&k='.$k.'&page='.$nextpage;
	
}


?>