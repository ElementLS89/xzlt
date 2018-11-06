
<?php if($_GET['show']=='member') { if(is_array($list)) foreach($list as $value) { ?><a href="user.php?uid=<?php echo $value['uid'];?>" class="weui-cell weui-cell_link load">
  <div class="weui-cell__hd"><?php echo head($value,2);?></div>
  <div class="weui-cell__bd">
    <h4><?php echo $value['username'];?></h4>
    <p class="c4"><?php echo $value['bio'];?></p>
  </div>
  <div class="weui-cell__ft">
  <?php echo $topicgroup[$value['level']]['name'];?>
  </div>
</a>
<?php } } else { if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
<div class="themeslist">
  <div id="list">
<?php } ?>
  
<?php if($_GET['show']=='tips') { include temp('topic/themes_tips',false)?><?php } else { include temp('topic/'.$themetemp,false)?><?php } ?>
  
<?php if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?>
  <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#vt_<?php echo $_GET['tid'];?>_<?php echo $_GET['order'];?><?php echo $_GET['typeid'];?>"<?php if($topic['liststype']=='5') { ?>type="water"<?php } ?>><span class="weui-loadmore__tips">下一页</span></a>
  <?php } ?>
  </div>
  <?php if($topic['liststype']=='5') { ?>
  <div id="script">
    <script language="javascript" reload="1">
      var id=SMS.hash(PHPSCRIPT);
      var wf = {};
      $('.currentbody').ready(function(){
        if($('.currentbody #waterfall').length >0) {
          wf = waterfall();
        }
      });
    </script>
  </div>
  <?php } ?>
</div>
<?php } } ?>