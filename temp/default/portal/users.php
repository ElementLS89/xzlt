<?exit?>
<div class="scrollx users_list" style="$modstyle">
  <div class="scrollx_area">
    <ul class="c">
    <!--{if $modvar['form']=='discuz'}-->
    <!--{loop $modvar['users'] $value}-->
    <li>
      <a href="user.php?dzuid=$value['uid']" class="load b_c3 tc"><!--{avatar($value['uid'],2,'img','dz')}--><h4 class="s17">$value['username']</h4><p class="s13 c2">$value['credits']积分</p><p class="s13 pt10"><span class="bo o_c2 c1">+关注</span></p></a>
    </li>
    <!--{/loop}-->
    <!--{else}-->
    <!--{loop $modvar['users'] $value}-->
    <li>
      <a href="user.php?uid=$value['uid']" class="load b_c3 tc"><!--{avatar($value['user'],2)}--><h4 class="s17">$value['username']</h4><p class="s13 c2">$value['experience']经验</p><p class="s13 pt10"><span class="bo o_c2 c1">+关注</span></p></a>
    </li>
    <!--{/loop}-->
    <!--{/if}-->
    </ul>  
  </div>
</div>