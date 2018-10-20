<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <ul class="portal_news_topic">
    <!--{eval $i=1}-->
    <!--{loop $modvar['list'] $value}-->
    <li class="flexbox ">
      <em class="num c2">0{$i}</em>
      <div class="flex {if $i!=1} bot o_c3{/if}">
        <p class="sub s17"><a href="$value['url']" class="load" >$value['subject']</a></p>
        <p class="info cl s13"><span class="r c2">{date($value['dateline'],'Y-m-d')}</span><!--{if $paramarr['form']=='discuz'}--><a href="discuz.php?mod=forum&fid=$value['fid']" class="bo o_c2 c1">$_S['cache']['discuz_forum'][$value['fid']]['name']</a><!--{elseif $value['topic']}--><a href="$value['topic_url']" class="bo o_c2 c1">$value['topic']</a><!--{/if}--></p>
      </div>
      <em class="icon icon-qt c2"></em>
    </li>
    <!--{eval $i++}-->
    <!--{/loop}-->
  </ul>
</div>