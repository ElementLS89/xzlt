<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header flexbox b_c1 c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <div class="weui-search-bar" id="searchBar">
        <form class="weui-search-bar__form" action="discuz.php" method="get" id="search-tag" type="search" onsubmit="getform(this.id);return false">
          <input type="hidden" name="mod" value="tag">
          <div class="weui-search-bar__box"> <i class="weui-icon-search"></i>
            <input type="search" class="weui-search-bar__input" id="searchInput" name="tag" placeholder="输入要搜索的标签" required="">
            <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
          </div>
          <a href="javascript:" class="weui-search-bar__label" id="searchText"><i class="weui-icon-search"></i><span>搜索</span></a>
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
      </div>
      <div class="weui-cells__title">大家都在搜</div>
      <div class="hotkey cl p10 s15">
        <!--{loop $list $tag}-->
        <a href="hack.php?mod=tag&tagid=$tag['tagid']" class="load bo o_c1 b_c3">$tag['tagname']</a>
        <!--{/loop}-->
      </div>
      
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
</div>
<!--{template footer}-->