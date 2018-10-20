
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php if($metakeywords) { ?><?php echo $metakeywords;?><?php } else { ?><?php echo $_S['setting']['keywords'];?><?php } ?>" />
<meta name="description" content="<?php if($metadescription) { ?><?php echo $metadescription;?><?php } else { ?><?php echo $_S['setting']['description'];?><?php } ?>" />
<title><?php if($title) { ?><?php echo $title;?><?php } else { ?><?php echo $_S['setting']['sitename'];?><?php } ?></title>
<link rel="stylesheet" href="./temp/<?php echo $_S['temp']['dir'];?>/pc/style/style.css?t=<?php echo $_S['hash'];?>" type="text/css" media="all">
</head>

<body><?php $url=urlencode($_S['setting']['siteurl']);?><div class="qrcode">
  <img src="<?php if($_S['setting']['qrcode']) { ?><?php echo $_S['atc'];?>/<?php echo $_S['setting']['qrcode'];?><?php } else { ?>qrcode.php?url=<?php echo $url;?>&size=8<?php } ?>" />
  <div>
    <h3><?php echo $_S['setting']['sitename'];?></h3>
    <p><?php echo $_S['setting']['description'];?></p>  
  </div>
</div>
<p class="info tc">扫码开始体验</p>
<p class="copy tc">Powered by <a href="https://www.smsot.com/">Smsot</a></p>
</body>
</html>