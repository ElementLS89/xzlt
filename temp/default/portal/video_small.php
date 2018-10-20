<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <ul class="portal_video portal_video_small cl">
    <!--{loop $modvar['list'] $value}-->
    <!--{eval $cover=$value['video'].'?vframe/jpg/offset/'.$_S['setting']['qiniu_frame'];}-->
    <li>
      <div><a href="topic.php?vid=$value['vid']" class="load img c3"><img src="{eval getwebpic($cover,260,140,'qiniu')}" onerror="this.onerror=null;this.src='./ui/novideocover.png'"><span class="icon icon-play"></span><em>播放$value['views']次</em></a>
      <h4 class="s17"><a href="topic.php?vid=$value['vid']" class="load sub">$value['subject']</a></h4></div>
    </li>
    <!--{/loop}-->
  </ul>
<!--{if $modvar['name']}-->
</div>
<!--{/if}-->