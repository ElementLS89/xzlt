<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <ul class="portal_news_pic">
    <!--{if $paramarr['form']=='discuz'}-->
    <!--{eval $pics=getlistpic($modvar['pictab'],$modvar['tids']);}-->
    <!--{/if}-->
    <!--{loop $modvar['list'] $value}-->
    <li class="{if $i<$max}bob o_c3 {/if}cl">
    <a href="$value['url']" class="load" ><!--{if $paramarr['form']=='discuz'}--><!--{eval getdzpic($pics[$value['tid']],220,160,1)}--><!--{else}--><!--{eval piclist($value,220,160,1)}--><!--{/if}-->
    <h4>$value['subject']</h4>
    <p class="s12 c4"><span class="r">阅读$value['views']</span>{date($value['dateline'],'m-d')}</p></a>
    </li>
    <!--{/loop}-->
  </ul>
</div>