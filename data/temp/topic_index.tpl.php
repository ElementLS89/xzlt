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
      <div class="weui-search-bar" id="searchBar">
        <form class="weui-search-bar__form" action="search.php" method="get" id="search-topic" type="search" onsubmit="getform(this.id);return false">
          <input type="hidden" name="mod" value="topic" />
          <input type="hidden" name="t" value="topic" />
          <div class="weui-search-bar__box"> <i class="weui-icon-search"></i>
            <input type="search" class="weui-search-bar__input" id="searchInput" name="k" placeholder="搜索" required>
            <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
          </div>
          <a href="javascript:" class="weui-search-bar__label" id="searchText"><i class="weui-icon-search"></i><span>搜索</span></a>
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
      </div>
      <div class="box b_c3 mb10">
        <h3 class="box_title bob o_c3 cl"><a href="topic.php?mod=creat" class="r weui-btn weui-btn_mini  weui-btn_plain-primary load">创建话题</a><span class="c4">我的话题</span></h3>
        <div class="users" id="mytopic">
          <?php if(is_array($mytopic)) foreach($mytopic as $value) { ?>          <a href="topic.php?tid=<?php echo $value['tid'];?>" class="weui-cell weui-cell_access load" id="mytopic_<?php echo $value['tid'];?>">
            <div class="weui-cell__hd"><img src="<?php echo $value['cover'];?>"></div>
            <div class="weui-cell__bd">
              <h4><?php echo $value['name'];?></h4>
              <p class="c4"><?php echo $value['about'];?></p>
            </div>
          </a>
          <?php } ?>
        </div>
      </div>
      <div class="box b_c3">
        <h3 class="box_title bob o_c3 cl"><a href="topic.php?mod=list" class="r weui-btn weui-btn_mini weui-btn_plain-primary load">查看全部</a><span class="c4">推荐话题</span></h3>
        <div class="users">
          <?php if(is_array($hotopic)) foreach($hotopic as $value) { ?>          <a href="topic.php?tid=<?php echo $value['tid'];?>" class="weui-cell weui-cell_access load">
            <div class="weui-cell__hd"><img src="<?php echo $value['cover'];?>"></div>
            <div class="weui-cell__bd">
              <h4><?php echo $value['name'];?></h4>
              <p class="c4"><?php echo $value['about'];?></p>
            </div>
          </a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <div id="footer"> 
  <?php include temp('tabbar'); ?>  </div>
</div>
<div id="smsscript">
  <?php include temp('wechat'); ?>  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>