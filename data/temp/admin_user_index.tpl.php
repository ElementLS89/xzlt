
<?php if($_GET['searchsubmit']) { include temp(user_list);?><?php } else { ?>
<div class="block">
  <h3>用户管理</h3>
  <ul class="block_info">
    <li>通过下方搜索出符合条件的用户</li>
    <li>然后对列表展示出来的用户进行管理操作</li>
  </ul>
</div>
<div class="block">
  <h3>搜索用户</h3>
  <form action="admin.php" method="get">
    <input name="mod" type="hidden" value="<?php echo $_GET['mod'];?>" />
    <input name="item" type="hidden" value="<?php echo $_GET['item'];?>" />
    <input name="iframe" type="hidden" value="true" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>用户名</th>
        <td><input type="text" class="input w300" name="search[username]" value=""></td>
      </tr>
      <tr>
        <th>电话号码</th>
        <td><input type="text" class="input w300" name="search[telnum]" value=""></td>
      </tr>
      <tr>
        <th>用户组</th>
        <td>
          <div class="select">
            <select name="search[groupid]">
              <option value="">请选择</option>
              <?php if(is_array($_S['cache']['usergroup'])) foreach($_S['cache']['usergroup'] as $value) { ?>              <option value="<?php echo $value['gid'];?>"><?php echo $value['name'];?></option>
              <?php } ?>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>状态</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="search[state]" value="-1" checked="checked"/><span class="icon"></span>不限</label>
        <label class="radio"><input type="radio" class="check" name="search[state]" value="0" /><span class="icon"></span>未审核</label>
        <label class="radio"><input type="radio" class="check" name="search[state]" value="1"/><span class="icon"></span>已审核</label>
        </td>
      </tr>
      <tr>
        <th>是否绑定微信</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="search[openid]" value="-1" checked="checked"/><span class="icon"></span>不限</label>
        <label class="radio"><input type="radio" class="check" name="search[openid]" value="0"/><span class="icon"></span>否</label>
        <label class="radio"><input type="radio" class="check" name="search[openid]" value="1"/><span class="icon"></span>是</label>
        </td>
      </tr>
      <tr>
        <th>是否绑定手机</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="search[tel]" value="-1" checked="checked"/><span class="icon"></span>不限</label>
        <label class="radio"><input type="radio" class="check" name="search[tel]" value="0"/><span class="icon"></span>否</label>
        <label class="radio"><input type="radio" class="check" name="search[tel]" value="1"/><span class="icon"></span>是</label>
        </td>
      </tr>
      <tbody id="more" style="display:none">
        <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>        <?php if($value['canuse']) { ?>
        <tr>
          <th><?php echo $value['name'];?></th>
          <td>
          <?php if(in_array($value['type'],array('text','textarea','file'))) { ?>
          <label class="radio"><input type="radio" class="check" name="field[<?php echo $field;?>]" value="0" /><span class="icon"></span>未设置</label>
          <label class="radio"><input type="radio" class="check" name="field[<?php echo $field;?>]" value="1"/><span class="icon"></span>有设置</label>
          <?php } elseif($value['type']=='radio') { ?>
          <?php if(is_array($value['choises'])) foreach($value['choises'] as $k => $n) { ?>          <label class="radio"><input type="radio" class="check" name="field[<?php echo $field;?>]" value="<?php echo $k;?>"/><span class="icon"></span><?php echo $n;?></label>
          <?php } ?>
          <?php } elseif(in_array($value['type'],array('select','checkbox'))) { ?>
          <div class="select">
            <select name="field[<?php echo $field;?>]">
              <option value="">请选择</option>
              <?php if(is_array($value['choises'])) foreach($value['choises'] as $k => $n) { ?>              <option value="<?php echo $k;?>"><?php echo $n;?></option>
              <?php } ?>
            </select>
          </div> 
          <?php } elseif(in_array($value['type'],array('number','date'))) { ?>
          <input type="text" class="input" name="field[<?php echo $field;?>][]" value=""><em>-</em><input type="text" class="input" name="field[<?php echo $field;?>][]" value="">
          <?php } ?>
          </td>
        </tr>
        <?php } ?>
        <?php } ?>
      </tbody>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="searchsubmit" value="true">搜索</button><a href="javascript:" onclick="$('#more').toggle()">点击进行高级搜索</a>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>
</div>
<?php } ?>

