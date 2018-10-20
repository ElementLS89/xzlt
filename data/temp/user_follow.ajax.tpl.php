
<?php if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
<div class="main">
  <div id="list">
<?php } ?>
    <?php if(is_array($list)) foreach($list as $value) { ?>    <div class="weui-cell" id="follow_l<?php echo $value['uid'];?>">
      <div class="weui-cell__hd"><a href="user.php?uid=<?php echo $value['uid'];?>" class="load"><?php echo head($value['user'],2);?></a></div>
      <div class="weui-cell__bd">
        <a href="user.php?uid=<?php echo $value['uid'];?>" class="load"><h4 class="c6"><?php echo $value['username'];?></h4>
        <p class="c4"><?php if($value['lm']) { ?><?php echo $value['lm'];?><?php } else { ?>这个人很懒什么也没留下<?php } ?></p>
      </div>
      <div class="weui-cell__ft">
        <a href="user.php?mod=action&action=follow&uid=<?php echo $value['uid'];?>" class="weui-btn weui-btn_mini<?php if($list_more[$value['uid']]) { ?> weui-btn_default<?php } else { ?> weui-btn_primary<?php } ?> load"><?php if($list_more[$value['uid']]) { ?>取消<?php } else { ?>关注<?php } ?></a>
      </div>
    </div>
    <?php } if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#follow_<?php echo $_GET['uid'];?>_<?php echo $_GET['show'];?>"><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
  </div>
  <div id="script"></div>
</div>
<?php } ?>