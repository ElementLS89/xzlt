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
      <form action="my.php?mod=id" method="post" id="id_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <input name="clear" type="hidden" value="$_GET['clear']" />
        <!--{if $_S['member']['password']!='null'}-->
        <div class="weui-cells__title">修改用户名</div>
        <!--{/if}-->
        <div class="weui-cells">
          <div class="weui-cell" >
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="username" placeholder="给自己起一个名字" value="$_S['member']['username']">
            </div>
          </div>
          <!--{if $_S['member']['password']=='null'}-->
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
          <!--{/if}-->
        </div> 
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost" id="member-btn">提交</button></div>
      </form>
    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">
  <!--{if $_GET['clear']}-->
  <script language="javascript">
   	sessionStorage.clear();
		localStorage.clear();
  </script>
  <!--{/if}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->