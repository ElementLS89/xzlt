<?exit?>
<!--{loop $list $value}-->
<div class="viewmessage $value['userclass'] $value['typeclass']" id="msg_{$value['mid']}">
  <div class="cl">
    <a href="user.php?uid=$value['uid']" class="user load"><!--{avatar($value['user'],2)}--></a>
    <span class="bubble"></span>
    <div class="message-area">
      $value['message']
    </div>          
  </div>
  <p class="date c2">{date($value['dateline'],'m-d H:i:s')}</p>
</div>
<!--{/loop}-->