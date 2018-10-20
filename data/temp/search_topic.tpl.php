<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('close')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>">
      <?php if($_GET['k']) { ?>
      <?php if($list) { ?>
      <div class="<?php if($_GET['t']=='topic') { ?>users b_c3 <?php } ?>autolist">
      <?php include temp('search/topic_ajax'); ?>      </div>
      <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" ><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
      <?php } else { ?>
      <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">没有搜索到符合条件的数据</span></div>
      <?php } ?>
      <?php } else { ?>
      <div class="weui-search-bar" id="searchBar">
        <form class="weui-search-bar__form" action="search.php" method="get" id="search-topic" type="search" onsubmit="getform(this.id);return false">
          <input type="hidden" name="mod" value="topic" />
          <?php if($_GET['t']) { ?>
          <input type="hidden" name="t" value="<?php echo $_GET['t'];?>" />
          <?php } ?>
          <div class="weui-search-bar__box"> <i class="weui-icon-search"></i>
            <input type="search" class="weui-search-bar__input" id="searchInput" name="k" placeholder="搜索" required>
            <a href="javascript:" class="weui-icon-clear" id="searchClear"></a> </div>
          <a href="javascript:" class="weui-search-bar__label" id="searchText"><i class="weui-icon-search"></i><span>搜索</span></a>
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
      </div>
      <?php } ?>
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript"><?php include temp('wechat'); include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>