
<ul class="catalog cl">
  <li<?php if($_GET['ac']!='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&iframe=yes">模板管理</a></li>
  <li<?php if($_GET['ac']=='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=add&iframe=yes">添加模板</a></li>
</ul>

<?php if(in_array($_GET['ac'],array('add','edit'))) { ?>
<div class="block">
  <h3><?php if($_GET['ac']=='add') { ?>添加模板<?php } else { ?>编辑模板<?php } ?></h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=<?php echo $_GET['ac'];?>" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <?php if($_GET['tempid']) { ?>
    <input name="tempid" type="hidden" value="<?php echo $_GET['tempid'];?>" />
    <?php } ?>
  <table class="table" cellpadding="0" cellspacing="0">
    <tr>
      <th class="need">模板名称</th>
      <td><input type="text" class="input" name="name" value="<?php echo $temp['name'];?>"><em>给模板起一个名字可以由汉字、字母、或数字组成</em></td>
    </tr>
    <tr>
      <th class="need">模板目录</th>
      <td><input type="text" class="input" name="dir" value="<?php echo $temp['dir'];?>"><em>填写模板所在的文件夹名称（网站根目录下temp文件夹内创建）</em></td>
      
    </tr>
    <?php if(!$temp) { ?>
    <tr class="line">
      <td colspan="2"></td>
    </tr>
    <tr>
      <th>版权所属</th>
      <td><input type="text" class="input w300" name="copyright" value="<?php echo $temp['copyright'];?>"><em>填写模板的版权所属</em></td>
    </tr>
    <tr>
      <th>作者</th>
      <td><input type="text" class="input" name="author" value="<?php echo $temp['author'];?>"><em>模板作者</em></td>
    </tr>
    <tr>
      <th>版本号</th>
      <td><input type="text" class="input" name="version" value="<?php echo $temp['version'];?>"><em>模板的版本号用于提示站长升级更新</em></td>
    </tr>
    <?php } ?>
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
<div class="block">
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>" method="post">
    <h3>模板设置</h3>
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <ul class="tempslist cl">
      <?php if(is_array($temps)) foreach($temps as $value) { ?>      <li>
        <h4><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&tempid=<?php echo $value['tempid'];?>&iframe=yes"><?php echo $value['name'];?></a><?php if($value['author']) { ?><span>(<?php echo $value['author'];?>)</span><?php } ?></h4>
        <div><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&tempid=<?php echo $value['tempid'];?>&iframe=yes"><img src="<?php echo $value['cover'];?>" onerror="this.onerror=null;this.src='./admin/style/nocover.jpg'"></a></div>
        <?php if($value['copyright']) { ?><p class="copy"><?php echo $value['copyright'];?></p><?php } ?>
        <p class="set"><label class="radio"><input type="radio" class="check" name="touch" value="<?php echo $value['tempid'];?>" <?php if($value['touch']) { ?>checked<?php } ?>/><span class="icon"></span>手机版</label><label class="radio"><input type="radio" class="check" name="pc" value="<?php echo $value['tempid'];?>" <?php if($value['pc']) { ?>checked<?php } ?>/><span class="icon"></span>PC版</label></p>
        <p class="btn"><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&tempid=<?php echo $value['tempid'];?>&iframe=yes">[编辑]</a><?php if(!$value['touch'] && !$value['pc']) { ?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=delete&tempid=<?php echo $value['tempid'];?>&iframe=yes">[删除]</a><?php } ?></p>
        
      </li>
      <?php } ?>
    </ul>
    <p class="btnarea"><button type="submit" class="button" name="submit" value="true">提交设置</button></p>
  </form>
</div>
<?php } ?>