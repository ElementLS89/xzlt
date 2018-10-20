
<ul class="catalog cl">
  <li<?php if($_GET['ac']!='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&iframe=yes">分类管理</a></li>
  <li<?php if($_GET['ac']=='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=add&iframe=yes">添加分类</a></li>
</ul>
<?php if(in_array($_GET['ac'],array('add','edit'))) { ?>
<div class="block">
  <h3><?php if($_GET['ac']=='add') { ?>添加分类<?php } else { ?>管理分类<?php } ?></h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=<?php echo $_GET['ac'];?>" method="post" >
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <?php if($_GET['typeid']) { ?>
    <input name="typeid" type="hidden" value="<?php echo $_GET['typeid'];?>" />
    <?php } ?>
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>名称</th>
        <td><input type="text" class="input w300" name="name" value="<?php echo $type['name'];?>"></td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>  
</div>

<?php } else { ?>
<form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="s">Typeid</td>
        <td class="l">顺序</td>
        <td class="l">话题数</td>
        <td>名称</td>
      </tr>
    </thead>
    <?php if(is_array($types)) foreach($types as $value) { ?>    <input type="hidden" name="typeids[]" value="<?php echo $value['typeid'];?>">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="typeid[]" value="<?php echo $value['typeid'];?>"/><span class="icon"></span></label></td>
        <td class="s"><?php echo $value['typeid'];?></td>
        <td class="l"><input type="text" class="input" name="list[]" value="<?php echo $value['list'];?>"></td>
        <td class="l">
        <?php echo $value['topics'];?>
        </td>
        <td><?php echo $value['name'];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&typeid=<?php echo $value['typeid'];?>&iframe=yes"><em>[编辑]</em></a></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'typeid[]')"/><span class="icon"></span></label></td>
        <td colspan="4"><button type="button" class="button" onclick="checkdelete(this.form,'typeid')">提交</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>


<?php } ?>