<?exit?>
<h1 class="article_title">{if $thread['displayorder']>0}<span class="b_c8 c3">置顶</span>{/if}{if $thread['digest']>0}<span class="b_c1 c3">推荐</span>{/if}<em id="subject_$thread['tid']">$thread['subject']</em></h1>
<div class="article_usre flexbox">
  <div class="flex">
    <!--{if $thread['author']}-->
    <a href="user.php?dzuid=$thread['authorid']" class="load"><!--{avatar($thread['authorid'],2,'img','dz')}--></a><h3><a href="user.php?dzuid=$thread['authorid']" class="c1 load">$thread['author']</a></h3>
    <!--{else}-->
    <!--{avatar('anonymous',2)}--><h3>匿名</h3>
    <!--{/if}-->
    <p class="c4 s12">{date($thread['dateline'],'Y-m-d H:i')}</p>
  </div>
  <div>
  <!--{if $canmanage}-->
  <a href="javascript:SMS.opensheet('#threadsheet_$thread[tid]')" class="r weui-btn weui-btn_mini weui-btn_default c2">管理</a>
  <!--{/if}-->
  </div>
</div>
<!--{if $sorts}-->
<div class="sort_opt s15">
  <!--{loop $sorts $sort}-->
  <!--{eval $option=$_S['cache']['discuz_typeoption'][$sort['optionid']]}-->
  <!--{if !in_array($option['type'],array('radio','select','image'))}-->
  <!--{if stripos('+'.$option['identifier'],"tel") || stripos('+'.$option['identifier'],"dianhua")}-->
  <!--{eval $tel='<a href="tel:'.$sort['value'].'" class="weui-btn weui-btn_mini weui-btn_primary mt10"><span class="icon icon-tel pr5"></span>拨打电话</a><br>';}-->
  <!--{else}-->
  <!--{eval $sortopt=true}-->
  <!--{if $sort['value']}-->
  <p><span class="c1">{$option['title']}</span>{if $option['type']=='checkbox'}{loop $sort['value'] $v}<em class="s15">$option['choices'][$v]</em>{/loop}{else}$sort['value']{$option['unit']}{/if}</p>
  <!--{/if}-->
  <!--{/if}-->
  <!--{elseif in_array($option['type'],array('radio','select'))}-->
  <!--{eval $sortlist=true}-->
  <!--{elseif $option['type']=='image'}-->
  <!--{eval $sortimage=true}-->
  <!--{/if}-->
  <!--{/loop}-->
</div>
<!--{if $sortlist}-->
<p class="sort_opt bob o_c3 pb5 cl{if $sortopt} bot mt10 pt10{/if}">
  <!--{eval $i=0}-->
  <!--{loop $sorts $sort}-->
  <!--{eval $option=$_S['cache']['discuz_typeoption'][$sort['optionid']]}-->
  <!--{if in_array($option['type'],array('radio','select'))}-->
  <span class="bo fc{$i}">$option['choices'][$sort['value']]</span>
  <!--{if $i==3}-->
  <!--{eval $i=0}-->
  <!--{else}-->
  <!--{eval $i++}-->
  <!--{/if}-->
  <!--{/if}-->
  <!--{/loop}-->
</p>
<!--{/if}-->
<!--{/if}-->
<div class="weui-article">
  $tel
  <!--{if $sortimage}-->
  <!--{loop $sorts $sort}-->
  <!--{eval $option=$_S['cache']['discuz_typeoption'][$sort['optionid']]}-->
  <!--{if $option['type']=='image'}-->
  <!--{eval $sortaids[]=$sort['value']['aid'];}-->
  <img src="{$_S['dz']['url']}/{$sort['value']['url']}" />
  <p class="tc s13 c2">{$option['title']}</p>
  <!--{/if}-->
  <!--{/loop}-->
  <!--{/if}-->
  <!--{eval $content=$thread['content']}-->
  <!--{eval $attachment=$atcs[$thread['content']['pid']]}-->
  
  <!--{template discuz/content}-->
  <!--{if $thread['tags']}-->
  <div class="tags icon icon-tag">
  <!--{loop $thread['tags'] $value}-->
  <a href="discuz.php?mod=tag&tagid=$value[0]" class="load c8">$value[1]</a>
  <!--{/loop}-->
  </div>
  <!--{/if}-->
</div>
<!--{if $thread['authorid'] && $_S['wxpay']}-->
<div class="reward">
  <a href="gratuity.php?mod=discuz&ac=gratuity&vid=$_GET['tid']" class="reward_btn b_c8 c3 load">打赏</a>
  <!--{if $gratuity['money']}-->
  <p id="gratuity_info_$_GET['tid']"><a href="gratuity.php?mod=discuz&vid=$_GET['tid']" class="load">有<span class="c1 number">$gratuity['number']</span>人给作者打赏了<span class="c1 money">$gratuity['money']</span>元</a></p>
  <!--{else}-->
  <p id="gratuity_text_$_GET['tid']">给作者打赏</p>
  <!--{/if}-->
  <!--{if $rewards}-->
  <ul>
    <!--{loop $rewards $i $value}-->
    <li class="u1"><a href="gratuity.php?mod=discuz&vid=$_GET['tid']" class="load"><!--{avatar($value,2)}--></a></li>
    <!--{/loop}-->
  </ul>
  <!--{/if}-->
</div>
<!--{/if}-->
<!--{if $theme['lbs']}--><p class="lbs"><span class="b_c7 c8 ellipsis icon icon-lbs s12">$theme['lbs']</span></p><!--{/if}-->