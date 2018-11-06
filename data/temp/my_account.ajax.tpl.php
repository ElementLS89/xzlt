
<?php if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
<div class="main">
  <div id="list">
<?php } ?>
  <?php if(is_array($list)) foreach($list as $value) { ?>  <a class="weui-cell load" id="<?php echo $value['lid'];?>" href="my.php?mod=account&lid=<?php echo $value['lid'];?>">
    <div class="weui-cell__bd">
      <h4><strong class="c6"><?php echo $value['title'];?></strong><?php echo $value['title_after'];?></h4>
      <p class="c4 s12"><?php echo smsdate($value['logtime'],'Y-m-d H:i:s');?></p>
    </div>
    <div class="weui-cell__ft">
      <?php echo $value['arose_before'];?><?php echo $value['arose'];?>
    </div>
  </a>
  <?php } if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#content-3"><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
  </div>
  <div id="script"></div>
</div>
<?php } ?>