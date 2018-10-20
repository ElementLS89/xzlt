<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('back')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="search.php?mod=user" class="icon icon-search load"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>" nocache="true">
      
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="flex c1"><a href="javascript:SMS.null(1)" class="get" type="switch" box="content-1"><span>好友</span></a></li>
          <li class="flex c7"><a href="javascript:SMS.null(2)" class="get" type="switch" box="content-2"><span>群</span></a></li>
          <li class="flex c7"><a href="user.php?mod=follow&uid=<?php echo $_S['uid'];?>" class="get" type="switch" box="follow_<?php echo $_S['uid'];?>_follow"><span>关注</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>

      <div class="box-area">
        <div class="box-content newfriendnoticearea current ready" id="content-1">
          
          <?php if($_S['member']['newfriend']) { ?>
          <a href="my.php?mod=newfriend" class="notice load" id="newfriendnotice">有新的好友请求(<span id="newfriend"><?php echo $_S['member']['newfriend'];?></span>)</a>
          <?php } else { ?>
          <div class="weui-cells" id="newfriendlink">
            <a class="weui-cell weui-cell_access load" href="my.php?mod=newfriend">
              <div class="weui-cell__bd">
                <p>新朋友</p>
              </div>
              <div class="weui-cell__ft"></div>   
            </a>
          </div>
          <?php } ?>
          <div class="weui-cells" id="friendlist">
            <a href="javascript:SMS.list('my.php?mod=friend','friend_t0')" class="weui-cell weui-cell_listopen managefriendtype" id="friend_t0">
              <div class="weui-cell__hd open"></div>
              <div class="weui-cell__bd c6">我的好友</div>
              <div class="weui-cell__ft"><?php echo $friendnum;?></div>
            </a>
            <div class="users ml15 hasvar" id="list_friend_t0">
            <?php include temp('my/friend_ajax'); ?>            </div>
            <?php if(is_array($friendtype)) foreach($friendtype as $value) { ?>            <a href="javascript:SMS.list('my.php?mod=friend&typeid=<?php echo $value['typeid'];?>','friend_t<?php echo $value['typeid'];?>')" class="weui-cell weui-cell_listopen managefriendtype" id="friend_t<?php echo $value['typeid'];?>">
              <div class="weui-cell__hd"></div>
              <div class="weui-cell__bd c6"><?php echo $value['name'];?></div>
              <div class="weui-cell__ft"><?php echo $value['number'];?></div>
            </a>
            <div class="users ml15" id="list_friend_t<?php echo $value['typeid'];?>"></div>
            <?php } ?>
            <a href="javascript:SMS.list('my.php?mod=friend&typeid=black','friend_tblack')" class="weui-cell weui-cell_listopen managefriendtype" id="friend_tblack">
              <div class="weui-cell__hd"></div>
              <div class="weui-cell__bd c6">黑名单</div>
            </a>
            <div class="users ml15" id="list_friend_tblack"></div>
          </div>
        </div>
        <div class="box-content ready" id="content-2" style="display:none">
          <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">暂未开放</span></div>
        </div>
        <div class="box-content weui-cells users myfollows" id="follow_<?php echo $_S['uid'];?>_follow" style="display:none"></div>
      </div>
      <div id="page"></div>
      <div class="weui-actionsheet" id="managefriendtype">
        <div class="weui-actionsheet__menu">
          <a href="user.php?mod=action&action=managefriendtype" class="weui-actionsheet__cell c6 load">管理好友分组</a>
        </div>
        <div class="weui-actionsheet__action">
          <a href="javascript:" class="weui-actionsheet__cell c1">取消</a>
        </div>
      </div>
      
    </div>
  </div>
  <div id="footer"> 
    <?php include temp('my/tabbar'); ?> 
  </div>
</div>
<div id="smsscript">
  
  <script language="javascript" reload="1">
  $(document).ready(function() {
      SMS.translate_int();
});
$('.managefriendtype').longPress(function(){
      SMS.opensheet('#managefriendtype');
},function(){
});
  </script>
  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>