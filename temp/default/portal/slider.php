<?exit?>
<div class="swiper" style="$modstyle">
  <div class="swiper-wrapper">
    <!--{loop $modvar['content'] $slider}-->
    <div class="swiper-slide b_f tc flex_box"><a href="{if $slider[url]}$slider[url]{else}javascript:SMS.null(){/if}" class="load"><img src="$slider[pic]"/></a></div>
    <!--{/loop}-->
  </div>
  <div class="swiper-pagination"></div>
  <!--{if $modvar['style']==2}--><div class="water"><div class="water_1"></div><div class="water_2"></div></div><!--{/if}-->
  
</div>
