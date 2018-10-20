<?exit?>
<!--{if $_GET['show']=='member'}-->
<!--{loop $list $value}-->
<a href="user.php?uid=$value['uid']" class="weui-cell weui-cell_link load">
  <div class="weui-cell__hd"><!--{avatar($value,2)}--></div>
  <div class="weui-cell__bd">
    <h4>$value['username']</h4>
    <p class="c4">$value['bio']</p>
  </div>
  <div class="weui-cell__ft">
  $topicgroup[$value['level']]['name']
  </div>
</a>
<!--{/loop}-->
<!--{else}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="themeslist">
  <div id="list">
<!--{/if}-->
<!--{eval include temp('topic/'.$themetemp,false)}-->
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}-->
  <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vt_{$_GET['tid']}_{$_GET['order']}{$_GET['typeid']}"{if $topic['liststype']=='5'}type="water"{/if}><span class="weui-loadmore__tips">下一页</span></a>
  <!--{/if}-->
  </div>
  <!--{if $topic['liststype']=='5'}-->
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
<!--{/if}-->