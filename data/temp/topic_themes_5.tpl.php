
<div class="waterfallist">
  <ul id="waterfall" class="waterfall cl">
    <?php if(is_array($list)) foreach($list as $value) { ?>    <?php $cover=watercover($value);?>    <li id="<?php echo $value['vid'];?>/<?php echo $cover['width'];?>/<?php echo $cover['height'];?>">
      <div class="c">
        <div class="b_c3">
          <a href="topic.php?vid=<?php echo $value['vid'];?>" class="load block">
          <img src="ui/sl.png" class="cover lazyload" id="cover<?php echo $value['vid'];?>" data-original="<?php echo $cover['pic'];?>" />
          <p class="sub"><?php echo $value['subject'];?></p></a>
        </div>
      </div>
    </li>
    <?php } ?>
  </ul>
  <div id="tmppic" style="display: none;"></div>
</div>



