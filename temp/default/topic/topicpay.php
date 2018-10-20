<div class="weui-dialog">
  <div class="dialog-content">
    <form action="topic.php?mod=action&ac=pay" method="post" id="pay_form">
      <input name="submit" type="hidden" value="true" />
      <input name="hash" type="hidden" value="$_S['hash']" />
      <input id="paytype" type="hidden" value="wxpay" />
      <input id="idtype" type="hidden" value="tid" />
      <input id="id" type="hidden" value="$_GET['tid']" />
      <input name="tid" type="hidden" value="$_GET[tid]" />
      <div class="weui-dialog__hd"><strong class="weui-dialog__title">付费提醒</strong></div>
      <div class="weui-dialog__bd">本小组是收费小组,申请加入需要支付费用{$topic['price']}元</div>
      <div class="weui-dialog__ft">
        <a href="javascript:;" onclick="SMS.close();" class="weui-dialog__btn weui-dialog__btn_default">取消</a>
        $paybtn
      </div>
    </form>
  </div>
</div>
<div id="smsscript"><div class="dialogjs"><!--{template wechat_pay}--></div></div>