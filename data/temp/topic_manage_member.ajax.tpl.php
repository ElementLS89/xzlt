
<?php if($_S['page']==1) { ?>
<div class="memberlist">
  <div id="list">
    <div class="box b_c3 mb10 mt10">
      <h3 class="box_title cl"><span>管理团队</span></h3>
      <div class="users bot o_c3">
        <?php if(is_array($manager)) foreach($manager as $value) { ?>        <div class="weui-cell" id="manager_<?php echo $value['uid'];?>">
          <div class="weui-cell__hd"><?php echo head($value,2);?></div>
          <div class="weui-cell__bd">
            <h4><?php echo $value['username'];?></h4>
            <p class="c4"><?php echo $topicgroup[$value['level']]['name'];?></p>
          </div>
          <div class="weui-cell__ft">
          <?php if($topic['level']>$value['level']) { ?>
          <a href="topic.php?mod=manage&item=action&ac=6&uid=<?php echo $value['uid'];?>&tid=<?php echo $_GET['tid'];?>" class="weui-btn weui-btn_mini weui-btn_default load" loading="tab">撤销</a>
          <?php } ?>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="box b_c3 mb10 mt10">
      <h3 class="box_title cl"><span>成员管理</span></h3>
      <div class="users autolist bot o_c3">
<?php } ?>
        <?php if(is_array($list)) foreach($list as $value) { ?>        <div class="weui-cell" id="member_<?php echo $value['uid'];?>">
          <div class="weui-cell__hd"><?php echo head($value,2);?></div>
          <div class="weui-cell__bd">
            <h4><?php echo $value['username'];?></h4>
            <p class="c4"><?php echo $topicgroup[$value['level']]['name'];?></p>
          </div>
          <div class="weui-cell__ft">
          <a href="topic.php?mod=manage&item=action&ac=5&uid=<?php echo $value['uid'];?>&tid=<?php echo $_GET['tid'];?>" class="weui-btn weui-btn_mini weui-btn_default load" loading="tab">删除</a>
          </div>
        </div>
        <?php } if($_S['page']==1) { ?>
      </div>
    </div>
  
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#member"><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
  </div>
</div>
<?php } ?>