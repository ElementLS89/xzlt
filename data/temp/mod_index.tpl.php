
<?php if($_GET['get']!='ajax') { include temp('header'); ?><div id="view">
  <div id="header">
    <?php if($portal['header']['use']) { ?>
    <div class="header b_c1 flexbox c3">
      <div class="header-l topuser"><?php if($_S['uid']) { ?><a href="user.php" class="load"><?php echo head($_S['member'],2);?></a><?php } else { ?><a href="member.php" class="icon icon-login load"></a><?php } ?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
    <?php } ?>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $bodyclass;?> <?php echo $outback;?>">
<?php } ?>
    <?php if(is_array($hackcss)) foreach($hackcss as $css) { ?>    <link rel="stylesheet" href="<?php echo $css;?>" type="text/css" media="all">
    <?php } ?>
    <?php if(is_array($mods)) foreach($mods as $value) { ?>    <?php getportalmod($value);?>    <?php } ?>
    
<?php if($_GET['get']!='ajax') { ?>
    </div>
  </div>
  <div id="footer">
    <?php if($portal['footer']['use']) { ?>
    <?php $tabbar=$portal['footer']['tabbar']?$portal['footer']['tabbar']:'tabbar'?>    <?php include temp($tabbar)?>    <?php } ?>
  </div>
</div>
<div id="smsscript">
  <?php if($modjs) { ?>
  <script language="javascript" reload="1">
  $(document).ready(function() {
<?php echo $modjs;?>
});
  </script>
  <?php } ?>
  <?php include temp('wechat'); ?>  <?php include temp('wechat_shar'); ?>  <?php include temp('wechat_lbs'); ?></div><?php include temp('footer'); } ?>