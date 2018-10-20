<?php
define('PHPSCRIPT', 'upload');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';

$S = new S();
$S -> star();

if(!$_S['uid']){
	showmessage('错误的操作');
}
if(checksubmit('submit')){
	if($_GET['uptype']=='video'){
		require_once './include/video.php';
	}elseif($_GET['uptype']=='img'){
		require_once './include/upimg.php';
	}
	if($_GET['hackid']){
		if($_FILES['illustration']['name']){
			$pic = upload_img($_FILES['illustration'],$_GET['hackid'],'640','9999','10240','thumb');
			if($pic){
				$illustration=$_S['atc'].'/'.$pic['attachment'].($pic['thumb']?'_thumb.jpg':'');
				$picid=insert('common_illustration',array('uid'=>$_S['uid'],'atc'=>$pic['attachment'],'thumb'=>$pic['thumb'],'width'=>$pic['imageinfo']['0'],'height'=>$pic['imageinfo']['1'],'dateline'=>$_S['timestamp']));
				$code='<img src="'.$illustration.'" picid="'.$picid.'">';
				showmessage('上传成功','',array('type'=>'toast','fun'=>'smsot.editor(\''.$code.'\')'));		
			}else{
				showmessage('图片上传失败');		
			}
		}elseif($_FILES['pic']['name']){
			$pic = upload_img($_FILES['pic'],$_GET['hackid'],'640','9999','10240','thumb');
			if($pic){
				require_once './include/json.php';
				$atc['filename']=$pic['name'];
				$atc['filesize']=$pic['size'];
				$atc['atc']=$pic['attachment'];
				$atc['width']=$pic['imageinfo']['0'];
				$atc['height']=$pic['imageinfo']['1'];
				$atc['thumb']=$pic['thumb']?'1':'0';
				$atc['src']=$_S['atc'].'/'.$pic['attachment'].($pic['thumb']?'_thumb.jpg':'');
				
				$atc=JSON::encode($atc);
				showmessage('','',array('type'=>'toast','fun'=>'smsot.uploads(\''.$atc.'\',\'\')'));		
			}else{
				showmessage('图片上传失败');		
			}
		}else{
			require_once './hack/'.$_GET['hackid'].'/upload.php';
		}
	}else{
		switch ($_GET['item']){
			case 'avatar':
				if($_FILES['avatar']){
					require_once './include/upload.php';
					require_once './include/image.php';
					
					$file=$_FILES['avatar'];
					$upload = new upload();
					$file['ext'] = $upload->fileext($file['name']);
					!$upload->is_image_ext($file['ext']) && showmessage('上传的不是图片');
					
					$upload->type = 'avatar';
					$upload->extid = $_S['uid'];
				
					$upload->init($file,$upload->type, $upload->extid);
					
					if(!$upload->save()) {
						showmessage($upload->errormessage());
					}
					
					$img = new image;
				
					$folder=array();
					$folder[0]=ceil($_S['uid']/1000000);
					$folder[1]=ceil($_S['uid']/10000);
					$folder[2]=ceil($_S['uid']/100);
					
					$avatar='avatar/'.$folder[0].'/'.$folder[1].'/'.$folder[2].'/'.$_S['uid'];
					
					$img->Thumb($upload->attach['target'],$avatar.'_1.jpg',64, 64, 'fixwr');
					$img->Thumb($upload->attach['target'],$avatar.'_2.jpg',96, 96, 'fixwr');
					$img->Thumb($upload->attach['target'],$avatar.'_3.jpg',200, 200, 'fixwr');
					upuser(10,$_S['uid']);
					
					if($_S['dz'] && $_S['member']['dzuid']){
						$head=$_S['setting']['siteurl'].$_S['atc'].'/'.$avatar.'_3.jpg';
						require_once './include/json.php';
						if(!$_S['cache']['discuz_common']){
							require_once './include/discuz/function.php';
							C::chche('discuz_common');
						}
						$post=array(
						  'head'=>$head,
							'uid'=>$_S['member']['dzuid'],
							'key'=>$_S['cache']['discuz_common']['authkey']
						);
            get_urlcontent($_S['cache']['discuz']['discuz_common']['url'].'plugin.php?id=cis_smsot&head='.urlencode($head).'&uid='.$_S['member']['dzuid'].'&key='.$_S['cache']['discuz_common']['authkey']);
					}
					showmessage('上传成功','',array('type'=>'toast','fun'=>'smsot.reloadavatar(\''.$_S['atc'].'/'.$avatar.'\',\''.$_S['uid'].'\')'));
				}
				break;
			case 'cover':
				if($_FILES['cover']['name']){
					ajaxupload('cover','topic',140,140);
				}
				break;
			case 'banner':
				if($_FILES['banner']['name']){
					ajaxupload('banner','topic',640,320);
				}
				break;
			case 'illustration':
				if($_FILES['illustration']['name']){
					$pic = upload_img($_FILES['illustration'],'topic','640','9999','10240','thumb');
					if($pic){
						$illustration=$_S['atc'].'/'.$pic['attachment'].($pic['thumb']?'_thumb.jpg':'');
						$picid=insert('topic_illustration',array('uid'=>$_S['uid'],'atc'=>$pic['attachment'],'thumb'=>$pic['thumb'],'width'=>$pic['imageinfo']['0'],'height'=>$pic['imageinfo']['1'],'dateline'=>$_S['timestamp']));
						$code='<img src="'.$illustration.'" picid="'.$picid.'">';
						showmessage('上传成功','',array('type'=>'toast','fun'=>'smsot.editor(\''.$code.'\')'));		
					}else{
						showmessage('图片上传失败');		
					}
				}
				
				break;
			case 'video':
			  if($_FILES['video']['name']){
					$video = upload_video($_FILES['video'],'topic');
					if($video){
						$videoid=insert('topic_video',array('uid'=>$_S['uid'],'video'=>$video['attachment'],'dateline'=>$_S['timestamp']));
						$code='<video src="'.$_S['atc'].'/'.$video['attachment'].'" controls="controls" id="'.$videoid.'"></video>';
						showmessage('上传成功','',array('type'=>'toast','fun'=>'smsot.editor(\''.$code.'\')'));								
					}else{
						showmessage('上传失败');
					}
				}
				break;
			case 'space':
				
				
				break;
			case 'theme':
				if($_FILES['pic']['name']){
					$pic = upload_img($_FILES['pic'],'topic','640','9999','10240','thumb');
					if($pic){
						require_once './include/json.php';
						$atc['filename']=$pic['name'];
						$atc['filesize']=$pic['size'];
						$atc['atc']=$pic['attachment'];
						$atc['width']=$pic['imageinfo']['0'];
						$atc['height']=$pic['imageinfo']['1'];
						$atc['thumb']=$pic['thumb']?'1':'0';
						$atc['src']=$_S['atc'].'/'.$pic['attachment'].($pic['thumb']?'_thumb.jpg':'');
						
						$atc=JSON::encode($atc);
						showmessage('','',array('type'=>'toast','fun'=>'smsot.uploads(\''.$atc.'\')'));		
					}else{
						showmessage('图片上传失败');		
					}
				}
				break;
		}
	}
}
?>