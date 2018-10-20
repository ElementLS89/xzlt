
<h1 class="article_title"><?php if($theme['top']>0) { ?><span class="b_c8 c3">置顶</span><?php } if($theme['best']) { ?><span class="b_c1 c3">推荐</span><?php } ?><em id="subject_<?php echo $theme['vid'];?>"><?php echo $theme['subject'];?></em></h1>
<div class="article_usre flexbox">
  <div class="flex">
  <?php if($theme['uid']) { ?>
  <a href="user.php?uid=<?php echo $theme['uid'];?>" class="load"><?php echo head($theme['user'],2);?></a><h3><a href="user.php?uid=<?php echo $theme['uid'];?>" class="c1 load"><?php echo $theme['username'];?></a></h3>
  <?php } ?>
  <p class="c4 s12"><?php echo smsdate($theme['dateline'],'Y-m-d H:i');?></p>
  </div>
  <div>
  <?php if($canmanage || $theme['uid']==$_S['uid']) { ?>
  <a href="javascript:SMS.opensheet('#themesheet_<?php echo $theme['vid'];?>')" class="r weui-btn weui-btn_mini weui-btn_default c2">管理</a>
  <?php } else { ?>
    <?php if($theme['uid']) { ?>
      <?php if($theme['fuid']) { ?>
      <span class="r weui-btn weui-btn_mini weui-btn_default c2">已关注</span>
      <?php } else { ?>
      <a href="user.php?mod=action&action=follow&uid=<?php echo $theme['uid'];?>" id="follow_<?php echo $theme['uid'];?>" class="r weui-btn weui-btn_mini weui-btn_warn load" loading="tab">关注</a>
      <?php } ?>
    <?php } ?>
  <?php } ?>  
  </div>
</div>

<div class="weui-article">
  <?php if($theme['top']<0) { ?>
   <p class="notice">当前帖子还在审核中</p>
  <?php } ?>
  <?php if($needpay) { ?>
  <div class="abstract p10 b_c5"><?php echo $theme['abstract'];?></div>
  <form action="topic.php?mod=action&ac=pay" method="post" id="pay_form">
    <input name="submit" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <input id="paytype" type="hidden" value="wxpay" />
    <input id="idtype" type="hidden" value="vid" />
    <input id="payid" type="hidden" value="<?php echo $_GET['vid'];?>" />
    <input name="vid" type="hidden" value="<?php echo $_GET['vid'];?>" />
        
    <div class="needpay tc">
      <h2><span class="icon icon-mark c2"></span></h2>
      <h3 class="c4 s17">付费阅读</h3>
      <p class="c4 s15">作者设置了阅读本帖子需要支付<?php echo $theme['price'];?>元</p>
      <p class="paybtn"><?php echo $paybtn;?></p>
    
    </div>
  </form>
  <?php } else { ?>
  <?php echo $theme['content'];?>
  <?php $i=0?>  <div class="swiper">
    <?php if(is_array($theme['images'])) foreach($theme['images'] as $img) { ?>    <?php if(PHPSCRIPT=='get') { ?>
    <p><img src="<?php echo $_S['atc'];?>/<?php echo $img['atc'];?>" class="viewpic" thumb="_thumb" swiper="<?php echo $i;?>"></p>
    <?php } else { ?>
    <p><img src="ui/sl.png" data-original="<?php echo $_S['atc'];?>/<?php echo $img['atc'];?>" class="viewpic lazyload" thumb="_thumb" swiper="<?php echo $i;?>" scaling="<?php echo $img['scaling'];?>"></p>
    <?php } ?>
    <?php $i++?>    <?php } ?>
  </div>
  <?php } ?>
</div>
<?php if($theme['uid'] && !$theme['price'] && $_S['wxpay']) { ?>
<div class="reward">
  <a href="gratuity.php?mod=topic&ac=gratuity&vid=<?php echo $_GET['vid'];?>" class="reward_btn b_c8 c3 load">打赏</a>
  <?php if($theme['gratuity_money']) { ?>
  <p id="gratuity_info_<?php echo $_GET['vid'];?>"><a href="gratuity.php?mod=topic&vid=<?php echo $_GET['vid'];?>" class="load">有<span class="c1 number"><?php echo $theme['gratuity_number'];?></span>人给作者打赏了<span class="c1 money"><?php echo $theme['gratuity_money'];?></span>元</a></p>
  <?php } else { ?>
  <p id="gratuity_text_<?php echo $_GET['vid'];?>">给作者打赏</p>
  <?php } ?>
  <?php if($rewards) { ?>
  <ul>
    <?php if(is_array($rewards)) foreach($rewards as $i => $value) { ?>    <li class="u1"><a href="gratuity.php?mod=topic&vid=<?php echo $_GET['vid'];?>" class="load"><?php echo head($value,1);?></a></li>
    <?php } ?>
  </ul>
  <?php } ?>
</div>
<?php } if($theme['lbs']) { ?><p class="lbs"><span class="b_c7 c8 ellipsis icon icon-lbs s12"><?php echo $theme['lbs'];?></span></p><?php } ?>
