<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="topiclist">
  <div id="list">
<!--{/if}-->
  <!--{loop $list $value}-->
  <a href="topic.php?tid=$value['tid']" class="weui-cell weui-cell_access load">
    <div class="weui-cell__hd"><img src="$value['cover']"></div>
    <div class="weui-cell__bd">
      <h4>$value['name']</h4>
      <p class="c4">$value['about']</p>
    </div>
  </a>
  <!--{/loop}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#topiclist_{$_GET['typeid']}"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
</div>
<!--{/if}-->