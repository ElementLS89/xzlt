<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="collectionlist">
  <div id="list">
<!--{/if}-->
<!--{if $list}-->
<!--{if $_GET['mod']=='topic'}-->
<!--{eval include temp('topic/themes_1',false)}-->
<!--{elseif $_GET['mod']=='discuz'}-->
<!--{eval include temp('discuz/threads_1',false)}-->
<!--{else}-->
<!--{eval include temp($_GET['mod'].':collection',false)}-->
<!--{/if}-->
<!--{else}-->
<div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂未收藏任何$mod['name']</span></div>
<!--{/if}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}-->
  <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vc_{$_GET['mod']}"><span class="weui-loadmore__tips">下一页</span></a>
  <!--{/if}-->
  </div>
</div>
<!--{/if}-->


