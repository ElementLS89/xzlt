<!--{if $modvar['style']==1}-->
<div class="weui-search-bar" id="searchBar">
  <form class="weui-search-bar__form" action="search.php" method="get" id="search-topic" type="search" onsubmit="getform(this.id);return false">
    <!--{if $modvar['mid']=='theme'}-->
    <input type="hidden" name="mod" value="topic" />
    <!--{elseif $modvar['mid']=='topic'}-->
    <input type="hidden" name="mod" value="topic" />
    <input type="hidden" name="t" value="topic" />
    <!--{else}-->
    <input type="hidden" name="mod" value="$modvar['mid']" />
    <!--{/if}-->
    <div class="weui-search-bar__box"> <i class="weui-icon-search"></i>
      <input type="search" class="weui-search-bar__input" id="searchInput" name="k" placeholder="搜索" required>
      <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
    </div>
    <a href="javascript:" class="weui-search-bar__label" id="searchText"><i class="weui-icon-search"></i><span>搜索</span></a>
  </form>
  <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
</div>
<!--{else}-->
<!--{if $modvar['mid']=='theme'}-->
<!--{eval $searchurl='search.php?mod=topic';}-->
<!--{elseif $modvar['mid']=='topic'}-->
<!--{eval $searchurl='search.php?mod=topic&t=topic';}-->
<!--{else}-->
<!--{eval $searchurl='search.php?mod='.$modvar['mid'];}-->
<!--{/if}-->
<div class="topsearch"><a href="$searchurl" class="load">搜索你感兴趣的</a></div>
<!--{/if}-->