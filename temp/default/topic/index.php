<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <div class="weui-search-bar" id="searchBar">
        <form class="weui-search-bar__form" action="search.php" method="get" id="search-topic" type="search" onsubmit="getform(this.id);return false">
          <input type="hidden" name="mod" value="topic" />
          <input type="hidden" name="t" value="topic" />
          <div class="weui-search-bar__box"> <i class="weui-icon-search"></i>
            <input type="search" class="weui-search-bar__input" id="searchInput" name="k" placeholder="搜索" required>
            <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
          </div>
          <a href="javascript:" class="weui-search-bar__label" id="searchText"><i class="weui-icon-search"></i><span>搜索</span></a>
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
      </div>
      <div class="box b_c3 mb10">
        <h3 class="box_title bob o_c3 cl"><a href="topic.php?mod=creat" class="r weui-btn weui-btn_mini  weui-btn_plain-primary load">创建话题</a><span class="c4">我的话题</span></h3>
        <div class="users" id="mytopic">
          <!--{loop $mytopic $value}-->
          <a href="topic.php?tid=$value['tid']" class="weui-cell weui-cell_access load" id="mytopic_{$value['tid']}">
            <div class="weui-cell__hd"><img src="$value['cover']"></div>
            <div class="weui-cell__bd">
              <h4>$value['name']</h4>
              <p class="c4">$value['about']</p>
            </div>
          </a>
          <!--{/loop}-->
        </div>
      </div>
      <div class="box b_c3">
        <h3 class="box_title bob o_c3 cl"><a href="topic.php?mod=list" class="r weui-btn weui-btn_mini weui-btn_plain-primary load">查看全部</a><span class="c4">推荐话题</span></h3>
        <div class="users">
          <!--{loop $hotopic $value}-->
          <a href="topic.php?tid=$value['tid']" class="weui-cell weui-cell_access load">
            <div class="weui-cell__hd"><img src="$value['cover']"></div>
            <div class="weui-cell__bd">
              <h4>$value['name']</h4>
              <p class="c4">$value['about']</p>
            </div>
          </a>
          <!--{/loop}-->
        </div>
      </div>
    </div>
  </div>
  <div id="footer"> 
  <!--{template tabbar}-->
  </div>
</div>
<div id="smsscript">
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->