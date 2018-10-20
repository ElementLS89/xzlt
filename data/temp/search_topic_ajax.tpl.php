
<?php if($_S['dz']) { include temp('discuz/'.$themetemp,false)?><?php } else { if($_GET['t']=='topic') { if(is_array($list)) foreach($list as $value) { ?><a href="topic.php?tid=<?php echo $value['tid'];?>" class="weui-cell weui-cell_access load">
  <div class="weui-cell__hd"><img src="<?php echo $value['cover'];?>"></div>
  <div class="weui-cell__bd">
    <h4><?php echo $value['name'];?></h4>
    <p class="c4"><?php echo $value['about'];?></p>
  </div>
</a>
<?php } } else { include temp('topic/viewtopic_ajax',false)?><?php } } ?>