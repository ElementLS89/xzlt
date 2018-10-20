<?exit?>
<!--{loop $list $value}-->
<div id="theme_$value[vid]">
  <div class="b_c3 bob o_c3">
    <div class="theme-ui">
      <span class="r c2 s12">{date($value['dateline'],'Y-m-d H:i:s')}</span><a href="user.php?uid=$value['uid']" class="c8 load"><!--{avatar($value['user'],2)}-->$value['username']</a>
    </div>
    <div style="padding-left:42px">
      <!--{if $value['subject']}-->
      <h3 class="theme-sub"><a href="topic.php?vid=$value['vid']" class="load">$value['subject']</a></h3>
      <!--{/if}-->
      <!--{if $value['video']}-->
      <div class="theme-play"><a {if $_S['setting']['qiniu_play']}href="$value['video']" class="playvideo"{else}href="topic.php?vid=$value['vid']" class="load"{/if}><div class="theme-video video_hode"><img src="{$value['video']}?vframe/jpg/offset/{$_S['setting']['qiniu_frame']}" onerror="this.onerror=null;this.src='./ui/novideocover.png'"/><span class="icon icon-play"></span></div></a></div>
      
      <!--{else}-->
      <!--{if $value['pics']==1}-->
      <div class="theme-img-one"><a href="topic.php?vid=$value['vid']" class="load"><!--{eval piclist($value,640,320)}--></a></div>
      <!--{elseif $value['pics']>1}-->
      <a href="topic.php?vid=$value['vid']" class="load"><ul class="theme-img cl" id="pics_$value[vid]">
        <!--{eval piclist($value)}-->
      </ul></a>
      <!--{/if}-->
      <!--{/if}-->
      <p class="theme-foot s13">{if $value['lbs']}<span class="r b_c7 c8 ellipsis icon icon-lbs">$value['lbs']</span>{else}<a href="$value['topic_url']" class="c8 r load">$value['topic']</a>{/if}<span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replys']}</span><em class="c4"></em><span class="c4">点赞{$value['praise']}</span></p>  
    </div>
  </div>
</div>
<!--{/loop}-->