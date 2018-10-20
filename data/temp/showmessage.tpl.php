
<?php if(!$_GET['load']) { include temp('header'); } if($_GET['load']) { if($param['type']=='toast') { ?>
<div class="weui-toast">
<div class="toast-content"><?php echo $message;?>|<?php echo $param['fun'];?></div>
</div>

<?php } else { ?>
<div class="weui-dialog">
  <div class="dialog-content">
    <div class="weui-dialog__hd"><strong class="weui-dialog__title"><?php echo $param['title'];?></strong></div>
    <div class="weui-dialog__bd"><?php echo $message;?></div>
    <div class="weui-dialog__ft">
      <?php if($url) { ?>
      <?php if(!$param['must']) { ?><a href="javascript:;" onclick="<?php if($param['clear']) { ?>SMS.clear();<?php } else { ?>SMS.close();<?php } ?>" class="weui-dialog__btn weui-dialog__btn_default"><?php echo $default;?></a><?php } ?>
      <a href="<?php echo $url;?>" class="weui-dialog__btn weui-dialog__btn_primary<?php if(!$param['clear']) { ?> load<?php } ?>" loading="tab" <?php if($param['param']) { ?>param="<?php echo $param['param'];?>"<?php } ?> id="primary"><?php echo $primary;?></a>
      <?php } else { ?>
      <a href="javascript:;" onclick="SMS.close();" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
      <?php } ?>
    </div>
  </div>
</div>
<div id="smsscript"><div class="js-content"><?php echo $param['js'];?></div></div>
<?php } } else { ?>
<div id="view">
  <div id="main">
    <div class="smsbody <?php echo $outback;?>">

      <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        
        <div class="weui-msg__text-area">
          <h2 class="weui-msg__title"><?php echo $param['title'];?></h2>
          <p class="weui-msg__desc"><?php echo $message;?></p>
        </div>
        <div class="weui-msg__opr-area">
          <p class="weui-btn-area">
          <?php if($url) { ?>
          <a href="<?php echo $url;?>" class="weui-btn weui-btn_primary"><?php echo $primary;?></a>
          <?php } ?>
          <?php if($param['go'] || !$url) { ?>
          <a href="<?php if($param['go']) { ?><?php echo $param['go'];?><?php } else { ?>javascript:history.back();<?php } ?>" class="weui-btn weui-btn_default"><?php echo $default;?></a> </p>
          <?php } ?>
        </div>
        <div class="weui-msg__extra-area">
          <div class="weui-footer">
            <p class="weui-footer__links"> <a href="http://www.smsot.com" class="weui-footer__link">Smsot.com</a> </p>
            <p class="weui-footer__text">Copyright &copy; 2017-2027 Smsot 1.0</p>
          </div>
        </div>
      </div>

      

    </div>
  </div>
</div>
<div id="smsscript">
  <?php if($param['js'] || $param['fun']) { ?>
<script language="javascript">
<?php if($param['js']) { ?>
  <?php echo $param['js'];?>
<?php } elseif($param['fun']) { ?>
<?php echo $param['fun'];?>
<?php } ?>
  </script>
  <?php } ?>
</div>
<?php } if(!$_GET['load']) { include temp('footer'); } ?>