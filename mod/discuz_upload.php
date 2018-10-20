<?php
if(!$_S['myid']){
	showmessage('错误的操作');
}
if(checksubmit('submit')){
	if($_GET['uptype']=='video'){
		require_once './include/video.php';
	}elseif($_GET['uptype']=='img'){
		require_once './include/upimg.php';
	}
  $name=$_GET['item']=='illustration'?'illustration':'pic';
	if($_FILES[$name]['name']){
		$pic = upload_img($_FILES[$name],'discuz','640','9999','10240','.thumb');
		if($pic){
			require_once './include/json.php';
			$atc['uid']=$_S['myid'];
			$atc['dateline']=$_S['timestamp'];
			$atc['filename']=$pic['name'];
			$atc['filesize']=$pic['size'];
			$atc['attachment']=$pic['attachment'];
			$atc['remote']='2';
			$atc['isimage']='1';
			$atc['width']=$pic['imageinfo']['0'];
			$atc['thumb']=$pic['thumb']?'1':'0';

      $atc['aid']=getattachnewaid($_S['myid']);
			dzinsert('forum_attachment_unused',$atc);
			if($_GET['item']=='illustration'){
				$code='[attach]'.$atc['aid'].'[/attach]';
				showmessage('上传成功','',array('type'=>'toast','fun'=>'smsot.editor(\''.$code.'\');discuz.insertpic(\''.$atc['aid'].'\')'));		
			}else{
				$return['src']=$_S['atc'].'/'.$pic['attachment'].($pic['thumb']?'.thumb.jpg':'');
				$return['aid']=$atc['aid'];
				$return=JSON::encode($return);
				showmessage('','',array('type'=>'toast','fun'=>'smsot.uploads(\''.$return.'\',\'dz\')'));						
			}
		}else{
			showmessage('图片上传失败');		
		}
	}
	
}

function getattachnewaid($uid = 0) {
	global $_S;
	$uid = !$uid ? $_S['myid'] : $uid;
	return dzinsert('forum_attachment',array('tid' => 0, 'pid' => 0, 'uid' => $uid, 'tableid' => 127));
}


?>