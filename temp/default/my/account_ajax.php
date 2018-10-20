<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="main">
  <div id="list">
<!--{/if}-->
  <!--{loop $list $value}-->
  <a class="weui-cell load" id="{$value['lid']}" href="my.php?mod=account&lid=$value['lid']">
    <div class="weui-cell__bd">
      <h4><strong class="c6">$value['title']</strong>$value['title_after']</h4>
      <p class="c4 s12">{date($value['logtime'],'Y-m-d H:i:s')}</p>
    </div>
    <div class="weui-cell__ft">
      {$value['arose_before']}$value['arose']
    </div>
  </a>
  <!--{/loop}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#content-3"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
  <div id="script"></div>
</div>
<!--{/if}-->