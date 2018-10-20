<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="main">
  <div id="list">
<!--{/if}-->
    <!--{if $list}-->
    <!--{loop $list $value}-->
    <a href="hongbao.php?hid=$value['hid']" class="weui-cell load b_c3" id="hb_$value['hid']">
      <div class="weui-cell__hd"><!--{avatar($value['user'],2)}--></div>
      <div class="weui-cell__bd">
        <h4 class="c6">$value['username']的{if $value['password']}口令{/if}红包</h4>
        <p class="c4">$value['message']</p>
      </div>
      <div class="weui-cell__ft">$value['btn']</div>
    </a>
    <!--{/loop}-->
    <!--{else}-->
    <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂无红包数据</span></div>
    <!--{/if}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#hongbao{$_GET['list']}"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
  <div id="script"></div>
</div>
<!--{/if}-->
