
<div id="view">
    <div class="smsbody body_b <?php echo $outback;?>">
  <div class="find-items b_c3">
        <ul class="cl c6">
          <?php if(is_array($tipsList)) foreach($tipsList as $value) { ?>          <?php if($value['subject']) { ?>
          <li><a href="<?php echo $value['link'];?>" <?php if($value['link']) { ?>class="load"<?php } ?>><img src="<?php echo $_S['atc'];?>/<?php echo $value['pic'];?>" /><p<?php if(!$value['link']) { ?> class="c4"<?php } ?>><?php echo $value['subject'];?></p></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
</div>