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
    
      <div class="scrollx topnv navs b_c3 bob o_c3">
        <div class="scrollx_area">
          <ul class="c">
            <li{if !$_GET['sortid']} class="c1 o_c1"{/if} id="sort_"><a href="discuz.php?mod=sort" class="get" box="vsort_" btn="sort_">最新发布</a></li>
            <!--{loop $sorttypes $typeid $name}-->
            <li{if $_GET['sortid']==$typeid} class="c1 o_c1"{/if} id="sort_{$typeid}"><a href="discuz.php?mod=sort&sortid=$typeid" class="get" box="vsort_{$typeid}" btn="sort_{$typeid}">$name</a></li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <div id="otherarea">
        <!--{if $thissort}-->
        <!--{template discuz/sortsearch}-->
        <!--{/if}-->      
      </div>
      <div id="vsort_" {if !$_GET['sortid']}class="ready current pt10"{else}class="pt10" style="display:none"{/if}><!--{if !$_GET['sortid']}--><!--{template discuz/sort_ajax}--><!--{/if}--></div>
      <!--{loop $sorttypes $typeid $name}-->
      <div id="vsort_{$typeid}" {if $_GET['sortid']==$typeid}class="ready current pt10"{else}class="pt10" style="display:none"{/if}><!--{if $typeid==$_GET['sortid']}--><!--{template discuz/sort_ajax}--><!--{/if}--></div>
      <!--{/loop}-->

      <div id="page">
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vsort_{$_GET['sortid']}"><span class="weui-loadmore__tips">下一页</span></a>
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