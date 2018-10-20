<?exit?>
<form action="admin.php?mod=hacks" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="item" type="hidden" value="$_GET['item']" />
  
  <input name="id" type="hidden" value="$_GET['id']" />
  <input name="ac" type="hidden" value="$_GET['ac']" />

  
  <table class="table" cellpadding="0" cellspacing="0">
    <tr>
      <th class="need">应用名称</th>
      <td><input type="text" class="input" name="name" value="$hack['name']"><em>此应用的名称，中英文均可，最多 20 个字节</em></td>
    </tr>
    <tr>
      <th class="need">应用ID</th>
      <td><input type="text" class="input" name="{if $hack}hackid{else}id{/if}" value="$hack['id']"><em>应用的唯一英文标识，不能够与现有插件标识重复。可使用字母、数字、下划线命名，不能包含其他符号或特殊字符，最大 20 个字节</em></td>
    </tr>
    <tr>
      <th>版本号</th>
      <td><input type="text" class="input" name="version" value="$hack['version']"><em>此应用的版本，版本号高于旧版本号时，安装给用户时将会提示更新</em></td>
    </tr>
    <tr>
      <th>类型</th>
      <td>
        <div class="select">
          <select name="type">
            <option value="local" {if $hack['type']=='local'}selected{/if}>本地应用</option>
            <option value="cloud" {if $hack['type']=='cloud'}selected{/if}>云应用</option>
          </select>
        </div>
        <em>上架到应用商店的应用可以选择云应用</em>
      </td>
    </tr>
    <tr>
      <th>介绍</th>
      <td><textarea class="textarea" name="about">$hack['about']</textarea></td>  
      
    </tr>
    <tfoot>
      <tr>
        <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">创建应用</button>
        </td>
      </tr>  
    </tfoot>
  
  </table>
</form>