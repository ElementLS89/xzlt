<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="main">
  <div id="list">
    <div class="pt10 list_{$_GET['show']}">
<!--{/if}-->
  <!--{eval include temp('discuz/'.$themetemp,false)}-->
  
  
  
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
    </div>
  </div>
  <div id="page">
    <!--{if $maxpage>1}-->
    <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area=".list_{$_GET['show']}" {if $_GET['show']=='pics'}type="water"{/if}><span class="weui-loadmore__tips">下一页</span></a>
    <!--{/if}-->
  </div>
  <div id="script">
    <!--{if $_GET['show']=='pics'}-->
    <script language="javascript" reload="1">
      var id=SMS.hash(PHPSCRIPT);
      var wf = {};
      $('.currentbody').ready(function(){
        if($('.currentbody #waterfall').length >0) {
          wf = waterfall();
        }
      });
    </script>
    <!--{/if}-->
  </div>
</div>
<!--{/if}-->