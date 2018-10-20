
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $navtitle;?></title>
<meta content="Smsot.com" name="Copyright" />
<link rel="stylesheet" href="admin/style/style.css" type="text/css" media="all" />
<body scroll="no" class="iframe">

<div class="showmessage">
  <h3><?php if($param['title']) { ?><?php echo $param['title'];?><?php } else { ?>提示信息<?php } ?></h3>
  <?php if($param['confirm']) { ?>
  <p><?php echo $message;?></p>
  <p><a href="<?php echo $url;?>" class="confirm">确定</a><a href="javascript:history.back();" class="reset">取消</a></p>
  <?php } else { ?>
  <p><a href="<?php if($url) { ?><?php echo $url;?>&iframe=yes<?php } else { ?>javascript:history.back();<?php } ?>"><?php echo $message;?></a></p>
  <?php } ?>
  
</div>
</body>
</html>