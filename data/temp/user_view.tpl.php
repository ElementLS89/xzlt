<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header flexbox transparent c3">
      <div class="header-l"><?php back('close')?></div>
      <div class="header-m flex"><?php echo $user['username'];?></div>
      <div class="header-r"><a href="javascript:SMS.opensheet('#usersheet')" class="icon icon-more"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_0 <?php echo $outback;?>">
      <div class="usertop" id="viewuser_<?php echo $uid;?>">
        <a class="usertop-bg<?php if($user['uid']==$_S['uid']) { ?> load<?php } ?>" <?php if($user['uid']==$_S['uid']) { ?>href="set.php?type=spacecover"<?php } ?> <?php if($user['spacecover']) { ?>style="background-image:url(<?php echo $user['spacecover'];?>);"<?php } ?>></a>
        
        <div class="usertop-btn b_c3">
          <?php if($uid!=$_S['uid']) { ?>
          <a href="user.php?mod=action&action=follow&uid=<?php echo $uid;?>" class="weui-btn weui-btn_mini weui-btn_default load<?php if($isfollow) { ?> c2<?php } ?>" id="follow_<?php echo $uid;?>" loading="tab"><?php if($isfollow) { ?>取消关注<?php } else { ?>关注<?php } ?></a>
          <?php } else { ?>
          <a href="my.php?mod=profile" class="weui-btn weui-btn_mini weui-btn_default load">设置</a>
          <?php } ?>
          <?php if(!$_S['setting']['closebbs']) { ?>
          <?php if($isfriend=='-1') { ?>
          <a href="javascript:" class="weui-btn weui-btn_mini weui-btn_default c2" id="addfriend_<?php echo $uid;?>">待审核</a>
          <?php } elseif(!$isfriend && $_S['uid']!=$uid) { ?>
          <a href="user.php?mod=action&action=add&uid=<?php echo $uid;?>" class="weui-btn weui-btn_mini weui-btn_default load" id="addfriend_<?php echo $uid;?>">加好友</a>
          <?php } elseif($isfriend=='1') { ?>
          <a href="my.php?mod=talk&tid=<?php echo $tid;?>" class="weui-btn weui-btn_mini weui-btn_primary load" id="addfriend_<?php echo $uid;?>">发消息</a>
          <?php } ?>
          <?php } ?>
        </div>
        
        <div class="water"><div class="water_1"></div><div class="water_2"></div></div>
        <?php echo head($user,2);?>        
      </div>
      
      <div class="usermiddle b_c3">
        <h3><?php echo $user['username'];?><span class="bo o_c2 c1 s12"><?php echo $user['group'];?></span></h3>
      </div>
      <p class="userbottom b_c3 bob o_c3 c6"><a href="javascript:SMS.opensheet('#usersheet')" class="r">更多&gt;&gt;</a><a href="user.php?mod=follow&show=follow&uid=<?php echo $_GET['uid'];?>" class="load"><strong class="c8" id="follows_<?php echo $uid;?>"><?php echo $user['follow'];?></strong>关注</a><a href="user.php?mod=follow&show=fans&uid=<?php echo $uid;?>" class="load"><strong class="c8" id="fans_<?php echo $uid;?>"><?php echo $user['fans'];?></strong>粉丝</a></p>
      <?php if(!$_S['setting']['closebbs']) { ?>
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          
          <?php if($_S['uid']==$uid) { ?>
          <li class="c1 flex"><a href="user.php?uid=<?php echo $uid;?>" class="get" type="switch" box="uv_<?php echo $uid;?>"><span>朋友圈</span></a></li>
          <li class="c7 flex"><a href="user.php?uid=<?php echo $uid;?>&show=my" class="get" type="switch" box="uv_<?php echo $uid;?>my"><span>我的</span></a></li>
          <li class="c7 flex"><a href="user.php?uid=<?php echo $uid;?>&show=follow" class="get" type="switch" box="uv_<?php echo $uid;?>follow"><span>关注</span></a></li>
          
          <?php } else { ?>
          <li class="c1 flex"><a href="user.php?uid=<?php echo $uid;?>" class="get" type="switch" box="uv_<?php echo $uid;?>"><span>动态</span></a></li>
          <?php } ?>
          <?php if($_S['dz'] && $user['dzuid']) { ?>
          <li class="c7 flex"><a href="user.php?uid=<?php echo $uid;?>&show=sms" class="get" type="switch" box="uv_<?php echo $uid;?>sms"><span>日记</span></a></li>
          <?php } ?>
          <li class="c7 flex"><a href="javascript:SMS.null(1)" class="get" type="switch" box="uv_<?php echo $uid;?>profile"><span>资料</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>
      <?php } ?>
      <div class="box-area">
        <?php if(!$_S['setting']['closebbs']) { ?>
        <div class="box-content current ready" id="uv_<?php echo $uid;?>">
          <?php include temp('user/view_ajax'); ?>        </div>
        <div class="box-content" id="uv_<?php echo $uid;?>follow" style="display:none"></div>
        <div class="box-content" id="uv_<?php echo $uid;?>my" style="display:none"></div>
        <?php if($_S['dz'] && $user['dzuid']) { ?><div class="box-content" id="uv_<?php echo $uid;?>sms" style="display:none"></div><?php } ?>
        <?php } ?>
        <div class="box-content ready" id="uv_<?php echo $uid;?>profile" <?php if(!$_S['setting']['closebbs']) { ?>style="display:none"<?php } ?>>
          
          <div class="weui-cells__title">用户信息</div>
          <div class="weui-cells">
            <a href="my.php?mod=group&gid=<?php echo $user['groupid'];?>&uid=<?php echo $uid;?>" class="weui-cell weui-cell_access load">
              <div class="weui-cell__hd c4"><label class="weui-label">用户组</label></div>
              <div class="weui-cell__bd"><?php echo $_S['cache']['usergroup'][$user['groupid']]['name'];?></div>
              <div class="weui-cell__ft"></div>
            </a>
            <?php if($_S['uid']==$uid) { ?>
            <a href="my.php?mod=account" class="weui-cell weui-cell_access load">
            <?php } else { ?>
            <div class="weui-cell weui-cell_access">
            <?php } ?>
              <div class="weui-cell__hd c4"><label class="weui-label">经验值</label></div>
              <div class="weui-cell__bd"><?php echo $user['experience'];?></div>
              <div class="weui-cell__ft"></div>
            <?php if($_S['uid']==$uid) { ?></a><?php } else { ?></div><?php } ?>       
          </div>
          <?php if($user['profile'] || $_S['uid']==$uid) { ?>
          <div class="weui-cells__title">基本资料</div>
          <div class="weui-cells">
            <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>            <?php if($value['canuse'] && $value['position']==1) { ?>
            <div class="weui-cell weui-cell_access">
              <div class="weui-cell__hd c4"><label class="weui-label"><?php echo $value['name'];?></label></div>
              <div class="weui-cell__bd"><?php echo $user[$field];?></div>
            </div>
            <?php } ?>
            <?php } ?>       
          </div>
          <div class="weui-cells__title">工作信息</div>
          <div class="weui-cells">
            <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>            <?php if($value['canuse'] && $value['position']==3) { ?>
            <div class="weui-cell weui-cell_access">
              <div class="weui-cell__hd c4"><label class="weui-label"><?php echo $value['name'];?></label></div>
              <div class="weui-cell__bd"><?php echo $user[$field];?></div>
            </div>
            <?php } ?>
            <?php } ?>    
          </div>
          <div class="weui-cells__title">其他信息</div>
          <div class="weui-cells">
            <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>            <?php if($value['canuse'] && $value['position']==2) { ?>
            <div class="weui-cell weui-cell_access">
              <div class="weui-cell__hd c4"><label class="weui-label"><?php echo $value['name'];?></label></div>
              <div class="weui-cell__bd"><?php echo $user[$field];?></div>
            </div>
            <?php } ?>
            <?php } ?>    
          </div>
          <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>          <?php if($value['canuse'] && $value['position']==4) { ?>
          <div class="weui-cells__title"><?php echo $value['name'];?></div>
          <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
              <div class="weui-cell__bd"><?php echo $user[$field];?></div>
            </div>        
          </div>
          <?php } ?>
          <?php } ?>
          
          <?php } else { ?>
          <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">对方未公开个人资料</span></div>
          <?php } ?>
        </div>
      </div>
      <?php if(!$_S['setting']['closebbs']) { ?>
      <div id="page">
      <?php if($maxpage>1) { ?>
      <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#uv_<?php echo $uid;?>"><span class="weui-loadmore__tips">下一页</span></a>
      <?php } ?>
      </div>
      <?php } ?>
      <div class="weui-actionsheet" id="usersheet">
        <div class="weui-actionsheet__menu">
          <?php if($isfriend) { ?>
          <a href="user.php?mod=action&action=delete&uid=<?php echo $uid;?>" class="weui-actionsheet__cell c6 load" id="delete_<?php echo $uid;?>">删除好友</a>
          <?php } ?>
          <?php if($isblack) { ?>
          <a href="user.php?mod=action&action=deleteblack&uid=<?php echo $uid;?>" class="weui-actionsheet__cell c6 load" id="black_<?php echo $uid;?>">移出黑名单</a>
          <?php } elseif(!$isblack && $_S['uid'] && $_S['uid']!=$uid) { ?>
          <a href="user.php?mod=action&action=addblack&uid=<?php echo $uid;?>" class="weui-actionsheet__cell c6 load" id="black_<?php echo $uid;?>">加入黑名单</a>
          <?php } ?>
          
          <?php if($isfriend) { ?>
          <a href="user.php?mod=action&action=friendtype&uid=<?php echo $uid;?>" class="weui-actionsheet__cell c6 load">设置分组</a>
          <?php } ?>
          <a href="user.php?mod=action&action=qrcode&uid=<?php echo $uid;?>" class="weui-actionsheet__cell c6 load">二维码</a>
          <?php if($_S['uid'] && $_S['uid']!=$uid) { ?>
          <a href="index.php?mod=feed&type=3&ref=user.php?uid=<?php echo $_GET['uid'];?>" class="weui-actionsheet__cell c6 load">举报</a>
          <?php } ?>
        </div>
        <div class="weui-actionsheet__action">
          <a href="javascript:" class="weui-actionsheet__cell c1">取消</a>
        </div>
      </div>


    </div>
  </div>
  <div id="footer"> 
  <?php if($_S['uid']==$uid && !$_S['setting']['closebbs']) { ?>
  <a href="topic.php?mod=post" class="icon icon-write addtopic b_c8 load"></a>
  <?php } ?>
  
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
  $(document).ready(function() {
      SMS.translate_int()
});
  </script>
  <?php include temp('wechat'); ?>  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>