<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <div class="scrollx topic_fav b_c3 bob o_c3" style="$modstyle">
    <div class="scrollx_area">
      <ul class="c">
        <!--{if $modvar['form']=='discuz'}-->
        <!--{loop $modvar['ids'] $forum}-->
        <li class="tc"><a href="discuz.php?mod=forum&fid=$forum['fid']" class="load"><img src="$forum['icon']" /><h4 class="s17">$forum['name']</h4><p class="s13 c2">$forum['threads']主题<em></em>$forum['posts']帖子</p></a></li>
        <!--{/loop}-->      
        <!--{else}-->
        <!--{loop $modvar['ids'] $forum}-->
        <li class="tc"><a href="topic.php?tid=$forum[tid]" class="load"><img src="$forum['cover']" /><h4 class="s17">$forum['name']</h4><p class="s13 c2">$forum['themes']话题<em></em>$forum['users']成员</p></a></li>
        <!--{/loop}-->  
        <!--{/if}-->
      </ul>  
    </div>
  </div>
</div>