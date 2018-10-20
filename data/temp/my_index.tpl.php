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
      <div class="usercenter flexbox b_c3 bob bot o_c3 p10">
        <div class="flex">
          <div class="l"><a href="javascript:" class="upload" name="avatar"><?php echo head($_S['member'],2);?></a></div>
          <div class="l">
          <a href="user.php" class="load"><h3 class="c6" id="uc-username"><?php echo $_S['member']['username'];?></h3>
          <p class="c4">点击进入个人空间</p></a>          
          </div>
        </div>
        <a href="javascript:" class="c3 upload" name="avatar">更换</a>
        <a href="my.php?mod=profile" class="weui-btn weui-btn_mini weui-btn_warn load">设置</a>
      </div>
      <?php if($_S['in_wechat'] && !$_S['member']['openid']) { ?>
      <div class="weui-cells">
        <a href="wechat.php?mod=getopenid" class="weui-cell weui-cell_access load">
          <div class="weui-cell__bd">绑定微信</div>
          <div class="weui-cell__ft"></div>
        </a>
      </div>
      <?php } ?>
      <?php if(!empty($_S['hacks']['my_top'])) echo $_S['hacks']['my_top'];?>
      <div class="weui-cells">
        <?php if(!empty($_S['hacks']['my_c1'])) echo $_S['hacks']['my_c1'];?>
        <?php if($_S['setting']['alloweditusername'] || $_S['member']['password']=='null') { ?>
        <a href="my.php?mod=id" class="weui-cell weui-cell_access load" id="setid">
          <div class="weui-cell__bd"><?php if($_S['member']['password']=='null') { ?>完善个人账号<?php } else { ?>修改用户名<?php } ?></div>
          <div class="weui-cell__ft"></div>
        </a>
        <?php } ?>
        <?php if($_S['dz']) { ?>
        <a href="discuz.php?mod=bind" class="weui-cell weui-cell_access load" id="setid">
          <div class="weui-cell__bd"><?php if($_S['member']['dzuid']) { ?>更换绑定论坛账号<?php } else { ?>绑定论坛账号<?php } ?></div>
          <div class="weui-cell__ft"></div>
        </a>
        <?php } ?>
        <?php if(!empty($_S['hacks']['my_c2'])) echo $_S['hacks']['my_c2'];?>
        <a href="my.php?mod=group" class="weui-cell weui-cell_access load">
          <div class="weui-cell__bd"><?php echo $_S['cache']['usergroup'][$_S['member']['groupid']]['name'];?></div>
          <div class="weui-cell__ft"></div>
        </a>
        <?php if(!empty($_S['hacks']['my_c3'])) echo $_S['hacks']['my_c3'];?>
        <a href="my.php?mod=account" class="weui-cell weui-cell_access load">
          <div class="weui-cell__bd"><em>我的钱包</em></div>
          <div class="weui-cell__ft">详细信息</div>
        </a>
        <?php if(!empty($_S['hacks']['my_c4'])) echo $_S['hacks']['my_c4'];?>
        <a href="my.php?mod=hongbao" class="weui-cell weui-cell_access load">
          <div class="weui-cell__bd"><em>我的红包</em></div>
          <div class="weui-cell__ft">查看详情</div>
        </a>
        <?php if(!empty($_S['hacks']['my_c5'])) echo $_S['hacks']['my_c5'];?>
        <a href="collection.php" class="weui-cell weui-cell_access load">
          <div class="weui-cell__bd"><em>我的收藏</em></div>
          <div class="weui-cell__ft"></div>
        </a>
        <?php if(!empty($_S['hacks']['my_c6'])) echo $_S['hacks']['my_c6'];?>
      </div>
      <?php if(!empty($_S['hacks']['my_middle_1'])) echo $_S['hacks']['my_middle_1'];?>
      <div class="weui-cells" >
        <a href="my.php?mod=notice" class="weui-cell weui-cell_access load" id="my_newnotice" onclick="$('#my_newnotice .weui-badge').remove()">
          <div class="weui-cell__bd"><em>系统消息</em><?php if($_S['member']['newnotice']) { ?><span class="weui-badge"><?php echo $_S['member']['newnotice'];?></span><?php } ?></div>
          <div class="weui-cell__ft">查看</div>
        </a>
        <?php if(!$_S['setting']['closebbs']) { ?>
        <a href="my.php?mod=message" class="weui-cell weui-cell_access load" id="my_newmessage" onclick="$('#my_newmessage .weui-badge').remove()">
          <div class="weui-cell__bd"><em>聊天</em><?php if($_S['member']['newmessage']) { ?><span class="weui-badge"><?php echo $_S['member']['newmessage'];?></span><?php } ?></div>
          <div class="weui-cell__ft">查看</div>
        </a>
        <a href="my.php?mod=friend" class="weui-cell weui-cell_access load" id="my_newfriend" onclick="$('#my_newfriend .weui-badge').remove()">
          <div class="weui-cell__bd"><em>联系人</em><?php if($_S['member']['newfriend']) { ?><span class="weui-badge"><?php echo $_S['member']['newfriend'];?></span><?php } ?></div>
          <div class="weui-cell__ft"><?php if($_S['member']['newfriend']) { ?>有新的好友请求<?php } ?></div>
        </a>
        <?php } ?>
      </div>
      <?php if(!empty($_S['hacks']['my_middle_2'])) echo $_S['hacks']['my_middle_2'];?>
      <div class="weui-cells">
        <a href="my.php?mod=profile" class="weui-cell weui-cell_access load">
          <div class="weui-cell__bd">个人设置</div>
          <div class="weui-cell__ft"></div>
        </a>
        <a href="set.php" class="weui-cell weui-cell_access load">
          <div class="weui-cell__bd">系统信息</div>
          <div class="weui-cell__ft"></div>
        </a>
        <a href="index.php?mod=feed" class="weui-cell weui-cell_access load">
          <div class="weui-cell__bd">问题反馈</div>
          <div class="weui-cell__ft"></div>
        </a>
      </div>
      <?php if(!empty($_S['hacks']['my_bot'])) echo $_S['hacks']['my_bot'];?>
      <div class="p15"><a href="member.php?mod=out&closepage=true" class="weui-btn weui-btn_primary load">退出登录</a></div>
      <form action="upload.php?item=avatar&load=true&submit=true&hash=<?php echo $_S['hash'];?>" id="avatar-form" style="display:none;" >
        <input type="file" id="avatar-file" name="avatar" accept="image/gif,image/jpeg,image/jpg,image/png">
      </form>


      
    </div>
  </div>
  <div id="footer"> 
    <?php include temp('tabbar'); ?> 
  </div>
</div>
<div id="smsscript"><?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>