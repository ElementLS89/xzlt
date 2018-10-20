<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('close')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_t <?php echo $outback;?>">
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="c1 flex"><a href="my.php?mod=hongbao" class="get" type="switch" box="hongbao"><span>我收到的</span></a></li>
          <li class="c7 flex"><a href="my.php?mod=hongbao&list=give" class="get" type="switch" box="hongbaogive"><span>我发的</span></a></li>
          <li class="c7 flex"><a href="my.php?mod=hongbao&list=receive" class="get" type="switch" box="hongbaoreceive"><span>我领取的</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>
      <div class="box-area">
        <div class="box-content users current ready pt10" id="hongbao">
        <?php include temp('my/hongbao_list_ajax'); ?>        </div>
        <div class="box-content users pt10" id="hongbaogive" style="display:none">
        </div>
        <div class="box-content users pt10" id="hongbaoreceive" style="display:none">
        </div>
      </div>
      <div id="page">
      <?php if($maxpage>1) { ?>
      <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#hongbao"><span class="weui-loadmore__tips">下一页</span></a>
      <?php } ?>
      </div>
    </div>
  </div>
  <div id="footer">
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
  $(document).ready(function() {
      SMS.translate_int();
});
  </script>
  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>