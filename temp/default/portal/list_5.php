<?exit?>
<!--{eval $list=$modvar['list'];}-->
  <!--{if $paramarr['form']=='discuz'}-->
  <!--{eval $pics=getlistpic($modvar['pictab'],$modvar['tids']);}-->
  <!--{eval include temp('discuz/threads_5',false)}-->
  <!--{else}-->
  <!--{eval include temp('topic/themes_5',false)}-->
  <!--{/if}-->
<!--{if $_GET['get']!='ajax'}-->
<!--{if $modvar['maxpage']>1}-->
<a href="$modvar['nexturl']" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$modvar['maxpage']" type="water"><span class="weui-loadmore__tips">下一页</span></a>
<!--{/if}-->   
<!--{/if}-->  