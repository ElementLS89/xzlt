<?exit?>
<!--{eval $i=1}-->
<!--{loop $list $value}-->
<a href="user.php?uid=$value['fuid']" class="weui-cell{if $_S['page']=='1' && $i=='1'} bot o_c3{/if} load" id="friend_{$value['fuid']}">
  <div class="weui-cell__hd"><!--{avatar($value['user'],2)}-->{if $list_more[$value[tid]]['newmessage']}<span class="weui-badge">$list_more[$value[tid]]['newmessage']</span>{/if}</div>
  <div class="weui-cell__bd">
    <h4 class="c6">$value['friendname']</h4>
    <p class="c4">{if $list_more[$value[tid]]['lastmessage']}$list_more[$value[tid]]['lastmessage']{/if}</p>
  </div>
</a>
<!--{eval $i++}-->
<!--{/loop}-->