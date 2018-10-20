<?exit?>
<!--{if $_GET['iframe']}-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--{/if}-->
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>$navtitle</title>
<meta content="Smsot.com" name="Copyright" />
<meta http-equiv= "Pragma"   content= "no-cache" /> 
<meta http-equiv= "Cache-Control"   content= "no-cache" /> 
<meta http-equiv= "Expires"   content= "0" /> 
<link rel="stylesheet" href="admin/style/style.css" type="text/css" media="all" />
<style type="text/css">
@font-face {
  font-family: 'selffont';  /* project id 561027 */
  src: url('//at.alicdn.com/t/$_S['setting']['self_font'].eot');
  src: url('//at.alicdn.com/t/$_S['setting']['self_font'].eot?#iefix') format('embedded-opentype'),
  url('//at.alicdn.com/t/$_S['setting']['self_font'].woff') format('woff'),
  url('//at.alicdn.com/t/$_S['setting']['self_font'].ttf') format('truetype'),
  url('//at.alicdn.com/t/$_S['setting']['self_font'].svg#iconfont') format('svg');
}
.selficon {
  font-family:"selffont" !important;
  font-size:32px;
  font-style:normal;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
<!--{eval echo"\n"}-->
<!--{loop $_S['cache']['icon'] $value}-->
.s-$value['name']:before { content: "\$value['code']";}
<!--{if $value['code_on']}-->
.c1 .s-$value['name']:before { content: "\$value['code_on']";}
<!--{/if}-->
<!--{/loop}-->
</style>
<script src="js/jquery-1.8.3.min.js" charset="utf-8"></script>
<script src="js/admin.js" charset="utf-8"></script>
<body scroll="no"{if $_GET['iframe']} class="iframe"{/if}>
<!--{if $_GET['iframe']}-->
<div id="mask" style="display:none"></div>
<div id="window"></div>
<div id="nav">
<div><a href="admin.php?mod=$_GET['mod']" target="_top">$mods[$_GET['mod']]</a><em class="ic"></em>$menus[$_GET['item']][0]</div>
</div>
<div class="iframearea">
<!--{eval include temp($_GET['mod'].'_'.$_GET['item']);}-->
</div>
<!--{else}-->

<table id="smsot" cellpadding="0" cellspacing="0">
  <tr class="hd">
    <td colspan="2">
    <p class="y">$_S['member']['username']<em>|</em><a href="admin.php?mod=out">退出</a></p>
    <a href="admin.php" class="logo"><img src="ui/smsot.png"></a>
    <ul>
      <!--{loop $mods $mid $mod}-->
      <li{if $_GET['mod']==$mid} class="a"{/if}><a href="admin.php?mod=$mid" target="_top">$mod</a></li>
      <!--{/loop}-->
    </ul>
    </td>
  </tr>
  <tr>
    <td class="la">
    <ul>
      <!--{loop $menus $type $menu}-->
      <li{if $type==$_GET['item']} class="a"{/if}><a href="$menu[1]">$menu[0]</a></li>
      <!--{/loop}-->
    </ul>
    </td>
    <td class="ra">
    <div><iframe src="$iframe" id="main" name="main" frameborder="0" scrolling="yes"></iframe></div>
    </td>
  </tr>
</table>

<!--{/if}-->
</body>
</html>