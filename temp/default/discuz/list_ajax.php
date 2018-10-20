<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="main">
  <div id="list">
<!--{/if}-->
<!--{loop $list $value}-->
<div id="theme_$value[aid]">
  <div class="b_c3 bob o_c4 pt10">
    <div class="theme-content cl">
      <a href="discuz.php?mod=news&aid=$value['aid']" class="load block">{if $value['pic']}<img src="$value['pic']">{/if}<h3 class="theme-sub">$value['title']</h3></a>
    </div>    
    <p class="theme-foot s13 c4"><span class="r">{date($value['dateline'],'Y-m-d H:i')}</span><span>阅读{$value['viewnum']}</span><em></em><span>评论{$value['commentnum']}</span></p>
  </div>
</div>
<!--{/loop}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vp_{$_GET['catid']}"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
</div>
<!--{/if}-->