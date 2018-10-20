<?exit?>
<!--{loop $list $value}-->
<div id="notice_{$value['nid']}" class="viewnotice b_c3 p10 bob o_c3 flexbox">
  <div class="user pr10">
    <!--{if $value['authorid']}-->
    <!--{avatar($value['authorid'],2)}-->
    <!--{else}-->
    $value['icon']
    <!--{/if}-->
  </div>
  <div class="flex">
    <div class="notice-content">
      <h3>系统消息{if $value['nums']>1}<span class="weui-badge">$value['nums']</span>{/if}</h3>
      <div>$value['note']</div>
      <p class="s12 c4 cl"><a href="my.php?mod=notice&nid=$value['nid']" class="load r" loading="tab">忽略</a>{date($value['dateline'],'Y-m-d H:i:s')}</p>
    </div>

  </div>
</div>
<!--{/loop}-->