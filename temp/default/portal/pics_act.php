<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <div class="portal_pics_act">
    <!--{if $paramarr['form']=='discuz'}-->
    <!--{eval $pics=getlistpic($modvar['pictab'],$modvar['tids']);}-->
    <!--{eval $value['pics']=count($pics[$value['tid']]);}-->
    <!--{/if}-->
    <!--{loop $modvar['list'] $value}-->
    <div class="item">
      <h4><a href="$value['url']" class="load">$value['subject']</a></h4>
      <div>
        <a href="$value['url']" class="load"><!--{if $paramarr['form']=='discuz'}--><!--{eval getdzpic($pics[$value['tid']],600,200,1)}--><!--{else}--><!--{eval piclist($value,600,200,1)}--><!--{/if}--></a>
        <div>
          <strong><!--{date($value['dateline'],'d')}--></strong><span><!--{date($value['dateline'],'Y')}--><br><!--{date($value['dateline'],'m')}-->月</span>
        </div>
      </div>
      <p class="tr"><a href="$value['user_url']" class="c8 load l"><!--{if $paramarr['form']=='discuz'}--><!--{avatar($value['uid'],2,'img','dz')}--><!--{else}--><!--{avatar($value['user'],2)}--><!--{/if}-->$value['username']</a><span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replys']}</span></p>
    </div>
    <!--{/loop}-->
  </div>
</div>