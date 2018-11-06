
<?php if($_GET['ac']) { if($_GET['ac']=='set') { ?>
<ul class="catalog cl">
  <li<?php if(!$_GET['t']) { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&ac=set&id=<?php echo $_GET['id'];?>&iframe=yes">基本设置</a></li>
  <?php if(is_array($navs)) foreach($navs as $t => $nv) { ?>  <li<?php if($_GET['t']==$t) { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&ac=set&id=<?php echo $_GET['id'];?>&t=<?php echo $t;?>&iframe=yes"><?php echo $nv;?></a></li>
  <?php } ?>
</ul>
<?php if($_GET['t']) { $temp=$_GET['id'].':set/'.$_GET['t']?><?php include temp($temp);?><?php } else { ?>
<div class="block">
  <h3>基本设置</h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&ac=<?php echo $_GET['ac'];?>&id=<?php echo $_GET['id'];?>" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />

    <table class="table" cellpadding="0" cellspacing="0">
      <?php if(is_array($hack['setting'])) foreach($hack['setting'] as $value) { ?>      <?php $value['about']=str_replace("\n","<br />",$value['about']);?>      <tr>
        <th><?php echo $value['name'];?></th>
        <td>
        <?php if($value['type']=='usergroup') { ?>
        <?php C::chche('usergroup');?>        <?php $value['value']=@explode(',',$value['value'])?>        <?php if(is_array($_S['cache']['usergroup'])) foreach($_S['cache']['usergroup'] as $v) { ?>        <label class="checkbox"><input type="checkbox" class="check" name="set[<?php echo $value['valueid'];?>][]" value="<?php echo $v['gid'];?>" <?php if(in_array($v['gid'],$value['value'])) { ?>checked="checked"<?php } ?>/><span class="icon"></span><?php echo $v['name'];?></label>
        <?php } ?>
        <?php } elseif($value['type']=='forum') { ?>
        <input type="text" class="input" name="set[<?php echo $value['valueid'];?>]" value="<?php echo $value['value'];?>"><em>填写板块或话题的tid多个用半角的逗号","隔开</em>
        <?php } elseif($value['type']=='number' || $value['type']=='text') { ?>
        <input type="text" class="input" name="set[<?php echo $value['valueid'];?>]" value="<?php echo $value['value'];?>">
        <?php } elseif($value['type']=='textarea') { ?>
        <textarea class="textarea" name="set[<?php echo $value['valueid'];?>]"><?php echo $value['value'];?></textarea>
        <?php } elseif($value['type']=='radio') { ?>
        <?php if(is_array($value['choose'])) foreach($value['choose'] as $v) { ?>        <label class="radio"><input type="radio" class="check" name="set[<?php echo $value['valueid'];?>]" value="<?php echo $v['key'];?>" <?php if($value['value']==$v['key']) { ?>checked="checked"<?php } ?>/><span class="icon"></span><?php echo $v['name'];?></label>
        <?php } ?>
        <?php } elseif($value['type']=='select') { ?>
        <div class="select">
          <select name="set[<?php echo $value['valueid'];?>]">
            <option value="0">请选择</option>
            <?php if(is_array($value['choose'])) foreach($value['choose'] as $v) { ?>            <option value="<?php echo $v['key'];?>" <?php if($value['value']==$v['key']) { ?>selected="selected"<?php } ?>><?php echo $v['name'];?></option>
            <?php } ?>
          </select>
        </div>      
        <?php } elseif($value['type']=='checkbox') { ?>
        <?php $value['value']=@explode(',',$value['value'])?>        <?php if(is_array($value['choose'])) foreach($value['choose'] as $v) { ?>        <label class="checkbox"><input type="checkbox" class="check" name="set[<?php echo $value['valueid'];?>][]" value="<?php echo $v['key'];?>" <?php if(in_array($v['key'],$value['value'])) { ?>checked="checked"<?php } ?>/><span class="icon"></span><?php echo $v['name'];?></label>
        <?php } ?>
        <?php } elseif($value['type']=='date') { ?>
        <input type="text" class="input" name="set[<?php echo $value['valueid'];?>]" value="<?php echo $value['value'];?>"><em>格式为 : <?php echo smsdate($_S['timestamp'],'Y-m-d');?></em>
        <?php } elseif($value['type']=='time') { ?>
        <input type="text" class="input" name="set[<?php echo $value['valueid'];?>]" value="<?php echo $value['value'];?>"><em>格式为 : <?php echo smsdate($_S['timestamp'],'Y-m-d H:i:s');?></em>
        <?php } ?>
        
        </td>
        <td class="about"><?php echo $value['about'];?></td>
      </tr>
      <?php } ?>

  
      <tfoot>
        <tr>
          <td colspan="3">
           <button type="submit" class="button" name="submit" value="true">提交</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>
</div>


<?php } } elseif($_GET['ac']=='develop') { ?>
<ul class="catalog cl">
  <li<?php if(!$_GET['op']) { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&ac=develop&id=<?php echo $_GET['id'];?>&iframe=yes">基本设置</a></li>
  <li<?php if($_GET['op']=='set' || $_GET['op']=='edit') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&ac=develop&id=<?php echo $_GET['id'];?>&op=set&iframe=yes">变量设置</a></li>
  <li<?php if($_GET['op']=='add') { ?> class="a"<?php } ?>><a href="admin.php?mod=<?php echo $_GET['mod'];?>&ac=develop&id=<?php echo $_GET['id'];?>&op=add&iframe=yes">添加变量</a></li>
</ul>
<?php if(!$_GET['op']) { ?>
<div class="block">
  <h3>基本设置</h3>
  <?php include temp('hack'); ?></div>
<?php } else { if(in_array($_GET['op'],array('add','edit'))) { ?>
<div class="block">
  <h3><?php if($_GET['op']=='add') { ?>添加变量<?php } else { ?>编辑变量<?php } ?></h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&ac=<?php echo $_GET['ac'];?>&op=<?php echo $_GET['op'];?>&id=<?php echo $_GET['id'];?>" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <?php if($_GET['valueid']) { ?>
    <input name="valueid" type="hidden" value="<?php echo $_GET['valueid'];?>" />
    <?php } ?>
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th class="need">变量名称</th>
        <td><input type="text" class="input" name="name" value="<?php echo $set['name'];?>"><em>中英文均可，用于显示在应用配置的菜单中</em></td>
      </tr>
      <tr>
        <th class="need">变量ID</th>
        <td><input type="text" class="input" name="<?php if($set) { ?>newvalueid<?php } else { ?>valueid<?php } ?>" value="<?php echo $set['valueid'];?>"><em>设置配置项目的变量名，用于应用程序中调用，可包含英文、数字和下划线，在同一个应用中需要保持变量名的唯一性</em></td>
      </tr>
      <tr>
        <th class="need">变量类型</th>
        <td>
          <div class="select">
            <select name="type" onchange="changetype(this.value)">
              <?php if(is_array($valuetype)) foreach($valuetype as $type => $name) { ?>              <option value="<?php echo $type;?>" <?php if($set['type']==$type) { ?>selected="selected"<?php } ?>><?php echo $name;?></option>
              <?php } ?>
            </select>
          </div>    
        </td>
      </tr>    
      <tr>
        <th>配置说明</th>
        <td><textarea class="textarea" name="about"><?php echo $set['about'];?></textarea><em>描述此项配置的用途和取值范围，详细的描述有利于应用使用者了解这个设置的作用</em></td>
      </tr>
  
      <tr id="content" <?php if(!in_array($set['type'],array('radio','select','checkbox'))) { ?>style="display:none"<?php } ?>>
        <th>配置内容</th>
        <td><textarea class="textarea" name="content"><?php echo $set['content'];?></textarea><em>任意写法的字符串，后期在应用程序文件中进行解析</em></td>
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
<script language="javascript">
  function changetype(value){
if(value=='radio' || value=='select' || value=='checkbox'){
$('#content').show();
}else{
$('#content').hide();
}
}
</script>
<?php } else { if($values) { ?>
<form action="admin.php?mod=<?php echo $_GET['mod'];?>&ac=<?php echo $_GET['ac'];?>&id=<?php echo $hack['id'];?>&op=set" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="l">顺序</td>
        <td class="w200">变量名称</td>
        <td class="w200">变量ID</td>
        <td>变量类型</td>
      </tr>
    </thead>
    <?php if(is_array($values)) foreach($values as $valueid => $value) { ?>    
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="valueid[]" value="<?php echo $value['valueid'];?>"/><span class="icon"></span></label></td>
        <td class="l"><input name="valueids[]" type="hidden" value="<?php echo $valueid;?>" /><input type="text" class="input" name="list[<?php echo $valueid;?>]" value="<?php echo $value['list'];?>"></td>
        <td class="w200"><?php echo $value['name'];?></td>
        <td class="w200"><?php echo $value['valueid'];?></td>
        <td><?php echo $valuetype[$value['type']];?><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&ac=develop&id=<?php echo $hack['id'];?>&valueid=<?php echo $value['valueid'];?>&op=edit&iframe=yes"><em>[设置]</em></a></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'valueid[]')"/><span class="icon"></span></label></td>
        <td colspan="4"><button type="submit" class="button" name="submit" value="true">提交</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } else { ?>
<p class="empty">插件暂未添加变量</p>
<?php } } } } } else { if(!$hacklist['open'] && !$hacklist['close'] && !$hacklist['notinstall']) { ?>
<p class="empty">暂未安装任何应用,前往<a href="admin.php?mod=hacks&item=appstore" target="_top">应用商店</a>安装需要的应用</p>
<?php } else { if($hacklist['open']) { ?>
<div class="block">
  <h3>已启用</h3>
  <ul class="hacks cl">
    <?php if(is_array($hacklist['open'])) foreach($hacklist['open'] as $hack) { ?>    <li>
      <img src="<?php echo $hack['icon'];?>" onerror="this.onerror=null;this.src='./admin/style/nologo.jpg'"/>
      <h4><?php echo $hack['name'];?><span>V <?php echo $hack['version'];?></span></h4>
      <p><?php echo $hack['about'];?></p>
      <p><a href="<?php echo $hack['set'];?>" class="c">[设置]</a><a href="admin.php?mod=hacks&ac=close&id=<?php echo $hack['id'];?>&iframe=yes" class="c">[关闭]</a><a href="admin.php?mod=hacks&ac=uninstall&id=<?php echo $hack['id'];?>&iframe=yes" class="c">[卸载]</a><a href="admin.php?mod=hacks&ac=develop&id=<?php echo $hack['id'];?>&iframe=yes" class="c">[开发]</a></p>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } if($hacklist['close']) { ?>
<div class="block">
  <h3>未启用</h3>
  <ul class="hacks cl">
    <?php if(is_array($hacklist['close'])) foreach($hacklist['close'] as $hack) { ?>    <li>
      <img src="<?php echo $hack['icon'];?>" onerror="this.onerror=null;this.src='./admin/style/nologo.jpg'"/>
      <h4><?php echo $hack['name'];?><span>V <?php echo $hack['version'];?></span></h4>
      <p><?php echo $hack['about'];?></p>
      <p><a href="<?php echo $hack['set'];?>" class="c">[设置]</a><a href="admin.php?mod=hacks&ac=open&id=<?php echo $hack['id'];?>&iframe=yes" class="c">[开启]</a><a href="admin.php?mod=hacks&ac=uninstall&id=<?php echo $hack['id'];?>&iframe=yes" class="c">[卸载]</a><a href="admin.php?mod=hacks&ac=develop&id=<?php echo $hack['id'];?>&iframe=yes" class="c">[开发]</a></p>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } if($hacklist['notinstall']) { ?>
<div class="block">
  <h3>未安装</h3>
  <ul class="hacks cl">
    <?php if(is_array($hacklist['notinstall'])) foreach($hacklist['notinstall'] as $hack) { ?>    <li>
      <img src="<?php echo $hack['icon'];?>" onerror="this.onerror=null;this.src='./admin/style/nologo.jpg'"/>
      <h4><?php echo $hack['name'];?><span>V <?php echo $hack['version'];?></span></h4>
      <p><?php echo $hack['about'];?></p>
      <p><a href="admin.php?mod=hacks&ac=install&id=<?php echo $hack['id'];?>&iframe=yes" class="c">[安装]</a></p>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } } } ?>