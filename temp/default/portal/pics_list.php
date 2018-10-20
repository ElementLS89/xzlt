<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <div class="portal_pics">
    <ul class="cl">
      <!--{if $paramarr['form']=='discuz'}-->
      <!--{eval $pics=getlistpic($modvar['pictab'],$modvar['tids']);}-->
      <!--{/if}-->
      <!--{loop $modvar['list'] $value}-->
      <li><div><a href="$value['url']" class="load"><!--{if $paramarr['form']=='discuz'}--><!--{eval getdzpic($pics[$value['tid']],300,200,1)}--><!--{else}--><!--{eval piclist($value,300,200,1)}--><!--{/if}--><p class="s13 ellipsis c3">$value['subject']</p></a></div></li>
      <!--{/loop}-->
    </ul>
  </div>
</div>