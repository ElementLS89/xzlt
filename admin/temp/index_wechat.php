<?exit?>
<ul class="catalog cl">
  <li{if !$_GET['op']} class="a"{/if}><a href="admin.php?mod=index&item=wechat&iframe=yes">接口设置</a></li>
  <li{if $_GET['op']=='gzh'} class="a"{/if}><a href="admin.php?mod=index&item=wechat&op=gzh&iframe=yes">关注公众号设置</a></li>
  <li{if $_GET['op']=='xx'} class="a"{/if}><a href="admin.php?mod=index&item=wechat&op=xx&iframe=yes">模板消息</a></li>
</ul>
<!--{if $_GET['op']=='gzh'}-->
<div class="block">
  <h3>公众号关注提示设置</h3>
  <ul class="block_info">
    <li>当用户第一次打开网页时将显示在页面顶部浮动提示用户关注公众号</li>
  </ul>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&op=gzh" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>文字说明</th>
        <td>
        <input type="text" class="input w300" name="gzh_text" value="$_S['setting']['gzh_text']">
        <em>设置关注公众号的文字说明</em>
        </td>
      </tr>
      <tr>
        <th>公众号LOGO</th>
        <td>
        <!--{if $_S['setting']['gzh_logo']}--><img src="$_S[atc]/$_S['setting']['gzh_logo']"><!--{/if}--><input type="file" name="gzh_logo">
        <em>上传公众号的二维码图片</em>
        </td>
      </tr>
      <tr>
        <th>是否显示关注提醒</th>
        <td>
        <label class="checkbox"><input type="checkbox" class="check" name="gzh_show" value="1" {if $_S['setting']['gzh_show']}checked="checked"{/if}/><span class="icon"></span></label>
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
<!--{elseif $_GET['op']=='xx'}-->
<div class="block">
  <h3>微信模板消息设置</h3>
  <ul class="block_info">
    <li>只有关注了公证号的用户才能收到消息</li>
    <li><a href="https://www.smsot.com/hack.php?id=dot&aid=8" target="_blank">配置教程</a></li>
  </ul>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&op=xx" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>帖子回复模板消息</th>
        <td>
        <input type="text" class="input w300" name="wxnotice_reply" value="$_S['setting']['wxnotice_reply']">
        <em>填写模板ID</em>
        </td>
      </tr>
      <tr>
        <th>聊天模板消息</th>
        <td>
        <input type="text" class="input w300" name="wxnotice_talk" value="$_S['setting']['wxnotice_talk']">
        <em>填写模板ID</em>
        </td>
      </tr>
      <tr>
        <th>打赏通知模板消息</th>
        <td>
        <input type="text" class="input w300" name="wxnotice_shang" value="$_S['setting']['wxnotice_shang']">
        <em>填写模板ID</em>
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

<!--{else}-->
<div class="block">
  <h3>接口说明</h3>
  <ul class="block_info">
    <li>必须是认证的服务号</li>
    <li>微信公众号内需要设置业务域名和JS安全域名以及网页授权域名</li>
    <li>mchid和key请按照您的微信支付开户邮件里的说明去获取</li>
    <li>设置微信支付需要在微信支付商户平台设置支付授权目录</li>
  </ul>
</div>
<div class="block">
  <h3>微信公众号设置</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>微信公众号appid</th>
        <td>
        <input type="text" class="input" name="wx_appid" value="$_S['setting']['wx_appid']">
        <em>填写微信公众号的Appid</em>
        </td>
      </tr>
      <tr>
        <th>微信公众号appsecret</th>
        <td>
        <input type="text" class="input w300" name="wx_appsecret" value="$_S['setting']['wx_appsecret']">
        <em>填写微信公众号的Appsecret</em>
        </td>
      </tr>
      <tr>
        <th>小程序appid</th>
        <td>
        <input type="text" class="input" name="mini_appid" value="$_S['setting']['mini_appid']">
        <em>填写小程序号的Appid</em>
        </td>
      </tr>
      <tr>
        <th>小程序appsecret</th>
        <td>
        <input type="text" class="input w300" name="mini_appsecret" value="$_S['setting']['mini_appsecret']">
        <em>填写小程序号的Appsecret</em>
        </td>
      </tr>
      <tr>
        <th>微信商户号mchid</th>
        <td>
        <input type="text" class="input w300" name="wx_mchid" value="$_S['setting']['wx_mchid']">
        <em>填写微信商户号（这里填的不是微信开放平台的商户号）</em>
        </td>
      </tr>
      <tr>
        <th>微信商户号支付秘钥key</th>
        <td>
        <input type="text" class="input w300" name="wx_apikey" value="$_S['setting']['wx_apikey']">
        <em>填写微信商户号支付秘钥</em>
        </td>
      </tr>
      <tr>
        <th>微信自定登录</th>
        <td>
        <label class="checkbox"><input class="check" type="checkbox" name="wx_autologin" value="1" {if $_S['setting']['wx_autologin']}checked="checked"{/if} /><span class="icon"></span></label>
        <em>在微信环境下是否自动登录</em>
        </td>
      </tr>
      <tr>
        <th>微信注册免审核</th>
        <td>
        <label class="checkbox"><input class="check" type="checkbox" name="wx_examine" value="1" {if $_S['setting']['wx_examine']}checked="checked"{/if} /><span class="icon"></span></label>
        <em>设置通过微信注册的用户是否需要审核（只有开启了新注册用户审核这里设置才有效）</em>
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
<!--{/if}-->
