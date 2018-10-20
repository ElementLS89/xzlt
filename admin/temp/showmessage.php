<?exit?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>$navtitle</title>
<meta content="Smsot.com" name="Copyright" />
<link rel="stylesheet" href="admin/style/style.css" type="text/css" media="all" />
<body scroll="no" class="iframe">

<div class="showmessage">
  <h3>{if $param['title']}$param['title']{else}提示信息{/if}</h3>
  {if $param['confirm']}
  <p>$message</p>
  <p><a href="$url" class="confirm">确定</a><a href="javascript:history.back();" class="reset">取消</a></p>
  {else}
  <p><a href="{if $url}$url&iframe=yes{else}javascript:history.back();{/if}">$message</a></p>
  {/if}
  
</div>
</body>
</html>