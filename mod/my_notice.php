<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if($_GET['upnotice']){
	DB::query("UPDATE ".DB::table('common_notice')." SET `nums`='0' WHERE uid ='$_S[uid]'");
}else{
	if($_GET['nid']){
		$notice=DB::fetch_first("SELECT * FROM ".DB::table('common_notice')." WHERE `nid`='$_GET[nid]'");
	
		if(!$notice){
			showmessage('消息不存在');
		}
		if($notice['uid']!=$_S['uid'] && $_S['usergroup']['power']<9){
			showmessage('你没有权限进行此操作');
		}
		DB::query("DELETE FROM ".DB::table('common_notice')." WHERE nid='$_GET[nid]'");
		showmessage('删除成功','',array('type'=>'toast','fun'=>'smsot.deletenotice('.$_GET['nid'].');'));		
	}else{
		$navtitle='系统消息';
		$title=$navtitle.'-'.$_S['setting']['sitename'];
		$sql['select'] = 'SELECT *';
		$sql['from'] ='FROM '.DB::table('common_notice');
		$wherearr[] = "uid ='$_S[uid]'";
		$sql['order']='ORDER BY new DESC,dateline DESC';	
		$select=select($sql,$wherearr,10);
		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)) {
				if($value['new']){
					$news[]=$value['nid'];
					$nums[]=$value['nums'];
				}
				if($value['nums']){
					$nids[]=$value['nid'];
				}
				if(in_array($value['type'],array('notice','gratuity','reply','praise','topic'))){
          $value['icon']='<span class="icon icon-notice-'.$value['type'].'"></span>';
				}else{
					$value['icon']='<img src="hack/'.$value['type'].'/style/notice.png">';
				}
				$list[$value['nid']]=$value;
			}
		}
		if($nids){
			$nids=implode(',',$nids);
		}
		
		if($news){
			$newstrs=implode(',',$news);
			DB::query("UPDATE ".DB::table('common_notice')." SET `new`='0' WHERE nid IN($newstrs)");
		}
		if($_S['member']['newnotice']){
			DB::query("UPDATE ".DB::table('common_user')." SET `newnotice`='0' WHERE uid='$_S[uid]'");
		}	
		$maxpage = @ceil($select[1]/10);
		$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
		$nexturl = 'my.php?mod=notice&page='.$nextpage;
		
		include temp(PHPSCRIPT.'/'.$_GET['mod']);	
	}	
}


?>