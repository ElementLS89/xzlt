<?php if(is_array($list)) foreach($list as $value) { ?><div id="notice_<?php echo $value['nid'];?>" class="viewnotice b_c3 p10 bob o_c3 flexbox">
  <div class="user pr10">
    <?php if($value['authorid']) { ?>
    <?php echo head($value['authorid'],2);?>    <?php } else { ?>
    <?php echo $value['icon'];?>
    <?php } ?>
  </div>
  <div class="flex">
    <div class="notice-content">
      <h3>系统消息<?php if($value['nums']>1) { ?><span class="weui-badge"><?php echo $value['nums'];?></span><?php } ?></h3>
      <div><?php echo $value['note'];?></div>
      <p class="s12 c4 cl"><a href="my.php?mod=notice&nid=<?php echo $value['nid'];?>" class="load r" loading="tab">忽略</a><?php echo smsdate($value['dateline'],'Y-m-d H:i:s');?></p>
    </div>

  </div>
</div>
<?php } ?>