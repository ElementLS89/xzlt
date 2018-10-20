<?exit?>
<!--{if $_GET['get']!='ajax'}-->
<div class="themeslist autolist">
<!--{/if}-->
<!--{eval $list=$modvar['list'];}-->
<!--{eval $sorts=$modvar['sorts']}-->
  <!--{eval $pics=getlistpic($modvar['pictab'],$modvar['tids']);}-->
  <!--{eval include temp('discuz/threads_sorts',false)}-->
<!--{if $_GET['get']!='ajax'}-->
</div>
<!--{if $modvar['maxpage']>1}-->
<a href="$modvar['nexturl']" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$modvar['maxpage']"><span class="weui-loadmore__tips">下一页</span></a>
<!--{/if}-->   
<!--{/if}-->  