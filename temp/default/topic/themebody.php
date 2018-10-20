<?exit?>
<h1 class="article_title">{if $theme['top']>0}<span class="b_c8 c3">置顶</span>{/if}{if $theme['best']}<span class="b_c1 c3">推荐</span>{/if}<em id="subject_$theme['vid']">$theme['subject']</em></h1>
<div class="article_usre flexbox">
  <div class="flex">
  <!--{if $theme['uid']}-->
  <a href="user.php?uid=$theme['uid']" class="load"><!--{avatar($theme['user'],2)}--></a><h3><a href="user.php?uid=$theme['uid']" class="c1 load">$theme['username']</a></h3>
  <!--{/if}-->
  <p class="c4 s12">{date($theme['dateline'],'Y-m-d H:i')}</p>
  </div>
  <div>
  <!--{if $canmanage || $theme['uid']==$_S['uid']}-->
  <a href="javascript:SMS.opensheet('#themesheet_$theme[vid]')" class="r weui-btn weui-btn_mini weui-btn_default c2">管理</a>
  <!--{else}-->
    <!--{if $theme['uid']}-->
      <!--{if $theme['fuid']}-->
      <span class="r weui-btn weui-btn_mini weui-btn_default c2">已关注</span>
      <!--{else}-->
      <a href="user.php?mod=action&action=follow&uid=$theme[uid]" id="follow_$theme[uid]" class="r weui-btn weui-btn_mini weui-btn_warn load" loading="tab">关注</a>
      <!--{/if}-->
    <!--{/if}-->
  <!--{/if}-->  
  </div>
</div>

<div class="weui-article">
  <!--{if $theme['top']<0}-->
   <p class="notice">当前帖子还在审核中</p>
  <!--{/if}-->
  <!--{if $needpay}-->
  <div class="abstract p10 b_c5">$theme['abstract']</div>
  <form action="topic.php?mod=action&ac=pay" method="post" id="pay_form">
    <input name="submit" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <input id="paytype" type="hidden" value="wxpay" />
    <input id="idtype" type="hidden" value="vid" />
    <input id="payid" type="hidden" value="$_GET['vid']" />
    <input name="vid" type="hidden" value="$_GET[vid]" />
        
    <div class="needpay tc">
      <h2><span class="icon icon-mark c2"></span></h2>
      <h3 class="c4 s17">付费阅读</h3>
      <p class="c4 s15">作者设置了阅读本帖子需要支付{$theme['price']}元</p>
      <p class="paybtn">$paybtn</p>
    
    </div>
  </form>
  <!--{else}-->
  $theme['content']
  <!--{eval $i=0}-->
  <div class="swiper">
    <!--{loop $theme['images'] $img}-->
    <!--{if PHPSCRIPT=='get'}-->
    <p><img src="$_S['atc']/$img['atc']" class="viewpic" thumb="_thumb" swiper="$i"></p>
    <!--{else}-->
    <p><img src="ui/sl.png" data-original="$_S['atc']/$img['atc']" class="viewpic lazyload" thumb="_thumb" swiper="$i" scaling="$img['scaling']"></p>
    <!--{/if}-->
    <!--{eval $i++}-->
    <!--{/loop}-->
  </div>
  <!--{/if}-->
</div>
<!--{if $theme['uid'] && !$theme['price'] && $_S['wxpay']}-->
<div class="reward">
  <a href="gratuity.php?mod=topic&ac=gratuity&vid=$_GET['vid']" class="reward_btn b_c8 c3 load">打赏</a>
  <!--{if $theme['gratuity_money']}-->
  <p id="gratuity_info_$_GET['vid']"><a href="gratuity.php?mod=topic&vid=$_GET['vid']" class="load">有<span class="c1 number">$theme['gratuity_number']</span>人给作者打赏了<span class="c1 money">$theme['gratuity_money']</span>元</a></p>
  <!--{else}-->
  <p id="gratuity_text_$_GET['vid']">给作者打赏</p>
  <!--{/if}-->
  <!--{if $rewards}-->
  <ul>
    <!--{loop $rewards $i $value}-->
    <li class="u1"><a href="gratuity.php?mod=topic&vid=$_GET['vid']" class="load"><!--{avatar($value,1)}--></a></li>
    <!--{/loop}-->
  </ul>
  <!--{/if}-->
</div>
<!--{/if}-->
<!--{if $theme['lbs']}--><p class="lbs"><span class="b_c7 c8 ellipsis icon icon-lbs s12">$theme['lbs']</span></p><!--{/if}-->
