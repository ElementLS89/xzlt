
<div id="tips_ajax_list"><?php if(is_array($tipsList)) foreach($tipsList as $value) { ?>  <input type="hidden" name="sids[]" value="<?php echo $value['sid'];?>">
  <tbody>
    <tr>
      <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="sid[]" value="<?php echo $value['sid'];?>"/><span class="icon"></span></label></td>
      <td class="l"><input type="text" class="input" name="list[]" value="<?php echo $value['list'];?>"></td>
      <td class="w300">
      <img src="<?php echo $_S['atc'];?>/<?php echo $value['pic'];?>" /><?php echo $value['name'];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&sid=<?php echo $value['sid'];?>&iframe=yes"><em>[编辑]</em></a>
      </td>
      <td><?php echo $value['url'];?></td>
    </tr>
  </tbody>
  <?php } ?>

</div>