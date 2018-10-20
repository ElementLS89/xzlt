<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
  </div>
  <div id="main">
    <div class="smsbody body_b $outback">
      <div class="find-items write">
        <ul class="cl c6">
          <!--{loop $_S['cache']['navs']['nav_write'] $value}-->
          <!--{if $value['canuse'] && !$value['close']}-->
          <li><a href="$value['url']" {if $value['url']}class="load"{/if}><img src="$value[icon]" /><p{if !$value['url']} class="c4"{/if}>$value[name]</p></a></li>
          <!--{/if}-->
          <!--{/loop}-->
        </ul>
      
      </div>
      
    </div>
  </div>
  <div id="footer">
    <a href="javascript:" class="closepage b_c3 bot o_c3 icon icon-close c1"></a>
  </div>
</div>
<div id="smsscript">
	<script language="javascript" reload="1">
	  setTimeout(function(){
			contentheight=$(window).height()-51;
			$('.currentbody .find-items').css('height', contentheight+'px');			
		})

  </script>
  <!--{template wechat_shar}-->
  <!--{template wechat_lbs}-->
</div>

<!--{template footer}-->