<?exit?>
<!--{loop $list $value}-->
<!--{eval $value['pics']=count($pics[$value['tid']])}-->
<div id="theme_$value[tid]">
  <div class="b_c3 bob o_c3">
    <div class="theme-ui">
      <span class="r c2 s12">{date($value['dateline'],'Y-m-d H:i:s')}</span><a href="user.php?dzuid=$value['authorid']" class="c8 load"><!--{avatar($value['authorid'],2,'img','dz')}-->$value['author']</a>
    </div>
    <div style="padding-left:42px">
      <h3 class="theme-sub"><a href="discuz.php?mod=view&tid=$value['tid']" class="load">$value['subject']</a></h3>
      <!--{if $value['pics']==1}-->
      <div class="theme-img-one"><a href="discuz.php?mod=view&tid=$value['tid']" class="load"><!--{eval getdzpic($pics[$value['tid']],640,320)}--></a></div>
      <!--{elseif $value['pics']>1 || $value['imgs']}-->
      <a href="discuz.php?mod=view&tid=$value['tid']" class="load"><ul class="theme-img cl" id="pics_$value[tid]">
        <!--{if $value['pics']>1}-->
        <!--{eval getdzpic($pics[$value['tid']])}-->
        <!--{else}-->
        <!--{eval getdzwebpic($value['imgs'])}-->
        <!--{/if}-->
      </ul></a>
      <!--{/if}-->
      <p class="theme-foot s13"><a href="discuz.php?mod=forum&fid=$value['fid']" class="c8 r load">$_S['cache']['discuz_forum'][$value['fid']]['name']</a><span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replies']}</span></p>  
    </div>
  </div>
</div>
<!--{/loop}-->