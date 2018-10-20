<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('back')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>">

      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="flex c1"><a href="topic.php?mod=forum" class="get" type="switch" box="forum"><span>板块</span></a></li>
          <li class="flex c7"><a href="topic.php?mod=forum&show=new" class="get" type="switch" box="new"><span>最新</span></a></li>
          <li class="flex c7"><a href="topic.php?mod=forum&show=best" class="get" type="switch" box="best"><span>推荐</span></a></li>
          <li class="flex c7"><a href="topic.php?mod=forum&show=pics" class="get" type="switch" box="pics"><span>图集</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>

      <div class="box-area">
        <div class="box-content current ready" id="forum">
          <?php if($_S['cache']['slider']['forum']) { ?>
          <div class="swiper">
            <div class="swiper-wrapper">
              <?php if(is_array($_S['cache']['slider']['forum'])) foreach($_S['cache']['slider']['forum'] as $value) { ?>              <div class="swiper-slide b_f tc flex_box"><a href="<?php echo $value['url'];?>" class="load"><img src="<?php echo $_S['atc'];?>/<?php echo $value['pic'];?>"/></a></div>
              <?php } ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
          <?php } ?>
          <?php if($_S['cache']['announcement']) { ?>
          <div class="announcement b_c3 bob o_c3 flexbox">
            <span class="c9">公告</span>
            <div>
              <ul class="flex s15">
                <?php if(is_array($_S['cache']['announcement'])) foreach($_S['cache']['announcement'] as $value) { ?>                <li><a href="index.php?mod=announcement&aid=<?php echo $value['aid'];?>" class="load"><?php echo $value['subject'];?></a></li>
                <?php } ?>
              </ul>            
            </div>

          </div>
          <?php } ?>

          <?php if(is_array($_S['cache']['topic_groups'])) foreach($_S['cache']['topic_groups'] as $group) { ?>          <div class="box b_c3 mt10" id="group_<?php echo $group['gid'];?>">
            <h3 class="box_title bob o_c3 cl"><a href="javascript:collapsed('group_<?php echo $group['gid'];?>')" class="r icon icon-collapsed-no c4"></a><span class="c4"><em class="b_c1"></em><?php echo $group['name'];?></span></h3>
            <div class="users">
              <?php if(is_array($forums[$group['gid']])) foreach($forums[$group['gid']] as $forum) { ?>              <a href="topic.php?tid=<?php echo $forum['tid'];?>" class="weui-cell load">
                <div class="weui-cell__hd"><img src="<?php echo $_S['atc'];?>/<?php echo $forum['cover'];?>"><?php if($forum['today']) { ?><span class="weui-badge"><?php echo $forum['today'];?></span><?php } ?></div>
                <div class="weui-cell__bd">
                  <h4><?php echo $forum['name'];?></h4>
                  <p class="c4"><?php echo $forum['about'];?></p>
                </div>
                <div class="weui-cell__ft">
                
                </div>
              </a>
              <?php } ?>
            </div>
          </div>
          <?php } ?>

        </div>
        <div class="box-content" id="new" style="display:none"></div>
        <div class="box-content" id="best" style="display:none"></div>
        <div class="box-content" id="pics" style="display:none"></div>
      </div>
      <div id="page"></div>
    </div>
  </div>
  <div id="footer"> 
  <?php include temp('tabbar'); ?>  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
  $(document).ready(function() {
<?php if($_S['cache']['announcement']) { ?>
$(function(){
setInterval('SMS.autoscroll(".currentbody .announcement")',3000)
});
<?php } if($_S['cache']['slider']['forum']) { ?>
var swiper = new Swiper('.currentbody .swiper', {
pagination: {el: '.currentbody .swiper-pagination'},
autoplay: {delay: 3000}
});
<?php } ?>
      SMS.translate_int();
});
  </script>
  <script language="javascript">
    function collapsed(id){
if($('#'+id+' .users').css('display')=='none'){
$('#'+id+' .users').css('display','');
$('#'+id+' .icon').removeClass('icon-collapsed-yes').addClass('icon-collapsed-no');
}else{
$('#'+id+' .users').css('display','none');
$('#'+id+' .icon').removeClass('icon-collapsed-no').addClass('icon-collapsed-yes');
}
}
  </script>
  <?php include temp('wechat'); ?>  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>