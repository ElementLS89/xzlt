
<div class="layer_header b_c1 c3"><a href="javascript:SMS.openlayer('setstyle')" class="icon icon-close"></a><span>选择风格配色</span></div>

<form action="set.php?type=preference" method="post" id="set_preference">
  <input name="submit" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <ul class="styles cl">
    <?php if(is_array($_S['cache']['colors'])) foreach($_S['cache']['colors'] as $style) { ?>    <?php if($style['canuse']) { ?>
    <li>
      <label for="s<?php echo $style['cid'];?>" onclick="selectstyle('<?php echo $style['color'];?>')">
      <div style="background:<?php echo $style['color'];?>">
        <p class="b_c3"><?php echo $style['name'];?></p>
        <input type="radio" name="style" value="<?php echo $style['cid'];?>" <?php if($_S['member']['style']==$style['cid']) { ?>checked="checked"<?php } ?> id="s<?php echo $style['cid'];?>">
        <span class="icon icon-yes"></span> </div>
      </label>
    </li>
    <?php } ?>
    <?php } ?>
  </ul>

  <div class="footer_btn b_c7"><div class="p10"><button type="button" class="weui-btn weui-btn_primary formpost">选择使用</button></div></div>
</form>
    
    