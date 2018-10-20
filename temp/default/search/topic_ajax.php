<?exit?>
<!--{if $_S['dz']}-->
<!--{eval include temp('discuz/'.$themetemp,false)}-->
<!--{else}-->
<!--{if $_GET['t']=='topic'}-->
<!--{loop $list $value}-->
<a href="topic.php?tid=$value['tid']" class="weui-cell weui-cell_access load">
  <div class="weui-cell__hd"><img src="$value['cover']"></div>
  <div class="weui-cell__bd">
    <h4>$value['name']</h4>
    <p class="c4">$value['about']</p>
  </div>
</a>
<!--{/loop}-->
<!--{else}-->
<!--{eval include temp('topic/viewtopic_ajax',false)}-->
<!--{/if}-->
<!--{/if}-->