<?exit?>
<div id="view">
 
    <div class="smsbody body_b $outback">
	  <div class="find-items b_c3">
        <ul class="cl c6">
          <!--{loop $_S['cache']['navs']['nav_find'] $value}-->
          <!--{if $_S['setting']['closebbs'] && in_array($value['url'],array('topic.php','topic.php?mod=forum','topic.php?mod=post','discuz.php'))}-->
          <!--{eval $value['close']=true;}-->
          <!--{/if}-->
          <!--{if $value['best'] && $value['canuse'] && !$value['close']}-->
          <li><a href="$value['url']" {if $value['url']}class="load"{/if}><img src="$value[icon]" /><p{if !$value['url']} class="c4"{/if}>$value[name]</p></a></li>
          <!--{/if}-->
          <!--{/loop}-->
        </ul>
      </div>
    </div>

</div>

<!--{loop $list $value}-->
<div id="theme_$value[vid]">
  <div class="b_c3 bob o_c4 pt10">
    <!--{if $value['video']}-->
    <h3 class="theme-sub"><a href="topic.php?vid=$value['vid']" class="load">$value['subject']</a></h3>
    <div class="theme-play"><a {if $_S['setting']['qiniu_play']}href="$value['video']" class="playvideo"{else}href="topic.php?vid=$value['vid']" class="load"{/if}><div class="theme-video video_hode"><img src="{$value['video']}?vframe/jpg/offset/{$_S['setting']['qiniu_frame']}" onerror="this.onerror=null;this.src='./ui/novideocover.png'" /><span class="icon icon-play"></span></div></a></div>
    
    <!--{else}-->
    <!--{if $value['pics']==1}-->
    <div class="theme-content cl">
      <a href="topic.php?vid=$value['vid']" class="load block"><!--{eval piclist($value)}--><h3 class="theme-sub">$value['subject']</h3></a>
    </div>
    <!--{else}-->
    <a href="topic.php?vid=$value['vid']" class="load"><h3 class="theme-sub">$value['subject']</h3>
    <!--{if $value['pics']>1}-->
    <ul class="theme-img cl" id="pics_$value[vid]">
      <!--{eval piclist($value,200,150,3)}-->
    </ul></a>
    <!--{/if}-->  
    <!--{/if}-->
    <!--{/if}-->
  </div>
</div>
<!--{/loop}-->