
<?php if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
<div class="main">
  <div id="list">
<?php } if($list) { if($_S['dz'] && $user['dzuid'] && $_GET['show']!='sms') { include temp('discuz/'.$themetemp,false)?><?php } else { if(is_array($list)) foreach($list as $value) { ?><div id="theme_<?php echo $value['vid'];?>">
  <div class="b_c3 bob o_c3">
    <div class="theme-ui">
      <span class="r c2 s12"><?php echo smsdate($value['dateline'],'Y-m-d H:i:s');?></span><a href="user.php?uid=<?php echo $value['uid'];?>" class="c8 load"><?php echo head($value['user'],1);?><?php if($value['username']) { ?><?php echo $value['username'];?><?php } else { ?><?php echo $user['username'];?><?php } ?></a>
    </div>
    <div style="padding-left:42px">
      <?php if($value['subject']) { ?>
      <h3 class="theme-sub"><a href="<?php echo $value['url'];?>" class="load"><?php echo $value['subject'];?></a></h3>
      <?php } ?>
      <?php if($value['video']) { ?>
      <a href="topic.php?vid=<?php echo $value['vid'];?>" class="load"><div class="theme-video video_hode"><img src="<?php echo $value['video'];?>?vframe/jpg/offset/<?php echo $_S['setting']['qiniu_frame'];?>" onerror="this.onerror=null;this.src='./ui/novideocover.png'"/><span class="icon icon-play"></span></div></a>
      <?php } else { ?>
      <?php if($value['picnum']==1) { ?>
      <?php $pic=$value[images][0];?>      <div class="theme-img-one"><a href="topic.php?vid=<?php echo $value['vid'];?>" class="load"><img src="<?php getimg($pic,'640','320','true')?>"></a></div>
      <?php } elseif($value['picnum']>1) { ?>
      <ul class="theme-img cl">
      <?php if(is_array($value['images'])) foreach($value['images'] as $pic) { ?>      <li><div><a href="topic.php?vid=<?php echo $value['vid'];?>" class="load"><img src="<?php getimg($pic,'200','150','true')?>"/></a></div></li>
      <?php } ?>
      </ul>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>
<?php } } } else { if($_S['page']=='1') { ?>
<div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂无内容</span></div>
<?php } } if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#uv_<?php echo $uid;?><?php echo $_GET['show'];?>"><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
  </div>
</div>
<?php } ?>