<?exit?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smsot管理后台</title>
<link rel="stylesheet" href="admin/style/style.css" type="text/css" media="all" />
</head>

<body>
<!--{if $msg}-->
<p class="alert"><a href="javascript:history.back();">$msg</a></p>
<!--{else}-->
<form action="admin.php" method="post" class="loginpannel">
  <input name="hash" type="hidden" value="$_S['hash']" />
  <!--{if $_S['uid']}-->
  <input name="username" type="hidden" value="$_S['member']['username']" />
  <!--{/if}-->
  <p class="inp"><span>账号</span><input type="text" name="username" class="input" value="$_S['member']['username']" {if $_S['uid']}disabled="disabled"{/if}></p>
  <p class="inp"><span>密码</span><input type="password" name="password" class="input"></p>
  <p class="btn"><button type="submit" name="submit" value="true" class="button">登录</button></p>
  <p class="info">山东魔缇网络科技有限公司（Smsot.com）</p>
</form>
<!--{/if}-->
</body>
</html>