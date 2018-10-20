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
      <div class="userlist b_c3 pl10 pr10 autolist">
        <?php include temp('user/nearby_ajax'); ?>      </div>
      <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" ><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
      <?php } else { ?>
      <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">没有搜索到符合条件的人</span></div>
      <?php } ?>
      <?php } else { ?>
      <form action="search.php" method="get" id="search-user"  onsubmit="getform(this.id);return false">
        <input type="hidden" name="mod" value="user" />
        <div class="weui-cells mb10">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" id="searchInput" type="text" name="k" placeholder="请输入你要搜索的用户名">
            </div>
          </div>
        </div>
        <div class="weui-cells">
          <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>          <?php if($value['canuse'] && $value['search']) { ?>
          <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
              <label for="" class="weui-label"><?php if($field=='birthday') { ?>年龄<?php } else { ?><?php echo $value['name'];?><?php } ?></label>
            </div>
            <div class="weui-cell__bd">
              <select class="weui-select" name="search[<?php echo $field;?>]">
                <option value="">不限</option>
                <?php if($field=='birthday') { ?>
                <option value="1,20">20岁以下</option>
                <option value="20,30">20-30岁</option>
                <option value="30,40">30-40岁</option>
                <option value="40,50">40-50岁</option>
                <option value="50,99">50岁以上</option>
                <?php } else { ?>
                <?php if(is_array($value['choises'])) foreach($value['choises'] as $id => $value) { ?>                <?php if($id>0) { ?>
                <option value="<?php echo $id;?>"><?php echo $value;?></option>
                <?php } ?>
                <?php } ?>                
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } ?>
          <?php } ?>
        </div>
        <div class="p15">
          <button type="button" class="weui-btn weui-btn_primary" onclick="getform('search-user');">搜索</button>
        </div>
        <div class="pl50 pr50"><a href="user.php?mod=nearby" class="weui-btn weui-btn_plain-primary load" close="true">查找附近的人</a></div>
      </form>
      <?php } ?>
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript"><?php include temp('wechat'); include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>