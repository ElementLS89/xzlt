<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><!--{if $_S['uid']}--><a href="javascript:SMS.opensheet('#themesheet_$theme[vid]')" class="icon icon-more"></a><!--{else}--><a href="javascript:SMS.openside()" class="icon icon-openside"></a><!--{/if}--></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <div class="p15 b_c3 bob o_c3 themecontent">
        <!--{eval include temp('topic/themebody')}-->
      </div>
      <!--{if $theme['praise']}-->
      <div class="praise bob o_c3 p10 b_c3 flexbox">
        <div class="flex s12 c2">
          <ul class="cl">
            <!--{loop $praise $value}-->
            <li><a href="topic.php?mod=praise&&type=topic&id=$_GET['vid']" class="load"><!--{avatar($value,1)}--></a></li>
            <!--{/loop}-->
          </ul><a href="topic.php?mod=praise&&type=topic&id=$_GET['vid']" class="load">{$theme['praise']}人点赞<span class="icon icon-forward"></span></a>
        </div>
        <span class="icon icon-praise c4">{$theme['praise']}</span>
      </div>
      <!--{/if}-->
      <div class="weui-cells__title pb10">{if $topic['name']}<a href="topic.php?tid=$topic['tid']" class="r c1 load">#{$topic['name']}</a>{/if}评论<span class="pr5" id="replyscount_{$_GET[vid]}">$theme['replys']</span>阅读$theme['views']</div>
      <div class="replys b_c3 bot o_c3" id="replylist">
        <!--{template topic/viewtheme_ajax}-->
      </div>
      <!--{if $maxpage>1}-->
      <div id="page">
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" area="#replylist" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <!--{/if}-->
      <!--{template shar}-->
      <div class="weui-actionsheet" id="themesheet_$theme[vid]">
        <div class="weui-actionsheet__menu">
          <!--{if $canmanage || $_S['uid']==$theme['uid']}-->
          <a href="topic.php?mod=post&vid=$_GET['vid']" class="weui-actionsheet__cell c6 load">编辑</a>
          <a href="topic.php?mod=action&ac=delete&vid=$_GET['vid']" class="weui-actionsheet__cell c6 load" loading="tab">删除</a>
          <!--{/if}-->
          <!--{if $canmanage}-->
          <a href="topic.php?mod=action&ac=settop&vid=$_GET['vid']" class="weui-actionsheet__cell c6 load" id="settop_$_GET['vid']" loading="tab"><!--{if $theme['top']}-->取消置顶<!--{else}-->置顶<!--{/if}--></a>
          <a href="topic.php?mod=action&ac=setbest&vid=$_GET['vid']" class="weui-actionsheet__cell c6 load" id="setbest_$_GET['vid']" loading="tab"><!--{if $theme['best']}-->取消推荐<!--{else}-->推荐<!--{/if}--></a>
          <!--{/if}-->
          <!--{if $_S['uid']}-->
          <a href="index.php?mod=feed&type=3&ref=topic.php?vid=$_GET[vid]" class="weui-actionsheet__cell c6 load">举报</a>
          <!--{/if}-->
        </div>
        <div class="weui-actionsheet__action">
          <a href="javascript:" class="weui-actionsheet__cell c1">取消</a>
        </div>
      </div>
    </div>
  </div>
  <div id="footer">
    <div class="footer b_c2 bot o_c1">
      <ul class="send flexbox">
        <li class="btn"><a href="index.php" class="icon icon-home load"></a></li>
        <li class="flex message"><a href="reply.php?mod=topic&ac=rt&s=l&vid=$_GET['vid']" class="bo o_c1 b_c3 c4 load" loading="tab">写评论...</a></li>
        <li class="btn" id="themepraise_{$_GET[vid]}"><a href="topic.php?mod=action&ac=praise&vid=$_GET['vid']" class="icon icon-praise load" loading="tab"></a>{if $theme['praise']}<span class="weui-badge">$theme['praise']</span>{/if}</li>
        <li class="btn"><a href="collection.php?mod=topic&vid=$_GET['vid']" class="icon icon-collection load" id="collectionbtn_{$_GET[vid]}" loading="tab"></a></li>
        <li class="btn"><a href="javascript:share();" class="icon icon-shar"></a></li>
      </ul>
    </div>
  </div>
</div>
<div id="smsscript">
  <!--{if $_S['bro']=='qqbro' || $_S['bro']=='ucbro'}-->
  <script language="javascript" reload="1" >
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
  <!--{if $needpay}-->
  <!--{template wechat_pay}-->
  <!--{/if}-->
</div>
<!--{template footer}-->