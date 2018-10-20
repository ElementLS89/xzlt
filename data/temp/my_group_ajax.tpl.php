<?php if(is_array($list)) foreach($list as $value) { ?><a class="weui-cell load" id="<?php echo $value['lid'];?>" href="my.php?mod=account&lid=<?php echo $value['lid'];?>">
  <div class="weui-cell__bd">
    <h4><strong class="c6"><?php echo $value['title'];?></strong><?php echo $value['title_after'];?></h4>
    <p class="c4 s12"><?php echo smsdate($value['logtime'],'Y-m-d H:i:s');?></p>
  </div>
  <div class="weui-cell__ft">
    <?php echo $value['arose_before'];?><?php echo $value['arose'];?>
  </div>
</a>
<?php } ?>