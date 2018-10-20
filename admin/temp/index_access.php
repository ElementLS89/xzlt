<?exit?>
<div class="block">
  <h3>注册控制</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>IP注册间隔限制(一小时)</th>
        <td><input type="text" class="input" name="ip_limit_hour" value="$_S['setting']['ip_limit_hour']"><em>同一个IP在一小时内允许注册的次数，0表示不限</em></td>
      </tr>
      <tr>
        <th>IP注册间隔限制(一天)</th>
        <td><input type="text" class="input" name="ip_limit_day" value="$_S['setting']['ip_limit_day']"><em>同一个IP在一天内允许注册的次数，0表示不限</em></td>
      </tr>
      <tr>
        <th>人工审核</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="user_examine" value="1" {if $_S['setting']['user_examine']}checked{/if}/><span class="icon"></span>是</label>
        <label class="radio"><input type="radio" class="check" name="user_examine" value="0" {if !$_S['setting']['user_examine']}checked{/if}/><span class="icon"></span>否</label>
        <em>是否开启人工新用户注册审核（微信和手机注册的用户可以单独设置是否需要审核，具体前往<a href="admin.php?mod=index&item=wechat&iframe=true">微信相关</a>和<a href="admin.php?mod=index&item=sms&iframe=true">手机短信</a>栏目进行设置）</em>
        </td>
      </tr>
      <tr>
        <th>是否显示注册协议</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="agreement_open" value="1" {if $_S['setting']['agreement_open']}checked{/if}/><span class="icon"></span>是</label>
        <label class="radio"><input type="radio" class="check" name="agreement_open" value="0" {if !$_S['setting']['agreement_open']}checked{/if}/><span class="icon"></span>否</label>
        <em>用户注册时是否显示注册协议</em>
        </td>
      </tr>
      <tr>
        <th>是否允许修改用户名</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="alloweditusername" value="1" {if $_S['setting']['alloweditusername']}checked{/if}/><span class="icon"></span>是</label>
        <label class="radio"><input type="radio" class="check" name="alloweditusername" value="0" {if !$_S['setting']['alloweditusername']}checked{/if}/><span class="icon"></span>否</label>
        <em>是否允许用户修改用户名（dz打通版无效）</em>
        </td>
      </tr>
      <tr>
        <th>保留用户名</th>
        <td><textarea class="textarea" name="retain">$_S['setting']['retain']</textarea><em>填写保留的或禁止使用的用户名,多个用逗号隔开</em></td>
      </tr>
      <tr>
        <th>注册协议</th>
        <td><textarea class="textarea" name="agreement">$_S['setting']['agreement']</textarea></td>
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

