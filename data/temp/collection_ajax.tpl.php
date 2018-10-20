
<?php if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
<div class="collectionlist">
  <div id="list">
<?php } if($list) { if($_GET['mod']=='topic') { include temp('topic/themes_1',false)?><?php } elseif($_GET['mod']=='discuz') { include temp('discuz/threads_1',false)?><?php } else { include temp($_GET['mod'].':collection',false)?><?php } } else { ?>
<div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂未收藏任何<?php echo $mod['name'];?></span></div>
<?php } if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?>
  <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#vc_<?php echo $_GET['mod'];?>"><span class="weui-loadmore__tips">下一页</span></a>
  <?php } ?>
  </div>
</div>
<?php } ?>


