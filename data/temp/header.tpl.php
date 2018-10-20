
<?php if(!$_GET['load']) { ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="600" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0,minimal-ui">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-title" content="<?php echo $_S['setting']['sitename'];?>">
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<meta name="full-screen" content="yes">
<meta name="browsermode" content="application"/>
<meta name="x5-fullscreen" content="true" />
<meta name="x5-page-mode" content="app" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ui/ico72.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ui/ico144.png">
<link rel="apple-touch-icon-precomposed" href="ui/ico.png" />
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="<?php if($metakeywords) { ?><?php echo $metakeywords;?><?php } else { ?><?php echo $_S['setting']['keywords'];?><?php } ?>" />
<meta name="description" content="<?php if($metadescription) { ?><?php echo $metadescription;?><?php } else { ?><?php echo $_S['setting']['description'];?><?php } ?>" />
<title><?php if($title) { ?><?php echo $title;?><?php } else { ?><?php echo $_S['setting']['sitename'];?><?php } ?></title>
<link rel="stylesheet" href="ui/weui1.35.css" type="text/css" media="all">
<link rel="stylesheet" href="ui/swiper4.0.css" type="text/css" media="all">
<link rel="stylesheet" href="ui/common1.35.css" type="text/css" media="all">
<?php if($_S['setting']['self_font']) { ?>
<style type="text/css">
@font-face {
  font-family: 'selffont';  /* project id 561027 */
  src: url('//at.alicdn.com/t/<?php echo $_S['setting']['self_font'];?>.eot');
  src: url('//at.alicdn.com/t/<?php echo $_S['setting']['self_font'];?>.eot?#iefix') format('embedded-opentype'),
  url('//at.alicdn.com/t/<?php echo $_S['setting']['self_font'];?>.woff') format('woff'),
  url('//at.alicdn.com/t/<?php echo $_S['setting']['self_font'];?>.ttf') format('truetype'),
  url('//at.alicdn.com/t/<?php echo $_S['setting']['self_font'];?>.svg#iconfont') format('svg');
}
.selficon {
  font-family:"selffont" !important;
  font-size:32px;
  font-style:normal;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}<?php echo"\n"?><?php if(is_array($_S['cache']['icon'])) foreach($_S['cache']['icon'] as $value) { ?>.s-<?php echo $value['name'];?>:before { content: "\<?php echo $value['code'];?>";}
<?php if($value['code_on']) { ?>
.c1 .s-<?php echo $value['name'];?>:before { content: "\<?php echo $value['code_on'];?>";}
<?php } } ?>
</style>
<?php } loadcss(); ?><script src="js/zepto.min.js" charset="utf-8"></script>
<script src="js/dropload.min.js" type="text/javascript"></script>
<script src="js/upload.js" type="text/javascript"></script>
<?php if($_S['in_wechat']) { ?>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
<script language="javascript">
<?php if($_S['miniProgram']) { ?>
var mini=true;
<?php } else { ?>
var mini=window.__wxjs_environment === 'miniprogram'?true:false;
<?php } ?>
</script>
<?php } if($_S['setting']['lbs_appkey'] && $_S['setting']['lbs_appname']) { if($_S['in_wechat']) { ?>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=<?php echo $_S['setting']['lbs_appkey'];?>"></script>
<?php } else { ?>
<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<?php } } ?>
<script src="js/swiper4.0.min.js" type="text/javascript"></script>
<script language="javascript">
  var PHPSCRIPT = '<?php echo $_S['php'];?>',SITEURL = '<?php echo $_S['setting']['siteurl'];?>',HEADER=<?php echo $_S['app']['header'];?>,CLOSE='<?php echo $_S['setting']['closebbs'];?>',BRO='<?php echo $_S['bro'];?>',UID='<?php echo $_S['uid'];?>',ATC='<?php echo $_S['atc'];?>',QN='<?php echo $_S['setting']['qiniu_domain'];?>',cookiepre = '<?php echo $_S['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_S['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_S['config']['cookie']['cookiepath'];?>';
function gz(){
SMS.open('<div class="gzgzh"><span class="icon icon-close" onClick="SMS.close()"></span><div class="qrcode"><img src="<?php echo $_S['atc'];?>/<?php echo $_S['setting']['gzh_logo'];?>"></div><div class="c3"><h2>长按二维码</h2><p><?php echo $_S['setting']['gzh_text'];?></p></div></div>','html','gzh');
}
</script>
<script src="js/smsot-1.35.js" charset="utf-8"></script>
<?php if(in_array($_S['bro'],array('qqbro','ucbro'))) { ?>
<script src="js/share.js" charset="utf-8"></script>
<?php } ?>
<script src="js/auto.js" charset="utf-8"></script>
<script src="js/smsot-1.35.api.js" charset="utf-8"></script>
<script src="js/topic-1.35.js" charset="utf-8"></script>
<?php if($_S['app']['jsapi']) { ?>
<script src="<?php echo $_S['app']['jsapi'];?>" charset="utf-8"></script>
<?php } else { ?>
<script src="js/jsapi.js" charset="utf-8"></script>
<?php } if($_S['gzh'] && !$_S['member']['subscribe'] && $_S['setting']['gzh_show']) { ?>
<script language="javascript">
$(document).ready(function() {
gz();
});
</script>
<?php } if($_S['setting']['getposition'] && $_S['setting']['lbs_appkey'] && $_S['setting']['lbs_appname']) { ?>
<script language="javascript">
$(document).ready(function() {
if(isweixin){
SMS.WxPosition();
}else{
SMS.Position('<?php echo $_S['setting']['lbs_appkey'];?>', '<?php echo $_S['setting']['lbs_appname'];?>',SMS.GetPosition);
}
});
</script>
<?php } include temp('websocket'); ?></head>
<body class="b_c7">
<audio id="sendAudio">
<source src="ui/voice/send.mp3" type="audio/mpeg">
</audio>
<audio id="receivedAudio">
<source src="ui/voice/received.mp3" type="audio/mpeg"> 
</audio>
<?php } ?>
<div id="body" class="<?php echo $_S['app']['body'];?>">
<?php if(PHPSCRIPT=='hack' && $_GET['id']) { ?>
<div id="hackcss">hack/<?php echo $_GET['id'];?>/style/style.css</div>
<?php } if($_GET['load']) { ?>
<div id="pagetitle"><?php if($title) { ?><?php echo $title;?><?php } else { ?><?php echo $_S['setting']['sitename'];?><?php } ?></div>
<?php } ?>
