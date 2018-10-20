<?exit?>
<div class="block">
  <h3>相关说明</h3>
  <ul class="block_info">
    <li>需要注册阿里云账号并开通短信服务</li>
    <li>短信模板内容为<span>"您的短信验证码是$<em>{</em>number<em>}</em>,请于5分钟内使用，5分钟后将过期"</span>其中除了$<em>{</em>number<em>}</em>之外的都可以修改</li>
  </ul>
</div>
<div class="block">
  <h3>阿里云短信接口设置</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>阿里云短信签名</th>
        <td>
        <input type="text" class="input" name="aliyun-sms-sign" value="$_S['setting']['aliyun-sms-sign']">
        <em>填写您的阿里云短信签名</em>
        </td>
      </tr>
      <tr>
        <th>阿里云Key</th>
        <td>
        <input type="text" class="input w300" name="aliyun-sms-key" value="$_S['setting']['aliyun-sms-key']">
        <em>填写阿里云账号的key</em>
        </td>
      </tr>
      <tr>
        <th>阿里云secret</th>
        <td><input type="text" class="input w300" name="aliyun-sms-secret" value="$_S['setting']['aliyun-sms-secret']"><em>填写阿里云账号的secret</em></td>
      </tr>
      <tr>
        <th>手机绑定短信模板</th>
        <td><input type="text" class="input" name="sms_bind" value="$_S['setting']['sms_bind']"><em>填写短信模板的ID</em></td>
      </tr>
      <tr>
        <th>注册短信模板</th>
        <td><input type="text" class="input" name="sms_reg" value="$_S['setting']['sms_reg']"><em>填写短信模板的ID</em></td>
      </tr>
      <tr>
        <th>登录短信模板</th>
        <td><input type="text" class="input" name="sms_login" value="$_S['setting']['sms_login']"><em>填写短信模板的ID</em></td>
      </tr>
      <tr>
        <th>强制手机认证</th>
        <td><label class="checkbox"><input type="checkbox" class="check" name="sms_need" {if $_S['setting']['sms_need']}checked="checked"{/if} value="1"/><span class="icon"></span></label><em>设置新用户是否必须强制认证手机号</em></td>
      </tr>
      <tr>
        <th>手机注册免审核</th>
        <td>
        <label class="checkbox"><input class="check" type="checkbox" name="sms_examine" value="1" {if $_S['setting']['sms_examine']}checked="checked"{/if} /><span class="icon"></span></label>
        <em>设置通过手机短信注册的用户是否需要审核（只有开启了新注册用户审核这里设置才有效）</em>
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