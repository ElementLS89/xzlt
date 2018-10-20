<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <ul class="portal_news_top">
    <!--{eval $max=count($modvar['list']);}-->
    <!--{eval $i=1}-->
    <!--{loop $modvar['list'] $value}-->
    <li class="{if $i<$max}bob o_c3 {/if}ellipsis"><span class="{if $i>3}b_c4{else}b_c1 c3{/if}">$i</span><a href="$value['url']" class="load" >$value['subject']</a></li>
    <!--{eval $i++}-->
    <!--{/loop}-->

  </ul>
</div>