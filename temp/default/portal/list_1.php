<?exit?>
<!--{if $_GET['get']!='ajax'}-->
<div class="themeslist autolist">
<!--{/if}-->
<!--{eval $list=$modvar['list'];}-->
  <!--{if $paramarr['form']=='discuz'}-->
  <!--{eval $pics=getlistpic($modvar['pictab'],$modvar['tids']);}-->
  <!--{eval include temp('discuz/threads_1',false)}-->
  <!--{else}-->
  <!--{eval include temp('topic/themes_1',false)}-->
  <!--{/if}-->
  
<!--{if $_GET['get']!='ajax'}-->
</div>
<!--{if $modvar['maxpage']>1}-->
<a href="$modvar['nexturl']" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$modvar['maxpage']"><span class="weui-loadmore__tips">下一页</span></a>
<!--{/if}-->   
<!--{/if}-->  