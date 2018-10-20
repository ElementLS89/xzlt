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
      <form action="topic.php?mod=action&ac=apply&tid=$_GET['tid']&level=$_GET['level']" method="post" id="{PHPSCRIPT}_{$_GET['mod']}_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />

        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="name" placeholder="真实姓名">
            </div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="tel" placeholder="联系电话">
            </div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="qq" placeholder="QQ号码">
            </div>
          </div>
        </div>

        <div class="weui-cells__title">个人介绍</div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea" name="about" placeholder="请介绍下你自己以及申请理由" maxlength="200" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">申请加入管理团队</button></div>
      </form>      
    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">
<!--{template wechat_shar}-->
<!--{template wechat_pay}-->
</div>

<!--{template footer}-->