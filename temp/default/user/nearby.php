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
      <div class="userlist b_c3 pl10 pr10 autolist">
        <!--{template user/nearby_ajax}-->
      </div>
      
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
  <!--{template wechat}-->
  <!--{template wechat_lbs}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->