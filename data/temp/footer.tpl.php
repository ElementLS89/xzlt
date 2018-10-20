
  <div id="sharpic" style="display:none"><?php echo $_S['shar']['pic'];?></div>
  <div id="wxconfig" style="display:none">
    <?php if($_S['in_wechat']) { ?>
    <input type="hidden" id="url" value="<?php echo(getrequest())?>" />
    <input type="hidden" id="wx_appid" value="<?php echo $_S['setting']['wx_appid'];?>" />
    <input type="hidden" id="wx_timestamp" value="<?php echo $_S['timestamp'];?>" />
    <input type="hidden" id="wx_noncestr" value="<?php echo $_S['hash'];?>" />
    <input type="hidden" id="wx_signature" value="<?php echo $signature;?>" />
    <input type="hidden" id="wx_jsapilist" value="<?php echo $apilist;?>" />
    <?php } else { ?>
    <input type="hidden" id="notinweixin" value="true" />
    <?php } ?>
  </div>
</div>

<?php if(!$_GET['load']) { ?>
<div id="rightpannel">
  <?php if($_S['app']['hideheader']) { ?>
  <a href="javascript:SMS.showheader('<?php echo $_S['app']['body'];?>')" class="icon icon-showheader mainpannel"></a>
  <?php } ?>
  <?php if(!$_SERVER['HTTP_REFERER']) { ?>
  <a href="javascript:SMS.openside()" class="icon icon-openside mainpannel"></a>
  <?php } ?>
  <?php if(!empty($_S['hacks']['footer_right'])) echo $_S['hacks']['footer_right'];?>
  <div id="newmsg">
  <?php if($_S['member']['newnotice']) { ?>
  <a href="my.php?mod=notice" class="newmsg icon icon-newnotice load"><span class="weui-badge"><?php echo $_S['member']['newnotice'];?></span></a>
  <?php } elseif($_S['member']['newmessage']) { ?>
  <a href="my.php?mod=message" class="newmsg icon icon-newmsg load"><span class="weui-badge"><?php echo $_S['member']['newmessage'];?></span></a>
  <?php } elseif($_S['member']['newfriend']) { ?>
  <a href="my.php?mod=newfriend" class="newmsg icon icon-newfriend load"><span class="weui-badge"><?php echo $_S['member']['newfriend'];?></span></a>
  <?php } ?>
  </div>  
</div>
<div id="leftpannel">
<?php if(!empty($_S['hacks']['footer_left'])) echo $_S['hacks']['footer_left'];?>
<a href="javascript:SMS.back()" class="icon icon-back mainpannel"></a>
</div>
<div id="mask" style="display:none"></div>
<div id="loading" style="display:none"></div>
<div id="loadpage" class="b_c3" style="display:none;-webkit-transform:translateX(100%);-webkit-transition:-webkit-transform 0s 0s;"><div class="loadingpage"><span class="l1"></span><span class="l2"></span><span class="l3"></span></div></div>
<div id="sidenv" class="c3" style="display:none;-webkit-transform:translateX(100%);-webkit-transition:-webkit-transform 0s 0s;">
  <div class="sidenv-content">
    <div class="side-user">
      <?php if($_S['member']['uid']) { ?>
      <a href="user.php" class="load"><?php echo head($_S['member'],2);?>      <h3 id="side-username"><?php echo $_S['member']['username'];?></h3></a>
      <?php } else { ?>
      <a href="member.php" class="load"><img src="ui/avatar_2.jpg" />
      <h3>登录</h3></a>
      <?php } ?>
    </div>
    <div class="side-nv">
      <ul>
        <?php if(is_array($_S['cache']['navs']['nav_side'])) foreach($_S['cache']['navs']['nav_side'] as $value) { ?>        <?php if($_S['setting']['closebbs'] && in_array($value['url'],array('topic.php','topic.php?mod=forum','topic.php?mod=post','discuz.php'))) { ?>
        <?php $value['close']=true;?>        <?php } ?>
        <?php if($value['canuse'] && !$value['close']) { ?>
        <li><a href="<?php echo $value['url'];?>" class="load <?php echo $value['icon'];?>"><?php echo $value['name'];?></a></li>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <div class="side-btn flexbox">
    <?php if($_S['member']['uid']) { ?>
    <a href="set.php" class="flex load icon-set">设置</a><a href="member.php?mod=out" class="flex load icon-out">退出</a>
    <?php } else { ?>
    <a href="member.php" class="flex load icon-login">登录</a><a href="member.php?mod=reg" class="flex load icon-reg">注册</a>
    <?php } ?>
    </div>
  </div>
</div>

</body>
</html>
<?php } ?>