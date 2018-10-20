<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <div class="list_pannel flexbox">
        <div class="scrolly left">
          <ul class="scrolly_area">
            <!--{eval $i=1}-->
            <!--{loop $_S['cache']['topic_types'] $type}-->
            <!--{if $i==1}-->
            <!--{eval $firstid=$type['typeid']}-->
            <!--{/if}-->
            <li class="{if $type['typeid']==$_GET['typeid']}b_c3 {/if}bob o_c3" id="type_{$type['typeid']}"><a href="topic.php?mod=list&typeid=$type['typeid']" class="get" type="side" btn="type_{$type['typeid']}" box="topiclist_{$type['typeid']}"><span class="{if $type['typeid']==$_GET['typeid']}b_c1{/if}"></span>$type[name]</a></li>
            <!--{eval $i++}-->
            <!--{/loop}-->
          </ul>
        </div>
        <div class="right flex b_c3">
          <!--{eval $i=1}-->
          <!--{loop $_S['cache']['topic_types'] $type}-->
          <div class="users {if $i==1}ready current{/if}" id="topiclist_{$type['typeid']}" {if $i!=1}style="display:none"{/if}>
          <!--{if $i==1}-->
          <!--{template topic/list_ajax}-->
          <!--{/if}-->
          </div>
          <!--{eval $i++}-->
          <!--{/loop}-->
          <div id="page">
          <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#topiclist_{$firstid}"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
          </div>

        </div>
      </div>
    </div>
  </div>
  <div id="footer"> 
  <!--{template tabbar}-->
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
	  $(document).ready(function() {
			$('.list_pannel').css('height',clientheight-103 + 'px');
		});
  </script>
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->