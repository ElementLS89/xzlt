<?php if(is_array($list)) foreach($list as $value) { ?><div id="theme_<?php echo $value['vid'];?>">
  <div class="b_c3 bob o_c4 pt10">
    <?php if($value['video']) { ?>
    <h3 class="theme-sub"><a href="topic.php?vid=<?php echo $value['vid'];?>" class="load"><?php echo $value['subject'];?></a></h3>
    <div class="theme-play"><a <?php if($_S['setting']['qiniu_play']) { ?>href="<?php echo $value['video'];?>" class="playvideo"<?php } else { ?>href="topic.php?vid=<?php echo $value['vid'];?>" class="load"<?php } ?>><div class="theme-video video_hode"><img src="<?php echo $value['video'];?>?vframe/jpg/offset/<?php echo $_S['setting']['qiniu_frame'];?>" onerror="this.onerror=null;this.src='./ui/novideocover.png'" /><span class="icon icon-play"></span></div></a></div>
    
    <?php } else { ?>
    <div class="theme-content cl">
      <a href="topic.php?vid=<?php echo $value['vid'];?>" class="load block"><?php piclist($value,200,150,1)?><h3 class="theme-sub"><?php echo $value['subject'];?></h3></a>
    </div>    
    <?php } ?>

  
    <p class="theme-foot s13"><?php if($value['lbs']) { ?><span class="r b_c7 c8 ellipsis icon icon-lbs"><?php echo $value['lbs'];?></span><?php } else { ?><a href="<?php echo $value['topic_url'];?>" class="c8 r load"><?php echo $value['topic'];?></a><?php } ?><span class="c4">阅读<?php echo $value['views'];?></span><em class="c4"></em><span class="c4">评论<?php echo $value['replys'];?></span></p>
  </div>
</div>
<?php } ?>