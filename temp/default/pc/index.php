<?exit?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="{if $metakeywords}$metakeywords{else}$_S['setting']['keywords']{/if}" />
<meta name="description" content="{if $metadescription}$metadescription{else}$_S['setting']['description']{/if}" />
<title><!--{if $title}-->$title<!--{else}-->$_S['setting']['sitename']<!--{/if}--></title>
<link rel="stylesheet" href="./temp/{$_S['temp']['dir']}/pc/style/style.css?t={$_S[hash]}" type="text/css" media="all">
</head>

<body>
<!--{eval $url=urlencode($_S['setting']['siteurl']);}-->
<div class="qrcode">
  <img src="{if $_S['setting']['qrcode']}{$_S['atc']}/{$_S['setting']['qrcode']}{else}qrcode.php?url=$url&size=8{/if}" />
  <div>
    <h3>$_S['setting']['sitename']</h3>
    <p>$_S['setting']['description']</p>  
  </div>
</div>
<p class="info tc">扫码开始体验</p>
<p class="copy tc">Powered by <a href="https://www.smsot.com/">Smsot</a></p>
</body>
</html>