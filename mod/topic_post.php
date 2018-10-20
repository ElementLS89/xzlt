<?php
if(!defined('IN_SMSOT')) {
	exit;
}
if($_GET['vid']){
	$backurl='topic.php?vid='.$_GET['vid'];
	$theme=getthemecontent($_GET['vid'],'post');
	if(!$theme){
		showmessage('帖子不存在');
	}
	$tid=$theme['tid'];
	$navtitle='编辑';
}else{
	$navtitle='发表';
	$backurl=$_GET['tid']?'topic.php?tid='.$_GET['tid']:'user.php';
	$tid=$_GET['tid'];
}

if(!$_S['usergroup']['allowaddtheme']){
	if(!$_S['member']['uid']){
		showmessage('您需要登录后才能继续操作','member.php');
	}else{
		showmessage('您所在用户组无法发表帖子');
	}
}
if($_S['setting']['sms_need'] && !$_S['member']['tel']){
	showmessage('您需要绑定手机号之后才能进行下面的操作','my.php?mod=profile&show=3');
}
$_S['outback']=true;
$title=$navtitle.'-'.$_S['setting']['sitename'];

if($tid){
	$topic=DB::fetch_first("SELECT t.*,u.uid,u.level,u.experience FROM ".DB::table('topic')." t LEFT JOIN ".DB::table('topic_users')." u ON u.tid=t.tid AND u.uid='$_S[uid]' WHERE t.`tid`='$tid'");
	if(!$topic){
		showmessage('话题不存在');
	}
	$canmanage=getpower($topic);
	$topic['types']=dunserialize($topic['types']);
	if(!$topic['addtheme'] && !$topic['level'] && !$canmanage){
		if($topic['level']==''){
			showmessage('只有加入本话题的成员才能发帖');
		}else{
			showmessage('您的申请还未被通过，请耐心等待');
		}
	}
}else{
	$canmanage=$_S['usergroup']['power']>5?true:false;
}
if($_GET['vid']){
	if($theme['uid']!=$_S['uid'] && !$canmanage){
		showmessage('你没有权限进行此操作');
	}
}
require_once './include/upimg.php';

$signature=signature();
$apilist='openLocation,getLocation,chooseImage,uploadImage,downloadImage';

/*begin*/
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
if($_S['qiniu']){
	require_once './sdk/Qiniu/autoload.php';

	$accessKey = $_S['setting']['qiniu_ak'];
	$secretKey = $_S['setting']['qiniu_sk'];
	$auth = new Auth($accessKey, $secretKey);
	$bucket = $_S['setting']['qiniu_bucket'];
	
	$Mp4Fop = "avthumb/mp4/s/".$_S['setting']['qiniu_resolution']."/autoscale/1|saveas/".\Qiniu\base64_urlSafeEncode($bucket.":$(key).mp4");
	$JpgFop = "vframe/jpg/offset/".$_S['setting']['qiniu_frame']."|saveas/".\Qiniu\base64_urlSafeEncode($bucket.":$(key).jpg");
	
	$policy = array(
	  'persistentOps' => $Mp4Fop.";".$JpgFop,
		'persistentPipeline' => $_S['setting']['qiniu_pipeline'],
		'callbackBody' => '{"key":"$(key)"}',
		'callbackBodyType' => 'application/json'
	);
	$token = $auth->uploadToken($bucket, null, 3600, $policy);	
}

/*end*/
if(checksubmit('submit')){
	
  $c['content']=striptags($_GET['content']);
	if($_S['setting']['freetitle']){
		$s['subject']=$e['subject']=$_GET['subject']?stringvar($_GET['subject'],60):stringvar(strip_tags($_GET['content']),60);
	}else{
		$s['subject']=$e['subject']=stringvar($_GET['subject'],60);
	}
	$s['abstract']=$e['abstract']=stringvar(strip_tags($_GET['content']),80);
	
	$s['tid']=$tid;
	$s['price']=$e['price']=abs(intval($_GET['price']));
	$s['typeid']=$e['typeid']=$_GET['typeid'];
	$s['uid']=$theme?$theme['uid']:$_S['uid'];
	$s['lbs']=$e['lbs']=$_GET['lbs'];
	$s['dateline']=$_S['timestamp'];
	$s['top']=$_S['usergroup']['examinetheme'] && $s['tid'] ?-1:0;
  
	$illustration=preg_match_all("/\<[img|IMG].*?picid\=[\'|\"](.+?)[\'|\"].*?[\/]?>/s",$_GET['content'],$match_pic);
	$video=preg_match_all("/\<[video|VIDEO].*?data\=[\'|\"](.+?)[\'|\"].*?[\/]?>\<\/video\>/s",$_GET['content'],$match_video);
	

	if($topic['types'] && !$s['typeid']){
		showmessage('请选择话题分类');
	}
  if(strlen($s['subject'])<10){
		showmessage('标题或内容不能少于10个字节（5个汉字）');
	}	
	if($s['price'] && (!$_S['wxpay'] || !$_S['usergroup']['allowsetprice'])){
		showmessage('您不能发布付费阅读');
	}	
	
	if($theme){
		$vid=$theme['vid'];
		update('topic_themes',$e,"vid='$vid'");
		update('topic_theme_content',$c,"vid='$vid'");
	}else{
		$vid=insert('topic_themes',$s);
		
		if(!$vid){
			showmessage('帖子发布失败');
		}
		upuser(5,$_S['uid']);
		insert('topic_theme_content',array('vid'=>$vid,'content'=>$c['content']));
		if($_GET['tid']){
			$count['themes']=$topic['themes']+1;
			if(smsdate($_S['timestamp'],'Ymd')>smsdate($topic['lastadd'],'Ymd')){
				$count['today']=1;
			}else{
				$count['today']=$topic['today']+1;
			}
			$count['lastadd']=$_S['timestamp'];
			update('topic',$count,"tid='$_GET[tid]'");
			upuserlevel($topic,5);
		}
	}
	/*video*/
	if($video){
		$video=str_replace($_S['atc'].'/','',$match_video[1][0]);
		$media['video']=$video;
	}elseif(!$video && $theme['video']){
		$media['video']='';
	}
	/*imgs*/
	$table='topic_atc_'.substr($vid,-1);
	if($_GET['pics']){
		foreach($_GET['pics']['filename'] as $k=>$name){
			$atc['vid']=$vid;
			$atc['uid']=$_S['uid'];
			$atc['dateline']=$_S['timestamp'];
			$atc['filename']=$name;
			$atc['filesize']=$_GET['pics']['filesize'][$k];
			$atc['atc']=$_GET['pics']['atc'][$k];
			$atc['isimage']=1;
			$atc['width']=$_GET['pics']['width'][$k];
			$atc['height']=$_GET['pics']['height'][$k];
			$atc['thumb']=$_GET['pics']['thumb'][$k];
			$aid=insert($table,$atc);
			$images[$aid]=array('atc'=>$atc['atc'],'thumb'=>$atc['thumb'],'width'=>$atc['width'],'height'=>$atc['height']);
		}
	}
	if($_GET['deleteimg']){
		$aids=implode(',',$_GET['deleteimg']);
		DB::query("DELETE FROM ".DB::table($table)." WHERE aid IN($aids)");
		foreach($_GET['deleteimg'] as $deleteaid){
			unset($theme['images'][$deleteaid]);
		}
	}
	
	
	if($images || $_GET['deleteimg']){
		if($images){
			$images=$theme['images']?array_merge($theme['images'],$images):$images;
		}else{
			$images=$theme['images'];
		}
	}
	if($images){
		$imgs=array_slice($images,0,9);
	}elseif(!$images && $illustration){
    $picids=implode(',',$match_pic[1]);
		$query = DB::query("SELECT * FROM ".DB::table('topic_illustration')." WHERE `picid` IN($picids)");
		while($value = DB::fetch($query)) {
			$allillustrations[$value['picid']]=$value;
		}
		$imgs=array_slice($allillustrations,0,9);
	}

	if($imgs){
		$media['imgs']=serialize($imgs);
	}
	/*media*/
	if($media){
		update('topic_themes',$media,"vid='$vid'");
	}
	
  /*record*/
	$record=array();
	$record['mod']='topic';
	$record['vid']=$vid;
	$record['uid']=$theme['uid']?$theme['uid']:$_S['uid'];
	$record['subject']=$s['subject'];
	$record['abstract']=$s['abstract'];
	$record['pics']=$media['imgs'];
	$record['video']=$media['video'];
	
	if(!$_GET['vid']){
		$record['url']='topic.php?vid='.$vid;
		$record['dateline']=$_S['timestamp'];		
	}
	
	
	if($_GET['vid']){
		update('common_record',$record,"`mod`='topic' AND `vid`='$vid'");
		showmessage('编辑成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){topic.updatetheme(\''.$vid.'\',\''.$s['subject'].'\')},500)'));
	}else{
		$liststype=$topic?($topic['liststype']?$topic['liststype']:'1'):'2';
		insert('common_record',$record);
		$lm='<a href="topic.php?vid='.$vid.'" class="load">'.$s['subject'].'</a>';
		update('common_user',array('lm'=>$lm),"`uid`='$_S[uid]'");
    showmessage('发布成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){topic.addtheme(\''.$vid.'\',\''.$liststype.'\',\''.$_GET['tid'].'\')},500)'));
	}
}


include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>