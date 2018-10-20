<?exit?>
<div class="layer_header b_c1 c3"><a href="javascript:SMS.openlayer('sendmessage')" class="icon icon-close"></a><span>发消息</span></div>
<form action="send.php?tid=$_GET[tid]" method="post" id="send_form">
  <input name="submit" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <div class="weui-cells__title">消息内容</div>
  <div class="weui-cells weui-cells_form">
    
    <div class="weui-cell">
      <div class="weui-cell__bd">
        <textarea class="weui-textarea" name="message" placeholder="请输入.." rows="3" id="postmessage"></textarea>
      </div>
    </div>
  </div>
  <div class="smiles b_c5">
    <ul class="cl">
      <!--{loop $_S['cache']['smiles'][1] $value}-->
      <li><a href="javascript:SMS.smile('$value['str']','sendmessage')"><img src="$value['pic']" /></a></li>
      <!--{/loop}-->
    </ul>
  </div>
  <div class="p10 bob o_c1 b_c2 bot cl">
    <span class="s14 c4">随机展示的小贴士</span>
    <button type="button" class="weui-btn weui-btn_mini weui-btn_primary r formpost">发送</button>
  </div>
</form>
