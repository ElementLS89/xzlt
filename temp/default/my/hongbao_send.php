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
    <div class="smsbody body_t $outback" nocache="true">

      <form action="my.php?mod=hongbao&touid=$_GET['touid']" method="post" id="hongbao_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />

        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">金额</label></div>
            <div class="weui-cell__bd"><input class="weui-input" type="number" name="money" placeholder="请输入红包金额"></div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">口令</label></div>
            <div class="weui-cell__bd"><input class="weui-input" type="text" name="password" placeholder="此处可不填"></div>
          </div>
        </div>
        <div class="weui-cells__title">留言</div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea" name="message" maxlength="200" rows="3">恭喜发财</textarea>
            </div>
          </div>
        </div>
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">塞钱进红包</button></div>
        
      </form>
          
    </div>
  </div>
  <div id="footer"> 
  
  </div>
</div>
<div id="smsscript">
<!--{template wechat_shar}-->
</div>
<!--{template footer}-->