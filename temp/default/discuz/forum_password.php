<?exit?>
<div class="weui-dialog">
  <div class="dialog-content">
    <div class="weui-dialog__hd"><strong class="weui-dialog__title">需要密码</strong></div>
    <form action="discuz.php?mod=action&ac=passforum&fid=$_GET['fid']" method="post" id="{PHPSCRIPT}_{$_GET['mod']}_form">
      <input name="submit" type="hidden" value="true" />
      <input name="hash" type="hidden" value="$_S['hash']" />      
      <div class="weui-dialog__bd pt10">
        <input class="weui-input" type="text" name="pass" placeholder="请输入板块的访问密码">
      </div>
      <div class="weui-dialog__ft">
        <button type="button" class="weui-dialog__btn weui-dialog__btn_default formpost">提交</button>
      </div>
    </form>
  </div>
  
</div>
<div id="smsscript"><div class="js-content">$(".weui-dialog__bd .weui-input").focus();</div></div>
  
   
  
