<?exit?>
<div class="scrollx topnv navs b_c3 bob o_c3" style="$modstyle">
  <div class="scrollx_area">
    <ul class="c">
      <!--{loop $modvar['content'] $nav}-->
      <!--{eval $nav['current']=getnavcurrent($nav['url'])}-->
      <!--{if $nav['current']=='c1'}-->
      <!--{eval $nav['current']='c1 o_c1'}-->
      <!--{else}-->
      <!--{eval $nav['current']=''}-->
      <!--{/if}-->
      <li class="$nav['current']"><a href="$nav['url']" class="load">$nav['name']</a></li>
      <!--{/loop}-->
    </ul>  
  </div>
</div>