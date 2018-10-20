<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="themeslist">
  <div id="list">
<!--{/if}-->
<!--{eval include temp('discuz/threads_'.$forum['liststype'],false)}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <!--{if $thissort}-->
  <div id="other">
  <!--{eval include temp('discuz/sortsearch',false)}-->
  </div>
  <!--{/if}-->
  <div id="page">
  <!--{if $maxpage>1}-->
  <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vf_{if $_GET['typeid']}t{/if}{if $_GET['sortid']}s{/if}{$_GET['fid']}_{$_GET['order']}{$_GET['typeid']}{$_GET['sortid']}"{if $topic['liststype']=='5'}type="water"{/if}><span class="weui-loadmore__tips">下一页</span></a>
  <!--{/if}-->
  </div>
  
  <!--{if $forum['liststype']=='5'}-->
  <div id="script">
    <script language="javascript" reload="1">
      var id=SMS.hash(PHPSCRIPT);
      var wf = {};
      $('.currentbody').ready(function(){
        if($('.currentbody #waterfall').length >0) {
          wf = waterfall();
        }
      });
    </script>
  </div>
  <!--{/if}-->
</div>
<!--{/if}-->
