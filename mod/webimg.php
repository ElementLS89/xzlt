<?php
$src=urldecode($_GET['src']);
$pic=getwebpic($src,$_GET['w'],$_GET['h'],'web','return');
dheader('Content-Type: image');
@readfile($pic);
@unlink($pic);
?>