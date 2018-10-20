<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('back')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><?php if($_S['uid']) { ?><a href="javascript:SMS.opensheet('#themesheet_<?php echo $theme['vid'];?>')" class="icon icon-more"></a><?php } else { ?><a href="javascript:SMS.openside()" class="icon icon-openside"></a><?php } ?></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>">
      <div class="p15 b_c3 bob o_c3 themecontent">
        <?php include temp('topic/themebody')?>      </div>
      <?php if($theme['praise']) { ?>
      <div class="praise bob o_c3 p10 b_c3 flexbox">
        <div class="flex s12 c2">
          <ul class="cl">
            <?php if(is_array($praise)) foreach($praise as $value) { ?>            <li><a href="topic.php?mod=praise&&type=topic&id=<?php echo $_GET['vid'];?>" class="load"><?php echo head($value,1);?></a></li>
            <?php } ?>
          </ul><a href="topic.php?mod=praise&&type=topic&id=<?php echo $_GET['vid'];?>" class="load"><?php echo $theme['praise'];?>人点赞<span class="icon icon-forward"></span></a>
        </div>
        <span class="icon icon-praise c4"><?php echo $theme['praise'];?></span>
      </div>
      <?php } ?>
      <div class="weui-cells__title pb10"><?php if($topic['name']) { ?><a href="topic.php?tid=<?php echo $topic['tid'];?>" class="r c1 load">#<?php echo $topic['name'];?></a><?php } ?>评论<span class="pr5" id="replyscount_<?php echo $_GET['vid'];?>"><?php echo $theme['replys'];?></span>阅读<?php echo $theme['views'];?></div>
      <div class="replys b_c3 bot o_c3" id="replylist">
        <?php include temp('topic/viewtheme_ajax'); ?>      </div>
      <?php if($maxpage>1) { ?>
      <div id="page">
      <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" area="#replylist" total="<?php echo $maxpage;?>"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <?php } ?>
      <?php include temp('shar'); ?>      <div class="weui-actionsheet" id="themesheet_<?php echo $theme['vid'];?>">
        <div class="weui-actionsheet__menu">
          <?php if($canmanage || $_S['uid']==$theme['uid']) { ?>
          <a href="topic.php?mod=post&vid=<?php echo $_GET['vid'];?>" class="weui-actionsheet__cell c6 load">编辑</a>
          <a href="topic.php?mod=action&ac=delete&vid=<?php echo $_GET['vid'];?>" class="weui-actionsheet__cell c6 load" loading="tab">删除</a>
          <?php } ?>
          <?php if($canmanage) { ?>
          <a href="topic.php?mod=action&ac=settop&vid=<?php echo $_GET['vid'];?>" class="weui-actionsheet__cell c6 load" id="settop_<?php echo $_GET['vid'];?>" loading="tab"><?php if($theme['top']) { ?>取消置顶<?php } else { ?>置顶<?php } ?></a>
          <a href="topic.php?mod=action&ac=setbest&vid=<?php echo $_GET['vid'];?>" class="weui-actionsheet__cell c6 load" id="setbest_<?php echo $_GET['vid'];?>" loading="tab"><?php if($theme['best']) { ?>取消推荐<?php } else { ?>推荐<?php } ?></a>
          <?php } ?>
          <?php if($_S['uid']) { ?>
          <a href="index.php?mod=feed&type=3&ref=topic.php?vid=<?php echo $_GET['vid'];?>" class="weui-actionsheet__cell c6 load">举报</a>
          <?php } ?>
        </div>
        <div class="weui-actionsheet__action">
          <a href="javascript:" class="weui-actionsheet__cell c1">取消</a>
        </div>
      </div>
    </div>
  </div>
  <div id="footer">
    <div class="footer b_c2 bot o_c1">
      <ul class="send flexbox">
        <li class="btn"><a href="index.php" class="icon icon-home load"></a></li>
        <li class="flex message"><a href="reply.php?mod=topic&ac=rt&s=l&vid=<?php echo $_GET['vid'];?>" class="bo o_c1 b_c3 c4 load" loading="tab">写评论...</a></li>
        <li class="btn" id="themepraise_<?php echo $_GET['vid'];?>"><a href="topic.php?mod=action&ac=praise&vid=<?php echo $_GET['vid'];?>" class="icon icon-praise load" loading="tab"></a><?php if($theme['praise']) { ?><span class="weui-badge"><?php echo $theme['praise'];?></span><?php } ?></li>
        <li class="btn"><a href="collection.php?mod=topic&vid=<?php echo $_GET['vid'];?>" class="icon icon-collection load" id="collectionbtn_<?php echo $_GET['vid'];?>" loading="tab"></a></li>
        <li class="btn"><a href="javascript:share();" class="icon icon-shar"></a></li>
      </ul>
    </div>
  </div>
</div>
<div id="smsscript">
  <?php if($_S['bro']=='qqbro' || $_S['bro']=='ucbro') { ?>
  <script language="javascript" reload="1" >
var share_config = {
url:window.location.href.split('#')[0],
title:'<?php echo $title;?>',
desc:'<?php echo $_S['shar']['desc'];?>',
img:'<?php echo $_S['shar']['pic'];?>',
from:'<?php echo $_S['setting']['sitename'];?>'
};
var ShareObj = new smsshare(share_config);
</script>
  <?php } ?>
  <?php include temp('wechat'); ?>  <?php include temp('wechat_shar'); ?>  <?php if($needpay) { ?>
  <?php include temp('wechat_pay'); ?>  <?php } ?>
</div><?php include temp('footer'); ?>