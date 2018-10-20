<?exit?>
<form action="topic.php?mod=manage&tid=$_GET['tid']&item=level" method="post" id="{PHPSCRIPT}_{$_GET['mod']}_form">
  <input name="submit" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <div class="weui-cells">
    <!--{loop $topicgroup $id $value}-->
    <div class="weui-cell">
      <div class="weui-cell__bd">
        <input type="hidden" name="id[$id]" value="$id" />
        <input class="weui-input" type="text" name="name[$id]" placeholder="等级名称" value="$value['name']">
      </div>
      <div class="weui-cell__ft s15"><!--{if $value['experience']}-->$value['experience'] 经验<!--{else}-->/<!--{/if}--></div>
    </div>
    <!--{/loop}-->
  </div>
  <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">设置自定义用户等级</button></div>
</form>  