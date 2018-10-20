<?exit?>
<!--{loop $list $value}-->
<a href="my.php?mod=talk&tid=$value[tid]" class="weui-cell weui-cell_access load" id="talk_$value[tid]">
  <div class="weui-cell__hd"><!--{avatar($value['formuid'],2)}--><!--{if $value['newmessage']}--><span class="weui-badge">$value['newmessage']</span><!--{/if}--></div>
  <div class="weui-cell__bd">
    <h4><span class="r s12 c2">{date($value['lastdateline'],'m-d H:i:s')}</span><span class="c1">$list_more[$value[formuid]]['username']</span></h4>
    <p class="c4">$value['lastmessage']</p>
  </div>
</a>
<!--{/loop}-->