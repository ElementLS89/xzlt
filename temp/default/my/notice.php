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
    <div class="smsbody $outback" nocache="true">
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="flex c1"><a href="my.php?mod=notice" class="load"><span>通知</span></a></li>
          <li class="flex c7"><a href="my.php?mod=message" class="load"><span>聊天</span></a></li>
          <li class="flex c7"><a href="my.php?mod=newfriend" class="load"><span>新朋友</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>
      <div class="autolist pt10" id="mynotice">
      <!--{template my/notice_ajax}-->
      </div>
      <!--{if $maxpage>1}-->
      <div id="page">
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <!--{/if}-->
    
    </div>
  </div>
  <div id="footer"> 
    <!--{template tabbar}--> 
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
		$(document).ready(function() {
			SMS.translate_int();
			$('#newmsg').empty();
			$('#botnotice').remove();
			smsot.upnotice();
		});
  
		
  </script>
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->