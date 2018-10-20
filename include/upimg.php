<?php
if(!defined('IN_SMSOT')) {
	exit;
}
require_once './include/upload.php';
require_once './include/image.php';

function upload_img($file,$type,$width='600', $height='9999',$max=10240,$thumb=''){
	global $_S;
  
	$file['size'] > ($max * 1024) && showmessage('图片尺寸不能超过'.$max.'KB');
	
	$upload = new upload();
	
	$file['ext'] = $upload->fileext($file['name']);
	!$upload->is_image_ext($file['ext']) && showmessage('上传的不是图片');
	
	$upload->type = upload::check_dir_type($type);
	$upload->extid = makeid();
	$upload->init($file,$type, $upload->extid);
	
	if(!$upload->save()) {
		showmessage($upload->errormessage());
	}
	if($upload->attach['imageinfo'][0] > $width || $upload->attach['imageinfo'][1] > $height){
		$makethumb=true;
	}
	if($_S['setting']['watermarkstatus'] && $upload->attach['imageinfo'][0]>=$_S['setting']['watermarkminwidth'] && $upload->attach['imageinfo'][1]>=$_S['setting']['watermarkminheight']){
		$makewater=true;
	}
  if($makethumb || $makewater){
		$img = new image;
		if($makewater){
			$img->Watermark($_S['atc'].'/'.$upload->attach['attachment']);
		}
		if($makethumb){
			$w=$upload->attach['imageinfo'][0]>$width?$width:$upload->attach['imageinfo'][0];
			$h=$height=='9999'?round(($w/$upload->attach['imageinfo'][0])*$upload->attach['imageinfo'][1]):$height;
			
			if($thumb){
				if(strpos('+'.$thumb,'.')){
					$dot='';
				}else{
					$dot='_';
				}
			}else{
				$dot='_';
			}
			$thumbname=$thumb?$thumb:$width.'_'.$height;
			$upload->attach['thumb']=$img->Thumb($upload->attach['target'],$upload->attach['attachment'].$dot.$thumbname.'.jpg',$w, $h, 'fixwr');					
		}
	}
	return $upload->attach;
}
?>