<?exit?>
<!--{if $_GET['get']!='ajax'}-->
<!--{template header}-->
<div id="view">
  <div id="header">
    <!--{if $portal['header']['use']}-->
    <div class="header b_c1 flexbox c3">
      <div class="header-l topuser"><!--{if $_S['uid']}--><a href="user.php" class="load"><!--{avatar($_S['member'],2)}--></a><!--{else}--><a href="member.php" class="icon icon-login load"></a><!--{/if}--></div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
    <!--{/if}-->
  </div>
  <div id="main">
    <div class="smsbody $bodyclass $outback">
<!--{/if}-->
    <!--{loop $hackcss $css}-->
    <link rel="stylesheet" href="$css" type="text/css" media="all">
    <!--{/loop}-->
    <!--{loop $mods $value}-->
    <!--{eval getportalmod($value);}-->
    <!--{/loop}-->
    
<!--{if $_GET['get']!='ajax'}-->
    </div>
  </div>
  <div id="footer">
    <!--{if $portal['footer']['use']}-->
    <!--{eval $tabbar=$portal['footer']['tabbar']?$portal['footer']['tabbar']:'tabbar'}-->
    <!--{eval include temp($tabbar)}-->
    <!--{/if}-->
  </div>
</div>
<div id="smsscript">
  <!--{if $modjs}-->
  <script language="javascript" reload="1">
	  $(document).ready(function() {
			<!--{$modjs}-->
		});
  </script>
  <!--{/if}-->
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
  <!--{template wechat_lbs}-->
</div>

<!--{template footer}-->
<!--{/if}-->