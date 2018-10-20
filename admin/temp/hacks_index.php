<?exit?>
<!--{if $_GET['ac']}-->
<!--{if $_GET['ac']=='set'}-->
<ul class="catalog cl">
  <li{if !$_GET['t']} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&ac=set&id=$_GET['id']&iframe=yes">基本设置</a></li>
  <!--{loop $navs $t $nv}-->
  <li{if $_GET['t']==$t} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&ac=set&id=$_GET['id']&t=$t&iframe=yes">$nv</a></li>
  <!--{/loop}-->
</ul>
<!--{if $_GET[t]}-->
<!--{eval $temp=$_GET['id'].':set/'.$_GET['t']}-->
<!--{eval include temp($temp);}-->
<!--{else}-->
<div class="block">
  <h3>基本设置</h3>
  <form action="admin.php?mod=$_GET['mod']&ac=$_GET['ac']&id=$_GET['id']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />

    <table class="table" cellpadding="0" cellspacing="0">
      <!--{loop $hack['setting'] $value}-->
      {eval $value['about']=str_replace("\n","<br />",$value['about']);}
      <tr>
        <th>$value['name']</th>
        <td>
        <!--{if $value['type']=='usergroup'}-->
        <!--{eval C::chche('usergroup');}-->
        <!--{eval $value['value']=@explode(',',$value['value'])}-->
        <!--{loop $_S['cache']['usergroup'] $v}-->
        <label class="checkbox"><input type="checkbox" class="check" name="set[{$value['valueid']}][]" value="$v['gid']" {if in_array($v['gid'],$value['value'])}checked="checked"{/if}/><span class="icon"></span>$v['name']</label>
        <!--{/loop}-->
        <!--{elseif $value['type']=='forum'}-->
        <input type="text" class="input" name="set[{$value['valueid']}]" value="$value['value']"><em>填写板块或话题的tid多个用半角的逗号","隔开</em>
        <!--{elseif $value['type']=='number' || $value['type']=='text'}-->
        <input type="text" class="input" name="set[{$value['valueid']}]" value="$value['value']">
        <!--{elseif $value['type']=='textarea'}-->
        <textarea class="textarea" name="set[{$value['valueid']}]">$value['value']</textarea>
        <!--{elseif $value['type']=='radio'}-->
        <!--{loop $value['choose'] $v}-->
        <label class="radio"><input type="radio" class="check" name="set[{$value['valueid']}]" value="$v['key']" {if $value['value']==$v['key']}checked="checked"{/if}/><span class="icon"></span>$v['name']</label>
        <!--{/loop}-->
        <!--{elseif $value['type']=='select'}-->
        <div class="select">
          <select name="set[{$value['valueid']}]">
            <option value="0">请选择</option>
            <!--{loop $value['choose'] $v}-->
            <option value="$v['key']" {if $value['value']==$v['key']}selected="selected"{/if}>$v['name']</option>
            <!--{/loop}-->
          </select>
        </div>      
        <!--{elseif $value['type']=='checkbox'}-->
        <!--{eval $value['value']=@explode(',',$value['value'])}-->
        <!--{loop $value['choose'] $v}-->
        <label class="checkbox"><input type="checkbox" class="check" name="set[{$value['valueid']}][]" value="$v['key']" {if in_array($v['key'],$value['value'])}checked="checked"{/if}/><span class="icon"></span>$v['name']</label>
        <!--{/loop}-->
        <!--{elseif $value['type']=='date'}-->
        <input type="text" class="input" name="set[{$value['valueid']}]" value="$value['value']"><em>格式为 : {date($_S['timestamp'],'Y-m-d')}</em>
        <!--{elseif $value['type']=='time'}-->
        <input type="text" class="input" name="set[{$value['valueid']}]" value="$value['value']"><em>格式为 : {date($_S['timestamp'],'Y-m-d H:i:s')}</em>
        <!--{/if}-->
        
        </td>
        <td class="about">$value['about']</td>
      </tr>
      <!--{/loop}-->

  
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


<!--{/if}-->
<!--{elseif $_GET['ac']=='develop'}-->
<ul class="catalog cl">
  <li{if !$_GET['op']} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&ac=develop&id=$_GET['id']&iframe=yes">基本设置</a></li>
  <li{if $_GET['op']=='set' || $_GET['op']=='edit'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&ac=develop&id=$_GET['id']&op=set&iframe=yes">变量设置</a></li>
  <li{if $_GET['op']=='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&ac=develop&id=$_GET['id']&op=add&iframe=yes">添加变量</a></li>
</ul>
<!--{if !$_GET['op']}-->
<div class="block">
  <h3>基本设置</h3>
  <!--{template hack}-->
</div>
<!--{else}-->
<!--{if in_array($_GET['op'],array('add','edit'))}-->
<div class="block">
  <h3>{if $_GET['op']=='add'}添加变量{else}编辑变量{/if}</h3>
  <form action="admin.php?mod=$_GET['mod']&ac=$_GET['ac']&op=$_GET['op']&id=$_GET['id']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <!--{if $_GET['valueid']}-->
    <input name="valueid" type="hidden" value="$_GET['valueid']" />
    <!--{/if}-->
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th class="need">变量名称</th>
        <td><input type="text" class="input" name="name" value="$set['name']"><em>中英文均可，用于显示在应用配置的菜单中</em></td>
      </tr>
      <tr>
        <th class="need">变量ID</th>
        <td><input type="text" class="input" name="{if $set}newvalueid{else}valueid{/if}" value="$set['valueid']"><em>设置配置项目的变量名，用于应用程序中调用，可包含英文、数字和下划线，在同一个应用中需要保持变量名的唯一性</em></td>
      </tr>
      <tr>
        <th class="need">变量类型</th>
        <td>
          <div class="select">
            <select name="type" onchange="changetype(this.value)">
              <!--{loop $valuetype $type $name}-->
              <option value="$type" {if $set[type]==$type}selected="selected"{/if}>$name</option>
              <!--{/loop}-->
            </select>
          </div>    
        </td>
      </tr>    
      <tr>
        <th>配置说明</th>
        <td><textarea class="textarea" name="about">$set[about]</textarea><em>描述此项配置的用途和取值范围，详细的描述有利于应用使用者了解这个设置的作用</em></td>
      </tr>
  
      <tr id="content" {if !in_array($set['type'],array('radio','select','checkbox'))}style="display:none"{/if}>
        <th>配置内容</th>
        <td><textarea class="textarea" name="content">$set[content]</textarea><em>任意写法的字符串，后期在应用程序文件中进行解析</em></td>
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
<!--{else}-->
<!--{if $values}-->
<form action="admin.php?mod=$_GET['mod']&ac=$_GET['ac']&id=$hack['id']&op=set" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
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
    <!--{loop $values $valueid $value}-->
    
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="valueid[]" value="$value['valueid']"/><span class="icon"></span></label></td>
        <td class="l"><input name="valueids[]" type="hidden" value="$valueid" /><input type="text" class="input" name="list[$valueid]" value="$value['list']"></td>
        <td class="w200">$value['name']</td>
        <td class="w200">$value['valueid']</td>
        <td>$valuetype[$value['type']]<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=develop&id=$hack[id]&valueid=$value['valueid']&op=edit&iframe=yes"><em>[设置]</em></a></td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'valueid[]')"/><span class="icon"></span></label></td>
        <td colspan="4"><button type="submit" class="button" name="submit" value="true">提交</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">插件暂未添加变量</p>
<!--{/if}-->

<!--{/if}-->
<!--{/if}-->
<!--{/if}-->
<!--{else}-->
<!--{if !$hacklist['open'] && !$hacklist['close'] && !$hacklist['notinstall']}-->
<p class="empty">暂未安装任何应用,前往<a href="admin.php?mod=hacks&item=appstore" target="_top">应用商店</a>安装需要的应用</p>
<!--{else}-->
<!--{if $hacklist['open']}-->
<div class="block">
  <h3>已启用</h3>
  <ul class="hacks cl">
    <!--{loop $hacklist['open'] $hack}-->
    <li>
      <img src="$hack[icon]" onerror="this.onerror=null;this.src='./admin/style/nologo.jpg'"/>
      <h4>$hack[name]<span>V $hack[version]</span></h4>
      <p>$hack[about]</p>
      <p><a href="$hack['set']" class="c">[设置]</a><a href="admin.php?mod=hacks&ac=close&id=$hack['id']&iframe=yes" class="c">[关闭]</a><a href="admin.php?mod=hacks&ac=uninstall&id=$hack['id']&iframe=yes" class="c">[卸载]</a><a href="admin.php?mod=hacks&ac=develop&id=$hack['id']&iframe=yes" class="c">[开发]</a></p>
    </li>
    <!--{/loop}-->
  </ul>
</div>
<!--{/if}-->
<!--{if $hacklist['close']}-->
<div class="block">
  <h3>未启用</h3>
  <ul class="hacks cl">
    <!--{loop $hacklist['close'] $hack}-->
    <li>
      <img src="$hack[icon]" onerror="this.onerror=null;this.src='./admin/style/nologo.jpg'"/>
      <h4>$hack[name]<span>V $hack[version]</span></h4>
      <p>$hack[about]</p>
      <p><a href="$hack['set']" class="c">[设置]</a><a href="admin.php?mod=hacks&ac=open&id=$hack['id']&iframe=yes" class="c">[开启]</a><a href="admin.php?mod=hacks&ac=uninstall&id=$hack['id']&iframe=yes" class="c">[卸载]</a><a href="admin.php?mod=hacks&ac=develop&id=$hack['id']&iframe=yes" class="c">[开发]</a></p>
    </li>
    <!--{/loop}-->
  </ul>
</div>
<!--{/if}-->
<!--{if $hacklist['notinstall']}-->
<div class="block">
  <h3>未安装</h3>
  <ul class="hacks cl">
    <!--{loop $hacklist['notinstall'] $hack}-->
    <li>
      <img src="$hack[icon]" onerror="this.onerror=null;this.src='./admin/style/nologo.jpg'"/>
      <h4>$hack[name]<span>V $hack[version]</span></h4>
      <p>$hack[about]</p>
      <p><a href="admin.php?mod=hacks&ac=install&id=$hack['id']&iframe=yes" class="c">[安装]</a></p>
    </li>
    <!--{/loop}-->
  </ul>
</div>
<!--{/if}-->
<!--{/if}-->
<!--{/if}-->