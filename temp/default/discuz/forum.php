<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header $forumskin['topbg'] flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r">
        <a href="discuz.php?mod=action&ac=fav&fid=$_GET['fid']" class="weui-btn weui-btn_mini load" id="forumbtn_{$forum['fid']}" loading="tab">收藏</a>
      </div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $forumskin['body'] $outback">
      <!--{if $forum['banner']}-->
      <div class="topic_banner" style="background-image:url($forum['banner'])">
      <!--{/if}-->
        <div class="topicinfo $forumskin['info']">
          <div class="flexbox p15">
            <img src="$forum['icon']">
            <div class="flex">
              <h3 class="s18 ellipsis">$forum['name']</h3>
              <p class="s13 $forumskin['info_p'] ellipsis">主题数<em id="threads_{$forum['fid']}">$forum['threads']</em>帖子数<em id="posts_{$forum['fid']}" class="pl5">$forum['posts']</em></p>
              <p class="s13 $forumskin['info_p']">$forum['description']</p>            
            </div>
            <!--{if $_S['app']['hideheader']}-->
            <a href="discuz.php?mod=action&ac=fav&fid=$_GET['fid']" class="weui-btn weui-btn_mini {if $forum['banner']}weui-btn_warn{else}weui-btn_default{/if} load" id="forumfav_{$forum['fid']}" loading="tab">收藏</a>
            <!--{/if}-->
          </div>
        </div>
      <!--{if $forum['banner']}-->
      </div>
      <!--{/if}-->
      <div class="scrollx topnv navs b_c3 bob o_c3">
        <div class="scrollx_area">
          <ul class="c">
            <li{if $_GET['order']=='new' && !$_GET['typeid'] && !$_GET['sortid']} class="c1 o_c1"{/if} id="by_{$_GET['fid']}_new"><a href="discuz.php?mod=forum&fid=$_GET['fid']" class="get" box="vf_{$_GET['fid']}_new" btn="by_{$_GET['fid']}_new">最新</a></li>
            <li{if $_GET['order']=='hot'} class="c1 o_c1"{/if} id="by_{$_GET['fid']}_hot"><a href="discuz.php?mod=forum&fid=$_GET['fid']&order=hot" class="get" box="vf_{$_GET['fid']}_hot" btn="by_{$_GET['fid']}_hot">最热</a></li>
            <li{if $_GET['order']=='best'} class="c1 o_c1"{/if} id="by_{$_GET['fid']}_best"><a href="discuz.php?mod=forum&fid=$_GET['fid']&order=best" class="get" box="vf_{$_GET['fid']}_best" btn="by_{$_GET['fid']}_best">推荐</a></li>
            <!--{loop $forum['threadtypes']['types'] $id $name}-->
            <li{if $_GET['typeid']==$id} class="c1 o_c1"{/if} id="by_{$_GET['fid']}_t{$id}"><a href="discuz.php?mod=forum&fid=$_GET['fid']&typeid=$id" class="get" box="vf_t{$_GET['fid']}_new{$id}" btn="by_{$_GET['fid']}_t{$id}">$name</a></li>
            <!--{/loop}-->
            <!--{loop $forum['threadsorts']['types'] $id $name}-->
            <li{if $_GET['sortid']==$id} class="c1 o_c1"{/if} id="by_{$_GET['fid']}_s{$id}"><a href="discuz.php?mod=forum&fid=$_GET['fid']&sortid=$id" class="get" box="vf_s{$_GET['fid']}_new{$id}" btn="by_{$_GET['fid']}_s{$id}">$name</a></li>
            <!--{/loop}-->
          </ul>
        </div>
      </div>
      <div id="otherarea">
        <!--{if $thissort}-->
        <!--{template discuz/sortsearch}-->
        <!--{/if}-->      
      </div>

      <!--{if $subs}-->
      <div class="b_c3 mb10">
        <div class="scrollx topic_fav b_c3 bob o_c3" style="margin-bottom:10px;">
          <div class="scrollx_area">
            <ul class="c">
              <!--{loop $subs $value}-->
              <li class="tc"><a href="discuz.php?mod=forum&fid=$value['fid']" class="load"><img src="$value['icon']">
                <h4 class="s17">$value['name']</h4>
                <p class="s13 c2">{$value['threads']}主题<em></em>{$value['posts']}帖子</p>
                </a>
              </li>
              <!--{/loop}-->
            </ul>
          </div>
        </div>
      </div>
      <!--{/if}-->
      <!--{if $tops}-->
      <ul class="toplist b_c3 o_c3{if count($tops)<4} mb10{/if}" {if count($tops)>3}style="height:122px;"{/if}>
        <!--{loop $tops $value}-->
        <li class="bob o_c3 ellipsis"><a href="discuz.php?mod=view&tid=$value['tid']" class="load"><span class="b_c8 c3">顶</span>$value['subject']</a></li>
        <!--{/loop}-->
      </ul>
      <!--{if count($tops)>3}--><a href="javascript:SMS.unfold('unfoldtoplist','.toplist',122)" class="icon icon-expanding bot o_c3 b_c2" id="unfoldtoplist"></a><!--{/if}-->
      <!--{/if}-->

      
      <div class="ready current themeslist pt10" id="vf_{$_GET['fid']}_new"><!--{template discuz/forum_ajax}--></div>
      <div class="themeslist pt10" id="vf_{$_GET['fid']}_hot" style="display:none"></div>
      <div class="themeslist pt10" id="vf_{$_GET['fid']}_best" style="display:none"></div>
      <!--{loop $forum['threadtypes']['types'] $id $name}-->
      <div class="themeslist pt10" id="vf_t{$_GET['fid']}_new{$id}" style="display:none"></div>
      <!--{/loop}-->
      <!--{loop $forum['threadsorts']['types'] $id $name}-->
      <div class="themeslist pt10" id="vf_s{$_GET['fid']}_new{$id}" style="display:none"></div>
      <!--{/loop}-->
      <div id="page">
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vf_{$_GET['fid']}_new"><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->   
      </div>      
    </div>
  </div>
  <div id="footer">
  <!--{if !$_S['setting']['closebbs']}-->
  <a href="discuz.php?mod=post&ac=addthread&fid=$_GET['fid']" class="icon icon-write addtopic b_c8 load" loading="tab"></a>
  <!--{/if}-->
  </div>
</div>
<div id="smsscript">
  <!--{template discuz/js}-->
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->