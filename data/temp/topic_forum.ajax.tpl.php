
<?php if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
<div class="main">
  <div id="list">
  <div class="pt10 list_<?php echo $_GET['show'];?>">
<?php } ?>
  <?php include temp('topic/'.$themetemp,false)?><?php if($_S['page']=='1' && $_GET['get']=='ajax') { ?>
  </div>
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area=".list_<?php echo $_GET['show'];?>" <?php if($_GET['show']=='pics') { ?>type="water"<?php } ?>><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
  </div>
  <div id="script">
    <?php if($_GET['show']=='pics') { ?>
    <script language="javascript" reload="1">
      var id=SMS.hash(PHPSCRIPT);
      var wf = {};
      $('.currentbody').ready(function(){
        if($('.currentbody #waterfall').length >0) {
          wf = waterfall();
        }
      });
    </script>
    <?php } ?>
  </div>
</div>
<?php } ?>