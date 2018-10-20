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
      <form action="discuz.php?mod=bind" method="post" id="discuz_$_GET['mod']">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <div class="weui-cells">
          <div class="weui-cell" >
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="username" placeholder="输入您要绑定的您原有的论坛账号名称">
            </div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="password" name="password" placeholder="输入您要绑定的您原有的论坛账号密码">
            </div>
          </div>
        </div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd">同步账号名称</div>
            <div class="weui-cell__ft">
              <label for="switchlbs" class="weui-switch-cp">
              <input id="switchlbs" class="weui-switch-cp__input" type="checkbox" value="1" name="synchronization" checked>
              <div class="weui-switch-cp__box"></div>
              </label>
            </div>
          </div>
        </div>
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost" id="member-btn">$navtitle</button></div>
      </form>

    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">
</div>

<!--{template footer}-->