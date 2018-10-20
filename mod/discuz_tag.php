<?php

if($_GET['tagid'] || $_GET['tag']){
	
	if($_GET['tagid']){
		$tag=DZ::fetch_first("SELECT * FROM ".DZ::table('common_tag')." WHERE `tagid`='$_GET[tagid]'");
	}else{
		$tag=DZ::fetch_first("SELECT * FROM ".DZ::table('common_tag')." WHERE `tagname`='$_GET[tag]'");
	}
  
	if(!$tag){
		showmessage('标签不存在');
	}
  $navtitle=$title=$tag['tagname'];
	$themetemp='threads_1';
	$sql['select'] = 'SELECT t.*';
	$sql['from'] ='FROM '.DZ::table('common_tagitem').' a';
	$wherearr[] = "a.idtype = 'tid'";
	$wherearr[] = "a.tagid ='$tag[tagid]'";
	
	$sql['from'] .=','.DZ::table('forum_thread').' t ';
	$wherearr[] = "t.tid=a.itemid GROUP BY t.tid";
	$sql['order']='ORDER BY t.`dateline` DESC';
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

	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'discuz.php?mod=tag&tagid='.$tag['tagid'].'&page='.$nextpage;
		
	include temp('discuz/viewtag');	
}else{
	$navtitle=$title='标签';
	
	$sql['select'] = 'SELECT *';
	$sql['from'] ='FROM '.DZ::table('common_tag');
	$wherearr[] = "status >= '0'";
	
	$select=select($sql,$wherearr,100,2);
	
	if($select[1]) {
		$query = DZ::query($select[0]);
		while($value = DZ::fetch($query)){
			$list[]=$value;	
		}
	}

  include temp('discuz/tag');	
}

?>