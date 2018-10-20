<?exit?>
<!--{if $_GET['show']=='list'}-->
<a href="my.php?mod=talk&tid=$message[tid]" class="weui-cell weui-cell_access load" id="talk_$message[tid]">
  <div class="weui-cell__hd"><!--{avatar($message['user'],2)}--><!--{if $message['newmessage']}--><span class="weui-badge">$message['newmessage']</span><!--{/if}--></div>
  <div class="weui-cell__bd">
    <h4><span class="r s12 c2">{date($message['lastdateline'],'m-d H:i:s')}</span><span class="c1">$message['username']</span></h4>
    <p class="c4">$message['lastmessage']</p>
  </div>
</a>
<!--{else}-->
<div class="viewmessage $message['userclass'] $message['typeclass']" id="msg_{$message['mid']}">
  <div class="cl">
    <a href="user.php?uid=$message['uid']" class="user load"><!--{avatar($message['user'],2)}--></a>
    <span class="bubble"></span>
    <div class="message-area">
      $message['message']
    </div>          
  </div>
  <p class="date c2">{date($message['dateline'],'m-d H:i:s')}</p>
</div>
<!--{/if}-->