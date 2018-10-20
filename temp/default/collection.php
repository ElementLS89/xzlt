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
      <!--{if $_S['setting']['mods']>1}-->
      <div class="scrollx topnv navs b_c3 bob o_c3 mb10">
        <div class="scrollx_area">
          <ul class="c">
            <!--{if $_S['dz'] && $_S['member']['dzuid']}-->
            <li{if $_GET['mod']=='discuz'} class="c1 o_c1"{/if} id="mod_discuz"><a href="collection.php?mod=discuz" class="get" box="vc_discuz" btn="mod_discuz">论坛帖子</a></li>
            <!--{/if}-->
            <!--{loop $_S['setting']['mods'] $mid $mod}-->
            <li{if $_GET['mod']==$mid} class="c1 o_c1"{/if} id="mod_{$mid}"><a href="collection.php?mod=$mid" class="get" box="vc_{$mid}" btn="mod_{$mid}">$mod['name']</a></li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>   
      <!--{/if}-->
      <!--{if $_S['dz'] && $_S['member']['dzuid']}-->
      <div id="vc_discuz" {if $_GET['mod']!='discuz'}style="display:none"{else} class="ready current"{/if}>
      <!--{template collection_ajax}-->
      </div>
      <!--{/if}-->
      <!--{loop $_S['setting']['mods'] $mid $mod}-->
      <div id="vc_{$mid}" {if $_GET['mod']!=$mid}style="display:none"{else} class="ready current"{/if}>
      <!--{template collection_ajax}-->
      </div>
      <!--{/loop}-->   
      
      <div id="page">
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vc_{$_GET['mod']}"><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->   
      </div>

    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
<!--{template wechat_shar}-->
</div>
<!--{template footer}-->