<?exit?>
<ul class="catalog cl">
  <li{if $_GET['ac']!='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&iframe=yes">模板管理</a></li>
  <li{if $_GET['ac']=='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=add&iframe=yes">添加模板</a></li>
</ul>

<!--{if in_array($_GET['ac'],array('add','edit'))}-->
<div class="block">
  <h3>{if $_GET['ac']=='add'}添加模板{else}编辑模板{/if}</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <!--{if $_GET['tempid']}-->
    <input name="tempid" type="hidden" value="$_GET['tempid']" />
    <!--{/if}-->
  <table class="table" cellpadding="0" cellspacing="0">
    <tr>
      <th class="need">模板名称</th>
      <td><input type="text" class="input" name="name" value="$temp['name']"><em>给模板起一个名字可以由汉字、字母、或数字组成</em></td>
    </tr>
    <tr>
      <th class="need">模板目录</th>
      <td><input type="text" class="input" name="dir" value="$temp['dir']"><em>填写模板所在的文件夹名称（网站根目录下temp文件夹内创建）</em></td>
      
    </tr>
    <!--{if !$temp}-->
    <tr class="line">
      <td colspan="2"></td>
    </tr>
    <tr>
      <th>版权所属</th>
      <td><input type="text" class="input w300" name="copyright" value="$temp['copyright']"><em>填写模板的版权所属</em></td>
    </tr>
    <tr>
      <th>作者</th>
      <td><input type="text" class="input" name="author" value="$temp['author']"><em>模板作者</em></td>
    </tr>
    <tr>
      <th>版本号</th>
      <td><input type="text" class="input" name="version" value="$temp['version']"><em>模板的版本号用于提示站长升级更新</em></td>
    </tr>
    <!--{/if}-->
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
<!--{else}-->
<div class="block">
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <h3>模板设置</h3>
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <ul class="tempslist cl">
      <!--{loop $temps $value}-->
      <li>
        <h4><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&tempid=$value['tempid']&iframe=yes">$value['name']</a>{if $value['author']}<span>($value['author'])</span>{/if}</h4>
        <div><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&tempid=$value['tempid']&iframe=yes"><img src="$value['cover']" onerror="this.onerror=null;this.src='./admin/style/nocover.jpg'"></a></div>
        {if $value['copyright']}<p class="copy">$value['copyright']</p><!--{/if}-->
        <p class="set"><label class="radio"><input type="radio" class="check" name="touch" value="$value['tempid']" {if $value['touch']}checked{/if}/><span class="icon"></span>手机版</label><label class="radio"><input type="radio" class="check" name="pc" value="$value['tempid']" {if $value['pc']}checked{/if}/><span class="icon"></span>PC版</label></p>
        <p class="btn"><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&tempid=$value['tempid']&iframe=yes">[编辑]</a>{if !$value['touch'] && !$value['pc']}<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=delete&tempid=$value['tempid']&iframe=yes">[删除]</a>{/if}</p>
        
      </li>
      <!--{/loop}-->
    </ul>
    <p class="btnarea"><button type="submit" class="button" name="submit" value="true">提交设置</button></p>
  </form>
</div>
<!--{/if}-->