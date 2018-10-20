<?exit?>
<!--{loop $list $value}-->
<!--{eval $value['pics']=count($pics[$value['tid']])}-->
<div id="theme_$value[tid]">
  <div class="b_c3 bob o_c4 pt10">
    <!--{if $value['pics']==1}-->
    <div class="theme-content cl">
      <a href="discuz.php?mod=view&tid=$value['tid']" class="load block"><!--{eval getdzpic($pics[$value['tid']])}--><h3 class="theme-sub">$value['subject']</h3></a>
    </div>
    <!--{else}-->
    <a href="discuz.php?mod=view&tid=$value['tid']" class="load"><h3 class="theme-sub">$value['subject']</h3>
    <!--{if $value['pics']>1 || $value['imgs']}-->
    <ul class="theme-img cl" id="pics_$value[tid]">
      <!--{if $value['pics']>1}-->
      <!--{eval getdzpic($pics[$value['tid']],200,150,3)}-->
      <!--{else}-->
      <!--{eval getdzwebpic($value['imgs'],200,150,3)}-->
      <!--{/if}-->
    </ul></a>
    <!--{/if}-->  
    <!--{/if}-->
    <p class="theme-foot s13"><a href="discuz.php?mod=forum&fid=$value['fid']" class="c8 r load">$_S['cache']['discuz_forum'][$value['fid']]['name']</a><span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replies']}</span></p>
  </div>
</div>
<!--{/loop}-->