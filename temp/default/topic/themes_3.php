<?exit?>
<!--{loop $list $value}-->
<div id="theme_$value[vid]">
  <div class="b_c3 mt10 bob o_c3">
    <!--{if $value['video']}-->
    <div class="theme-play"><a {if $_S['setting']['qiniu_play']}href="$value['video']" class="playvideo"{else}href="topic.php?vid=$value['vid']" class="load"{/if}><div class="theme-video theme-bigvideo video_hode"><img src="{$value['video']}?vframe/jpg/offset/{$_S['setting']['qiniu_frame']}" onerror="this.onerror=null;this.src='./ui/novideocover.png'" /><span class="icon icon-play"></span></div></a></div>
    <!--{else}-->
    <div class="theme-img-big"><a href="topic.php?vid=$value['vid']" class="load"><!--{eval piclist($value,640,320,1)}--></a></div>
    <!--{/if}-->
    <!--{if $value['subject']}-->
    <h3 class="theme-sub"><a href="topic.php?vid=$value['vid']" class="load">$value['subject']</a></h3>
    <!--{/if}-->
    <div class="theme-foot">
      <div class="r s13"><span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replys']}</span><em class="c4"></em><span class="c4">点赞{$value['praise']}</span></div>
      <a href="user.php?uid=$value['uid']" class="c8 load"><!--{avatar($value['user'],2)}-->$value['username']</a>
    
    </div>  
  </div>
</div>
<!--{/loop}-->