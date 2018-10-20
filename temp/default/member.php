<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback" nocache="true">

      <form action="member.php?mod=$_GET['mod']" method="post" id="member_$_GET['mod']">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <input name="lid" type="hidden" value="$_S['COOKIE']['lid']" id="smslid" />
        <!--{if $_GET['mod']=='login'}-->
        <!--{if $_S['sms_login']}-->
        <div class="topnv swipernv b_c3 bob o_c3">
          <ul class="flexbox">
            <li class="flex c1"><a href="javascript:setlogintype('tel')" class="get" type="switch" box="content-1"><span>用手机号登录</span></a></li>
            <li class="flex c7"><a href="javascript:setlogintype('comm')" class="get" type="switch" type="switch" box="content-2"><span>普通登录</span></a></li>
            <span class="swipernv-on b_c1"></span>
          </ul>      
        </div>
        <!--{/if}-->        
        <!--{if $_S['sms_login']}-->
        <input name="logintype" type="hidden" value="tel" id="logintype" />
        <div class="box-area">
          <div class="box-content ready current" id="content-1">
            <div class="weui-cells">
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" type="tel" name="tel" id="tel" placeholder="输入手机号">
                </div>
              </div>
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" type="number" name="code" placeholder="输入验证码">
                </div>
                <div class="weui-cell__ft">
                  <!--{if $_S['COOKIE']['lid']}-->
                  <button type="button" onclick="SMS.getsmscode('login')" class="weui-btn weui-btn_mini weui-vcode-btn-gray" id="smsbtn" disabled="disabled">获取验证码</button>
                  <!--{else}-->
                  <button type="button" onclick="SMS.getsmscode('login')" class="weui-btn weui-btn_mini weui-btn_primary" id="smsbtn">获取验证码</button>
                  <!--{/if}-->
                </div>
              </div>
            </div>
          </div>
          <div class="box-content ready" id="content-2" style="display:none">
          <!--{/if}-->
            <div class="weui-cells">
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" type="text" name="username" placeholder="账号">
                </div>
              </div>
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" type="password" name="password" placeholder="密码">
                </div>
              </div>
            </div>
            <!--{if $_S['sms_login']}-->
          </div>
        </div>
        <!--{/if}-->
        <!--{else}-->
        <!--{if $_S['sms_reg']}-->
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="tel" name="tel" id="tel" placeholder="输入手机号">
            </div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="number" name="code" placeholder="输入验证码">
            </div>
            <div class="weui-cell__ft">
              <!--{if $_S['COOKIE']['lid']}-->
              <button type="button" onclick="SMS.getsmscode('reg')" class="weui-btn weui-btn_mini weui-vcode-btn-gray" id="smsbtn" disabled="disabled">获取验证码</button>
              <!--{else}-->
              <button type="button" onclick="SMS.getsmscode('reg')" class="weui-btn weui-btn_mini weui-btn_primary" id="smsbtn">获取验证码</button>
              <!--{/if}-->
            </div>
          </div>
        </div>
        <!--{else}-->
        <div class="weui-cells">
          <div class="weui-cell" >
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="username" placeholder="输入账号名">
            </div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="password" name="password" placeholder="设置一个密码">
            </div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="password" name="password2" placeholder="再输入一次密码">
            </div>
          </div>
        </div>        
        <!--{/if}-->
        <!--{if $_S['setting']['agreement_open']}-->
        <label for="weuiAgree" class="weui-agree">
          <input id="weuiAgree" type="checkbox" name="agree" value="true" class="weui-agree__checkbox">
          <span class="weui-agree__text">阅读并同意<a href="index.php?mod=agreement" class="load">《用户注册协议》</a></span>
        </label>
        <!--{/if}-->
        <!--{/if}-->
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost" id="member-btn">$navtitle</button></div>
      </form>
      <div class="pl50 pr50" id="member-more">

      
      <!--{if $_GET['mod']=='login'}-->
      <a href="member.php?mod=reg" class="weui-btn weui-btn_plain-primary load" close="true">注册一个账号</a>
      <!--{else}-->
      <a href="member.php" class="weui-btn weui-btn_plain-primary load" close="true">已有账号直接登录</a>
      <!--{/if}-->
      <!--{if $_S['wechat'] && $_S['in_wechat']}-->
      <p class="tc pt15"><a href="wechat.php?mod=login&referer=$referer" class="load"><span class="icon icon-weixinpay pr10"></span>使用微信一键登录</a></p>
      <!--{/if}-->        
      </div>
    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">
  <!--{if $_S['sms_login']}-->
  <script language="javascript" reload="1">
	  $(document).ready(function() {
      SMS.translate_int()
		});
		function setlogintype(type){
			$(".currentbody #logintype").val(type);
		}
  </script>
  <!--{/if}-->
  <!--{if $_GET['clear']}-->
  <script language="javascript">
   	sessionStorage.clear();
		localStorage.clear();
  </script>
  <!--{/if}-->
  <!--{template wechat_shar}-->
</div>

<!--{template footer}-->