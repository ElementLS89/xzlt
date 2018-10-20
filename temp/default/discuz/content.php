$content['message']
<!--{if $canmanage || $perm['getattachperm'] || $_GET['mod']=='get'}-->
<!--{if $attachment['img']}-->
<!--{eval $i=0}-->
<div class="swiper">
  <!--{loop $attachment['img'] $img}-->
  <!--{if !$img['price'] && !in_array($img[aid],$attachtags[$img['pid']]) && !in_array($img[aid],$sortaids)}-->
  <!--{if $_GET['mod']=='get'}-->
  <p><img src="$img['atc']" class="viewpic" thumb="thumb" swiper="$i"></p>
  <!--{else}-->
  <p><img src="ui/sl.png" data-original="$img['atc']" class="viewpic lazyload" thumb="thumb" swiper="$i"></p>
  <!--{/if}-->
  <!--{eval $i++}-->
  <!--{/if}-->
  <!--{/loop}-->
</div>
<!--{/if}-->

<!--{if $attachment['atc']}-->
<!--{loop $attachment['atc'] $atc}-->
<!--{if !$atc['price'] && !in_array($atc[aid],$attachtags[$atc['pid']])}-->
<a href="$atc['attachment']" class="download c8"><span class="icon icon-down"></span>$atc['filename']<em class="c4">({$atc['filesize']})</em></a>
<!--{/if}-->
<!--{/loop}-->
<!--{/if}-->
<!--{/if}-->