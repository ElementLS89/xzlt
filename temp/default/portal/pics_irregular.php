<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <div class="portal_pics_irregular">
    <!--{if $paramarr['form']=='discuz'}-->
    <!--{eval $pics=getlistpic($modvar['pictab'],$modvar['tids']);}-->
    <!--{eval $value['pics']=count($pics[$value['tid']]);}-->
    <!--{/if}-->
    <div class="item1 cl">
      <div class="iteml">
        <ul class="cl">
          <!--{eval $i=1}-->
          <!--{loop $modvar['list'] $value}-->
          <!--{if $i==1}-->
          <li>
            <a href="$value['url']" class="load"><!--{if $paramarr['form']=='discuz'}--><!--{eval getdzpic($pics[$value['tid']],400,400,1)}--><!--{else}--><!--{eval piclist($value,400,400,1)}--><!--{/if}--></a>
            <p><span>$value['subject']</span></p>
          </li>
          <!--{/if}-->
          <!--{eval $i++}-->
          <!--{/loop}-->        
        </ul>
      </div>
      <div class="itemr">
        <ul class="cl">
        <!--{eval $i=1}-->
        <!--{loop $modvar['list'] $value}-->
        <!--{if $i>1 && $i<4}-->
        <li><a href="$value['url']" class="load"><!--{if $paramarr['form']=='discuz'}--><!--{eval getdzpic($pics[$value['tid']],200,200,1)}--><!--{else}--><!--{eval piclist($value,200,200,1)}--><!--{/if}--></a></li>
        <!--{/if}-->
        <!--{eval $i++}-->
        <!--{/loop}-->
        </ul>
      </div>
    </div>
    <ul class="item2 cl">
      <!--{eval $i=1}-->
      <!--{loop $modvar['list'] $value}-->
      <!--{if $i>3}-->
      <li><a href="$value['url']" class="load"><!--{if $paramarr['form']=='discuz'}--><!--{eval getdzpic($pics[$value['tid']],200,200,1)}--><!--{else}--><!--{eval piclist($value,200,200,1)}--><!--{/if}--></a></li>
      <!--{/if}-->
      <!--{eval $i++}-->
      <!--{/loop}-->
      <li class="btn"><a href="topic.php?mod=post" class="load"><div><img src="ui/b.png" /><span><em class="icon icon-pic"></em><br />发照片</span></div></a></li>
    </ul>
  </div>
</div>