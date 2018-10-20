<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><a href="javascript:history.back(-1)" class="icon icon-back"></a></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>" nocache="true">
      <?php if($_S['member']['newnotice']) { ?>
      <a href="my.php?mod=notice" class="notice load" id="newnotice" onclick="$(this).remove();">有新的系统消息(<span id="noticenum"><?php echo $_S['member']['newnotice'];?></span>)</a>
      <?php } ?>
      <div class="weui-cells users autolist" id="messagelist">
        <?php include temp('my/message_ajax'); ?> 
      </div>
      <?php if($maxpage>1) { ?>
      <div id="page">
      <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <?php } ?>
    </div>
  </div>
  <div id="footer">
    <?php include temp('my/tabbar'); ?>  </div>
</div>
<div id="smsscript"><?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>