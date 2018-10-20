<?exit?>
<!--{eval $i=1}-->
<!--{loop $list $value}-->
<a href="my.php?mod=mingpian&uid=$value['fuid']&touid=$_GET['touid']" class="weui-cell{if $_S['page']=='1' && $i=='1'} bot o_c3{/if} load" id="mingpian_{$value['fuid']}">
  <div class="weui-cell__hd"><!--{avatar($value['user'],2)}--></div>
  <div class="weui-cell__bd">
    <h4 class="c6">$value['friendname']</h4>
  </div>
</a>
<!--{eval $i++}-->
<!--{/loop}-->