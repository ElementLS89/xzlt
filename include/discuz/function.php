<?php
if(!defined('IN_SMSOT')) {
	exit;
}

function get_syscache_discuz_forum(){
	
	global $_S;

	unset($_S['cache']['discuz_forum']);
	
	$query = DZ::query("SELECT * FROM ".DZ::table('forum_forum')."  WHERE fid!=0 ORDER BY displayorder ASC");
	while($value = DZ::fetch($query)) {
		$value['name']=strip_tags($value['name']);
		$forum[$value['fid']]=$value;
	}
	$query = DZ::query("SELECT * FROM ".DZ::table('forum_forumfield')."  WHERE fid!=0");
	while($value = DZ::fetch($query)) {
		$value['icon']=$value['icon']?(strstr($value['icon'],'://')?$value['icon']:$_S['dz']['atc'].'common/'.$value['icon']):$_S['atc'].'/static/nocover.png';
		$value['description']=strip_tags($value['description']);
		$field[$value['fid']]=$value;
	}
	foreach($forum as $fid=>$v){
		if($field[$fid]){
			$_S['cache']['discuz_forum'][$fid]=array_merge($v,$field[$fid]); 
		}else{
			$_S['cache']['discuz_forum'][$fid]=$v;
		}
	}
	$cache.='$_S[\'cache\'][\'discuz_forum\']='.var_export($_S['cache']['discuz_forum'],true);
	writefile(ROOT.'./data/cache/sys_discuz_forum.php', $cache, 'php', 'w', 0);	
}

function get_syscache_discuz_common(){
	global $_S;
	unset($_S['cache']['discuz_common']);
	$query = DZ::query("SELECT * FROM ".DZ::table('common_setting'));
	while($value = DZ::fetch($query)) {
		$_S['cache']['discuz_common'][$value['skey']]=$value['svalue'];
	}
	$cache.='$_S[\'cache\'][\'discuz_common\']='.var_export($_S['cache']['discuz_common'],true);
	writefile(ROOT.'./data/cache/sys_discuz_common.php', $cache, 'php', 'w', 0);	
}

function get_syscache_discuz_credit_rule(){
	global $_S;
	unset($_S['cache']['discuz_credit_rule']);
	$query = DZ::query("SELECT * FROM ".DZ::table('common_credit_rule'));
	while($value = DZ::fetch($query)) {
		$_S['cache']['discuz_credit_rule'][$value['action']]=$value;
	}
	$cache.='$_S[\'cache\'][\'discuz_credit_rule\']='.var_export($_S['cache']['discuz_credit_rule'],true);
	writefile(ROOT.'./data/cache/sys_discuz_credit_rule.php', $cache, 'php', 'w', 0);	
}


function get_syscache_discuz_usergroup(){
	global $_S;
	unset($_S['cache']['discuz_usergroup']);
	$query = DZ::query("SELECT c.*,cl.* FROM ".DZ::table('common_usergroup')." c LEFT JOIN ".DZ::table('common_usergroup_field')." cl ON cl.groupid=c.groupid");
	while($value = DZ::fetch($query)) {
		$_S['cache']['discuz_usergroup'][$value['groupid']]=$value;
	}
	$cache.='$_S[\'cache\'][\'discuz_usergroup\']='.var_export($_S['cache']['discuz_usergroup'],true);
	writefile(ROOT.'./data/cache/sys_discuz_usergroup.php', $cache, 'php', 'w', 0);	
}

function get_syscache_discuz_types(){
	global $_S;
	unset($_S['cache']['discuz_types']);
	$query = DZ::query("SELECT * FROM ".DZ::table('forum_threadtype'));
	while($value = DZ::fetch($query)) {
		$_S['cache']['discuz_types'][$value['typeid']]=$value['name'];
	}
	$cache.='$_S[\'cache\'][\'discuz_types\']='.var_export($_S['cache']['discuz_types'],true);
	writefile(ROOT.'./data/cache/sys_discuz_types.php', $cache, 'php', 'w', 0);	
}

function get_syscache_discuz_typevar(){
	global $_S;
	unset($_S['cache']['discuz_typevar']);
	$query = DZ::query("SELECT * FROM ".DZ::table('forum_typevar'));
	while($value = DZ::fetch($query)) {
		$_S['cache']['discuz_typevar'][$value['sortid']][$value['optionid']]=$value;
	}
	$cache.='$_S[\'cache\'][\'discuz_typevar\']='.var_export($_S['cache']['discuz_typevar'],true);
	writefile(ROOT.'./data/cache/sys_discuz_typevar.php', $cache, 'php', 'w', 0);	
}

function get_syscache_discuz_typeoption(){
	global $_S;
	unset($_S['cache']['discuz_typeoption']);
	$query = DZ::query("SELECT * FROM ".DZ::table('forum_typeoption'));
	while($value = DZ::fetch($query)) {
		$value['protect']=dzusl($value['protect']);
		$value['rules']=dzusl($value['rules']);
		if($value['rules']['choices']){
			
			foreach(explode("\n",$value['rules']['choices']) as $item){
				list($id,$name)=explode('=',$item);
				$value['choices'][trim($id)]=trim($name);
			}
			
		}elseif($value['rules']['searchtxt']){
			$value['rules']['searchtxt']=explode(',',$value['rules']['searchtxt']);
		}
		$_S['cache']['discuz_typeoption'][$value['optionid']]=$value;
	}
	$cache.='$_S[\'cache\'][\'discuz_typeoption\']='.var_export($_S['cache']['discuz_typeoption'],true);
	writefile(ROOT.'./data/cache/sys_discuz_typeoption.php', $cache, 'php', 'w', 0);	
}


function get_syscache_discuz_smile(){
	global $_S;
	$typeid=$_S['cache']['discuz']['discuz_common']['smile'];
	unset($_S['cache']['discuz_smile']);
	$query = DZ::query("SELECT s.*,t.directory FROM ".DZ::table('common_smiley')." s LEFT JOIN ".DZ::table('forum_imagetype')." t ON t.typeid=s.typeid WHERE s.`type` ='smiley' ORDER BY t.displayorder ASC");
	while($value = DZ::fetch($query)) {
		$value['code']=addslashes($value['code']);
		$value['url']=$_S['dz']['url'].'static/image/smiley/'.$value['directory'].'/'.$value['url'];
		if($value['typeid']==$typeid){
			$_S['cache']['discuz_smile']['default'][$value['id']]=$value;
		}
		$_S['cache']['discuz_smile']['all'][$value['id']]=$value;
	}
	$cache.='$_S[\'cache\'][\'discuz_smile\']='.var_export($_S['cache']['discuz_smile'],true);
	writefile(ROOT.'./data/cache/sys_discuz_smile.php', $cache, 'php', 'w', 0);	
}

function getforumatc($tables,$tids){
	foreach($tables as $table){
		$sql[]='SELECT * FROM '.DZ::table($table);
	}
	$sqlstr=implode(' UNION ',$sql).' WHERE tid IN('.$tids.') AND isimage!=0 AND width>150 ORDER BY `dateline` ASC';
	return $sqlstr;
}

function setdzcredit($action,$uid){
	global $_S;
	$thisaction=$_S['cache']['discuz_credit_rule'][$action];

	if($thisaction && $uid){
		$log=DZ::fetch_first("SELECT * FROM ".DZ::table('common_credit_rule_log')." WHERE `uid`='$uid' AND rid='$thisaction[rid]'");
		if($log){
			if($thisaction['cycletype']==0){
				return false;
			}elseif(in_array($thisaction['cycletype'],array(1,2,3))){
				if($log['cyclenum']>=$thisaction['cyclenum']){
					return false;
				}
			}
			
			$newlog=array(
				'total'=>$log['total']+1,
				'cyclenum'=>$log['cyclenum']+1,
				'extcredits1'=>$thisaction['extcredits1'],
				'extcredits2'=>$thisaction['extcredits2'],
				'extcredits3'=>$thisaction['extcredits3'],
				'extcredits4'=>$thisaction['extcredits4'],
				'extcredits5'=>$thisaction['extcredits5'],
				'extcredits6'=>$thisaction['extcredits6'],
				'extcredits7'=>$thisaction['extcredits7'],
				'extcredits8'=>$thisaction['extcredits8'],
				'dateline'=>$_S['timestamp'],
			);
			
			dzupdate('common_credit_rule_log',$newlog,"clid='$log[clid]'");
			
		}else{
			$log=array(
			  'uid'=>$uid,
				'rid'=>$thisaction['rid'],
				'total'=>1,
				'cyclenum'=>1,
				'extcredits1'=>$thisaction['extcredits1'],
				'extcredits2'=>$thisaction['extcredits2'],
				'extcredits3'=>$thisaction['extcredits3'],
				'extcredits4'=>$thisaction['extcredits4'],
				'extcredits5'=>$thisaction['extcredits5'],
				'extcredits6'=>$thisaction['extcredits6'],
				'extcredits7'=>$thisaction['extcredits7'],
				'extcredits8'=>$thisaction['extcredits8'],
				'starttime'=>0,
				'dateline'=>$_S['timestamp'],
		  );
			dzinsert('common_credit_rule_log',$log);
		}
	}
	DZ::query("UPDATE ".DZ::table('common_member_count')." SET `extcredits1`=`extcredits1` + '$thisaction[extcredits1]',`extcredits2`=`extcredits2` + '$thisaction[extcredits2]',`extcredits3`=`extcredits3` + '$thisaction[extcredits3]',`extcredits4`=`extcredits4` + '$thisaction[extcredits4]',`extcredits5`=`extcredits5` + '$thisaction[extcredits5]',`extcredits6`=`extcredits6` + '$thisaction[extcredits6]',`extcredits7`=`extcredits7` + '$thisaction[extcredits7]',`extcredits8`=`extcredits8` + '$thisaction[extcredits8]' WHERE uid='$uid'");
}
function get_userpower($forum){
	global $_S;

  if($_S['myid']){
		if($_S['usergroup']['power']>5){
			return true;
		}
		
		$member=DZ::fetch_first("SELECT m.username,m.adminid,m.groupid,c.* FROM ".DZ::table('common_member')." m LEFT JOIN ".DZ::table('common_member_count')." c ON c.uid=m.uid WHERE m.`uid`='$_S[myid]'");
		
		if($member['adminid']==1 || $member['adminid']==2 ){
			return true;
		}elseif($member['adminid']==3){
			if($forum['type']=='sub'){
				$moderators=$forum['moderators'].($_S['cache']['discuz_forum'][$forum['fup']]['moderators']?"\t".$_S['cache']['discuz_forum'][$forum['fup']]['moderators']:'').($_S['cache']['discuz_forum'][$_S['cache']['discuz_forum'][$forum['fup']]['fup']]['moderators']?"\t".$_S['cache']['discuz_forum'][$_S['cache']['discuz_forum'][$forum['fup']]['fup']]['moderators']:'');
			}elseif($forum['type']=='forum'){
				$moderators=$forum['moderators'].($_S['cache']['discuz_forum'][$forum['fup']]['moderators']?"\t".$_S['cache']['discuz_forum'][$forum['fup']]['moderators']:'');
			}
			if($moderators){
				$moderators=explode("\t",$moderators);
				if(in_array($member['username'],$moderators)){
					return true;
				}
			}
		}
		return $member;		
	}else{
		$member=array(
		  'uid'=>'0',
			'groupid'=>'7',
		);
		return $member;
	}
}

function getstatus($status, $position) {
	$t = $status & pow(2, $position - 1) ? 1 : 0;
	return $t;
}

function sorturl($op,$v=''){
	$get=$_GET;
	unset($get['load']);
	unset($get['get']);
	unset($get['page']);
  unset($get['iosurl']);
	if($v){
		$get[$op]=$v;
	}else{
		unset($get[$op]);
	}
	foreach($get as $key=>$val){
		$urls[]=$key.'='.$val;
	}
	$url='discuz.php?'.implode('&',$urls);
	
	echo $url;
}


function sortsql(){
	global $thissort;
	foreach($_GET as $key=>$val){
		if(strpos('|'.$key,"op")){
			$opid=substr($key,2);
			if(is_numeric($opid)){
				$sql[]=" s.optionid='$opid' ";
				if($thissort[$opid]['type']=='checkbox'){
					$sql[] = '(s.value='.'\'' . $val . '\''.
						' OR s.value like '.'\'' . "$val\t%" . '\''.
						' OR s.value like '.'\'' . "%\t$val" . '\''.
						' OR s.value like '.'\'' . "%\t$val\t%" . '\''.') ';
				}elseif($thissort[$opid]['type']=='select'){
					if($thissort[$opid]['n']){
						$val=$val.'.';
						$sql[]=' s.value LIKE'."'%$val%' ";
					}else{
						$sql[]=" s.value='$val' ";
					}
				}elseif($thissort[$opid]['type']=='range'){
					$valarr=explode('|',$val);
					if($valarr[0]=='d'){
						$sql[] = " s.value<".intval($valarr[1]).' ';
					}elseif($valarr[0]=='u'){
						$sql[] = " s.value>".intval($valarr[1]).' ';
					}else{
						$sql[] = " (s.value BETWEEN ".intval($valarr[0])." AND ".intval($valarr[1]).") ";
					}
				}elseif($thissort[$opid]['type']=='text'){
					$sql[]=' s.value LIKE'."'%$val%' ";
				}else{
					$sql[]=" s.value='$val' ";
				}
			}
		}
	}
	if($sql){
		return implode('AND',$sql);
	}else{
		return ;
	}
}
function getdzsort(){
	global $_S;
	if($_GET['sortid'] && $_S['cache']['discuz_typevar'][$_GET['sortid']]){
		foreach($_S['cache']['discuz_typevar'][$_GET['sortid']] as $value){
			$thissort[$value['optionid']]=$_S['cache']['discuz_typeoption'][$value['optionid']];
			if($thissort[$value['optionid']]['type']=='range'){
				$max=count($thissort[$value['optionid']]['rules']['searchtxt'])-1;
				foreach($thissort[$value['optionid']]['rules']['searchtxt'] as $k=>$v){
					if($k==0){
						$searchtxt['d|'.$thissort[$value['optionid']]['rules']['searchtxt'][1]]='低于'.$thissort[$value['optionid']]['rules']['searchtxt'][1].$thissort[$value['optionid']]['unit'];
					}elseif($k==$max){
						$searchtxt['u|'.$thissort[$value['optionid']]['rules']['searchtxt'][$max]]='高于'.$thissort[$value['optionid']]['rules']['searchtxt'][$max].$thissort[$value['optionid']]['unit'];
					}else{
						$searchtxt[$thissort[$value['optionid']]['rules']['searchtxt'][$k].'|'.$thissort[$value['optionid']]['rules']['searchtxt'][$k+1]]=$v.'-'.$thissort[$value['optionid']]['rules']['searchtxt'][$k+1].$thissort[$value['optionid']]['unit'];
					}
				}
				$thissort[$value['optionid']]['choices']=$searchtxt;
			}elseif($thissort[$value['optionid']]['type']=='select'){
				foreach($_S['cache']['discuz_typeoption'][$value['optionid']]['choices'] as $k=>$v){
					if(strpos($k,".")){
						$thissort[$value['optionid']]['n']=true;
						unset($thissort[$value['optionid']]['choices'][$k]);
					}
				}
			}
			$thissort[$value['optionid']]['search']=$value['search'];
		}
		return $thissort;
	}
	
}

function getlistpic($pictab,$tids){

	if($pictab && $tids){
		$pictab=array_unique($pictab);
		$tidstr=implode(',',$tids);
		foreach($pictab as $table){
			$query=DZ::query("SELECT * FROM ".DZ::table($table)." WHERE tid IN($tidstr) AND isimage!=0 AND width>150 ORDER BY `dateline` ASC");
			while($value = DZ::fetch($query)){
				$pics[$value['tid']][]=$value;
			}
		}
	}
  return $pics;
}

function forumallow($member,$forum){
	global $_S;
	
	$return=array();
	$return['getattachperm']=true;
	$return['postimageperm']=true;	
	if($member && !is_array($member)){
		return $return;
	}
	//不受限制的用户组
	if($forum['spviewperm']){
		$spviewperm=explode("\t",$forum['spviewperm']);
		if(in_array($member['groupid'],$spviewperm)){
			return $return;
		}
	}	
	//付费板块
	if($forum['price']){
		if($_S['myid']){
			$paylog=DZ::fetch_first("SELECT * FROM ".DZ::table('common_member_forum_buylog')." WHERE `fid`='$forum[fid]' AND `uid`='$member[uid]'");
		}
		if(!$paylog || $paylog['credits']<$forum['price']){
			$extcredits=dzusl($_S['cache']['discuz_common']['extcredits']);
			$transextra=explode(',',$_S['cache']['discuz_common']['creditstrans']);
			showmessage('本版块需要支付'.($forum['price']-$paylog['credits']).$extcredits[$transextra[0]]['title'].'才能继续浏览，是否支付费用','discuz.php?mod=action&ac=payforum&fid='.$forum['fid']);
		}
	}
	//密码
	if($forum['password']){
		$dzforum=getcookies('dzforum_'.$forum['fid']);
		if(!$dzforum){
			include temp('discuz/forum_password');
			exit;
		}
	}
	
	//表达式
	$forum['formulaperm']=dzusl($forum['formulaperm']);
	if($forum['formulaperm'][1]){
		showmessage('本板块设置了访问权限表达式无法在小程序里进行验证');
	}
	//拥有勋章
	if($forum['formulaperm']['medal']){
		$medals=implode(',',$forum['formulaperm']['medal']);
		if($_S['myid']){
			$have=DZ::fetch_first("SELECT * FROM ".DZ::table('common_member_medal')." WHERE `uid`='$_S[myid]' AND `medalid`IN($medals)");
		}
		if(!$have){
			showmessage('本版块需要拥有指定的勋章才能访问');
		}
	}	
	//指定用户
	if($forum['formulaperm']['users']){
		$users=explode("\n",$forum['formulaperm']['users']);
		if(!in_array($member['username'],$users)){
			showmessage('本版本只允许指定用户访问');
		}
	}
	
	//允许浏览的用户组
	if($forum['viewperm']){
		$viewperm=explode("\t",$forum['viewperm']);
		if(!in_array($member['groupid'],$viewperm)){
			showmessage('本版本只允许指定用户组访问');
		}
	}
	//允许发帖的用户组
	if($forum['postperm'] && $_GET['ac']=='addthread'){
		$postperm=explode("\t",$forum['postperm']);
		if(!in_array($member['groupid'],$postperm)){
			showmessage('本版本只允许指定用户组发帖');
		}
	}
	//允许回帖的用户组
	if($forum['replyperm'] && in_array($_GET['ac'],array('replythread','replypost'))){
		$replyperm=explode("\t",$forum['replyperm']);
		if(!in_array($member['groupid'],$replyperm)){
			showmessage('本版本只允许指定用户组回帖');
		}
	}
	//允许下载的用户组
	if($forum['getattachperm']){
		$getattachperm=explode("\t",$forum['getattachperm']);
		if(!in_array($member['groupid'],$getattachperm)){
			$return['getattachperm']=false;
		}
	}
	//允许上传图片的用户组
	if($forum['postimageperm']){
		$postimageperm=explode("\t",$forum['postimageperm']);
		if(!in_array($member['groupid'],$postimageperm)){
			$return['postimageperm']=false;
		}
	}
  return $return;
}

function dzinsert($table,$array,$ignore=false){
	foreach($array as $k=>$v){
		$filds[]='`'.$k.'`';
		$values[]='\''.$v.'\'';
	}
	$fildstr=implode(',',$filds);
	$valuestr=implode(',',$values);
	
	if($ignore){
		DZ::query("INSERT IGNORE INTO ".DZ::table($table)." ($fildstr) VALUES ($valuestr)");	
	}else{
		DZ::query("INSERT INTO ".DZ::table($table)." ($fildstr) VALUES ($valuestr)");	
	}
	return DZ::insert_id();
}

function dzupdate($table,$array,$where,$replace=false){
	foreach($array as $k=>$v){
		$fs[]='`'.$k.'`';
		$vs[]='\''.$v.'\'';
		$filds[]= '`'.$k.'` = \''.$v.'\'';
	}
	$fstr=implode(',',$fs);
	$vstr=implode(',',$vs);
	$fildstr=implode(',',$filds);

	if($replace){
		DZ::query("REPLACE INTO ".DZ::table($table)." ($fstr) VALUES ($vstr)");
	}else{
		DZ::query("UPDATE ".DZ::table($table)." SET $fildstr WHERE $where");
	}
}



function getdzpic($pics,$w='200',$h='150',$max='9'){
	if($pics){
		foreach($pics as $pic){
			//$methode=$pic['remote']==2?'getimg':'getdzimg';
			$src=$pic['remote']==2?getimg($pic['attachment'],$w,$h,false,'return'):getdzimg($pic['aid'],$w,$h,false,'return');
			if($i<$max){
				if(count($pics)==1 || $max==1){
					if($_GET['mod']=='get'){
						$return='<img src="'.$src.'" class="pic" />';
					}else{
						$return='<img src="ui/sl.png" data-original="'.$src.'" class="pic lazyload" scaling="'.round($h/$w,2).'" />';
					}
				}else{
					if($_GET['mod']=='get'){
						$return .='<li><div><img src="'.$src.'"/></div></li>';
					}else{
						$return .='<li><div><img src="ui/sl.png" data-original="'.$src.'" class="lazyload" scaling="'.round($h/$w,2).'"/></div></li>';
					}
				}
				$i++;
			}
		}
		echo $return;		
	}
}
function getdzwebpic($matches,$w='200',$h='150',$n='9'){
  $i=1;
	foreach($matches as $key => $val){
		if(strpos($val,'magcloud.net') == false){
			$val=urlencode($val);
			if($i<=$n){
				if($n==1){
					$imgs = '<img src="ui/sl.png" data-original="index.php?mod=webimg&src='.$val.'&w='.$w.'&h='.$h.'" class="pic lazyload" scaling="'.round($h/$w,2).'"/>';
				}else{
					$imgs .= '<li><div><img src="ui/sl.png" data-original="index.php?mod=webimg&src='.$val.'&w='.$w.'&h='.$h.'" class="pic lazyload" scaling="'.round($h/$w,2).'"/></div></li>';
				}
				$i++;	
			}			
		}

	}
	echo($imgs);
}


function dzcontent($content){
	$content = preg_replace(array("/\<[div|DIV].*?\>/s","/\<[p|P].*?\>/s","/\<[br|BR].*?\>/s","/\<\/[div|DIV].*?\>/s","/\<\/[p|P].*?\>/s"), array("","","\n","\n","\n"), $content);
	$content = strip_tags($content);
	$content = preg_replace(array("#\n\r+#","#\r\n+#","#\n+#"), "\n", $content);
	return $content;
}

function dzusl($str){
	global $_S;
	if($_S['cache']['discuz']['discuz_common']['char']=='gbk'){
		$str=iconv('UTF-8','GBK',$str);
		$str=dunserialize($str);
		$str=array_iconv($str);
	}else{
		$str=dunserialize($str);
	}
	return $str;
}
function array_iconv($str){
	global $_S;
  if(is_array($str)){
    foreach($str as $k => $v){
	    $str[$k] =array_iconv($v);
    }
    return $str;
  }elseif(is_string($str)){
		if($_S['cache']['discuz']['discuz_common']['char']=='gbk'){
			return iconv('GBK', 'UTF-8', $str);
		}else{
			return $str;
		}
    
  }else{
    return $str;
  }
}


function getdzimg($pic,$width,$height,$scaling=false,$showtype='echo'){
	global $_S;
	/*
  $img=$_S['atc'].'/discuz/'.$pic.'_'.$width.'_'.$height.'.jpg';
	if(!is_file(ROOT.$img)) {
		$fileinfo=getimagesize($_S['dz']['atc'].'forum/'.$pic);
		if($fileinfo){
			if($scaling){
				$w=$width;
				$h=$height;			
			}else{
				$h=$fileinfo[1]>$height?$height:$fileinfo[1];
				$w=$fileinfo[0]>$width?$width:$fileinfo[0];		
			}
			require_once './include/image.php';
			$image = new image;
			$thumb=$image->Thumb($_S['dz']['atc'].'forum/'.$pic,'discuz/'.$pic.'_'.$width.'_'.$height.'.jpg',$w, $h, 'fixwr');		
			if($thumb){
				$return=$img;
			}else{
				$return=$_S['dz']['atc'].'forum/'.$pic;
			}
		}else{
			$return='ui/nopic.png';
		}
	}else{
		$return=$img;
	}
	*/
	if($showtype=='echo'){
		echo $_S['dz']['url'].'forum.php?mod=image&aid='.$pic.'&size='.$width.'x'.$height;
	}else{
		return $_S['dz']['url'].'forum.php?mod=image&aid='.$pic.'&size='.$width.'x'.$height;
	}
}

function dzwatercover($pics){
	global $_S;
	if($pics){
	  $cover=current($pics);
		$cover['pic']=getdzimg($cover['aid'],285,9999,true,'return');
		$fileinfo=getimagesize($cover['pic']);
		$cover['width']=$fileinfo[0];
		$cover['height']=$fileinfo[1];
	}else{
		$cover['pic']='ui/nopic.gif';
		$cover['width']='285';
		$cover['height']='285';
	}
  return $cover;
}

function dzbbcode($message,$authorid,$htmlon,$bbcodeoff,$smileyoff){
	global $_S,$canmanage;

	static $authorreplyexist;

	
	$msglower = strtolower($message);
  //html
	if(!$htmlon) {
		$message = dhtmlspecialchars($message);
	} else {
		$message = preg_replace("/<script[^\>]*?>(.*?)<\/script>/i", '', $message);
	}
  //password
	if(strpos($message, '[/password]') !== FALSE) {
		$message = preg_replace("/\s?\[password\](.+?)\[\/password\]\s?/i", "", $message);
	}
	//code
	if(!$bbcodeoff && (strpos($message, '[/code]') || strpos($message, '[/CODE]')) !== FALSE) {
		$message = preg_replace("/\s?\[code\](.+?)\[\/code\]\s?/is", "", $message);
	}	
	
	//smile
	if(!$smileyoff) {
		$message = parsesmiles($message);
	}
	//attach
	if(strpos($message, '[/attach]') !== FALSE) {
		$message = preg_replace_callback("/\s?\[attach\](.+?)\[\/attach\]\s?/i", 'putatc', $message);
	}
	
	//attach
	if(strpos($msglower, 'attach://') !== FALSE) {
		$message = preg_replace_callback("/attach:\/\/(\d+)\.?(\w*)/i", 'discuzcode_callback_parseattachurl_12', $message);
	}
	//ed2k
	if(strpos($msglower, 'ed2k://') !== FALSE) {
		$message = preg_replace_callback("/ed2k:\/\/(.+?)\//", 'discuzcode_callback_parseed2k_1', $message);
	}
  if(!$bbcodeoff) {
		//url
		if(strpos($msglower, '[/url]') !== FALSE) {
			$message = preg_replace_callback("/\[url(=((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|qqdl|synacast){1}:\/\/|www\.|mailto:)?([^\r\n\[\"']+?))?\](.+?)\[\/url\]/is", 'discuzcode_callback_parseurl_152', $message);
		}
		//email
		if(strpos($msglower, '[/email]') !== FALSE) {
			$message = preg_replace_callback("/\[email(=([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+))?\](.+?)\[\/email\]/is", 'discuzcode_callback_parseemail_14', $message);
		}
    //table
		$nest = 0;
		while(strpos($msglower, '[table') !== FALSE && strpos($msglower, '[/table]') !== FALSE){
			$message = preg_replace_callback("/\[table(?:=(\d{1,4}%?)(?:,([\(\)%,#\w ]+))?)?\]\s*(.+?)\s*\[\/table\]/is", 'discuzcode_callback_parsetable_123', $message);
			if(++$nest > 4) break;
		}
		$message = str_replace(array(
			'[/color]', '[/backcolor]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]', '[s]', '[/s]', '[hr]', '[/p]',
			'[i=s]', '[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
			'[list=A]', "\r\n[*]", '[*]', '[/list]', '[indent]', '[/indent]', '[/float]'
			), array(
			'</font>', '</font>', '</font>', '</font>', '</div>', '<strong>', '</strong>', '<strike>', '</strike>', '<hr class="l" />', '</p>', '<i class="pstatus">', '<i>',
			'</i>', '<u>', '</u>', '<ul>', '<ul type="1" class="litype_1">', '<ul type="a" class="litype_2">',
			'<ul type="A" class="litype_3">', '<li>', '<li>', '</ul>', '<blockquote>', '</blockquote>', '</span>'
			), preg_replace(array(
			"/\[color=([#\w]+?)\]/i",
			"/\[color=((rgb|rgba)\([\d\s,]+?\))\]/i",
			"/\[backcolor=([#\w]+?)\]/i",
			"/\[backcolor=((rgb|rgba)\([\d\s,]+?\))\]/i",
			"/\[size=(\d{1,2}?)\]/i",
			"/\[size=(\d{1,2}(\.\d{1,2}+)?(px|pt)+?)\]/i",
			"/\[font=([^\[\<]+?)\]/i",
			"/\[align=(left|center|right)\]/i",
			"/\[p=(\d{1,2}|null), (\d{1,2}|null), (left|center|right)\]/i",
			"/\[float=left\]/i",
			"/\[float=right\]/i"

			), array(
			"<font color=\"\\1\">",
			"<font style=\"color:\\1\">",
			"<font style=\"background-color:\\1\">",
			"<font style=\"background-color:\\1\">",
			"<font size=\"\\1\">",
			"<font style=\"font-size:\\1\">",
			"<font face=\"\\1\">",
			"<div align=\"\\1\">",
			"<p style=\"line-height:\\1px;text-indent:\\2em;text-align:\\3\">",
			"<span style=\"float:left;margin-right:5px\">",
			"<span style=\"float:right;margin-left:5px\">"
			), $message));
		
		//postbg
		$message = preg_replace("/\s?\[postbg\]\s*([^\[\<\r\n;'\"\?\(\)]+?)\s*\[\/postbg\]\s?/is", "", $message);
    //quote
		if(strpos($msglower, '[/quote]') !== FALSE) {
			$message = preg_replace_callback("/\s?\[quote\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s?/is", 'tpl_quote', $message);
		}
		//free
		if(strpos($msglower, '[/free]') !== FALSE) {
			$message = preg_replace_callback("/\s*\[free\][\n\r]*(.+?)[\n\r]*\[\/free\]\s*/is", 'tpl_free', $message);
		}
		//media
		if(strpos($msglower, '[/media]') !== FALSE) {
			$message = preg_replace_callback("/\[media=([\w,]+)\]\s*([^\[\<\r\n]+?)\s*\[\/media\]/is", "tpl_media", $message);
			$message = preg_replace_callback("/\[media\](.*?)\[\/media\]/is", "tpl_media", $message);
		}
		//audio
		if(strpos($msglower, '[/audio]') !== FALSE) {
			$message = preg_replace_callback("/\[audio(=1)*\]\s*([^\[\<\r\n]+?)\s*\[\/audio\]/is", "tpl_audio", $message);
		}
		//flash
		if(strpos($msglower, '[/flash]') !== FALSE) {
			$message = preg_replace_callback("/\[flash(=(\d+),(\d+))?\]\s*([^\[\<\r\n]+?)\s*\[\/flash\]/is", "tpl_flash", $message);
		}
		//hide
		if(strpos($msglower, '[/hide]') !== FALSE) {
			$message = preg_replace("/\[hide\]\s*(.*?)\s*\[\/hide\]/is", "\\1", $message);
			$message = preg_replace("/\[hide[=]?(d\d+)?[,]?(\d+)?\]\s*(.*?)\s*\[\/hide\]/is", "\\3", $message);
		}
		//swf
		if($parsetype != 1 && strpos($msglower, '[swf]') !== FALSE) {
			$message = preg_replace_callback("/\[swf\]\s*([^\[\<\r\n]+?)\s*\[\/swf\]/is", 'discuzcode_callback_bbcodeurl_1', $message);
		}
		$attrsrc = 'src';
		//img
		if(strpos($msglower, '[/img]') !== FALSE) {
			$message = preg_replace_callback("/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is", 'putimg', $message);
			$message = preg_replace_callback("/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is", 'putimg', $message);
		}		
	}
	unset($msglower);
  return $htmlon ? $message : nl2br(str_replace(array("\t", '   ', '  '), array('&nbsp; &nbsp; &nbsp; &nbsp; ', '&nbsp; &nbsp;', '&nbsp;&nbsp;'), $message));
	
}

function putimg($matches){
	if($matches[3]){
		return '<img src="'.$matches[3].'" class="viewimg">';
	}else{
		return '<img src="'.$matches[1].'" class="viewimg">';
	}
}
function getthreadatc($tid){
	global $_S;
	$pici=0;
	$atctab='forum_attachment_'.substr($tid, -1);
	$query = DZ::query('SELECT * FROM '.DZ::table($atctab)." WHERE tid = '$tid' ORDER BY `dateline` ASC");
	while($value = DZ::fetch($query)){
		if($value['isimage']){
			$atcs['img'][$value['aid']]=$value['pid'];
			if($value['remote']=='2'){
				$value['atc']=$_S['setting']['siteurl'].$_S['atc'].'/'.$value['attachment'].($value['thumb']?'.thumb.jpg':'');
			}elseif($value['remote']=='1'){
				$value['atc']=$_S['dz']['remote'].'forum/'.$value['attachment'].($value['thumb']?'.thumb.jpg':'');
			}else{
				$value['atc']=$_S['dz']['atc'].'forum/'.$value['attachment'].($value['thumb']?'.thumb.jpg':'');
			}
			if($pici==0){
				$firstpic=$value['atc'];
			}
			$pici++;
			$atcs[$value['pid']]['img'][$value['aid']]=$value;
		}else{
			$atcs['atc'][$value['aid']]=$value['pid'];
			$value['atc']=$atcs[$thread['content']['pid']][''];
			$value['filesize']=sizecount($value['filesize']);
			$atcs[$value['pid']]['atc'][$value['aid']]=$value;
		}
	}
	return array($atcs,$firstpic);
}
function putatc($matches){
  global $atcs;
	if($atcs['img'][$matches[1]]){
		$pid=$atcs['img'][$matches[1]];
		if($_GET['mod']=='get'){
			$return='<img src="'.$atcs[$pid]['img'][$matches[1]]['atc'].'" class="viewpic">';
		}else{
			$return='<img src="ui/sl.png" data-original="'.$atcs[$pid]['img'][$matches[1]]['atc'].'" class="viewpic lazyload">';
		}		
	}else{
		$pid=$atcs['atc'][$matches[1]];
		if($atcs[$pid]['atc'][$matches[1]]['atc']){
			$return='<a href="'.$atcs[$pid]['atc'][$matches[1]]['atc'].'" class="download c8"><span class="icon icon-down"></span>'.$atcs[$pid]['atc'][$matches[1]]['filename'].'<em class="c4">('.$atcs[$pid]['atc'][$matches[1]]['filesize'].')</em></a>';
		}
	}
	return $return;
}

function puthidden($matches){

}


function parsesmiles(&$message,$ac='analysis'){
	global $_S;
	foreach($_S['cache']['discuz_smile']['all'] as $smile){
		if($ac=='analysis'){
			$url=$smile['url'];
		}else{
			$url=str_replace($_S['dz']['url'],'',$smile['url']);
		}
		$smiles[$smile['code']]='<img src="'.$url.'" class="vm">';
	}
	$message=strtr($message,$smiles);
	return $message;
}
function tpl_quote($matches){
	$str = preg_replace("/<a[^>]*>(.*?)<\/a>/is", "", $matches[1]);
	return '<div class="quote p10 b_c5 mb10">'.$str.'</div>';
}
function tpl_free($matches){
	return '<div class="quote p10 b_c5 mb10">'.$matches[1].'</div>';
}
function tpl_media($matches){
	if(strpos($matches[2], '.mp4') !== FALSE) {
		return '<div class="video"><a href="'.$matches[2].'" class="icon icon-play playvideo"><img src="./ui/b.png"/></a></div>';
	}else{
		if($_S['miniProgram']){
			return '<p class="c4">复制下面的视频地址到浏览器播放</p><p class="c8">'.$matches[2].'</p>';
		}else{
			return put_video($matches[2]);
		}
	}	
}

function put_video($url){

  if(strpos($url, 'qq.com/') !== FALSE) {
		$lowerurl = $url;
		if(preg_match("/vid=(.*)/", $lowerurl, $matches)) {
			$iframe = 'https://v.qq.com/iframe/player.html?vid='.$matches[1];
		}elseif(strpos($lowerurl, 'x/page/')){
			preg_match("/x\/page\/([^\/]+).html/i", $url, $matches);
			$iframe = 'https://v.qq.com/iframe/player.html?vid='.$matches[1];			
		}elseif(strpos($lowerurl, 'x/cover/')){
			preg_match("/x\/cover\/([^\/]+)\/([^\/]+).html/i", $url, $matches);
			$iframe = 'https://v.qq.com/iframe/player.html?vid='.$matches[2];			
		}
	}elseif(strpos($url, 'tudou.com/') !== FALSE) {
    if(strpos($url, 'video.tudou.com')){
			preg_match("/video.tudou.com\/v\/([^\/]+).html/i", $url, $matches);
			$iframe = 'https://player.youku.com/embed/'.$matches[1];
		}elseif(strpos($url, 'programs/view')){
			preg_match("/programs\/view\/([^\/\?]+)\//i", $url, $matches);
			$iframe = 'http://www.tudou.com/programs/view/html5embed.action?type=0&code='.$matches[1].'&lcode=&resourceId=119693922_06_05_99';
		}
	}elseif(dstrpos($url, array('v.youku.com/v_show/', 'player.youku.com/player.php/'))) {
		$regexp = strpos($url, 'v.youku.com/v_show/') ? '/v.youku.com\/v_show\/id_([a-zA-Z0-9]+)/i' : '/player.youku.com\/player.php\/(?:.+\/)?sid\/([^\/]+)\/v.swf/i';
		if (preg_match($regexp, $url, $matches)) {
			$iframe = 'https://player.youku.com/embed/'.$matches[1].'==';
		}
	}elseif(strpos($url, 'iqiyi.com/') !== FALSE){
		preg_match("/iqiyi.com\/.*?vid=([^\/\"\[]+)/i", $url, $matches);
		$iframe = 'https://m.iqiyi.com/openplay.html?vid='.$matches[1];
	}


  return '<iframe width="100%" height="220px" src="'.$iframe.'" frameborder=0 allowfullscreen></iframe>';		
  
}

function parse_tudouicode($url){
	global $_S;
	
	$url = html_entity_decode($url);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$content = curl_exec($ch);
	$info = curl_getinfo($ch);
	
	if(!$info['url'] || $info['url'] == $url){
		preg_match('/Location: (.*?)\n/',$content,$ma);
		$info['url'] = $ma[1];
	}print_r($info);
	$p = '/(.*?)&code=(\w+)&(.*?)/';
	preg_match($p,$info['url'],$matches);
	if(!$matches || !$matches[2]) return false;
	return 'http://www.tudou.com/programs/view/html5embed.action?code='.$matches[2];
}



function tpl_audio($matches){
	
}
function tpl_flash($matches){
	
}
function discuzcode_callback_codedisp_1($matches) {
	return codedisp($matches[1]);
}
function discuzcode_callback_parseattachurl_12($matches){
	
}
function discuzcode_callback_parseed2k_1($matches){
	
}
function discuzcode_callback_parseurl_152($matches){
	return parseurl($matches[1], $matches[5], $matches[2]);
}
function discuzcode_callback_parseemail_14($matches){
	return parseemail($matches[1], $matches[4]);
}
function discuzcode_callback_parsetable_123($matches) {
	return parsetable($matches[1], $matches[2], $matches[3]);
}
function parsetable_callback_parsetrtd_12($matches) {
	return parsetrtd($matches[1], 0, 0, $matches[2]);
}

function parsetable_callback_parsetrtd_1($matches) {
	return parsetrtd('td', 0, 0, $matches[1]);
}

function parsetable_callback_parsetrtd_1234($matches) {
	return parsetrtd($matches[1], $matches[2], $matches[3], $matches[4]);
}

function parsetable_callback_parsetrtd_123($matches) {
	return parsetrtd('td', $matches[1], $matches[2], $matches[3]);
}

function discuzcode_callback_bbcodeurl_1($matches){
	return '<a href="'.$matches[1].'" target="_blank" class="c8">Flash: '.$matches[1].'</a>';
}

function parseurl($url, $text, $scheme) {
	global $_S;
	if(!$url && preg_match("/((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|qqdl|synacast){1}:\/\/|www\.)[^\[\"']+/i", trim($text), $matches)) {
		$url = $matches[0];
		$length = 65;
		if(strlen($url) > $length) {
			$text = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
		}
		return '<a href="'.(substr(strtolower($url), 0, 4) == 'www.' ? 'http://'.$url : $url).'" target="_blank">'.$text.'</a>';
	} else {
		$url = substr($url, 1);
		if(substr(strtolower($url), 0, 4) == 'www.') {
			$url = 'http://'.$url;
		}
		$url = !$scheme ? $_S['setting']['siteurl'].$url : $url;
		return '<a href="'.$url.'" class="c8 load">'.$text.'</a>';
	}
}
function parseemail($email, $text) {
	$text = str_replace('\"', '"', $text);
	if(!$email && preg_match("/\s*([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\s*/i", $text, $matches)) {
		$email = trim($matches[0]);
		return '<a href="mailto:'.$email.'">'.$email.'</a>';
	} else {
		return '<a href="mailto:'.substr($email, 1).'">'.$text.'</a>';
	}
}
function parsetable($width, $bgcolor, $message) {
	if(strpos($message, '[/tr]') === FALSE && strpos($message, '[/td]') === FALSE) {
		$rows = explode("\n", $message);
		$s = '<table>';
		foreach($rows as $row) {
			$s .= '<tr><td>'.str_replace(array('\|', '|', '\n'), array('&#124;', '</td><td>', "\n"), $row).'</td></tr>';
		}
		$s .= '</table>';
		return $s;
	} else {
		if(!preg_match("/^\[tr(?:=([\(\)\s%,#\w]+))?\]\s*\[td([=\d,%]+)?\]/", $message) && !preg_match("/^<tr[^>]*?>\s*<td[^>]*?>/", $message)) {
			return str_replace('\\"', '"', preg_replace("/\[tr(?:=([\(\)\s%,#\w]+))?\]|\[td([=\d,%]+)?\]|\[\/td\]|\[\/tr\]/", '', $message));
		}
		if(substr($width, -1) == '%') {
			$width = substr($width, 0, -1) <= 98 ? intval($width).'%' : '98%';
		} else {
			$width = intval($width);
			$width = $width ? ($width <= 560 ? $width.'px' : '98%') : '';
		}
		$message = preg_replace_callback("/\[tr(?:=([\(\)\s%,#\w]+))?\]\s*\[td(?:=(\d{1,4}%?))?\]/i", 'parsetable_callback_parsetrtd_12', $message);
		$message = preg_replace_callback("/\[\/td\]\s*\[td(?:=(\d{1,4}%?))?\]/i", 'parsetable_callback_parsetrtd_1', $message);
		$message = preg_replace_callback("/\[tr(?:=([\(\)\s%,#\w]+))?\]\s*\[td(?:=(\d{1,2}),(\d{1,2})(?:,(\d{1,4}%?))?)?\]/i", 'parsetable_callback_parsetrtd_1234', $message);
		$message = preg_replace_callback("/\[\/td\]\s*\[td(?:=(\d{1,2}),(\d{1,2})(?:,(\d{1,4}%?))?)?\]/i", 'parsetable_callback_parsetrtd_123', $message);
		$message = preg_replace("/\[\/td\]\s*\[\/tr\]\s*/i", '</td></tr>', $message);
		return '<table>'.str_replace('\\"', '"', $message).'</table>';
			
	}
}
function parsetrtd($bgcolor, $colspan, $rowspan, $width) {
	return ($bgcolor == 'td' ? '</td>' : '<tr>').'<td'.($colspan > 1 ? ' colspan="'.$colspan.'"' : '').($rowspan > 1 ? ' rowspan="'.$rowspan.'"' : '').'>';
}

function codedisp($code) {
	
}


?>