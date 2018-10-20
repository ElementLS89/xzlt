<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('back')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>">
      <?php if($_S['setting']['mods']>1) { ?>
      <div class="scrollx topnv navs b_c3 bob o_c3 mb10">
        <div class="scrollx_area">
          <ul class="c">
            <?php if($_S['dz'] && $_S['member']['dzuid']) { ?>
            <li<?php if($_GET['mod']=='discuz') { ?> class="c1 o_c1"<?php } ?> id="mod_discuz"><a href="collection.php?mod=discuz" class="get" box="vc_discuz" btn="mod_discuz">论坛帖子</a></li>
            <?php } ?>
            <?php if(is_array($_S['setting']['mods'])) foreach($_S['setting']['mods'] as $mid => $mod) { ?>            <li<?php if($_GET['mod']==$mid) { ?> class="c1 o_c1"<?php } ?> id="mod_<?php echo $mid;?>"><a href="collection.php?mod=<?php echo $mid;?>" class="get" box="vc_<?php echo $mid;?>" btn="mod_<?php echo $mid;?>"><?php echo $mod['name'];?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>   
      <?php } ?>
      <?php if($_S['dz'] && $_S['member']['dzuid']) { ?>
      <div id="vc_discuz" <?php if($_GET['mod']!='discuz') { ?>style="display:none"<?php } else { ?> class="ready current"<?php } ?>>
      <?php include temp('collection_ajax'); ?>      </div>
      <?php } ?>
      <?php if(is_array($_S['setting']['mods'])) foreach($_S['setting']['mods'] as $mid => $mod) { ?>      <div id="vc_<?php echo $mid;?>" <?php if($_GET['mod']!=$mid) { ?>style="display:none"<?php } else { ?> class="ready current"<?php } ?>>
      <?php include temp('collection_ajax'); ?>      </div>
      <?php } ?>   
      
      <div id="page">
      <?php if($maxpage>1) { ?>
      <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#vc_<?php echo $_GET['mod'];?>"><span class="weui-loadmore__tips">下一页</span></a>
      <?php } ?>   
      </div>

    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript"><?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>