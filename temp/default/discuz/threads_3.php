<?exit?>
<!--{loop $list $value}-->
<!--{eval $value['pics']=count($pics[$value['tid']])}-->
<div id="theme_$value[tid]">
  <div class="b_c3 mt10 bob o_c3">
    <!--{if $value['pics'] || $value['imgs']}-->
    <div class="theme-img-big"><a href="discuz.php?mod=view&tid=$value['tid']" class="load"><!--{if $value['pics']}--><!--{eval getdzpic($pics[$value['tid']],640,320,1)}--><!--{else}--><!--{eval getdzwebpic($value['imgs'],640,320,1)}--><!--{/if}--></a></div>
    <!--{/if}-->
    <h3 class="theme-sub"><a href="discuz.php?mod=view&tid=$value['tid']" class="load">$value['subject']</a></h3>
    <div class="theme-foot">
      <div class="r s13"><span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replies']}</span></div>
      <a href="user.php?dzuid=$value['authorid']" class="c8 load"><!--{avatar($value['authorid'],2,'img','dz')}-->$value['author']</a>
    </div>  
  </div>
</div>
<!--{/loop}-->