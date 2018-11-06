<?php if(is_array($list)) foreach($list as $value) { ?><div id="theme_<?php echo $value['vid'];?>">
  <div class="b_c3 mt10 bob o_c3">
    <?php if($value['video']) { ?>
    <div class="theme-play"><a <?php if($_S['setting']['qiniu_play']) { ?>href="<?php echo $value['video'];?>" class="playvideo"<?php } else { ?>href="topic.php?vid=<?php echo $value['vid'];?>" class="load"<?php } ?>><div class="theme-video theme-bigvideo video_hode"><img src="<?php echo $value['video'];?>?vframe/jpg/offset/<?php echo $_S['setting']['qiniu_frame'];?>" onerror="this.onerror=null;this.src='./ui/novideocover.png'" /><span class="icon icon-play"></span></div></a></div>
    <?php } else { ?>
    <div class="theme-img-big"><a href="topic.php?vid=<?php echo $value['vid'];?>" class="load"><?php piclist($value,640,320,1)?></a></div>
    <?php } ?>
    <?php if($value['subject']) { ?>
    <h3 class="theme-sub"><a href="topic.php?vid=<?php echo $value['vid'];?>" class="load"><?php echo $value['subject'];?></a></h3>
    <?php } ?>
    <div class="theme-foot">
      <div class="r s13"><span class="c4">阅读<?php echo $value['views'];?></span><em class="c4"></em><span class="c4">评论<?php echo $value['replys'];?></span><em class="c4"></em><span class="c4">点赞<?php echo $value['praise'];?></span></div>
      <a href="user.php?uid=<?php echo $value['uid'];?>" class="c8 load"><?php echo head($value['user'],2);?><?php echo $value['username'];?></a>
    
    </div>  
  </div>
</div>
<?php } ?>