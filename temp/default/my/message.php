<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><a href="javascript:history.back(-1)" class="icon icon-back"></a></div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback" nocache="true">
      <!--{if $_S['member']['newnotice']}-->
      <a href="my.php?mod=notice" class="notice load" id="newnotice" onclick="$(this).remove();">有新的系统消息(<span id="noticenum">$_S['member']['newnotice']</span>)</a>
      <!--{/if}-->
      <div class="weui-cells users autolist" id="messagelist">
        <!--{template my/message_ajax}--> 
      </div>
      <!--{if $maxpage>1}-->
      <div id="page">
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <!--{/if}-->
    </div>
  </div>
  <div id="footer">
    <!--{template my/tabbar}-->
  </div>
</div>
<div id="smsscript">
<!--{template wechat_shar}-->
</div>
<!--{template footer}-->