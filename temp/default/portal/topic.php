<?exit?>
<div class="scrollx topic_list" style="$modstyle">
  <div class="scrollx_area">
    <ul class="c">
      <!--{if $modvar['form']=='discuz'}-->
      <!--{loop $modvar['ids'] $forum}-->
      <li><a href="discuz.php?mod=forum&fid=$forum['fid']" class="load b_c3 cl"><img src="$forum['icon']" /><h4 class="s17">$forum['name']</h4><p class="s13 c2">$forum['threads']主题<em></em>$forum['posts']帖子</p></a></li>
      <!--{/loop}-->      
      <!--{else}-->
      <!--{loop $modvar['ids'] $forum}-->
      <li><a href="topic.php?tid=$forum[tid]" class="load b_c3 cl"><img src="$forum['cover']" /><h4 class="s17">$forum['name']</h4><p class="s13 c2">$forum['themes']话题<em></em>$forum['users']成员</p></a></li>
      <!--{/loop}-->  
      <!--{/if}-->
    </ul>  
  </div>
</div>