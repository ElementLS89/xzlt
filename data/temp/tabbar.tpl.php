
<div class="footer b_c2 bot o_c1 mainfooter">
  <div class="tabbar">
    <?php if(is_array($_S['tabbar'])) foreach($_S['tabbar'] as $id => $value) { ?>    <a href="<?php echo $value['url'];?>" class="load <?php if($_S['currentkey']==$id) { ?>c1<?php } else { ?>c4<?php } ?>"><span class="<?php echo $value['icon'];?>"></span><p><?php echo $value['name'];?></p></a>
    <?php } ?>
  </div>
</div>