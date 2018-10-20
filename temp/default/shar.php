<div class="weui-actionsheet" id="sharesheet">
  <div class="share-items c4">
    <ul class="cl">
      <!--{if $_S['bro']=='qq' || $_S['bro']=='wechat'}-->
      <li><a href="javascript:SMS.share_weixin();"><!--{if $_S['bro']=='qq'}--><img src="ui/share_qq.png" /><br />QQ分享<!--{else}--><img src="ui/share_wechat.png" /><br />微信分享<!--{/if}--></a></li>
      <li><a href="javascript:SMS.poster('$_S['poster']['api']');"><img src="ui/share_poster.png" /><br />生成封面</a></li>
      <!--{elseif $_S['bro']=='other'}-->
      <li><a href="javascript:share_qq('$_S[shar][desc]','$title','$_S[shar][pic]');"><img src="ui/share_qq.png" /><br />QQ好友</a></li>
      <li><a href="javascript:share_qzone('$_S[shar][desc]','$title','$_S[shar][pic]','$_S[setting][sitename]');"><img src="ui/share_qqzone.png" /><br />QQ空间</a></li>
      <li><a href="javascript:share_sina('$_S[shar][desc]','$_S[shar][pic]');"><img src="ui/share_weibo.png" /><br />新浪微博</a></li>
      <li><a href="javascript:SMS.poster('$_S['poster']['api']');"><img src="ui/share_poster.png" /><br />生成封面</a></li>
      <li><a href="javascript:share_more();"><img src="ui/share_more.png" /><br />更多</a></li>            
      <!--{else}-->
      <li data-app="weixin" class="share-item"><img src="ui/share_wechat.png"/><br />微信好友</li>
      <li data-app="weixinFriend" class="share-item"><img src="ui/share_friend.png" /><br />微信朋友圈</li>
      <li data-app="QQ" class="share-item"><img src="ui/share_qq.png" /><br />QQ好友</li>
      <li data-app="QZone" class="share-item"><img src="ui/share_qqzone.png" /><br />QQ空间</li>
      <li data-app="sinaWeibo" class="share-item"><img src="ui/share_weibo.png" /><br />新浪微博</li>
      <li><a href="javascript:SMS.poster('$_S['poster']['api']');"><img src="ui/share_poster.png" /><br />生成封面</a></li>
      <li data-app="" class="share-item"><img src="ui/share_more.png" /><br />更多</li>
      <!--{/if}-->
    </ul>
  </div>
  <div class="weui-actionsheet__action">
    <a href="javascript:" class="weui-actionsheet__cell c1">取消</a>
  </div>
</div>
