
<ul class="catalog cl">
  <li<?php if($_GET['ac']!='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&iframe=yes">话题管理</a></li>
  <li<?php if($_GET['ac']=='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=add&iframe=yes">添加话题</a></li>
</ul>
<?php if(in_array($_GET['ac'],array('add','edit'))) { ?>
<div class="block">
  <h3><?php if($_GET['ac']=='add') { ?>添加话题<?php } else { ?>编辑话题<?php } ?></h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=<?php echo $_GET['ac'];?>" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <input name="tid" type="hidden" value="<?php echo $_GET['tid'];?>" />
    <input name="ref" type="hidden" value="<?php echo $_GET['ref'];?>" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>话题名称</th>
        <td><input type="text" class="input w300" name="name" value="<?php echo $topic['name'];?>"></td>
      </tr>
      <tr>
        <th>所属分类</th>
        <td>
          <div class="select">
            <select name="typeid">
              <?php if(is_array($_S['cache']['topic_types'])) foreach($_S['cache']['topic_types'] as $value) { ?>              <option value="<?php echo $value['typeid'];?>"<?php if($value['typeid']==$topic['typeid']) { ?> selected<?php } ?>><?php echo $value['name'];?></option>
              <?php } ?>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>加入权限</th>
        <td>
          <div class="select">
            <select name="open">
              <option value="1" <?php if($topic['open']=='1') { ?>selected<?php } ?>>直接加入无需审核</option>
              <option value="0" <?php if($topic['open']=='0') { ?>selected<?php } ?>>需要审核</option>
              <option value="-1" <?php if($topic['open']=='-1') { ?>selected<?php } ?>>拒绝申请</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>看帖权限</th>
        <td>
          <div class="select">
            <select name="show">
              <option value="1" <?php if($topic['show']=='1') { ?>selected<?php } ?>>开放访问</option>
              <option value="0" <?php if($topic['show']=='0') { ?>selected<?php } ?>>仅成员可以访问</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>发帖权限</th>
        <td>
          <div class="select">
            <select name="addtheme">
              <option value="1" <?php if($topic['addtheme']=='1') { ?>selected<?php } ?>>开放发帖</option>
              <option value="0" <?php if($topic['addtheme']=='0') { ?>selected<?php } ?>>仅成员可以发帖</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>回帖权限</th>
        <td>
          <div class="select">
            <select name="reply">
              <option value="1" <?php if($topic['reply']=='1') { ?>selected<?php } ?>>开放回帖</option>
              <option value="0" <?php if($topic['reply']=='0') { ?>selected<?php } ?>>仅成员可以回帖</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>管理团队申请权限</th>
        <td>
          <div class="select">
            <select name="allowapply">
              <?php if(is_array($topicgroup)) foreach($topicgroup as $level => $value) { ?>              <option value="<?php echo $level;?>"<?php if($topic['allowapply']==$level) { ?> selected<?php } ?>><?php echo $value['name'];?></option>
              <?php } ?>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>最大组长数</th>
        <td>
          <div class="select">
            <select name="maxleaders">
              <option value="1"<?php if($topic['maxleaders']=='1') { ?> selected<?php } ?>>一个</option>
              <option value="2"<?php if($topic['maxleaders']=='2') { ?> selected<?php } ?>>两个</option>
              <option value="3"<?php if($topic['maxleaders']=='3') { ?> selected<?php } ?>>三个</option>
              <option value="4"<?php if($topic['maxleaders']=='4') { ?> selected<?php } ?>>四个</option>
              <option value="5"<?php if($topic['maxleaders']=='5') { ?> selected<?php } ?>>五个</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>最大小组长数</th>
        <td>
          <div class="select">
            <select name="maxmanagers">
              <option value="1"<?php if($topic['maxmanagers']=='1') { ?> selected<?php } ?>>一个</option>
              <option value="2"<?php if($topic['maxmanagers']=='2') { ?> selected<?php } ?>>两个</option>
              <option value="3"<?php if($topic['maxmanagers']=='3') { ?> selected<?php } ?>>三个</option>
              <option value="4"<?php if($topic['maxmanagers']=='4') { ?> selected<?php } ?>>四个</option>
              <option value="5"<?php if($topic['maxmanagers']=='5') { ?> selected<?php } ?>>五个</option>
              <option value="6"<?php if($topic['maxmanagers']=='6') { ?> selected<?php } ?>>六个</option>
              <option value="7"<?php if($topic['maxmanagers']=='7') { ?> selected<?php } ?>>七个</option>
              <option value="8"<?php if($topic['maxmanagers']=='8') { ?> selected<?php } ?>>八个</option>
              <option value="9"<?php if($topic['maxmanagers']=='9') { ?> selected<?php } ?>>九个</option>
              <option value="10"<?php if($topic['maxmanagers']=='10') { ?> selected<?php } ?>>十个</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>列表样式风格</th>
        <td>
          <div class="select">
            <select name="liststype">
              <?php if(is_array($_S['setting']['themestyle'])) foreach($_S['setting']['themestyle'] as $value) { ?>              <option value="<?php echo $value['id'];?>" <?php if($topic['liststype']==$value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
              <?php } ?>
            </select>
          </div>  
        </td>
      </tr>
      
      <tr>
        <th>图标</th>
        <td><?php if($topic['cover']) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $topic['cover'];?>"><?php } ?><input type="file" name="cover"></td>
      </tr>
      <tr>
        <th>顶部banner</th>
        <td><?php if($topic['banner']) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $topic['banner'];?>"><?php } ?><input type="file" name="banner"></td>
      </tr>
      <tr>
        <th>介绍</th>
        <td><textarea class="textarea" name="about"><?php echo $topic['about'];?></textarea></td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button><em>更多管理项目请直接通过前端进行管理</em>
          </td>
        </tr>  
      </tfoot>    
  
    </table>
  </form>
</div>
<?php } elseif($_GET['searchsubmit']) { if($list) { ?>
<form action="<?php echo $urlstr;?>&page=<?php echo $_S['page'];?>" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="deletesubmit" id="deletesubmit" type="hidden" value="" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">选择</td>
        <td class="s">Tid</td>
        <td class="w300">话题</td>
        <td class="l">状态</td>
        <td class="l">今日</td>
        <td class="l">用户数</td>
        <td class="l">帖子数</td>
        <td>介绍</td>
      </tr>
    </thead>
    <?php if(is_array($list)) foreach($list as $value) { ?>    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="tid[]" value="<?php echo $value['tid'];?>"/><span class="icon"></span></label></td>
        <td class="s"><?php echo $value['tid'];?></td>
        <td class="w300"><img src="<?php echo $value['cover'];?>" /><?php echo $value['name'];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=edit&tid=<?php echo $value['tid'];?>&iframe=yes&ref=<?php echo $ref;?>"><em>[编辑]</em></a></td>
        <td class="l"><?php if($value['state']) { ?>已审核<?php } else { ?>未审核<?php } ?></td>
        <td class="l"><?php echo $value['today'];?></td>
        <td class="l"><?php echo $value['users'];?></td>
        <td class="l"><?php echo $value['themes'];?></td>
        <td><?php echo $value['about'];?></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'tid[]')"/><span class="icon"></span></label></td>
        <td colspan="7"><?php echo $pages;?><button type="button" class="button w" onclick="checkdelete(this.form,'tid','deletesubmit')">删除</button><?php if(!$_GET['state']) { ?><button type="submit" class="button" name="examinesubmit" value="true">审核</button><?php } ?></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } else { ?>
<p class="empty">没有找到符合条件的话题</p>
<?php } } else { ?>
<div class="block">
  <h3>关于话题的管理</h3>
  <ul class="block_info">
    <li>通过下方搜索出相关话题</li>
    <li>然后对列表展示出来的话题进行管理操作</li>
  </ul>
  <form action="admin.php" method="get">
    <input name="mod" type="hidden" value="<?php echo $_GET['mod'];?>" />
    <input name="item" type="hidden" value="<?php echo $_GET['item'];?>" />
    <input name="iframe" type="hidden" value="true" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>分类</th>
        <td>
          <div class="select">
            <select name="typeid">
              <option value="0">不限</option>
              <?php if(is_array($_S['cache']['topic_types'])) foreach($_S['cache']['topic_types'] as $type) { ?>              <option value="<?php echo $type['typeid'];?>"><?php echo $type['name'];?></option>
              <?php } ?>
            </select>
          </div> 
        </td>
      </tr>
      <tr>
        <th>名称</th>
        <td><input type="text" class="input w300" name="name" value=""></td>
      </tr>
      <tr>
        <th>状态</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="state" value="0" checked="checked"
        /><span class="icon"></span>未审核</label>
        <label class="radio"><input type="radio" class="check" name="state" value="1"/><span class="icon"></span>已审核</label>
        </td>
      </tr>
      <tr>
        <th>排序</th>
        <td>
          <div class="select">
            <select name="order">
              <option value="1">按创建时间倒叙</option>
              <option value="2">按用户数量倒叙</option>
              <option value="3">按帖子数量倒叙</option>
            </select>
          </div>  
        </td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="searchsubmit" value="true">搜索</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>  
</div>



<?php } ?>