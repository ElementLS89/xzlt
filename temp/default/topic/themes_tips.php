<?exit?>
<div id="view">
 
    <div class="smsbody body_b $outback">
	  <div class="find-items b_c3">
        <ul class="cl c6">
          <!--{loop $_S['cache']['navs']['nav_find'] $value}-->
          <!--{if $_S['setting']['closebbs'] && in_array($value['url'],array('topic.php','topic.php?mod=forum','topic.php?mod=post','discuz.php'))}-->
          <!--{eval $value['close']=true;}-->
          <!--{/if}-->
          <!--{if $value['best'] && $value['canuse'] && !$value['close']}-->
          <li><a href="$value['url']" {if $value['url']}class="load"{/if}><img src="$value[icon]" /><p{if !$value['url']} class="c4"{/if}>$value[name]</p></a></li>
          <!--{/if}-->
          <!--{/loop}-->
        </ul>
      </div>
    </div>

</div>