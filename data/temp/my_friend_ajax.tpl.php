<?php $i=1?><?php if(is_array($list)) foreach($list as $value) { ?><a href="user.php?uid=<?php echo $value['fuid'];?>" class="weui-cell<?php if($_S['page']=='1' && $i=='1') { ?> bot o_c3<?php } ?> load" id="friend_<?php echo $value['fuid'];?>">
  <div class="weui-cell__hd"><?php echo head($value['user'],2);?><?php if($list_more[$value['tid']]['newmessage']) { ?><span class="weui-badge"><?php echo $list_more[$value['tid']]['newmessage'];?></span><?php } ?></div>
  <div class="weui-cell__bd">
    <h4 class="c6"><?php echo $value['friendname'];?></h4>
    <p class="c4"><?php if($list_more[$value['tid']]['lastmessage']) { ?><?php echo $list_more[$value['tid']]['lastmessage'];?><?php } ?></p>
  </div>
</a><?php $i++?><?php } ?>