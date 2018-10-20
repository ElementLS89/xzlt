<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <ul class="portal_news_list">
    <!--{eval $max=count($modvar['list']);}-->
    <!--{eval $i=1}-->
    <!--{loop $modvar['list'] $value}-->
    <li class="{if $i<$max}bob o_c3 {/if}ellipsis"><span class="r s12 c4">{date($value['dateline'],'m-d')}</span><a href="$value['topic_url']" class="load c1" >#{$value['name']}</a><a href="$value['url']" class="load" >$value['subject']</a></li>
    <!--{eval $i++}-->
    <!--{/loop}-->
  </ul>
</div>