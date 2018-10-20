<?php
if(!defined('IN_SMSOT')) {
	exit;
}

function formhash($specialadd = '') {
	global $_S;
	return substr(md5(substr($_S['timestamp'], 0, -7).$_S['username'].$_S['uid'].$_S['setting']['authkey'].$specialadd), 8, 8);
}

function checksubmit($submit){
	global $_S;
	if($_GET[$submit]){
		if($_GET['hash']!=$_S['hash']){
			showmessage('数据来路不安全');
		}else{
			return true;
		}
	}else{
		return false;
	}
}

function ajaxupload($name,$path,$w,$h){
	if($_FILES[$name]['name']){
		$pic = upload_img($_FILES[$name],$path,$w,$h);
		$src=$pic['attachment'].($pic['thumb']?'_'.$w.'_'.$h.'.jpg':'');
		if($src){
			showmessage('上传成功','',array('type'=>'toast','fun'=>'SMS.uploadsuccess(\''.$src.'\',\''.$name.'\')'));
		}else{
			showmessage('上传失败');
		}
	}else{
		return false;
	}
}

function sizecount($size) {
	if($size >= 1073741824) {
		$size = round($size / 1073741824 * 100) / 100 . ' GB';
	} elseif($size >= 1048576) {
		$size = round($size / 1048576 * 100) / 100 . ' MB';
	} elseif($size >= 1024) {
		$size = round($size / 1024 * 100) / 100 . ' KB';
	} else {
		$size = intval($size) . ' Bytes';
	}
	return $size;
}

function str_replace_limit($uid, $replace='', $tid) {
	$uid=strval($uid);
	$tid=strval($tid);
	$len=strlen($tid)-strlen($uid);
	$star=stripos($tid,$uid);
	$end=strrpos($tid,$uid);
	if($star==0){
		if($end){
			$sc=strlen($uid)-1;
		}else{
			$sc=$star+strlen($uid);
		}
	}else{
		$sc=0;
	}
	$touid=substr($tid,$sc,$len);
	return $touid;
}

function gethtmlcontent($content){
	$content = preg_replace(array("#\n\r+#","#\r\n+#","#\n+#"), "\n", $content);
	$content=str_replace(array("\n"),array("<br>"),$content);
	$content = preg_replace_callback("/\[h\=(.+?)]/s", 'puttitle', $content);
	$content = preg_replace_callback("/\[img\=(.+?)](.+?)\[\/img]/s", 'putimgs', $content);
	$content = preg_replace_callback("/\[pic\=(.+?)]/s", 'putpics', $content);
	
	return $content;
}
function pay($pay,$user){
	$money=$user['balance']+$user['gold'];
	if($money>$pay){
		if($user['balance']>$pay){
			$value['balance']=$pay;
			$value['gold']=0;
		}elseif($user['gold']>$pay){
			$value['gold']=ceil($pay);
			$value['balance']=0;
		}else{
			$value['balance']=$user['balance'];
			$value['gold']=ceil($pay-$user['balance']);
		}
	}else{
		$value['balance']=$user['balance'];
		$value['gold']=$user['gold'];
		$value['money']=$pay-$money;
	}
	return $value;
}

function settlement($pay,$oid,$uid,$title,$refund=false){
	global $_S;
	if($refund){
		$pay['balance']=$pay['balance']+$pay['money'];
	}
	if($pay['balance']>0){
		$lid=makeid();
		$balance=round($pay['balance']*100);
		$relation=serialize(array('oid'=>$oid));
		if(!$refund){
			$balance=-$balance;
		}
		insert('common_user_count_log',array('lid'=>$lid,'uid'=>$uid,'fild'=>'balance','arose'=>$balance,'title'=>$title,'relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
		DB::query("UPDATE ".DB::table('common_user_count')." SET `balance`=`balance`+'$balance' WHERE uid='$uid'");
	}
	if($pay['gold']>0){
		$lid=makeid();
		$gold=round($pay['gold'],2);
		$relation=serialize(array('oid'=>$oid));
		if(!$refund){
			$gold=-$gold;
		}
		insert('common_user_count_log',array('lid'=>$lid,'uid'=>$uid,'fild'=>'gold','arose'=>$gold,'title'=>$title,'relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
		DB::query("UPDATE ".DB::table('common_user_count')." SET `gold`=`gold`+'$gold' WHERE uid='$uid'");
	}
}

function upuser($cid,$uid){
	global $_S;
	C::chche('credits');
	$credit=$_S['cache']['credits'][$cid];
  
  
	if($credit){
		
		if($credit['cycle']==1){
			$count=DB::result_first("SELECT COUNT(*) FROM ".DB::table('common_user_count_log')." WHERE `uid`='$uid' AND cid='$cid'");
	
      if($count>0){
				return true;
			}
		}elseif($credit['cycle']==2){
			$logtime=strtotime(smsdate($_S['timestamp'],'Y-m-d'));

			$count=DB::result_first("SELECT COUNT(*) FROM ".DB::table('common_user_count_log')." WHERE `uid`='$uid' AND cid='$cid' AND `logtime`>'$logtime'");

      if($count>=$credit['rewardnum']){
				return true;
			}
		}
		
		if($credit['experience']){
			$lid=makeid();
			insert('common_user_count_log',array('lid'=>$lid,'uid'=>$uid,'cid'=>$cid,'fild'=>'experience','arose'=>$credit['experience'],'title'=>$credit['name'],'relation'=>'','state'=>'1','logtime'=>$_S['timestamp']),true);
			DB::query("UPDATE ".DB::table('common_user_count')." SET `experience`=`experience`+'$credit[experience]' WHERE uid='$uid'");
			
		}
		if($credit['gold']){
			$lid=makeid();
			insert('common_user_count_log',array('lid'=>$lid,'uid'=>$uid,'cid'=>$cid,'fild'=>'gold','arose'=>$credit['gold'],'title'=>$credit['name'],'relation'=>'','state'=>'1','logtime'=>$_S['timestamp']),true);
			DB::query("UPDATE ".DB::table('common_user_count')." SET `gold`=`gold`+'$credit[gold]' WHERE uid='$uid'");	
			
		}
	}
}

function getuser($item,$uid){
	global $_S;
	foreach($item as $i=> $table){
		$short[]=end(explode('_',$table));	
	}
	
	$sql['select'] = "SELECT $short[0].*";
	$sql['from'] ='FROM '.DB::table($item[0])." $short[0]";
	
	$wherearr[] = "$short[0].uid = '$uid'";

	foreach($item as $i=> $table){
		if($i>0){
			$sql['select'] .= ",$short[$i].*";
			$sql['left'] .=" LEFT JOIN ".DB::table($table)." $short[$i] ON $short[$i].uid=$short[0].uid ";
		}		
	}
	
	if(!empty($wherearr)) $sql['where'] = 'WHERE '.implode(' AND ', $wherearr);
	$sqlstring = $sql['select'].' '.$sql['from'].' '.$sql['left'].' '.$sql['where'];

	$user=DB::fetch_first($sqlstring);
	if($user['birthday']){
		$user['age']=smsdate($_S['timestamp'],'Y')-smsdate($user['birthday'],'Y');
	}
	if($user['gender']){
		$user['gender-text']=$user['gender']==1?'男':'女';
	}
	if($user['balance']){
		$user['balance']=$user['balance']/100;
	}
	$user['money']=$user['balance']+$user['gold'];

	return $user;
}

function upusergroup($uid,$groupid){
	global $_S;
	
	$groupid=$groupid?$groupid:$_S['member']['groupid'];
	$group=$_S['cache']['usergroup'][$groupid];
	
	$count=getuser(array('common_user_count'),$uid);
	if($group['type']=='member'){
		if($count['experience']>$group['creditshigher']){
			foreach($_S['cache']['usergroup'] as $value){
				if($value['type']=='member' && $value['gid']!=$groupid){
					if($count['experience']>=$value['creditslower']){
						$gid=$value['gid'];
					}
				}
			}		
		}elseif($count['experience']<$group['creditslower']){
			
			foreach($_S['cache']['usergroup'] as $value){
				if($value['type']=='member' && $value['gid']!=$groupid){
					
					if($count['experience']<$value['creditshigher']){
						$gid=$value['gid'];
					}
				}
			}	
		}
	}
	if($gid){
		update('common_user',array('groupid'=>$gid),"uid='$uid'");
	}
}

function back($btn){
	global $_SERVER,$backurl;
	
	if($_SERVER['HTTP_REFERER']){
		$back['back']='<a href="javascript:history.back(-1)" class="icon icon-back"></a>';
		$back['close']='<a href="javascript:SMS.closepage()" class="icon icon-close"></a>';
	}else{
		$back['back']='<a href="'.$backurl.'" class="icon icon-back load"></a>';
		$back['close']='<a href="'.$backurl.'" class="icon icon-close load"></a>';
	}
	echo $back[$btn];
}

function getimg($pic,$width,$height,$scaling=false,$showtype='echo'){
	global $_S;
  $img=$_S['atc'].'/'.$pic.'_'.$width.'_'.$height.'.jpg';

	if(!is_file(ROOT.$img)) {
		if($pic['width'] && $pic['height']){
			$fileinfo=array($pic['width'],$pic['height']);
		}else{
			$fileinfo=getimagesize(ROOT.$_S['atc'].'/'.$pic);
		}
		
		if($fileinfo){
			if($scaling){
				$w=$fileinfo[0]>$width?$width:$fileinfo[0];
				$h=$height=='9999'?round(($w/$fileinfo[0])*$fileinfo[1]):$height;
			}else{
				$h=$fileinfo[1]>$height?$height:$fileinfo[1];
				$w=$fileinfo[0]>$width?$width:$fileinfo[0];	
			}

			require_once './include/image.php';
			$image = new image;
			$thumb=$image->Thumb(ROOT.$_S['atc'].'/'.$pic,$pic.'_'.$width.'_'.$height.'.jpg',$w, $h, 'fixwr');		
			if($thumb){
				$return=$img;
			}else{
				$return=$_S['atc'].'/'.$pic;
			}

		}else{
			$return='ui/nopic.png';
		}
	}else{
		$return=$img;
	}
	if($showtype=='echo'){
		echo $return;
	}else{
		return $return;
	}
}

function getwebpic($src,$w,$h,$put,$m='echo'){
	global $_S;
	$filename=basename($src).'_'.$w.'_'.$h.'.jpg';
	if(count(basename($src))<6){
		$filename=md5($src).$filename;
	}
	$path=$put.'/'.substr($filename,0,1).'/'.substr($filename,1,1).'/'.$filename;
	if(!is_file(ROOT.$_S['atc'].'/'.$path)){
		require_once './include/image.php';
		$img = new image;
		if(!@getimagesize($src)){
			$src=$_S['setting']['siteurl'].'ui/nopic.jpg';
		}
		$thumb=$img->Thumb($src,$path,$w, $h, 'fixwr');
		if($thumb){
			$img= $_S['atc'].'/'.$path;
		}
	}else{
		$img= $_S['atc'].'/'.$path;
	}
	if($m=='echo'){
		echo $img;
	}else{
		return $img;
	}
}

function makelocal($url,$put,$full=true,$name=''){
	global $_S;
	
	$filename=$name?$name:basename($url);

	$dir=$_S['atc'].'/'.$put.'/'.smsdate($_S['timestamp'],'Ym').'/'.smsdate($_S['timestamp'],'d');
	

	makedir(ROOT.$dir);
	if(function_exists('curl_init')){
		$ch=curl_init(); 
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch,CURLOPT_FAILONERROR,1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		$img=curl_exec($ch); 
		$header=curl_getinfo($ch);
		if($header['http_code']!=200){
			$img=false;
		}
		curl_close($ch); 
	}else{
		ob_start();  
		@readfile($url); 
		$img=ob_get_contents();  
		ob_end_clean();
	}
	if($img){
		$fp2=@fopen(ROOT.$dir.'/'.$filename,'a');
		fwrite($fp2,$img); 
		fclose($fp2); 
		unset($img); 
		if($full){
			return $dir.'/'.$filename;
		}else{
			return $put.'/'.smsdate($_S['timestamp'],'Ym').'/'.smsdate($_S['timestamp'],'d').'/'.$filename;
		}
	}
}

function makedir($dir, $mode = 0777, $makeindex = TRUE){
	if(!is_dir($dir)) {
		makedir(dirname($dir), $mode, $makeindex);
		@mkdir($dir, $mode);
		if(!empty($makeindex)) {
			@touch($dir.'/index.html'); @chmod($dir.'/index.html', 0777);
		}
	}
	return true;
}



function sendnotice($touid,$type,$note,$id=0,$authorid=0,$author='',$wechat=''){
	global $_S;
	if($id){
		$notice=DB::fetch_first("SELECT * FROM ".DB::table('common_notice')." WHERE `type`='$type' AND `id`='$id' AND `uid`='$touid'");
		if($notice){
			if($notice['new']){
				DB::query("UPDATE ".DB::table('common_notice')." SET `nums`=`nums`+'1' WHERE nid='$notice[nid]'");
			}else{
				DB::query("UPDATE ".DB::table('common_notice')." SET `nums`='1',`new`='1' WHERE nid='$notice[nid]'");
			}
		}else{
			$nid=insert('common_notice',array('type'=>$type,'id'=>$id,'uid'=>$touid,'authorid'=>$authorid,'author'=>$author,'note'=>$note,'dateline'=>$_S['timestamp']));
		}
	}else{
		$nid=insert('common_notice',array('type'=>$type,'uid'=>$touid,'authorid'=>$authorid,'author'=>$author,'note'=>$note,'dateline'=>$_S['timestamp']));
	}
	
	DB::query("UPDATE ".DB::table('common_user')." SET `newnotice`=`newnotice`+'1' WHERE uid='$touid'");
	//wechat
	
	
}


/*
my:mod
*/
function getcurrentnav($nvs){
	//$_SERVER['QUERY_STRING']
	
	$get=$_GET;
	unset($get['load']);
	unset($get['get']);
	unset($get['iosurl']);	
	foreach($get as $k=>$v){

		$urlarrs[]=$k.'='.$v;
	}
	
	if($urlarrs){
		$urls=implode('&',$urlarrs);
	}
	$url=PHPSCRIPT.'.php'.($urls?'?'.$urls:'');
	$url=strtolower($url);

	//PHPSCRIPT
	foreach($nvs as $k=>$nv){
		$nv=strtolower($nv);
		if($nv==$url){
			$current[$k]='1';
		}else{
			if($find[$k]=strpos('+'.$url,$nv)){
				$current[$k]=strlen(str_replace($nv,'',$url));
			}else{
				$current[$k]='999';
			}
		}
	}
	$key=array_search(min($current),$current);
	return $key;
}

function getnavcurrent($url){

	if(strpos('+'.$url,PHPSCRIPT)==false){
    $class='c4';
	}else{
		if(PHPSCRIPT=='index'){
			
		}elseif(PHPSCRIPT=='hack'){
			
		}else{
			
		}
		if(strpos($url,'?')){
			$a=explode('?',$url);
			$b=explode('=',$a[1]);
			
			
			if($b[1]==$_GET[$b[0]]){
				$class="c1";
			}else{
				$class='c4';
			}
		}else{
			
			if(($_GET['mod']=='index' && $_GET['pid']==1) || ($_GET['mod']=='index' && !$_GET['pid'])){
				$class="c1";
			}else{
				$class='c4';
			}	
		}
		
	}
	return $class;
}
function upsetting(){
	$query = DB::query('SELECT * FROM '.DB::table('common_setting'));
	while($value = DB::fetch($query)) {
		$setting[$value['k']]=$value['v'];
	}
	$cache='$_S[\'setting\']='.var_export($setting,true);
	writefile(ROOT.'./data/cache/setting.php', $cache, 'php', 'w', 0);			
}

function page($nums,$perpage, $curpage,$url){
	global $_S;
	$maxpage=ceil($nums/$perpage);
	
	if($maxpage>1){
		if($curpage>1){
			$first='<a href="'.$url.'&page=1" class="first">1..</a>';
			$prev='<a href="'.$url.'&page='.($curpage-1).'" class="prev">上一页</a>';
		}
		if($curpage<$maxpage){
			$end='<a href="'.$url.'&page='.$maxpage.'" class="end">'.$maxpage.'..</a>';
			$next='<a href="'.$url.'&page='.($curpage+1).'" class="prev">下一页</a>';
		}
		
		if($curpage>5){
			$max=$curpage+4>$maxpage?$maxpage:$curpage+4;
			$star=$curpage-4;
		}else{
			$max=$maxpage>9?9:$maxpage;
			$star=1;
		}
		
		for($i=$star;$i<=$max;$i++){
			if($i==$curpage){
				$page .='<strong>'.$i.'</strong>';
			}else{
				$page .='<a href="'.$url.'&page='.$i.'">'.$i.'</a>';
			}
		}
		$pages='<div class="pages">'.$first.$prev.$page.$next.$end.'</div>';
		return $pages;
	}
	
}

function echovar($matches){
	global $_S;
	return $_S[$matches[1]];
}

function diconv($str, $in_charset, $out_charset = 'UTF-8', $ForceTable = FALSE) {
	global $_G;

	$in_charset = strtoupper($in_charset);
	$out_charset = strtoupper($out_charset);

	if(empty($str) || $in_charset == $out_charset) {
		return $str;
	}

	$out = '';

	if(!$ForceTable) {
		if(function_exists('iconv')) {
			$out = iconv($in_charset, $out_charset.'//IGNORE', $str);
		} elseif(function_exists('mb_convert_encoding')) {
			$out = mb_convert_encoding($str, $out_charset, $in_charset);
		}
	}

	if($out == '') {
		require_once 'include/chinese.php';
		$chinese = new Chinese($in_charset, $out_charset, true);
		$out = $chinese->Convert($str);
	}

	return $out;
}

function dfsockopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE, $encodetype  = 'URLENCODE', $allowcurl = TRUE, $position = 0, $files = array()) {
	require_once 'include/filesock.php';
	return _dfsockopen($url, $limit, $post, $cookie, $bysocket, $ip, $timeout, $block, $encodetype, $allowcurl, $position, $files);
}

function getredirect($redirect_uri,$type='snsapi_userinfo'){
	global $_S;
	$redirect = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$_S['setting']['wx_appid'].'&redirect_uri='.$redirect_uri.'&response_type=code&scope='.$type.'&state='.$_S['hash'].'#wechat_redirect';
	return $redirect;
}
function sendwxnotice($uid,$openid,$template_id,$url,$notice){
	global $_S;

	if($_S['wechat'] && $template_id){
		
		require_once './include/json.php';
		require_once './include/function_wechat.php';
		$access_token=getapival('access_token');
		
		if($access_token){
			if(!$openid){
				$openid=DB::result_first("SELECT `openid` FROM ".DB::table('common_user')." WHERE `uid`='$uid'");
				if(!$openid){
					return false;
				}
			}
			$post=array(
				'touser'=>$openid,
				'template_id'=>$template_id,
				'url'=>$url,
				'data'=>$notice
			);			
			$post=JSON::encode($post);
			
			postCurl($post,'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token);
		}
	}
}

function signature($type='sha1',$url=''){
	global $_S;
	if($_S['wechat']){
		if($_GET['iosurl']){
			$url=urldecode($_GET['iosurl']);
		}else{
			$url=$url?$url:getrequest();
		}
		require_once './include/json.php';
		require_once './include/function_wechat.php';
		$ticket=getapival();
		if($ticket){
			if($type=='sha1'){
				return sha1('jsapi_ticket='.$ticket.'&noncestr='.$_S['hash'].'&timestamp='.$_S['timestamp'].'&url='.$url);	
			}else{
				return 'jsapi_ticket='.$ticket.'&noncestr='.$_S['hash'].'&timestamp='.$_S['timestamp'].'&url='.$url;	
			}
		}		
	}
}

function getopenid(){
	global $_S;
	if($_S['uid'] && $_S['in_wechat'] && $_S['wechat'] && !$_S['member']['openid']){
		$_S['COOKIE']['wx_notoken']=getcookies('wx_notoken');
		$referer=referer();
		if($_S['COOKIE']['wx_notoken']){
			showmessage('微信绑定暂时无法使用请稍后再试',$referer);
		}else{
			$redirect=getredirect(urlencode($_S['setting']['siteurl'].'wechat.php?referer=').urlencode($referer),'snsapi_base');
			showmessage('微信支付功能需要绑定您的微信账号，是否前往绑定',$redirect);
		}
	}
}


function get_client_ip() {
	$ip = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
		foreach ($matches[0] AS $xip) {
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
				$ip = $xip;
				break;
			}
		}
	}
	return $ip == '::1' ? '127.0.0.1' : $ip;
}
function durlencode($url) {
	static $fix = array('%21', '%2A','%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
	static $replacements = array('!', '*', ';', ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
	return str_replace($fix, $replacements, urlencode($url));
}


function stringvar($string,$len='',$dot=''){
  global $_S;
	if($_S['setting']['sensitive']){
		$sensitives=explode(',',$_S['setting']['sensitive']);
		$string=str_replace($sensitives,'',$string);
	}
	if($len){
		return $string?cutstr(trim($string),$len,$dot):'';
	}else{
		return trim($string);
	}
}
function striptags($string,$smsot=true){
	global $_S;
  
	$string = stringvar($string);
	
	$string = preg_replace("/\<[h|H].*?\>(.+?)\<\/[h|H].*?\>/s", "[h=\\1]", $string);
	if($smsot){
		$string = preg_replace("/\<[img|IMG].*?src\=[\'|\"](.+?)[\'|\"].*?picid\=[\'|\"](.+?)[\'|\"].*?[\/]?>/s", "[img=\\2]\\1[/img]", $string);
	}
	$string = preg_replace("/\<[img|IMG].*?[src|SRC]\=[\'|\"](.+?)[\'|\"].*?[\/]?>/s", "[pic=\\1]", $string);
	$string = preg_replace("/\<[video|VIDEO].*?data\=[\'|\"](.+?)[\'|\"].*?[\/]?>\<\/video\>/s", "[video=\\1]", $string);
	$string = preg_replace(array("/\<[div|DIV].*?\>/s","/\<[p|P].*?\>/s","/\<[br|BR].*?\>/s","/\<\/[div|DIV].*?\>/s","/\<\/[p|P].*?\>/s"), array("","","\n","\n","\n"), $string);
	$string = strip_tags($string);
	$string = preg_replace(array("#\n\r+#","#\r\n+#","#\n+#"), "\n", $string);
	
	return $string;
}

function daddslashes($string){
	if(get_magic_quotes_gpc()){
		$string=$string;
	}else{
		$string = addslashes($string);
	}
	return trim($string);
}

function dserialize($string){
	return addslashes(serialize($string));
}
function puttitle($matches){
	$title='<h2>'.$matches[1].'</h2>';
	return $title;
}
function putimgs($matches){
	if(PHPSCRIPT=='get'){
		$img='<img src="'.$matches[2].'" picid="'.$matches[1].'" class="viewpic">';
	}else{
		$img='<img src="ui/sl.png" data-original="'.$matches[2].'" picid="'.$matches[1].'" class="viewpic lazyload">';
	}
	return $img;
}
function putpics($matches){
	if(PHPSCRIPT=='get'){
		$img='<img src="'.$matches[1].'" class="viewpic">';
	}else{
		$img='<img src="ui/sl.png" data-original="'.$matches[1].'" class="viewpic lazyload">';
	}
	return $img;
}

function putvideos($matches){
	global $_S;
  $video='<div class="video"><a href="'.$matches[1].'" class="icon icon-play playvideo"><img src="'.$matches[1].'?vframe/jpg/offset/'.$_S['setting']['qiniu_frame'].'" onerror="this.onerror=null;this.src=\'./ui/b.png\'"/></a></div>';
	return $video;
}

	
function putvideos_post($matches){
	global $_S;
  $video='<div class="video_form icon icon-play"><video data="'.$matches[1].'"></video></div><br>';
	return $video;
}

function getarraynewid($array,$idname=''){
	foreach($array as $id=>$value){
		if($idname){
			$ids[]=$value[$idname];
		}else{
			$ids[]=$id;
		}
	}
	return max($ids)+1;
}

function loaddiscuz(){
	global $_S;
	include_once ROOT.'./include/discuz/load.php';
};

function getdzuser($value,$type='username'){
	
	global $_S;

	$table_tel=$_S['cache']['discuz']['discuz_aliyun']['table'];
	$field_tel=$_S['cache']['discuz']['discuz_aliyun']['field'];
	$uid_tel=$_S['cache']['discuz']['discuz_aliyun']['uid']?$_S['cache']['discuz']['discuz_aliyun']['uid']:'uid';
	
	$table_wx=$_S['cache']['discuz']['discuz_wechat']['table'];
	$field_wx=$_S['cache']['discuz']['discuz_wechat']['field'];
	$uid_wx=$_S['cache']['discuz']['discuz_wechat']['uid']?$_S['cache']['discuz']['discuz_wechat']['uid']:'uid';
	
  if($type=='username' || $type=='uid'){
		$sql['select'] = 'SELECT m.*';
		$sql['from'] ='FROM '.DZ::table('ucenter_members').' m';		
	}
	if($table_wx && $field_wx){
		if($type=='openid'){
			$sql['select'] = "SELECT w.`$field_wx`";
			$sql['from'] ='FROM '.DZ::table($table_wx).' w';
			$wherearr[] = "w.`$field_wx` ='$value'";
			
			$sql['select'] .= ',m.*';
			$sql['left'] .=" LEFT JOIN ".DZ::table('ucenter_members')." m ON m.`uid`=w.`$uid_wx`";	
		}else{
			$sql['select'] .= ",w.`$field_wx`";
			$sql['left2'] .=" LEFT JOIN ".DZ::table($table_wx)." w ON w.`$uid_wx`=m.`uid`";
		}
	}else{
		if($type=='openid'){
			return false;
		}
	}
	if($table_tel && $field_tel){
    if($type=='tel'){
			$sql['select'] = "SELECT a.`$field_tel`";
			$sql['from'] ='FROM '.DZ::table($table_tel).' a';
			$wherearr[] = "a.`$field_tel` ='$value'";
			
			$sql['select'] .= ',m.*';
			$sql['left'] .=" LEFT JOIN ".DZ::table('ucenter_members')." m ON m.`uid`=a.`$uid_tel`";	
		}else{
			$sql['select'] .= ",a.`$field_tel`";
			$sql['left2'] .=" LEFT JOIN ".DZ::table($table_tel)." a ON a.`$uid_tel`=m.`uid`";						
		}
	}else{
		if($type=='tel'){
			return false;
		}
	}
  $sql['left'] .=$sql['left2'];
	
	$sql['select'] .= ',c.`credits`';
	$sql['left'] .=" LEFT JOIN ".DZ::table('common_member')." c ON c.`uid`=m.`uid`";	
	
	if($type=='username'){
		$wherearr[] = "m.`username` ='$value'";
	}elseif($type=='uid'){
		$wherearr[] = "m.`uid` ='$value'";
	}
  if(!empty($wherearr)) $sql['where'] = 'WHERE '.implode(' AND ', $wherearr);
	$sqlstring = $sql['select'].' '.$sql['from'].' '.$sql['left'].' '.$sql['where'];
  $dzuser=DZ::fetch_first($sqlstring);
	if($dzuser['uid']){
		return $dzuser;
	}else{
		if($dzuser[$field_tel]){
			$v=$dzuser[$field_tel];
			DZ::query("DELETE FROM ".DZ::table($table_tel)." WHERE `$field_tel`='$v'");
		}
		if($dzuser[$field_wx]){
			$v=$dzuser[$field_wx];
			DZ::query("DELETE FROM ".DZ::table($table_wx)." WHERE `$field_wx`='$v'");
		}
	}
}
function head($user,$size,$type='img',$s='smsot'){
	global $_S;
	if(is_array($user)){
		if($user['dzuid']){
			return avatar($user['dzuid'],$size,$type,'dz');
		}elseif($user['uid']){
			return avatar($user['uid'],$size,$type);
		}else{
			return $type=='img'?'<img src="./ui/avatar_'.$size.'.jpg" class="avatar" />':'./ui/avatar_'.$size.'.jpg';
		}
	}elseif(is_numeric($user)){
		if($s=='smsot'){
			return avatar($user,$size,$type);
		}else{
			return avatar($user,$size,$type,'dz');
		}
	}else{
		return $type=='img'?'<img src="./ui/anonymous_'.$size.'.jpg" class="avatar" />':'./ui/anonymous_'.$size.'.jpg';
	}
}
function avatar($uid,$size,$return='img',$type='smsot'){
	global $_S;

	if($type=='smsot'){
		$folder=array();
		$folder[0]=ceil($uid/1000000);
		$folder[1]=ceil($uid/10000);
		$folder[2]=ceil($uid/100);
		$avatar=$_S['atc'].'/avatar/'.$folder[0].'/'.$folder[1].'/'.$folder[2].'/'.$uid.'_'.$size.'.jpg';
		if($return=='img'){
			return '<img src="'.$avatar.'" class="avatar" onerror="this.onerror=null;this.src=\'./ui/avatar_'.$size.'.jpg\'" />';
		}else{
			if(is_file($avatar)){
				return $avatar;
			}else{
				return './ui/avatar_'.$size.'.jpg';
			}
			return $avatar;
		}
	}else{
		if(!$_S['cache']['discuz']){
			C::chche('discuz');
		}
		$uc=$_S['cache']['discuz']['discuz_common']['uc']?$_S['cache']['discuz']['discuz_common']['uc']:$_S['cache']['discuz']['discuz_common']['url'].'/uc_server/';
		$size=$size==1?'small':($size==2?'middle':'big');
		
		if($return=='img'){
			return '<img src="'.$uc.'avatar.php?uid='.$uid.'&size='.$size.'" class="avatar" onerror="this.onerror=null;this.src=\'./ui/avatar_'.$size.'.jpg\'" />';
		}else{
			return $uc.'avatar.php?uid='.$uid.'&size='.$size;
		}
	}		

}
function checkurl($url){
	if(substr($url,-1)=='/'){
		$url=substr($url, 0, -1);
	}
	if(!ereg("^(http|https)s?://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $url)){
		return false;
	}
	return true;
}
function checkmobile() {
	static $touchbrowser_list =array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
				'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
				'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
				'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
				'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
				'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
				'benq', 'haier', '^lct', '320x320', '240x320', '176x220', 'windows phone');
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(($v = dstrpos($useragent, $touchbrowser_list, true))){
		return true;
	}
}

function dstrpos($string, $arr, $returnvalue = false) {
	if(empty($string)) return false;
	foreach((array)$arr as $v) {
		if(strpos($string, $v) !== false) {
			$return = $returnvalue ? $v : true;
			return $return;
		}
	}
	return false;
}

function maketid($array){
	if($array[0]>$array[1]){
		return $array[0].$array[1];
	}else{
		return $array[1].$array[0];
	}
}

function smile($message){
	global $_S;
	
	foreach($_S['cache']['smiles'] as $smile){
		foreach($smile as $value){
			$smiles[$value['str']]='<img src="'.$value['pic'].'" class="smile">';
		}
	}

	$message=strtr($message,$smiles);
	return $message;
}


function dunserialize($data) {
	if(($ret = unserialize($data)) === false) {
		$ret = unserialize(stripslashes($data));
	}
	return $ret;
}
function dheader($string, $replace = true, $http_response_code = 0) {
	$islocation = substr(strtolower(trim($string)), 0, 8) == 'location';
	$string = str_replace(array("\r", "\n"), array('', ''), $string);
	if(empty($http_response_code) || PHP_VERSION < '4.3' ) {
		@header($string, $replace);
	} else {
		@header($string, $replace, $http_response_code);
	}
	if($islocation) {
		exit();
	}
}


function setcookies($var, $value = '', $life = 0, $prefix = 1, $httponly = false){

	global $_S;

	$config = $_S['config']['cookie'];

	$_S['cookie'][$var] = $value;
	$var = ($prefix==1 ? $config['cookiepre'] : $prefix).$var;
	$_COOKIE[$var] = $value;

	if($value == '' || $life < 0) {
		$value = '';
		$life = -1;
	}

	$life = $life > 0 ? $_S['timestamp'] + $life : ($life < 0 ? $_S['timestamp'] - 31536000 : 0);
	$path = $httponly && PHP_VERSION < '5.2.0' ? $config['cookiepath'].'; HttpOnly' : $config['cookiepath'];

	$secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	if(PHP_VERSION < '5.2.0') {
		setcookie($var, $value, $life, $path, $config['cookiedomain'], $secure);
	} else {
		setcookie($var, $value, $life, $path, $config['cookiedomain'], $secure, $httponly);
	}
	
}

function getcookies($key) {
	global $_S;
	$config = $_S['config']['cookie'];
	$cookieid = $config['cookiepre'] ? $config['cookiepre'].$key : $key;
	
	return isset($_COOKIE[$cookieid]) ? $_COOKIE[$cookieid] : '';
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	global $_S;
	
	$ckey_length = 4;
	$key = md5($key != '' ? $key : $_S['setting']['authkey']);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function checktel($phonenumber){
	if(preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^16[\d]{9}$|^17[0,3,6,7,8]{1}\d{8}$|^18[\d]{9}$|^19[\d]{9}$#',$phonenumber)){  
		return true;
	}else{  
		return false;
	} 
}

function checksmscode($lid,$code){
	global $_S;
	$log=DB::fetch_first("SELECT * FROM ".DB::table('common_sms_log')." WHERE lid='$lid'");
	if($log){
		$log['code']=dunserialize($log['code']);
		if($log['isuse']){
			showmessage('验证码已被使用');
		}elseif($log['dateline']<($_S['timestamp']-300)){
			showmessage('验证码已过期');
		}elseif($code!=$log['code']['number']){
			showmessage('验证码错误');
		}else{
			update('common_sms_log',array('isuse'=>1),"lid='$lid'");
			return true;
		}
	}else{
		showmessage('出现错误请重新获取验证码');
	}
}

function insert($table,$array,$ignore=false){
	foreach($array as $k=>$v){
		$filds[]='`'.$k.'`';
		$values[]='\''.$v.'\'';
	}
	$fildstr=implode(',',$filds);
	$valuestr=implode(',',$values);
	if($ignore){
		DB::query("INSERT IGNORE INTO ".DB::table($table)." ($fildstr) VALUES ($valuestr)");	
	}else{
		DB::query("INSERT INTO ".DB::table($table)." ($fildstr) VALUES ($valuestr)");	
	}
	return DB::insert_id();
}

function update($table,$array,$where,$replace=false){
	foreach($array as $k=>$v){
		$fs[]='`'.$k.'`';
		$vs[]='\''.$v.'\'';
		$filds[]= '`'.$k.'` = \''.$v.'\'';
	}
	$fstr=implode(',',$fs);
	$vstr=implode(',',$vs);
	$fildstr=implode(',',$filds);

	if($replace){
		DB::query("REPLACE INTO ".DB::table($table)." ($fstr) VALUES ($vstr)");
	}else{
		DB::query("UPDATE ".DB::table($table)." SET $fildstr WHERE $where");
	}
	
}

function select($sql,$where,$size,$type=1){
	global $_S;
	
	$cut=$_S['cut']?$_S['cut']:($_S['page']>1?($_S['page']-1)*$size:0);
	$sql['limit'] = 'LIMIT '.$cut.','.$size;
	
	if(!empty($where)) $sql['where'] = 'WHERE '.implode(' AND ', $where);
	$sqlstring = $sql['select'].' '.$sql['from'].' '.$sql['left'].' '.$sql['where'].' '.$sql['order'].' '.$sql['limit'];

	$num_sql='SELECT COUNT(*) '.$sql['from'].' '.$sql['left'].' '.$sql['where'];

	if($type==1){
		$listcount = DB::result_first($num_sql);
	}else{
		$listcount = DZ::result_first($num_sql);
	}
  
  return array($sqlstring,$listcount);
}

function makeid() {
	static $id = '';
	global $_S;
  $data = $_S['timestamp'];
  $data .= $_SERVER['REQUEST_TIME'];
  $data .= $_SERVER['HTTP_USER_AGENT'];
  $data .= $_SERVER['LOCAL_ADDR'];
  $data .= $_SERVER['LOCAL_PORT'];
  $data .= $_SERVER['REMOTE_ADDR'];
  $data .= $_SERVER['REMOTE_PORT'];
  $hash = strtoupper(hash('ripemd128', uniqid("", true) . $id . md5($data)));
  $id = substr($hash, 0, 8).substr($hash, 8, 4).substr($hash, 12, 4).substr($hash, 16, 4).substr($hash, 20, 12);
  return $id;
}

function smsdate($time,$s){
	 
	global $_S;
	
	$offset = $_S['member']['timeoffset'];
	$sysoffset = $_S['setting']['timeoffset'];
	$offset = $offset ? $offset : $sysoffset;
	$time = $time + $offset * 3600;
	$day=gmdate($s,$time);
	if($s=='w'){
		$week=array(
		  0=>'日',
			1=>'一',
			2=>'二',
			3=>'三',
			4=>'四',
			5=>'五',
			6=>'六',
		);
		$day=$week[$day];
	}
	return $day;	
}

function tplrefresh($tpldir, $tplfile, $cachefile, $file){
	
	if(@filemtime(ROOT.$tplfile)>@filemtime(ROOT.$cachefile)){
		require_once ROOT.'/include/template.php';
		$temp = new temp();
		$temp->template($tplfile, $tpldir, $file, $cachefile);
		return TRUE;
	}else{
		return FALSE;
	}
}

function temp($file,$ajax=true){
	global $_S,$jsonvar,$outback;
	if($_GET['get']=='json'){
		header('Content-type: application/json');
		echo($jsonvar);
	}else{
		if($_S['outback']){
			$outback='outback';
		}
		if(strpos($file, ':') !== false) {
			list($hack, $file) = explode(':', $file);
			$tpldir = './hack/'.$hack.'/temp';
			$hack_before='hack_'.$hack.'_';
		}elseif(defined('ADMIN')){ 
			$tpldir = './admin/temp';
			$hack_before='admin_';
		}else{
			$tpldir = './temp/'.$_S['temp']['dir'];
		}
		if(!$_S['mobile'] && !defined('ADMIN')){
			$tpldir=$tpldir.'/pc';
			if(!is_file(ROOT.$tpldir.'/'.$file.'.php')){
				$tpldir=str_replace('/pc', '', $tpldir);
			}else{
				$file_before='pc_';
			}
		}
		if($_GET['get']=='ajax' && $ajax){

			$tplfile = $tpldir.'/'.$file.'_ajax.php';
			$cachefile = './data/temp/'.$hack_before.str_replace('/', '_', $file_before.$file).'.ajax.tpl.php';	
		}else{
			$tplfile = $tpldir.'/'.$file.'.php';
			$cachefile = './data/temp/'.$hack_before.str_replace('/', '_', $file_before.$file).'.tpl.php';			
		}

		tplrefresh($tpldir, $tplfile, $cachefile, $file);
		return ROOT.$cachefile;		
	}

}


function error($message,$about){
	$error ='<h3>'.$message.'</h3>';
	$error .=$about?'<p>'.$about.'</p>':'';
	echo($error);
	die();
}

function cutstr($string, $length, $dot = ' ...') {
	global $_S;
	if(strlen($string) <= $length) {
		return $string;
	}
	$pre = chr(1);
	$end = chr(1);
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

	$strcut = '';
	if(strtolower($_S['char']) == 'utf-8') {
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
	} else {
		$_length = $length - 1;
		for($i = 0; $i < $length; $i++) {
			if(ord($string[$i]) <= 127) {
				$strcut .= $string[$i];
			} else if($i < $_length) {
				$strcut .= $string[$i].$string[++$i];
			}
		}
	}
	$strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	$pos = strrpos($strcut, chr(1));
	if($pos !== false) {
		$strcut = substr($strcut,0,$pos);
	}
	return $strcut.$dot;
}
function dstripslashes($string) {
	if(empty($string)) return $string;
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}

function dhtmlspecialchars($string, $flags = null) {
	global $_S;
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dhtmlspecialchars($val, $flags);
		}
	} else {
		if($flags === null) {
			$string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
			if(strpos($string, '&amp;#') !== false) {
				$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
			}
		} else {
			if(PHP_VERSION < '5.4.0') {
				$string = htmlspecialchars($string, $flags);
			} else {
				if(strtolower($_S['char']) == 'utf-8') {
					$charset = 'UTF-8';
				} else {
					$charset = 'ISO-8859-1';
				}
				$string = htmlspecialchars($string, $flags, $charset);
			}
		}
	}
	return $string;
}

function srealpath($path) {
	$path = str_replace('./', '', $path);
	if(DIRECTORY_SEPARATOR == '\\') {
		$path = str_replace('/', '\\', $path);
	} elseif(DIRECTORY_SEPARATOR == '/') {
		$path = str_replace('\\', '/', $path);
	}
	return $path;
}

function writefile($filename, $writetext, $filemod='text', $openmod='w', $eixt=1) {

	if(!@$fp = fopen($filename, $openmod)) {
		if($eixt) {
			exit('File :<br>'.srealpath($filename).'<br>Have no access to write!');
		} else {
			return false;
		}
	} else {
		$text = '';
		if($filemod == 'php') {
			$text = "<?php\r\n\r\n";
		}
		$text .= $writetext;
		if($filemod == 'php') {
			$text .= "\r\n\r\n?>";
		}
		flock($fp, 2);
		fwrite($fp, $text);
		fclose($fp);
		return true;
	}
}

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	if($numeric) {
		$hash = '';
	} else {
		$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		$length--;
	}
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

function upcss($cid=''){
	global $_S;
	C::chche('colors');
	if($cid){
		$color=$_S['cache']['colors'][$cid];
		$css=ROOT.'./data/cache/style_'.$color['cid'].'.css';
		$content = @implode('', file(ROOT.'./ui/style.css'));
		$content = preg_replace(array('/\s*([,;:\{\}])\s*/', '/[\t\n\r]/', '/\/\*.+?\*\//'), array('\\1', '',''), $content);
		foreach($color['setting'] as $id =>$val){
			$ids[]='['.$id.']';
			$vals[]=$val;
		}
		$content=str_replace($ids,$vals,$content);
		$fp = fopen($css, 'w');
		fwrite($fp, $content);
		fclose($fp);
	}else{
		
		foreach($_S['cache']['colors'] as $color){
			
			if($color['canuse']){
				
				$css=ROOT.'./data/cache/style_'.$color['cid'].'.css';
				$content = @implode('', file(ROOT.'./ui/style.css'));
				$content = preg_replace(array('/\s*([,;:\{\}])\s*/', '/[\t\n\r]/', '/\/\*.+?\*\//'), array('\\1', '',''), $content);
				foreach($color['setting'] as $id =>$val){
					$color['ids'][]='['.$id.']';
					$color['vals'][]=$val;
				}
				$content=str_replace($color['ids'],$color['vals'],$content);
				$fp = fopen($css, 'w');
				fwrite($fp, $content);
				fclose($fp);
			}
		}		
	}
}
function loadcss() {
	global $_S;
	$styleid=$_S['member']['style']?$_S['member']['style']:$_S['setting']['default_style'];

	if(is_file(ROOT.'./data/cache/style_'.$styleid.'.css')){
		echo '<link rel="stylesheet" id="stylecss" type="text/css" href="data/cache/style_'.$styleid.'.css?'.$_S['hash'].'" />';
	}else{
		C::chche('colors');

		if($_S['cache']['colors'][$styleid]['canuse']){
			
			$css=ROOT.'./data/cache/style_'.$styleid.'.css';
			$content = @implode('', file(ROOT.'./ui/style.css'));
			$content = preg_replace(array('/\s*([,;:\{\}])\s*/', '/[\t\n\r]/', '/\/\*.+?\*\//'), array('\\1', '',''), $content);
			foreach($_S['cache']['colors'][$styleid]['setting'] as $id =>$val){
				$ids[]='['.$id.']';
				$vals[]=$val;
			}
			$content=str_replace($ids,$vals,$content);
			$fp = fopen($css, 'w');
			fwrite($fp, $content);
			fclose($fp);
			echo '<link rel="stylesheet" id="stylecss" type="text/css" href="data/cache/style_'.$styleid.'.css?'.$_S['hash'].'" />';			
		}			
	}
	if(!$_S['mobile']){
		echo '<link rel="stylesheet" id="stylecss" type="text/css" href="ui/pc.css?'.$_S['hash'].'" />';
	}	
}

function showmessage($message,$url='',$param=array()){
	global $_S;
	
	$default=$param['default']?$param['default']:'取消';
	$primary=$param['primary']?$param['primary']:'确定';
	
	if($_S['showmessage']){
			include temp($_S['showmessage'].':showmessage');
			exit;
	}else{
		if(!defined('ADMIN') || $_GET['iframe']){
			include temp('showmessage',false);
			exit;
		}		
	}

}
function distance($lat1, $lng1, $lat2, $lng2){   
  $earthRadius = 6367000;  
	$lat1 = ($lat1 * pi() ) / 180;   
	$lng1 = ($lng1 * pi() ) / 180;   
	$lat2 = ($lat2 * pi() ) / 180;   
	$lng2 = ($lng2 * pi() ) / 180;   
	$calcLongitude = $lng2 - $lng1;   
	$calcLatitude = $lat2 - $lat1;   
	$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);   
	$stepTwo = 2 * asin(min(1, sqrt($stepOne)));   
	$calculatedDistance = round($earthRadius * $stepTwo);
	if($calculatedDistance>1000){
		$calculatedDistance=round(($calculatedDistance/1000),'1').'km';
	}else{
		$calculatedDistance=$calculatedDistance.'m';
	}
	return $calculatedDistance;   
}  

function referer($default=''){
	global $_S;
	$default = empty($default) && $_ENV['curapp'] ? $_ENV['curapp'].'.php' : '';
	$referer = !empty($_GET['referer']) ? $_GET['referer'] : $_SERVER['HTTP_REFERER'];
	$referer = substr($referer, -1) == '?' ? substr($referer, 0, -1) : $referer;
	if(strpos($referer, 'member.php') || strpos($referer, 'wechat.php')) {
		$referer = $default;
	}
	$reurl = parse_url($referer);
	if(!$reurl['path']) {
		$referer = 'index.php';
	}

	if(empty($reurl['host'])) {
		$referer = $_S['setting']['siteurl'].$referer;
	}
	$referer = durlencode($referer);
	return $referer;
}


function getrequest(){
	/*
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$request=$protocol.$_SERVER['HTTP_HOST'].($_SERVER['SCRIPT_NAME']?$_SERVER['SCRIPT_NAME']:$_SERVER['PHP_SELF']);
	//mini

	if($_GET){
		unset($_GET['load']);
		unset($_GET['mod']);
		unset($_GET['pid']);
		
		$urlstr='?';
		foreach($_GET as $k=>$n){
			$str[]=$k.'='.$n;
		}		
	}
	$urlstr .=implode('&',$str);
	$request=$request.$urlstr;

	return $request;
	*/
	
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$request=str_replace(array('?load=true','&load=true'), '', $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	if(!strpos($request,".php")){
		$request=$request.'index.php';
	}
	return $request;
	
}

function runquery($sql) {
	global $_S;

	if(!isset($sql) || empty($sql)) return;
	$sql = str_replace("\r", "\n", str_replace(' sms_', ' '.$_S['db']['1']['pre'], $sql));
	$sql = str_replace("\r", "\n", str_replace(' `sms_', ' `'.$_S['db']['1']['pre'], $sql));
	$ret = array();
	$num = 0;
	foreach(explode(";\n", trim($sql)) as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
		}
		$num++;
	}
	unset($sql);

	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE `([a-z0-9_]+)` .*/is", "\\1", $query);
				DB::query(createtable($query, DB::version()));
			} else {
				DB::query($query);
			}
		}
	}
}

function createtable($sql, $dbver) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP', 'MEMORY')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
	($dbver > '4.1' ? " ENGINE=$type DEFAULT CHARSET=utf8" : " TYPE=$type");
}

function postCurl($post,$url,$second=30){	
  
	$ch = curl_init();
	curl_setopt($ch, CURLOP_TIMEOUT, $second);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$data = curl_exec($ch);
	curl_close($ch);
	if($data){
		curl_close($ch);
		return $data;
	}else {
		curl_close($ch);
		return false;
	}
}
function get_urlcontent($url){
	if (function_exists('curl_init')) {
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl_handle, CURLOPT_FAILONERROR,1);
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
		$file_content = curl_exec($curl_handle);
		curl_close($curl_handle);
	} elseif (function_exists('file_get_contents')) {
		$file_content = @file_get_contents($url);
	} elseif (ini_get('allow_url_fopen') && ($file = @fopen($url, 'rb'))){
		$i = 0;
		while (!feof($file) && $i++ < 1000) {
		$file_content .= strtolower(fread($file, 4096));
		}
		fclose($file);	
	} else {
		$file_content = '';
	}
	return $file_content;
}


?>