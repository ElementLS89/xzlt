<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="main">
  <div id="list">
<!--{/if}-->
<!--{eval include temp('discuz/'.$themetemp,false)}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vp_{$_GET['catid']}"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
</div>
<!--{/if}-->
