<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback" nocache="true">
      <form action="discuz.php?mod=portal" method="post" id="{PHPSCRIPT}_{$_GET['mod']}_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <input name="ac" type="hidden" value="$_GET['ac']" />
        <input name="aid" type="hidden" value="$_GET['aid']" />
        <input name="cid" type="hidden" value="$_GET['cid']" />
        <div class="weui-cells__title">评论内容</div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea autoheight" id="postmessage" name="message" placeholder="请输入内容" maxlength="200" rows="3">{if $_GET['ac']=='replycomment'}[quote]{$comment['username']}: {$comment['summary']}[/quote]{/if}{if $_GET['ac']=='edit'}$comment['message']{/if}</textarea>
            </div>
          </div>
        </div>
        <div class="smiles b_c5">
          <ul class="cl">
            <!--{loop $_S['cache']['discuz_smile']['default'] $value}-->
            <li><a href="javascript:SMS.smile('$value['code']')"><img src="$value['url']" /></a></li>
            <!--{/loop}-->
          </ul>
        </div>
        
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">{$navtitle}</button></div>
      </form>
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
  <!--{template discuz/js}-->
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->