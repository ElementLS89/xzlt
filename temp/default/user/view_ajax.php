<?exit?>
<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
<div class="main">
  <div id="list">
<!--{/if}-->
<!--{if $list}-->
<!--{if $_S['dz'] && $user['dzuid'] && $_GET['show']!='sms'}-->
<!--{eval include temp('discuz/'.$themetemp,false)}-->
<!--{else}-->
<!--{loop $list $value}-->
<div id="theme_$value[vid]">
  <div class="b_c3 bob o_c3">
    <div class="theme-ui">
      <span class="r c2 s12">{date($value['dateline'],'Y-m-d H:i:s')}</span><a href="user.php?uid=$value['uid']" class="c8 load"><!--{avatar($value['user'],1)}-->{if $value['username']}$value['username']{else}$user['username']{/if}</a>
    </div>
    <div style="padding-left:42px">
      <!--{if $value['subject']}-->
      <h3 class="theme-sub"><a href="$value['url']" class="load">$value['subject']</a></h3>
      <!--{/if}-->
      <!--{if $value['video']}-->
      <a href="topic.php?vid=$value['vid']" class="load"><div class="theme-video video_hode"><img src="{$value['video']}?vframe/jpg/offset/{$_S['setting']['qiniu_frame']}" onerror="this.onerror=null;this.src='./ui/novideocover.png'"/><span class="icon icon-play"></span></div></a>
      <!--{else}-->
      <!--{if $value['picnum']==1}-->
      <!--{eval $pic=$value[images][0];}-->
      <div class="theme-img-one"><a href="topic.php?vid=$value['vid']" class="load"><img src="{eval getimg($pic,'640','320','true')}"></a></div>
      <!--{elseif $value['picnum']>1}-->
      <ul class="theme-img cl">
      <!--{loop $value[images] $pic}-->
      <li><div><a href="topic.php?vid=$value['vid']" class="load"><img src="{eval getimg($pic,'200','150','true')}"/></a></div></li>
      <!--{/loop}-->
      </ul>
      <!--{/if}-->
      <!--{/if}-->
    </div>
  </div>
</div>
<!--{/loop}-->
<!--{/if}-->



<!--{else}-->
<!--{if $_S['page']=='1'}-->
<div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂无内容</span></div>
<!--{/if}-->
<!--{/if}-->

<!--{if $_S['page']=='1' && $_GET['get']=='ajax'}-->
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#uv_{$uid}{$_GET['show']}"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
</div>
<!--{/if}-->