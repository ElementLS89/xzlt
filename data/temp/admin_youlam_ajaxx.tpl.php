<form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>" method="post" id="tips_ajax_list">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="l">顺序</td>
        <td class="w300">名称</td>
        <td>链接地址</td>
      </tr>
    </thead>
    <?php if(is_array($tipsList)) foreach($tipsList as $value) { ?>    <input type="hidden" name="vids[]" value="<?php echo $value['vid'];?>">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="vid[]" value="<?php echo $value['vid'];?>"/><span class="icon"></span></label></td>
        <td class="l"><input type="text" class="input" name="list[]" value="<?php echo $value['vid'];?>"></td>
        <td class="w300">
        <img src="<?php echo $_S['atc'];?>/<?php echo $value['pic'];?>" /><?php echo $value['subject'];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&vid=<?php echo $value['vid'];?>&iframe=yes"><em>[编辑]</em></a>
        </td>
        <td><?php echo $value['link'];?></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'vid[]')"/><span class="icon"></span></label></td>
        <td colspan="3" id="tipsAddNav">
<button id="youlam_tips_modify_btn" type="button" class="button" onclick="checkdelete(this.form,'vid')">提交</button>
<a href="javascript:void(0)" class="btn_login" onclick="youlam_btn_showTipsAdd()">+增加导航</a>
</td>
    </tfoot>
    
  </table>
</form>