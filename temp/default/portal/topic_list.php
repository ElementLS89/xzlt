<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <div class="users">
    <!--{if $modvar['form']=='discuz'}-->
    <!--{loop $modvar['ids'] $forum}-->
    <a href="discuz.php?mod=forum&fid=$forum['fid']" class="weui-cell weui-cell_access load">
      <div class="weui-cell__hd"><img src="$forum['icon']"></div>
      <div class="weui-cell__bd">
        <h4>$forum['name']</h4>
        <p class="c4">$forum['description']</p>
      </div>
    </a>
    <!--{/loop}-->      
    <!--{else}-->
    <!--{loop $modvar['ids'] $forum}-->
    <a href="topic.php?tid=$forum[tid]" class="weui-cell weui-cell_access load">
      <div class="weui-cell__hd"><img src="$forum['cover']"></div>
      <div class="weui-cell__bd">
        <h4>$forum['name']</h4>
        <p class="c4">$forum['about']</p>
      </div>
    </a>
    <!--{/loop}-->  
    <!--{/if}--> 
  </div>
</div>