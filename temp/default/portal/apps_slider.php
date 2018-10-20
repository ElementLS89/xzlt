<?exit?>
<div class="apps_swiper b_c3" style="{if $havepage}padding-bottom:25px;{/if}$modstyle">
  <div class="swiper-wrapper">
    <ul class="swiper-slide b_f tc flex_box">
      <!--{eval $i=1}-->
      <!--{loop $modvar $nid}-->
      <!--{if $i>1 && is_int(($i-1)/$num)}-->
      </ul>
      <ul class="swiper-slide b_f tc flex_box">
      <!--{/if}-->
      <li style="width:$width"><a href="{if $_S['cache']['navs']['nav_find'][$nid]['url']}$_S['cache']['navs']['nav_find'][$nid]['url']{else}javascript:{/if}" class="{if $_S['cache']['navs']['nav_find'][$nid]['url']}load {else}c4 {/if}block"><img src="$_S['cache']['navs']['nav_find'][$nid][icon]"><br />$_S['cache']['navs']['nav_find'][$nid]['name']</a></li>
      <!--{eval $i++}-->
      <!--{/loop}-->
    </ul>
  </div>
  <!--{if $havepage}--> 
  <div class="swiper-pagination"></div>
  <!--{/if}-->
</div>