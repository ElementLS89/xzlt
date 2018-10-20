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
      <div class="p15 b_c3 bob o_c3 themecontent">
        <h1 class="article_title">$news['title']</em></h1>
        <div class="article_usre flexbox">
          <div class="flex">
            <!--{if $news['uid']}-->
            <a href="user.php?dzuid=$news['uid']" class="load"><!--{avatar($news['uid'],2,'img','dz')}--></a><h3><a href="user.php?dzuid=$news['uid']" class="c1 load">$news['username']</a></h3>
            <!--{/if}-->
            <p class="c4 s12">{date($news['dateline'],'Y-m-d H:i')}</p>
          </div>
          <div>
 
          </div>
        </div>
        <div class="weui-article">
        $news['content']
        </div>
      </div>
      <!--{if $related}-->
      <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd s17">相关文章</div>
        <div class="weui-panel__bd">
          <!--{loop $related $value}-->
          <a href="discuz.php?mod=news&aid=$value['raid']" class="weui-media-box weui-media-box_appmsg load">
            <!--{if $value['pic']}-->
            <div class="weui-media-box__hd"><img class="weui-media-box__thumb" src="$value['pic']"></div>
            <!--{/if}-->
            <div class="weui-media-box__bd">
              <h4 class="weui-media-box__title">$value['title']</h4>
              <p class="weui-media-box__desc">$value['summary']</p>
            </div>
          </a>
          <!--{/loop}-->
        </div>
      </div>
      <!--{/if}-->
      <div class="weui-cells__title pb10"><a href="discuz.php?mod=list&catid=$news['catid']" class="r c1 load">#{$news['catname']}</a>评论<span class="pr5" id="replyscount_{$_GET[aid]}">$news['commentnum']</span>阅读$news['viewnum']</div>
      <div class="replys b_c3 bot o_c3" id="replylist">
        <!--{template discuz/news_ajax}-->
      </div> 
      <!--{if $maxpage>1}-->
      <div id="page">
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" area="#replylist" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <!--{/if}-->

     
      <!--{template shar}-->
    </div>
  </div>
  <div id="footer">
    <div class="footer b_c2 bot o_c1">
      <ul class="send flexbox">
        <li class="btn"><a href="index.php" class="icon icon-home load"></a></li>
        <!--{if !$news['allowcomment']}-->
        <li class="flex message"><a href="javascript:" class="bo o_c1 b_c3 c4" loading="tab">本文章已关闭评论</a></li>
        <!--{else}-->
        <li class="flex message"><a href="discuz.php?mod=portal&ac=comment&aid=$_GET['aid']" class="bo o_c1 b_c3 c4 load" loading="tab">写评论...</a></li>
        <!--{/if}-->
        <li class="btn" id="newsclick3_{$_GET[aid]}"><a href="discuz.php?mod=portal&ac=click3&aid=$_GET['aid']" class="icon icon-praise load" loading="tab"></a><!--{if $news['click3']}--><span class="weui-badge">$news['click3']</span><!--{/if}--></li>
        <li class="btn"><a href="discuz.php?mod=portal&ac=fav&aid=$_GET['aid']" class="icon icon-collection load" id="newsfavbtn_{$_GET[aid]}" loading="tab"></a></li>
        <li class="btn"><a href="javascript:share();" class="icon icon-shar"></a></li>
      </ul>
    </div>
    
  </div>
</div>
<div id="smsscript">
  <!--{template discuz/js}-->
  <!--{if $_S['bro']=='qqbro' || $_S['bro']=='ucbro'}-->
  <script language="javascript" reload="1" id="common_share">
		var share_config = {
			url:window.location.href.split('#')[0],
			title:'$title',
			desc:'$_S[shar][desc]',
			img:'$_S[shar][pic]',
			from:'$_S[setting][sitename]'
		};
		var ShareObj = new smsshare(share_config);
	</script>
  <!--{/if}-->
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->