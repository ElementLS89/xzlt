
<?php if($_S['page']==1) { ?>
<div class="memberlist">
  <div id="list">
    <div class="box b_c3 mb10 mt10">
      <h3 class="box_title cl"><span>管理申请</span></h3>
      <div class="users bot o_c3">
        <?php if(is_array($applys)) foreach($applys as $value) { ?>        <?php if($topic['level']==127  || $_S['usergroup']['power']>5) { ?>
        <a class="weui-cell weui-cell_access load" href="topic.php?mod=manage&tid=<?php echo $_GET['tid'];?>&aid=<?php echo $value['aid'];?>&item=apply" id="apply_<?php echo $value['uid'];?>">
        <?php } else { ?>
        <a class="weui-cell weui-cell_access" href="javascript:">
        <?php } ?>
          <div class="weui-cell__hd"><?php echo head($value,2);?></div>
          <div class="weui-cell__bd">
            <h4><?php echo $value['username'];?></h4>
            <p class="c4">申请：<?php echo $topicgroup[$value['level']]['name'];?></p>
          </div>
          <?php if($topic['level']==127) { ?>
          <div class="weui-cell__ft">详情</div>
          <?php } ?>
        </a>
        <?php } ?>
      </div>
    </div>
    <div class="box b_c3 mb10 mt10">
      <h3 class="box_title cl"><span>成员申请</span></h3>
      <div class="users autolist bot o_c3">
<?php } ?>
        <?php if(is_array($list)) foreach($list as $value) { ?>        <div class="weui-cell" id="user_<?php echo $value['uid'];?>">
          <div class="weui-cell__hd"><?php echo head($value,2);?></div>
          <div class="weui-cell__bd">
            <h4><?php echo $value['username'];?></h4>
            <p class="c4"><?php echo $topicgroup[$value['level']]['name'];?></p>
          </div>
          <div class="weui-cell__ft">
          <a href="topic.php?mod=manage&item=action&ac=1&uid=<?php echo $value['uid'];?>&tid=<?php echo $_GET['tid'];?>" class="weui-btn weui-btn_mini weui-btn_default load" loading="tab">拒绝</a>
          <a href="topic.php?mod=manage&item=action&ac=2&uid=<?php echo $value['uid'];?>&tid=<?php echo $_GET['tid'];?>" class="weui-btn weui-btn_mini weui-btn_primary load" loading="tab">通过</a>
          </div>
        </div>
        <?php } if($_S['page']==1) { ?>
      </div>
    </div>
  
  </div>
  <div id="page">
  <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#apply"><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
  </div>
</div>
<?php } ?>