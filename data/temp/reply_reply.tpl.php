<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 c3 flexbox">
      <div class="header-l"><?php back('close')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>" nocache="true">
      <?php if(!$_GET['ac']) { ?>
      <div class="reply flexbox pt10 pb10 bob o_c3 b_c3">
        <div class="reply_user">
        <a href="user.php?uid=<?php echo $reply['uid'];?>" class="load"><?php echo head($reply,1);?></a>
        </div>
        <div class="reply_content flex" id="reply_<?php echo $reply['pid'];?>">
          <h3><a href="user.php?uid=<?php echo $reply['uid'];?>" class="c8 load"><?php echo $reply['username'];?></a></h3>
          <div class="weui-article">
          <?php echo $reply['content'];?>
          </div>
          <p class="pt10 s13"><span class="c4"><?php echo smsdate($reply['dateline'],'Y-m-d H:i:s');?></span></p>
        </div>
      </div>
      <div class="weui-cells__title pb10">全部评论</div>
      <div class="replys b_c3 bot o_c3" id="replylist">
        <?php if(is_array($list)) foreach($list as $value) { ?>        <?php include temp('reply/reply_ajax'); ?>        <?php } ?>
      </div> 
      
      <?php } else { ?>
      <form action="reply.php?mod=<?php echo $_GET['mod'];?>&ac=<?php echo $_GET['ac'];?>&s=<?php echo $_GET['s'];?>" method="post" id="<?php echo PHPSCRIPT;?>_<?php echo $_GET['mod'];?>_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
        <input name="pid" type="hidden" value="<?php echo $_GET['pid'];?>" />
        <input name="vid" type="hidden" value="<?php echo $_GET['vid'];?>" />

        <div class="weui-cells__title">评论内容</div>
        <div class="weui-cells weui-cells_form">
          
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea" name="content" placeholder="请输入.." rows="3" id="postmessage"><?php if($_GET['ac']=='ed') { ?><?php echo $reply['content'];?><?php } ?></textarea>
            </div>
          </div>
        </div>
        <div class="smiles b_c5">
          <ul class="cl">
            <?php if(is_array($_S['cache']['smiles']['1'])) foreach($_S['cache']['smiles']['1'] as $value) { ?>            <li><a href="javascript:SMS.smile('<?php echo $value['str'];?>')"><img src="<?php echo $value['pic'];?>" /></a></li>
            <?php } ?>
          </ul>
        </div>
        <div class="p10 bob o_c1 b_c2 bot cl">
          <span class="s14 c4">随机展示的小贴士</span>
          <button type="button" class="weui-btn weui-btn_mini weui-btn_primary r formpost">提交</button>
        </div>
      </form>      
      <?php } ?>

    </div>
  </div>
  <div id="footer">
    <?php if(!$_GET['ac']) { ?>
    <div class="footer b_c2 bot o_c1">
      <ul class="send flexbox">
        <li class="flex message pl15"><a href="reply.php?mod=<?php echo $_GET['mod'];?>&ac=rp&s=l&vid=<?php echo $_GET['vid'];?>&pid=<?php echo $reply['pid'];?>" class="bo o_c1 b_c3 c4 load" loading="tab">写评论...</a></li>
        <li class="btn" id="replypraise_<?php echo $reply['pid'];?>"><a href="reply.php?mod=<?php echo $_GET['mod'];?>&ac=praise&vid=<?php echo $_GET['vid'];?>&pid=<?php echo $reply['pid'];?>&po=b" class="icon icon-praise load" loading="tab"></a><?php if($reply['praise']) { ?><span class="weui-badge"><?php echo $reply['praise'];?></span><?php } ?></li>
      </ul>
    </div>
    <?php } ?>
  </div>
</div>
<div id="smsscript">
  <?php if($_GET['ac']) { ?>
  <script language="javascript" reload="1">
  $(document).ready(function() {
if($('.smiles').css('padding-left')=='0px'){
$('.smiles').css('padding-left', (((window.innerWidth-10)%46)/2)+'px');
}
$('body').scrollTop($("body").height());
});
  </script>
  <?php } ?>
  <?php include temp('wechat'); ?>  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>