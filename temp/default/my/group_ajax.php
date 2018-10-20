<?exit?>
<!--{loop $list $value}-->
<a class="weui-cell load" id="{$value['lid']}" href="my.php?mod=account&lid=$value['lid']">
  <div class="weui-cell__bd">
    <h4><strong class="c6">$value['title']</strong>$value['title_after']</h4>
    <p class="c4 s12">{date($value['logtime'],'Y-m-d H:i:s')}</p>
  </div>
  <div class="weui-cell__ft">
    {$value['arose_before']}$value['arose']
  </div>
</a>
<!--{/loop}-->