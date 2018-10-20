<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <div class="scrollx portal_pics_roll">
    <div class="scrollx_area b_f">
      <!--{if $paramarr['form']=='discuz'}-->
      <!--{eval $pics=getlistpic($modvar['pictab'],$modvar['tids']);}-->
      <!--{/if}-->
      <ul class="c">
        <!--{loop $modvar['list'] $value}-->
        <li>
          <div class="b_c7 bo o_c3">
            <a href="$value['url']"  class="load"><!--{if $paramarr['form']=='discuz'}--><!--{eval getdzpic($pics[$value['tid']],400,320,1)}--><!--{else}--><!--{eval piclist($value,400,320,1)}--><!--{/if}-->
            <h4>$value['subject']</h4>
            </a>
            <p class="c4 s12"><span class="r">阅读$value['views']</span><a href="$value['user_url']" class="c8 load"><!--{if $paramarr['form']=='discuz'}--><!--{avatar($value['uid'],2,'img','dz')}--><!--{else}--><!--{avatar($value['user'],2)}--><!--{/if}-->$value['author']</a></p>
          </div>
        </li>
        <!--{/loop}-->
      </ul>
    </div> 
  </div>
</div>