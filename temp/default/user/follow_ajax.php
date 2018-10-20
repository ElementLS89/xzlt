<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="main">
  <div id="list">
<!--{/if}-->
    <!--{loop $list $value}-->
    <div class="weui-cell" id="follow_l{$value['uid']}">
      <div class="weui-cell__hd"><a href="user.php?uid=$value['uid']" class="load"><!--{avatar($value['user'],2)}--></a></div>
      <div class="weui-cell__bd">
        <a href="user.php?uid=$value['uid']" class="load"><h4 class="c6">$value['username']</h4>
        <p class="c4"><!--{if $value['lm']}-->$value['lm']<!--{else}-->这个人很懒什么也没留下<!--{/if}--></p>
      </div>
      <div class="weui-cell__ft">
        <a href="user.php?mod=action&action=follow&uid=$value['uid']" class="weui-btn weui-btn_mini{if $list_more[$value[uid]]} weui-btn_default{else} weui-btn_primary{/if} load">{if $list_more[$value[uid]]}取消{else}关注{/if}</a>
      </div>
    </div>
    <!--{/loop}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#follow_{$_GET[uid]}_{$_GET['show']}"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
  <div id="script"></div>
</div>
<!--{/if}-->