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
    <!--{if $list}-->
    <div class="autolist">
    <!--{template topic/nearby_ajax}-->
    </div>
    <!--{if $maxpage>1}-->
    <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
    <!--{/if}-->
    <!--{else}-->
    <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">{$city}暂无任何消息</span></div>
    <!--{/if}-->
    </div>
  </div>
  <div id="footer"> 
  <!--{template tabbar}-->
  </div>
</div>
<div id="smsscript">
  <!--{template wechat}-->
  <!--{template wechat_lbs}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->