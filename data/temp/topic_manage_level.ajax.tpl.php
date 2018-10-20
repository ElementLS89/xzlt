
<form action="topic.php?mod=manage&tid=<?php echo $_GET['tid'];?>&item=level" method="post" id="<?php echo PHPSCRIPT;?>_<?php echo $_GET['mod'];?>_form">
  <input name="submit" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <div class="weui-cells">
    <?php if(is_array($topicgroup)) foreach($topicgroup as $id => $value) { ?>    <div class="weui-cell">
      <div class="weui-cell__bd">
        <input type="hidden" name="id[<?php echo $id;?>]" value="<?php echo $id;?>" />
        <input class="weui-input" type="text" name="name[<?php echo $id;?>]" placeholder="等级名称" value="<?php echo $value['name'];?>">
      </div>
      <div class="weui-cell__ft s15"><?php if($value['experience']) { ?><?php echo $value['experience'];?> 经验<?php } else { ?>/<?php } ?></div>
    </div>
    <?php } ?>
  </div>
  <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">设置自定义用户等级</button></div>
</form>  