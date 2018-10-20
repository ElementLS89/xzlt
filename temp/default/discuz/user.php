<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header flexbox transparent c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$dzuser['username']</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_0 $outback">
      <div class="usertop" id="viewuser_$uid">
        <div class="usertop-bg"></div>
        <div class="usertop-dzuser b_c3">
          $dzuser['username']<span class="bo o_c2 c1 s12 ml10">$_S['cache']['discuz_usergroup'][$dzuser['groupid']]['grouptitle']</span>
        </div>
        <div class="water"><div class="water_1"></div><div class="water_2"></div></div>
        <!--{avatar($dzuser['uid'],2,'img','dz')}-->
      </div>
      
      
      <div class="pt10 autolist">
        <!--{eval include temp('discuz/user_ajax',false)}-->
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
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->