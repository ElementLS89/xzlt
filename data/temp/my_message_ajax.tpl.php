<?php if(is_array($list)) foreach($list as $value) { ?><a href="my.php?mod=talk&tid=<?php echo $value['tid'];?>" class="weui-cell weui-cell_access load" id="talk_<?php echo $value['tid'];?>">
  <div class="weui-cell__hd"><?php echo head($value['formuid'],2);?><?php if($value['newmessage']) { ?><span class="weui-badge"><?php echo $value['newmessage'];?></span><?php } ?></div>
  <div class="weui-cell__bd">
    <h4><span class="r s12 c2"><?php echo smsdate($value['lastdateline'],'m-d H:i:s');?></span><span class="c1"><?php echo $list_more[$value['formuid']]['username'];?></span></h4>
    <p class="c4"><?php echo $value['lastmessage'];?></p>
  </div>
</a>
<?php } ?>