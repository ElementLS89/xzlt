<?php
if(!defined('IN_SMSOT')) {
	exit;
}

$dzuser=DZ::fetch_first("SELECT * FROM ".DZ::table('common_member')." WHERE `uid`='$_GET[dzuid]'");
if(!$dzuser){
	showmessage('你要查看的用户不存在');
}
$themetemp='threads_2';

$sql['select'] = 'SELECT t.*';
$sql['from'] ='FROM '.DZ::table('forum_thread').' t';

$wherearr[] = "t.displayorder >=0";
$wherearr[] = "t.`isgroup` ='0'";

$wherearr[] = "t.authorid ='$_GET[dzuid]'";
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
$nexturl = 'user.php?dzuid='.$_GET['dzuid'].'&page='.$nextpage;

include temp('discuz/user');

?>