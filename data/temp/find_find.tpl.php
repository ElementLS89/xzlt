<?php include temp('header'); ?><div id="view">
  <div id="header">
  </div>
  <div id="main">
    <div class="smsbody body_b <?php echo $outback;?>">
      <div class="b_c1 c3">
        <div class="cl find_top">
          <strong><?php echo smsdate($_S['timestamp'],'d');?></strong>
          <h4>星期<?php echo smsdate($_S['timestamp'],'w');?></h4>
          <p><?php echo smsdate($_S['timestamp'],'Y年m月');?></p>        
        </div>
        <div class="find_search">
          <form action="search.php" method="get" class="flexbox" id="search-topic" onsubmit="getform(this.id);return false">
            <input type="hidden" name="mod" value="topic" />
            <input type="search" class="weui-input" class="flex" id="searchInput" name="k" placeholder="请输入搜索的关键字" required>
            <a href="javascript:getform('search-topic');" class="icon icon-search"></a>
          </form>
        </div>
      </div>
      <div class="find-items b_c3">
        <ul class="cl c6">
          <?php if(is_array($_S['cache']['navs']['nav_find'])) foreach($_S['cache']['navs']['nav_find'] as $value) { ?>          <?php if($_S['setting']['closebbs'] && in_array($value['url'],array('topic.php','topic.php?mod=forum','topic.php?mod=post','discuz.php'))) { ?>
          <?php $value['close']=true;?>          <?php } ?>
          <?php if($value['best'] && $value['canuse'] && !$value['close']) { ?>
          <li><a href="<?php echo $value['url'];?>" <?php if($value['url']) { ?>class="load"<?php } ?>><img src="<?php echo $value['icon'];?>" /><p<?php if(!$value['url']) { ?> class="c4"<?php } ?>><?php echo $value['name'];?></p></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
      
      </div>
      
    </div>
  </div>
  <div id="footer">
    <a href="javascript:" class="closepage b_c3 bot o_c3 icon icon-close c1"></a>
  </div>
</div>
<div id="smsscript">
<script language="javascript" reload="1">
  setTimeout(function(){
contentheight=$(window).height()-$(".currentbody .b_c1").height()-51;
$('.currentbody .find-items').css('height', contentheight+'px');			
})

  </script>
  <?php include temp('wechat_shar'); ?>  <?php include temp('wechat_lbs'); ?></div><?php include temp('footer'); ?>