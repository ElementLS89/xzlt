<?php
function cn_row_substr($str,$row = 1,$number = 10,$suffix = true){  
	$result = array();  
	for ($r=1;$r<=$row;$r++){  
		$result[$r] = '';  
	}  
	$str = trim($str);  
	if(!$str) return $result;  

	$theStrlen = strlen($str);  

	//每行实际字节长度  
	$oneRowNum = $number * 3;  
	for($r=1;$r<=$row;$r++){  
		if($r == $row and $theStrlen > $r * $oneRowNum and $suffix){  
			$result[$r] = mg_cn_substr($str,$oneRowNum-6,($r-1)* $oneRowNum).'...';  
		}else{  
			$result[$r] = mg_cn_substr($str,$oneRowNum,($r-1)* $oneRowNum);  
		}  
		if($theStrlen < $r * $oneRowNum) break;  
	}  

	return $result;  
}  

function mg_cn_substr($str,$len,$start = 0){  
	$q_str = '';  
	$q_strlen = ($start + $len)>strlen($str) ? strlen($str) : ($start + $len);  

	if($start and json_encode(substr($str,$start,1)) === false){  
		for($a=0;$a<3;$a++){  
			$new_start = $start + $a;  
			$m_str = substr($str,$new_start,3);  
			if(json_encode($m_str) !== false) {  
				$start = $new_start;  
				break;  
			}  
		}  
	}  
	for($i=$start;$i<$q_strlen;$i++){  
		if(ord(substr($str,$i,1))>0xa0){  
			$q_str .= substr($str,$i,3);  
			$i+=2;  
		}else{  
			$q_str .= substr($str,$i,1);  
		}  
	}  
	return $q_str;  
} 


function createImageFromFile($file,$pic=''){  
  $pic=$pic?$pic:$file;
	$fileSuffix =addslashes(strtolower(substr(strrchr($pic, '.'), 1, 10)));
	if(!$fileSuffix) return false;
	
	switch ($fileSuffix){  
		case 'jpeg':  
			$theImage = @imagecreatefromjpeg($file);  
			break;  
		case 'jpg':  
			$theImage = @imagecreatefromjpeg($file);  
			break;  
		case 'png':  
			$theImage = @imagecreatefrompng($file);  
			break;  
		case 'gif':  
			$theImage = @imagecreatefromgif($file);  
			break;  
		default:  
			$theImage = @imagecreatefromstring(file_get_contents($file));  
			break;  
	}  
	return $theImage;  
}

function creatposter($date,$api='',$all=''){
	global $_S;
	if($all){
		require_once './hack/'.$api.'/poster.php';
	}else{
		$im = imagecreatetruecolor(640, 1024);
		$bg = imagecolorallocate($im, 255, 255, 255);  
		imagefill($im, 0, 0, $bg);  
		$font_file = "./ui/font/msyh.ttc";	
		
	
		$date['title']=$date['title']?$date['title']:$_S['setting']['poster_title'];
		$date['summary']=$date['summary']?$date['summary']:$_S['setting']['poster_summary'];
		$date['summary']=str_replace(array("\n","\r","\r\n"),'',$date['summary']);
		$date['site']=$date['site']?$date['site']:($_S['setting']['poster_name']?$_S['setting']['poster_name']:$_S['setting']['sitename']);
		$date['info']=$date['info']?$date['info']:'长按识别图中二维码';
		
	
		/*图片*/
		if($date['pic']){
			if($date['picthumb']){
				$theImg=ROOT.$date['pic'];
			}else{
				$theImg=ROOT.getimg($date['pic'],640,600,true,'return');
			}
			
		}else{
			$theImg=ROOT.$_S['atc'].'/'.$_S['setting']['poster_pic'];
		}
		
		list($l_w,$l_h) = getimagesize($theImg);  
		$sharimg = createImageFromFile($theImg,$date['pic']);  
		imagecopyresized($im, $sharimg, 0, 0, 0, 0, 640, 600,$l_w, $l_h);
	  
		/*日期*/
		$date_color = imagecolorallocate($im, 255, 255, 255);
		imagettftext($im, 64,0, 50, 500, $date_color ,$font_file, smsdate($_S['timestamp'],'d'));
		imagettftext($im, 20,0, 42, 510, $date_color ,$font_file, '__________');
		imagettftext($im, 20,0, 50, 550, $date_color ,$font_file, smsdate($_S['timestamp'],'Y/m'));
		
		/*分界线*/
		$line_color = imagecolorallocate($im, 221, 221, 221);
		imagettftext($im, 12,0, 0, 868, $line_color ,$font_file, '-----------------------------------------------------------------------------------------------------------------');
		
		/*站点信息*/
		imagettftext($im, 20,0, 60, 928, $summary_color ,$font_file, $date['site']);
		imagettftext($im, 16,0, 60, 968, $line_color ,$font_file, $date['info']);
		
		/*二维码*/
		require_once './include/qrcode.php';
		QRcode::png($date['url'],'data/atc/common/poster_qrcode.png',4,3);
		
		$qrcode = createImageFromFile(ROOT.'./data/atc/common/poster_qrcode.png'); 
		imagecopy($im, $qrcode, 496, 878, 0, 0, 132, 132);
		if($api){
			require_once './hack/'.$api.'/poster.php';
		}else{
			/*标题*/
			$title_color = imagecolorallocate($im, 0, 0, 0);
			$theTitle = cn_row_substr($date['title'],2,16);  
			$left_1=(640-(strlen($theTitle[1])*9))/2;
			imagettftext($im, 20,0, $left_1, 660, $title_color ,$font_file, $theTitle[1]);
			if($theTitle[2]){
				$left_2=(640-(strlen($theTitle[2])*9))/2;
				imagettftext($im, 20,0, $left_2, 710, $title_color ,$font_file, $theTitle[2]);
			}
			
			/*摘要*/
			$summary_color = imagecolorallocate($im, 110, 110, 110);
			$theSummary = cn_row_substr($date['summary'],3,24);  
			imagettftext($im, 16,0, 60, 760, $summary_color ,$font_file, $theSummary[1]);
			if($theSummary[2]){
				imagettftext($im, 16,0, 60, 796, $summary_color ,$font_file, $theSummary[2]);
			}
			if($theSummary[3]){
				imagettftext($im, 16,0, 60, 832, $summary_color ,$font_file, $theSummary[3]);
			}		
		}	
		
	  
	}

	header("Content-type: image/png");
	imagepng($im);

	imagedestroy($im);  
	imagedestroy($sharimg);  
	imagedestroy($qrcode);  

}

?>