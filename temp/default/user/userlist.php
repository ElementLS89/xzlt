<?exit?>
<!--{loop $list $value}-->
<div class="bob o_c3 cl pt10 pb10">
  <a href="user.php?uid=$value['uid']" class="load"><!--{avatar($value['user'],2)}--></a>
  <a href="user.php?uid=$value['uid']" class="load"><h3><!--{if $value[dis]}--><span class="c4 icon icon-lbs">$value[dis]</span><!--{/if}-->$value['username']</h3></a>
  <p class="s12"><!--{if $value['gender']}--><span class="icon $value['gender'] c3">$value['age']</span><!--{/if}--><span class="bo o_c2 c1">$value['group']</span></p>
  <p class="lm s12 c4"><!--{if $value['lm']}-->$value['lm']<!--{else}-->$value['bio']<!--{/if}--></p>
</div>
<!--{/loop}-->