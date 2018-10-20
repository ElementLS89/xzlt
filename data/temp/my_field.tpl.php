
<?php if($value['type']=='text') { ?>
<div class="weui-cell">
  <div class="weui-cell__hd">
    <label class="weui-label"><?php if($value['need']) { ?><span class="c9">*</span><?php } ?><?php echo $value['name'];?></label>
  </div>
  <div class="weui-cell__bd">
    <input class="weui-input" type="text" name="<?php echo $field;?>" maxlength="20" value="<?php if($my[$field]) { ?><?php echo $my[$field];?><?php } ?>" placeholder="请输入您的<?php echo $value['name'];?>">
  </div>
</div>
<?php } elseif($value['type']=='textarea') { ?>
<div class="weui-cells weui-cells_form">
  <div class="weui-cell">
    <div class="weui-cell__bd">
      <textarea class="weui-textarea" name="<?php echo $field;?>" placeholder="请输入<?php echo $value['name'];?>" maxlength="200" rows="3"><?php echo $my[$field];?></textarea>
    </div>
  </div>
</div>
<?php } elseif($value['type']=='number') { ?>
<div class="weui-cell">
  <div class="weui-cell__hd">
    <label class="weui-label"><?php if($value['need']) { ?><span class="c9">*</span><?php } ?><?php echo $value['name'];?></label>
  </div>
  <div class="weui-cell__bd">
    <input class="weui-input" type="number" name="<?php echo $field;?>" pattern="[0-9]*" value="<?php if($my[$field]) { ?><?php echo $my[$field];?><?php } ?>" placeholder="请输入您的<?php echo $value['name'];?>">
  </div>
  <div class="weui-cell_ft">
    <?php echo $value['unit'];?>
  </div>
</div>
<?php } elseif(in_array($value['type'],array('radio','select'))) { ?>
<div class="weui-cell weui-cell_select weui-cell_select-after">
  <div class="weui-cell__hd">
    <label for="<?php echo $field;?>" class="weui-label"><?php if($value['need']) { ?><span class="c9">*</span><?php } ?><?php echo $value['name'];?></label>
  </div>
  <div class="weui-cell__bd">
    <select class="weui-select" name="<?php echo $field;?>" id="<?php echo $field;?>">
      <?php if(is_array($value['choises'])) foreach($value['choises'] as $id => $value) { ?>      <option value="<?php echo $id;?>" <?php if($my[$field]==$id) { ?>selected="selected"<?php } ?>><?php echo $value;?></option>
      <?php } ?>
    </select>
  </div>
</div>
<?php } elseif($value['type']=='checkbox') { $my[$field]=explode(',',$my[$field]);?><div class="weui-cells weui-cells_checkbox">
  <?php if(is_array($value['choises'])) foreach($value['choises'] as $id => $value) { ?>  <label class="weui-cell weui-check__label" for="<?php echo $field;?><?php echo $id;?>">
    <div class="weui-cell__hd">
      <input type="checkbox" class="weui-check" value="<?php echo $id;?>" name="<?php echo $field;?>[]" id="<?php echo $field;?><?php echo $id;?>" <?php if(in_array($id,$my[$field])) { ?>checked="checked"<?php } ?>>
      <i class="weui-icon-checked"></i>
    </div>
    <div class="weui-cell__bd">
      <p><?php echo $value;?></p>
    </div>
  </label>
  <?php } ?>
</div>
<?php } elseif($value['type']=='date') { $my[$field]=$my[$field]?smsdate($my[$field],$value['datetype']):'';?><div class="weui-cell">
  <div class="weui-cell__hd">
    <label for="" class="weui-label"><?php if($value['need']) { ?><span class="c9">*</span><?php } ?><?php echo $value['name'];?></label>
  </div>
  <div class="weui-cell__bd">
    <input class="weui-input" name="<?php echo $field;?>" type="date" value="<?php echo $my[$field];?>">
  </div>
</div>
<?php } elseif($value['type']=='file') { ?>
<div class="uploadcover" id="<?php echo $field;?>"><a href="javascript:" class="bo o_c1 b_c3" id="<?php echo $field;?>_area"><?php if($my[$field]) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $my[$field];?>"><?php } else { ?><span></span><?php } ?></a>上传<?php echo $value['name'];?>（<?php echo $value['width'];?>*<?php echo $value['height'];?>）</div>
<input type="file" id="<?php echo $field;?>-file" name="<?php echo $field;?>" accept="image/gif,image/jpeg,image/jpg,image/png" style="display:none">
<?php } ?>