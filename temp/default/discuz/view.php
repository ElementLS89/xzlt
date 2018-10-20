<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><!--{if $_S['myid']}--><a href="javascript:SMS.opensheet('#threadsheet_{$thread[tid]}')" class="icon icon-more"></a><!--{else}--><a href="javascript:SMS.openside()" class="icon icon-openside"></a><!--{/if}--></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <div class="p15 b_c3 bob o_c3 themecontent">
      <!--{template discuz/viewthread}-->
      </div>
      <!--{if $thread['recommend_add']}-->
      <div class="praise bob o_c3 p10 b_c3 flexbox">
        <div class="flex s12 c2">
          <ul class="cl">
            <!--{loop $praise $value}-->
            <li><a href="discuz.php?mod=praise&tid=$_GET['tid']" class="load"><!--{avatar($value['recommenduid'],2,'img','dz')}--></a></li>
            <!--{/loop}-->
          </ul><a href="discuz.php?mod=praise&tid=$_GET['tid']" class="load">{$thread['recommend_add']}人点赞<span class="icon icon-forward"></span></a>
        </div>
        <span class="icon icon-praise c4">{$thread['recommend_add']}</span>
      </div>
      <!--{/if}-->
      <!--{if $relateitem}-->
      <div class="weui-cells__title pb10">相关阅读</div>
      <div class="themeslist">
        <!--{loop $relateitem $value}-->
        <!--{eval $value['pics']=count($relateitem_pics[$value['tid']])}-->
        <div id="theme_$value[tid]">
          <div class="b_c3 bob o_c4 pt10">
            <!--{if $value['pics']==1}-->
            <div class="theme-content cl">
              <a href="discuz.php?mod=view&tid=$value['tid']" class="load block"><!--{eval getdzpic($relateitem_pics[$value['tid']])}--><h3 class="theme-sub">$value['subject']</h3></a>
            </div>
            <!--{else}-->
            <a href="discuz.php?mod=view&tid=$value['tid']" class="load"><h3 class="theme-sub">$value['subject']</h3>
            <!--{if $value['pics']>1}-->
            <ul class="theme-img cl" id="pics_$value[tid]">
              <!--{eval getdzpic($relateitem_pics[$value['tid']],200,150,3)}-->
            </ul></a>
            <!--{/if}-->  
            <!--{/if}-->
            <p class="theme-foot s13"><a href="discuz.php?mod=forum&fid=$value['fid']" class="c8 r load">$_S['cache']['discuz_forum'][$value['fid']]['name']</a><span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replies']}</span></p>
          </div>
        </div>
        <!--{/loop}-->      
      </div>

      
      <!--{/if}-->
      <div class="weui-cells__title pb10"><a href="discuz.php?mod=forum&fid=$thread['fid']" class="r c1 load">#{$forum['name']}</a>评论<span class="pr5" id="replyscount_{$_GET[tid]}">$thread['replies']</span>阅读$thread['views']</div>
      <!--{if $hiddenreplies}-->
      <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">本回帖仅作者可见</span></div>
      <!--{else}-->
      <div class="replys b_c3 bot o_c3" id="replylist">
        <!--{template discuz/view_ajax}-->
      </div>      
      <!--{/if}-->
      <!--{if $maxpage>1}-->
      <div id="page">
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" area="#replylist" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <!--{/if}-->
      <!--{template shar}-->
      <div class="weui-actionsheet" id="threadsheet_{$thread[tid]}">
        <div class="weui-actionsheet__menu">
          <!--{if $canmanage || $_S['myid']==$thread['authorid']}-->
          <a href="discuz.php?mod=post&ac=editthread&tid=$_GET['tid']" class="weui-actionsheet__cell c6 load">编辑</a>
          <!--{/if}-->
          <!--{if $canmanage}-->
          <a href="discuz.php?mod=action&ac=delete&tid=$_GET['tid']" class="weui-actionsheet__cell c6 load" loading="tab">删除</a>
          <a href="discuz.php?mod=action&ac=settop&tid=$_GET['tid']" class="weui-actionsheet__cell c6 load" id="settop_$_GET['tid']" loading="tab"><!--{if $thread['displayorder']>0}-->取消置顶<!--{else}-->置顶<!--{/if}--></a>
          <a href="discuz.php?mod=action&ac=setbest&tid=$_GET['tid']" class="weui-actionsheet__cell c6 load" id="setbest_$_GET['tid']" loading="tab"><!--{if $thread['digest']>0}-->取消推荐<!--{else}-->推荐<!--{/if}--></a>
          <!--{/if}-->
          <!--{if $_S['myid']}-->
          <a href="index.php?mod=feed&type=3&ref=discuz.php?mod=view&tid=$_GET[tid]" class="weui-actionsheet__cell c6 load">举报</a>
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
        <!--{if $thread['closed']}-->
        <li class="flex message"><a href="javascript:" class="bo o_c1 b_c3 c4" loading="tab">本帖子已被关闭无法参与评论</a></li>
        <!--{else}-->
        <li class="flex message"><a href="discuz.php?mod=post&ac=replythread&tid=$_GET['tid']" class="bo o_c1 b_c3 c4 load" loading="tab">写评论...</a></li>
        <!--{/if}-->
        <li class="btn" id="threadpraise_{$_GET[tid]}"><a href="discuz.php?mod=action&ac=praise&tid=$_GET['tid']" class="icon icon-praise load" loading="tab"></a><!--{if $thread['recommend_add']}--><span class="weui-badge">$thread['recommend_add']</span><!--{/if}--></li>
        <li class="btn"><a href="discuz.php?mod=action&ac=fav&tid=$_GET['tid']" class="icon icon-collection load" id="threadfavbtn_{$_GET[tid]}" loading="tab"></a></li>
        <li class="btn"><a href="javascript:share();" class="icon icon-shar"></a></li>
      </ul>
    </div>
    
  </div>
</div>
<div id="smsscript">
  <!--{template discuz/js}-->
  <script language="javascript">
    function postmanage(tid,pid,top,best){

			var toptext = top==1 ? '取消置顶' : '置顶';
			var sheet='<div class="weui-actionsheet" id="postsheet_'+pid+'"><div class="weui-actionsheet__menu">';
			   sheet+='<a href="discuz.php?mod=post&ac=editpost&pid='+pid+'" class="weui-actionsheet__cell c6 load">编辑</a>';
				 sheet+='<a href="discuz.php?mod=action&ac=delete&pid='+pid+'" class="weui-actionsheet__cell c6 load" loading="tab" >删除</a>';
				 sheet+='<a href="discuz.php?mod=action&ac=settop&pid='+pid+'" class="weui-actionsheet__cell c6 load" loading="tab" >'+toptext+'</a>';
				 sheet+='<a href="index.php?mod=feed&type=3&ref=discuz.php?mpd=view&tid='+tid+'&pid='+pid+'" class="weui-actionsheet__cell c6 load">举报</a>';
				 sheet+='</div><div class="weui-actionsheet__action"><a href="javascript:" class="weui-actionsheet__cell c1">取消</a></div>';
			$('.currentbody').append(sheet);
			setTimeout(function(){SMS.opensheet('#postsheet_'+pid,'remove');},100);
		}
  </script>
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