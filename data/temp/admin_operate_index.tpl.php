
<ul class="catalog cl">
  <li<?php if(!$_GET['ac']) { ?> class="a"<?php } ?>><a href="admin.php?mod=operate&item=index&iframe=yes">公告管理</a></li>
  <li<?php if($_GET['ac']=='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=operate&item=index&ac=add&iframe=yes">添加公告</a></li>
</ul>
<?php if(in_array($_GET['ac'],array('add','edit'))) { ?>
<div class="block">
  <h3>说明</h3>
  <ul class="block_info">
    <li>如果设置了展示期限，那么期限到了之后，公告将会被撤下</li>
  </ul>
  <form action="admin.php?mod=operate&item=index&ac=<?php echo $_GET['ac'];?>" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <?php if($_GET['aid']) { ?>
    <input name="aid" type="hidden" value="<?php echo $_GET['aid'];?>" />
    <?php } ?>
    
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>公告标题</th>
        <td><input type="text" class="input w300" name="subject" value="<?php echo $announcement['subject'];?>"></td>
      </tr>
      <tr>
        <th class="need">公告内容</th>
        <td><textarea class="textarea" name="content"><?php echo $announcement['content'];?></textarea></td>
      </tr>
      <tr>
        <th>展示期限</th>
        <td>
          <div class="select">
            <select name="term">
              <option value="0"<?php if(!$announcement['term']) { ?> selected<?php } ?>>不限时间</option>
              <option value="1"<?php if($announcement['term']==1) { ?> selected<?php } ?>>一周</option>
              <option value="2"<?php if($announcement['term']==2) { ?> selected<?php } ?>>两周</option>
              <option value="3"<?php if($announcement['term']==3) { ?> selected<?php } ?>>一个月</option>
              <option value="4"<?php if($announcement['term']==4) { ?> selected<?php } ?>>三个月</option>
            </select>
          </div>
          <em>展示期限是从当前时间开始算起的，如果编辑修改公告内容，则送编辑的时间开始算起</em>    
        </td>
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

<?php } else { if($announcements) { ?>
<form action="admin.php?mod=operate&item=index" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <input name="dosubmit" type="hidden" value="true" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="s">AID</td>
        <td class="w150">到期时间</td>
        <td>公告</td>
      </tr>
    </thead>
    <?php if(is_array($announcements)) foreach($announcements as $value) { ?>    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="aid[]" value="<?php echo $value['aid'];?>"/><span class="icon"></span></label></td>
        <td class="s"><?php echo $value['aid'];?></td>
        <td class="w150"><?php if($value['dateline']==-1) { ?>已过期<?php } elseif(!$value['dateline']) { ?>无期限<?php } else { ?><?php echo smsdate($value['dateline'],'Y-m-d');?><?php } ?></td>
        <td><?php echo $value['subject'];?><a href="admin.php?mod=operate&item=index&ac=edit&aid=<?php echo $value['aid'];?>&iframe=yes"><em>[编辑]</em></a></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'aid[]')"/><span class="icon"></span></label></td>
        <td colspan="3"><button type="button" class="button" onclick="checkdelete(this.form,'aid')">提交</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } else { ?>
<p class="empty">暂无任何公告内容</p>
<?php } } ?>