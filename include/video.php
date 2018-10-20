<?php
if(!defined('IN_SMSOT')) {
	exit;
}
require_once './include/upload.php';

function upload_video($file,$type){
	global $_S;
  
	//$file['size'] > ($max * 1024) && showmessage('图片尺寸不能超过'.$max.'KB');
	$upload = new upload();
	$file['ext'] = $upload->fileext($file['name']);
	//!$upload->is_image_ext($file['ext']) && showmessage('上传的不是图片');
	
	$upload->type = upload::check_dir_type($type);
	$upload->extid = makeid();
	$upload->init($file,$type, $upload->extid);
  
  
	if(!$upload->save()) {
		showmessage($upload->errormessage());
	}
	return $upload->attach;
}

?>