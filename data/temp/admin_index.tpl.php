
<?php if($_GET['iframe']) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php } ?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $navtitle;?></title>
<meta content="Smsot.com" name="Copyright" />
<meta http-equiv= "Pragma"   content= "no-cache" /> 
<meta http-equiv= "Cache-Control"   content= "no-cache" /> 
<meta http-equiv= "Expires"   content= "0" /> 
<link rel="stylesheet" href="admin/style/style.css" type="text/css" media="all" />
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
<script src="js/jquery-1.8.3.min.js" charset="utf-8"></script>
<script src="js/admin.js" charset="utf-8"></script>
<body scroll="no"<?php if($_GET['iframe']) { ?> class="iframe"<?php } ?>>
<?php if($_GET['iframe']) { ?>
<div id="mask" style="display:none"></div>
<div id="window"></div>
<div id="nav">
<div><a href="admin.php?mod=<?php echo $_GET['mod'];?>" target="_top"><?php echo $mods[$_GET['mod']];?></a><em class="ic"></em><?php echo $menus[$_GET['item']]['0'];?></div>
</div>
<div class="iframearea"><?php include temp($_GET['mod'].'_'.$_GET['item']);?></div>
<?php } else { ?>

<table id="smsot" cellpadding="0" cellspacing="0">
  <tr class="hd">
    <td colspan="2">
    <p class="y"><?php echo $_S['member']['username'];?><em>|</em><a href="admin.php?mod=out">退出</a></p>
    <a href="admin.php" class="logo"><img src="ui/smsot.png"></a>
    <ul>
      <?php if(is_array($mods)) foreach($mods as $mid => $mod) { ?>      <li<?php if($_GET['mod']==$mid) { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $mid;?>" target="_top"><?php echo $mod;?></a></li>
      <?php } ?>
    </ul>
    </td>
  </tr>
  <tr>
    <td class="la">
    <ul>
      <?php if(is_array($menus)) foreach($menus as $type => $menu) { ?>      <li<?php if($type==$_GET['item']) { ?> class="a"<?php } ?>><a href="<?php echo $menu['1'];?>"><?php echo $menu['0'];?></a></li>
      <?php } ?>
    </ul>
    </td>
    <td class="ra">
    <div><iframe src="<?php echo $iframe;?>" id="main" name="main" frameborder="0" scrolling="yes"></iframe></div>
    </td>
  </tr>
</table>

<?php } ?>
</body>
</html>