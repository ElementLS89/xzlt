
<?php if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
<div class="main">
  <div id="list">
<?php } ?>
    <?php if($list) { ?>
    <?php if(is_array($list)) foreach($list as $value) { ?>    <a href="hongbao.php?hid=<?php echo $value['hid'];?>" class="weui-cell load b_c3" id="hb_<?php echo $value['hid'];?>">
      <div class="weui-cell__hd"><?php echo head($value['user'],2);?></div>
      <div class="weui-cell__bd">
        <h4 class="c6"><?php echo $value['username'];?>的<?php if($value['password']) { ?>口令<?php } ?>红包</h4>
        <p class="c4"><?php echo $value['message'];?></p>
      </div>
      <div class="weui-cell__ft"><?php echo $value['btn'];?></div>
    </a>
    <?php } ?>
    <?php } else { ?>
    <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂无红包数据</span></div>
    <?php } if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#hongbao<?php echo $_GET['list'];?>"><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
  </div>
  <div id="script"></div>
</div>
<?php } ?>
