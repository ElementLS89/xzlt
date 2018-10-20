<?exit?>
<!--{loop $list $value}-->
<div id="theme_$value[vid]">
  <div class="b_c3 bob o_c4 pt10">
    <!--{if $value['video']}-->
    <h3 class="theme-sub"><a href="topic.php?vid=$value['vid']" class="load">$value['subject']</a></h3>
    <div class="theme-play"><a {if $_S['setting']['qiniu_play']}href="$value['video']" class="playvideo"{else}href="topic.php?vid=$value['vid']" class="load"{/if}><div class="theme-video video_hode"><img src="{$value['video']}?vframe/jpg/offset/{$_S['setting']['qiniu_frame']}" onerror="this.onerror=null;this.src='./ui/novideocover.png'" /><span class="icon icon-play"></span></div></a></div>
    
    <!--{else}-->
    <div class="theme-content cl">
      <a href="topic.php?vid=$value['vid']" class="load block"><!--{eval piclist($value,200,150,1)}--><h3 class="theme-sub">$value['subject']</h3></a>
    </div>    
    <!--{/if}-->

  
    <p class="theme-foot s13">{if $value['lbs']}<span class="r b_c7 c8 ellipsis icon icon-lbs">$value['lbs']</span>{else}<a href="$value['topic_url']" class="c8 r load">$value['topic']</a>{/if}<span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replys']}</span></p>
  </div>
</div>
<!--{/loop}-->