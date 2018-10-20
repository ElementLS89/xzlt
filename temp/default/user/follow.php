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
          <li class="{if $_GET['show']=='follow'}c1{else}c7{/if} flex"><a href="user.php?mod=follow&uid=$_GET[uid]" class="get" type="switch" box="follow_{$_GET[uid]}_follow"><span>关注</span></a></li>
          <li class="{if $_GET['show']=='fans'}c1{else}c7{/if} flex"><a href="user.php?mod=follow&uid=$_GET[uid]&show=fans" class="get" type="switch" class="switch" box="follow_{$_GET[uid]}_fans"><span>粉丝</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>
      <div class="box-area">
        <!--{if $_GET['show']=='fans'}-->
        <div class="box-content weui-cells users{if $uid==$_S['uid']} myfollows{/if}" id="follow_{$_GET[uid]}_follow" style="display:none"></div>
        <div class="box-content weui-cells users current ready" id="follow_{$_GET[uid]}_fans">
        <!--{template user/follow_ajax}-->
        </div>       
        <!--{else}-->
        <div class="box-content weui-cells users current ready{if $uid==$_S['uid']} myfollows{/if}" id="follow_{$_GET[uid]}_follow">
        <!--{template user/follow_ajax}-->
        </div>
        <div class="box-content weui-cells users" id="follow_{$_GET[uid]}_fans" style="display:none"></div>
        <!--{/if}-->
      </div>
      <div id="page">
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#follow_{$_GET[uid]}_{$_GET['show']}"><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->
      </div>
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
	  $(document).ready(function() {
      SMS.translate_int();
		});
  </script>
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->