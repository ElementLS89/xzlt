
<ul class="catalog cl">
  <?php if($_GET['ac']=='manage') { ?>
  <li<?php if(!$_GET['op']) { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=manage&typeid=<?php echo $_GET['typeid'];?>&iframe=yes">管理表情</a></li>
  <li<?php if($_GET['op']=='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=manage&typeid=<?php echo $_GET['typeid'];?>&op=add&iframe=yes">添加表情</a></li>
  <?php } else { ?>
  <li<?php if(!$_GET['ac'] || $_GET['ac']=='edit') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&iframe=yes">表情分类</a></li>
  <li<?php if($_GET['ac']=='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=add&iframe=yes">添加表情分类</a></li>  
  <?php } ?>

</ul>
<?php if(in_array($_GET['ac'],array('add','edit'))) { ?>
<div class="block">
  <h3><?php if($_GET['ac']=='add') { ?>添加表情分类<?php } else { ?>编辑表情分类<?php } ?></h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=<?php echo $_GET['ac'];?>" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <?php if($_GET['typeid']) { ?>
    <input name="typeid" type="hidden" value="<?php echo $_GET['typeid'];?>" />
    <?php } ?>
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>名称</th>
        <td><input type="text" class="input w300" name="name" value="<?php echo $smiletype['name'];?>"><em>起一个便于大家理解的名称</em></td>
      </tr>
      <tr>
        <th>目录</th>
        <td><input type="text" class="input w300" name="dir" value="<?php echo $smiletype['dir'];?>"><em>每个表情包都存放在static/smile/目录下，修改或者创建新的表情分类请通过FTP创建新的表情包文件夹以及上传表情图片</em></td>
      </tr>
      <tr>
        <th>顺序</th>
        <td><input type="text" class="input" name="list" value="<?php echo $smiletype['list'];?>"><em>数字越小越靠前</em></td>
      </tr>
      <tr>
        <th>启用</th>
        <td><label class="checkbox"><input type="checkbox" class="check" name="canuse" value="1" <?php if($smiletype['canuse']) { ?>checked="checked"<?php } ?>/><span class="icon"></span></label><em>是否启用本表情</em></td>
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
<?php } elseif($_GET['ac']=='manage') { if($_GET['op']=='add') { ?>
<div class="block">
  <h3>添加表情</h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=<?php echo $_GET['ac'];?>&typeid=<?php echo $_GET['typeid'];?>&op=add" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>表情图片</th>
        <td><input type="text" class="input w300" name="pic" value=""><em>填写表情图片的文件名称</em></td>
      </tr>
      <tr>
        <th>文字解析</th>
        <td><input type="text" class="input w300" name="str" value=""><em>用于再表情未解析的情况下显示的文字</em></td>
      </tr>
      <tr>
        <th>顺序</th>
        <td><input type="text" class="input" name="list" value=""><em>数字越小越靠前</em></td>
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
<form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=<?php echo $_GET['ac'];?>&typeid=<?php echo $_GET['typeid'];?>" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="l">顺序</td>
        <td class="w200">文字解析</td>
        <td>图片</td>
        
      </tr>
    </thead>
    <?php if(is_array($smiles)) foreach($smiles as $id => $value) { ?>    <input type="hidden" name="ids[]" value="<?php echo $value['id'];?>">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="id[]" value="<?php echo $value['id'];?>"/><span class="icon"></span></label></td>
        <td class="l"><input type="text" class="input" name="list[<?php echo $id;?>]" value="<?php echo $value['list'];?>"></td>
        <td class="w200"><input type="text" class="input" name="str[<?php echo $id;?>]" value="<?php echo $value['str'];?>"></td>
        <td><img src="<?php echo $smiletype['dir'];?>/<?php echo $value['pic'];?>" style="width:32px; height:32px;" /><input type="text" class="input" name="pic[<?php echo $id;?>]" value="<?php echo $value['pic'];?>"></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'id[]')"/><span class="icon"></span></label></td>
        <td colspan="3"><button type="button" class="button" onclick="checkdelete(this.form,'id')">提交</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } } else { ?>
<form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="l">顺序</td>
        <td class="l">启用</td>
        <td class="w300">名称</td>
        <td>目录</td>
        
      </tr>
    </thead>
    <?php if(is_array($smiletypes)) foreach($smiletypes as $typeid => $value) { ?>    <input type="hidden" name="typeids[]" value="<?php echo $value['typeid'];?>">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="typeid[]" value="<?php echo $value['typeid'];?>"/><span class="icon"></span></label></td>
        <td class="l"><input type="text" class="input" name="list[<?php echo $typeid;?>]" value="<?php echo $value['list'];?>"></td>
        <td class="l"><label class="checkbox"><input type="checkbox" class="check" name="canuse[<?php echo $typeid;?>]" value="1" <?php if($value['canuse']) { ?>checked="checked"<?php } ?>/><span class="icon"></span></label></td>
        <td class="w300"><?php echo $value['name'];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&typeid=<?php echo $value['typeid'];?>&iframe=yes"><em>[编辑]</em></a><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=manage&typeid=<?php echo $value['typeid'];?>&iframe=yes"><em>[管理]</em></a></td>
        <td><?php echo $value['dir'];?></td>
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