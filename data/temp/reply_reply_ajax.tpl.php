
<?php if($_GET['s']=='c') { ?>
<?php echo $value['content'];?>
<?php } else { if($value['s']=='n') { ?>
<p id="comment_<?php echo $value['pid'];?>"><a href="user.php?uid=<?php echo $value['uid'];?>" class="c8 load"><?php echo $value['username'];?></a><em>:</em><?php echo $value['content'];?></p>
<?php } else { ?>

<div class="reply flexbox pt10 pb10 bob o_c4" id="reply_<?php echo $value['pid'];?>">
  <div class="reply_user">
  <a href="user.php?uid=<?php echo $value['uid'];?>" class="load"><?php echo head($value['user'],1);?></a>
  </div>
  <div class="reply_content flex">
    <h3><a href="reply.php?mod=<?php echo $value['mod'];?>&ac=praise&vid=<?php echo $_GET['vid'];?>&pid=<?php echo $value['pid'];?>" class="icon icon-praise r load" loading="tab"><?php if($value['praise']) { ?><span class="s13 pl5">+<?php echo $value['praise'];?></span><?php } ?></a><a href="user.php?uid=<?php echo $value['uid'];?>" class="c8 load"><?php echo $value['username'];?></a><?php if($value['top']) { ?><span class="b_c8 c3">置顶</span><?php } if($value['best']) { ?><span class="b_c1 c3">推荐</span><?php } ?></h3>
    <a href="reply.php?mod=<?php echo $value['mod'];?>&vid=<?php echo $_GET['vid'];?>&pid=<?php echo $value['pid'];?>" class="weui-article load block" id="replycontent_<?php echo $value['pid'];?>">
    <?php echo $value['content'];?>
    </a>
    <p class="pt10 s13"><?php if($canmanage || $value['uid']==$_S['uid']) { ?><a href="javascript:smsot.replymanage('<?php echo $value['vid'];?>','<?php echo $value['pid'];?>','<?php echo $value['top'];?>','<?php echo $value['best'];?>','<?php echo $value['mod'];?>')" class="r c8" id="manage_<?php echo $value['pid'];?>">管理</a><?php } else { ?><a href="index.php?mod=feed&type=3&ref=reply.php?vid=<?php echo $theme['vid'];?>&pid=<?php echo $value['pid'];?>" class="r c8 load">举报</a><?php } ?><span class="c4"><?php echo smsdate($value['dateline'],'m-d H:i:s');?></span><a href="reply.php?mod=<?php echo $value['mod'];?>&ac=rp&s=n&vid=<?php echo $_GET['vid'];?>&pid=<?php echo $value['pid'];?>" class="b_c2 load" loading="tab"><span id="commentscount_<?php echo $value['pid'];?>"><?php echo $value['replys'];?></span>回复</a></p>
    <?php if($replys[$value['pid']]) { ?>
    <div class="comments b_c7 mt10 s13" id="comments_<?php echo $value['pid'];?>">
      <?php if(is_array($replys[$value['pid']])) foreach($replys[$value['pid']] as $comment) { ?>      <p id="comment_<?php echo $comment['pid'];?>"><a href="user.php?uid=<?php echo $comment['uid'];?>" class="c8 load"><?php echo $comment['username'];?></a><em>:</em><?php echo $comment['content'];?></p>
      <?php } ?>
      <?php if($value['replys']>count($replys[$value['pid']])) { ?>
      <p><a href="reply.php?mod=<?php echo $value['mod'];?>&vid=<?php echo $_GET['vid'];?>&pid=<?php echo $value['pid'];?>" class="load c8">查看全部<?php echo $value['replys'];?>条评论&gt;</a></p>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>
<?php } } ?>
