<?exit?>
<!--{loop $list $value}-->
<div id="theme_$value[vid]">
  <div class="b_c3 bob o_c3">
    <div class="theme-ui">
      <!--{if PHPSCRIPT=='collection'}--><a href="collection.php?mod=topic&ac=delete&cid=$value['cid']" class="r icon icon-close c2 load" loading="tab"></a><!--{else}--><span class="r c2 s12">{date($value['dateline'],'Y-m-d H:i:s')}</span><!--{/if}--><a href="user.php?uid=$value['uid']" class="c8 load"><!--{avatar($value['user'],2)}-->$value['username']</a>
    </div>
    <!--{if $value['video']}-->
    <!--{if $value['subject']}-->
    <h3 class="theme-sub"><a href="topic.php?vid=$value['vid']" class="load">$value['subject']</a></h3>
    <!--{/if}-->
    <div class="theme-play"><a {if $_S['setting']['qiniu_play']}href="$value['video']" class="playvideo"{else}href="topic.php?vid=$value['vid']" class="load"{/if}><div class="theme-video video_hode"><img src="{$value['video']}?vframe/jpg/offset/{$_S['setting']['qiniu_frame']}" onerror="this.onerror=null;this.src='./ui/novideocover.png'"/><span class="icon icon-play"></span></div></a></div>
    <!--{else}-->
    <!--{if $value['pics']==1}-->
    <div class="theme-content cl">
      <a href="topic.php?vid=$value['vid']" class="load block"><!--{eval piclist($value)}--><h3 class="theme-sub">$value['subject']</h3></a>
    </div>
    <!--{else}-->
    <h3 class="theme-sub"><a href="topic.php?vid=$value['vid']" class="load">$value['subject']</a></h3>
    <!--{if $value['pics']>1}-->
    <a href="topic.php?vid=$value['vid']" class="load"><ul class="theme-img cl" id="pics_$value[vid]">
      <!--{eval piclist($value)}-->
    </ul></a>
    <!--{/if}-->  
    <!--{/if}-->
    <!--{/if}-->
    <p class="theme-foot s13">{if $value['lbs']}<span class="r b_c7 c8 ellipsis icon icon-lbs">$value['lbs']</span>{else}<a href="$value['topic_url']" class="c8 r load">$value['topic']</a>{/if}<span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replys']}</span><em class="c4"></em><span class="c4">点赞{$value['praise']}</span></p>
  </div>
</div>
<!--{/loop}-->