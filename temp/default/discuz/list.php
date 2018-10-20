<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r">
        <a href="javascript:SMS.openside()" class="icon icon-openside"></a>
      </div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
    
      <div class="scrollx topnv navs b_c3 bob o_c3 mb10">
        <div class="scrollx_area">
          <ul class="c">
            <li{if !$_GET['catid']} class="c1 o_c1"{/if} id="news_"><a href="discuz.php?mod=list&catid=$value['catid']" class="get" box="vp_" btn="news_">全部</a></li>
            <!--{loop $cats $value}-->
            <li{if $_GET['catid']==$value['catid']} class="c1 o_c1"{/if} id="news_{$value['catid']}"><a href="discuz.php?mod=list&catid=$value['catid']" class="get" box="vp_{$value['catid']}" btn="news_{$value['catid']}">$value['catname']</a></li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <div id="vp_" {if !$_GET['catid']}class="ready current"{else}style="display:none"{/if}><!--{if !$_GET['catid']}--><!--{template discuz/list_ajax}--><!--{/if}--></div>
      <!--{loop $cats $catid $value}-->
      <div id="vp_{$catid}" {if $_GET['catid']==$catid}class="ready current"{else}style="display:none"{/if}><!--{if $catid==$_GET['catid']}--><!--{template discuz/list_ajax}--><!--{/if}--></div>
      <!--{/loop}-->

      <div id="page">
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vp_{$_GET['catid']}"><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->   
      </div> 
      
    </div>
  </div>
  <div id="footer">
  </div>
</div>
<div id="smsscript">
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->