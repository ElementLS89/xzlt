<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><a href="javascript:SMS.closepage()" class="icon icon-close"></a></div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_t $outback" nocache="true">
      <!--{if $list}-->
      <div class="autolist">
        <div class="weui-cells weui-cell_access">
          <!--{loop $list $value}-->
          <a href="user.php?uid=$value['uid']" class="weui-cell load">
            <div class="weui-cell__hd"><!--{avatar($value,1)}--></div>
            <div class="weui-cell__bd">
              <p>$value['username']</p>
            </div>
            <div class="weui-cell__ft s12">{date($value['dateline'],'Y-m-d H:i:s')}</div>
          </a>
          <!--{/loop}-->
        </div>
      </div>
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->
      <!--{else}-->
      <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂无点赞记录</span></div>
      <!--{/if}-->
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
</div>
<!--{template footer}-->
  