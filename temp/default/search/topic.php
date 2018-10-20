<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <!--{if $_GET['k']}-->
      <!--{if $list}-->
      <div class="{if $_GET['t']=='topic'}users b_c3 {/if}autolist">
      <!--{template search/topic_ajax}-->
      </div>
      <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" ><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
      <!--{else}-->
      <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">没有搜索到符合条件的数据</span></div>
      <!--{/if}-->
      <!--{else}-->
      <div class="weui-search-bar" id="searchBar">
        <form class="weui-search-bar__form" action="search.php" method="get" id="search-topic" type="search" onsubmit="getform(this.id);return false">
          <input type="hidden" name="mod" value="topic" />
          <!--{if $_GET['t']}-->
          <input type="hidden" name="t" value="$_GET['t']" />
          <!--{/if}-->
          <div class="weui-search-bar__box"> <i class="weui-icon-search"></i>
            <input type="search" class="weui-search-bar__input" id="searchInput" name="k" placeholder="搜索" required>
            <a href="javascript:" class="weui-icon-clear" id="searchClear"></a> </div>
          <a href="javascript:" class="weui-search-bar__label" id="searchText"><i class="weui-icon-search"></i><span>搜索</span></a>
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
      </div>
      <!--{/if}-->
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
<!--{template wechat}-->
<!--{template wechat_shar}-->
</div>
<!--{template footer}-->