
<ul class="catalog cl">
  <li<?php if(!$_GET['show']) { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&iframe=yes">论坛管理</a></li>
  <li<?php if($_GET['show']=='other') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&show=other&iframe=yes">未关联板块</a></li>
</ul>
<?php if(in_array($_GET['ac'],array('add','edit'))) { ?>
<div class="block">
  <h3><?php if($_GET['ac']=='add') { if($_GET['gid']) { ?>添加板块<?php } else { ?>添加分区<?php } } else { if($_GET['gid']) { ?>设置分区<?php } else { ?>设置板块<?php } } ?></h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=<?php echo $_GET['ac'];?>" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <?php if($_GET['gid']) { ?>
    <input name="gid" type="hidden" value="<?php echo $_GET['gid'];?>" />
    <?php } elseif($_GET['tid']) { ?>
    <input name="tid" type="hidden" value="<?php echo $_GET['tid'];?>" />
    <?php } ?>
    <table class="table" cellpadding="0" cellspacing="0">
      <?php if(($_GET['ac']=='add' && !$_GET['gid']) || ($_GET['ac']=='edit' && $_GET['gid'])) { ?>
      <tr>
        <th>分区名称</th>
        <td><input type="text" class="input w300" name="name" value="<?php echo $group['name'];?>"></td>
      </tr>
      <tr>
        <th>隐藏</th>
        <td><label class="checkbox"><input type="checkbox" class="check" name="hidden" value="1" <?php if($group['hidden']) { ?>checked<?php } ?>/><span class="icon"></span></label><em>是否隐藏分区不显示</em></td>
      </tr>
      <tr>
        <th>版主</th>
        <td><input type="text" class="input w300" name="manager" value="<?php echo $group['manager'];?>"><em>输入版主的用户名，多个用空格隔开</em></td>
      </tr>    
      <tr>
        <th>介绍</th>
        <td><textarea class="textarea" name="about"><?php echo $group['about'];?></textarea></td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button>
          </td>
        </tr>  
      </tfoot>
      <?php } else { ?>
      <tr>
        <th>板块名称</th>
        <td><input type="text" class="input w300" name="name" value="<?php echo $forum['name'];?>"></td>
      </tr>
      <?php if($forum) { ?>
      <tr>
        <th>设置为话题</th>
        <td><label class="checkbox"><input type="checkbox" class="check" name="settopic" value="1" onclick="set_topic()"/><span class="icon"></span>将本板块设置为话题</label></td>
      </tr>
      <tr id="settopic" style="display:none">
        <th>所属分类</th>
        <td>
          <div class="select">
            <select name="typeid">
              <?php if(is_array($_S['cache']['topic_types'])) foreach($_S['cache']['topic_types'] as $value) { ?>              <option value="<?php echo $value['typeid'];?>" ><?php echo $value['name'];?></option>
              <?php } ?>
            </select>
          </div>  
        </td>
      </tr>
      <?php } ?>
      <tr id="setforum">
        <th>所属分区</th>
        <td>
          <div class="select">
            <select name="groupid">
              <?php if(is_array($_S['cache']['topic_groups'])) foreach($_S['cache']['topic_groups'] as $value) { ?>              <option value="<?php echo $value['gid'];?>"<?php if($value['gid']==$forum['gid'] || $value['gid']==$_GET['gid']) { ?> selected<?php } ?>><?php echo $value['name'];?></option>
              <?php } ?>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>图标</th>
        <td><?php if($forum['cover']) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $forum['cover'];?>"><?php } ?><input type="file" name="cover"></td>
      </tr>
      <tr>
        <th>顶部banner</th>
        <td><?php if($forum['banner']) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $forum['banner'];?>"><?php } ?><input type="file" name="banner"></td>
      </tr>
      <tr>
        <th>介绍</th>
        <td><textarea class="textarea" name="about"><?php echo $forum['about'];?></textarea></td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button><em>更多管理项目请直接通过前端进行管理</em>
          </td>
        </tr>  
      </tfoot>    
      <?php } ?>
    </table>
  </form>
</div>
<script language="javascript">
  function set_topic(){
if($('#settopic').css('display')=='none'){
$('#settopic').show();
$('#setforum').hide();
}else{
$('#settopic').hide();
$('#setforum').show();
}
}

</script>
<?php } else { if($_GET['show']=='other') { if($others) { ?>
<form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&show=other" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="w80">帖子数</td>
        <td>板块名称</td>
        
      </tr>
    </thead>
    <?php if(is_array($others)) foreach($others as $forum) { ?>    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="tid[]" value="<?php echo $forum['tid'];?>"/><span class="icon"></span></label></td>
        <td class="w80"><?php echo $forum['themes'];?></td>
        <td><?php echo $forum['name'];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&tid=<?php echo $forum['tid'];?>&iframe=yes"><em>[编辑]</em></a></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'tid[]')"/><span class="icon"></span></label></td>
        <td colspan="2"><button type="button" class="button" onclick="checkdelete(this.form,'tid')">提交</button></td>
      </tr>
    </tfoot>
  </table>
</form>
<?php } else { ?>
<p class="empty">目前没有未关联板块</p>
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
        <td class="s">Tid</td>
        <td class="l">顺序</td>
        <td>名称</td>
      </tr>
    </thead>
    <?php if($groups) { ?>
    <?php if(is_array($groups)) foreach($groups as $value) { ?>    <input type="hidden" name="gids[]" value="<?php echo $value['gid'];?>">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="gid[]" value="<?php echo $value['gid'];?>"/><span class="icon"></span></label></td>
        <td class="s"></td>
        <td class="l"><input type="text" class="input" name="grouplist[]" value="<?php echo $value['list'];?>"></td>
        <td>
        <?php echo $value['name'];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&gid=<?php echo $value['gid'];?>&iframe=yes"><em>[编辑]</em></a><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=add&gid=<?php echo $value['gid'];?>&iframe=yes"><em>[添加板块]</em></a>
        </td>
      </tr>
    </tbody>
    <?php if(is_array($forums[$value['gid']])) foreach($forums[$value['gid']] as $forum) { ?>    <input type="hidden" name="tids[]" value="<?php echo $forum['tid'];?>">
    <tbody>
      <tr>
        <td class="s"></td>
        <td class="s"><?php echo $forum['tid'];?></td>
        <td class="l"><input type="text" class="input" name="forumlist[]" value="<?php echo $forum['list'];?>"></td>
        <td>
        |---- <?php echo $forum['name'];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&tid=<?php echo $forum['tid'];?>&iframe=yes"><em>[编辑]</em></a>
        </td>
      </tr>
    </tbody>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'gid[]')"/><span class="icon"></span></label></td>
        <td colspan="3"><button type="button" class="button" onclick="checkdelete(this.form,'gid')">提交</button><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=add&iframe=yes">+添加分区</a></td>
      </tr>
    </tfoot>
    
  </table>
</form>


<?php } } ?>

