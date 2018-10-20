<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='论坛';

$_GET['show']=$_GET['show']?$_GET['show']:'forum';



if($_GET['show']=='forum'){
  $filterfids=$_S['cache']['discuz']['discuz_common']['filterfids']?explode(',',$_S['cache']['discuz']['discuz_common']['filterfids']):array();
  
	
	foreach($_S['cache']['discuz_forum'] as $value){
		if($value['status']>0 && $value['status']!=3 && $value['fid'] && !in_array($value['fid'],$filterfids)){
			$value['lastpost']=$value['lastpost']?explode("\t",$value['lastpost']):array();
			if($value['type']=='group'){
				$groups[$value['fid']]=$value;
			}
			if($value['type']=='forum'){
				$forums[$value['fup']][$value['fid']]=$value;
			}
		}
	}
	
	C::chche('announcement');
}else{
  $themetemp=$_GET['show']=='pics'?'threads_5':($_S['setting']['closebbs']?'threads_6':'threads_1');
	
	$sql['select'] = 'SELECT t.*';
	$sql['from'] ='FROM '.DZ::table('forum_thread').' t';
  
	$wherearr[] = "t.displayorder >=0";
	$wherearr[] = "t.`isgroup` ='0'";
	if($_S['cache']['discuz']['discuz_common']['filterfids']){
		 $filterfids=$_S['cache']['discuz']['discuz_common']['filterfids'];
		$wherearr[] = "t.`fid` NOT IN($filterfids)";
	}
	if($_GET['show']=='pics'){
		$wherearr[] = "t.attachment ='2'";
	}
	
	if($_GET['show']=='best'){
		$wherearr[] = "t.digest IN(1,2,3)";
	}
	if($_S['cache']['discuz']['discuz_common']['webpic']){
		$sql['select'] .= ',p.`pid`,p.`message`';
		$sql['left'] .=" LEFT JOIN ".DZ::table('forum_post')." p ON p.`tid`=t.`tid` AND p.first='1'";		
	}

	
	$sql['order']='ORDER BY t.`dateline` DESC';
	
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

	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'discuz.php?mod=index&show='.$_GET['show'].'&page='.$nextpage;
	
}




include temp('discuz/index');
?>