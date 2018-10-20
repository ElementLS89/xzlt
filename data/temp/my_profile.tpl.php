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
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="<?php if(!$_GET['show']) { ?>c1<?php } else { ?>c7<?php } ?> flex"><a href="javascript:SMS.null(1)" class="get" type="switch" box="content-1"><span>个人资料</span></a></li>
          <?php if($_S['member']['password']!='null') { ?>
          <li class="<?php if($_GET['show']==2) { ?>c1<?php } else { ?>c7<?php } ?> flex"><a href="javascript:SMS.null(2)" class="get" type="switch" box="content-2"><span>密码安全</span></a></li>
          <?php } ?>
          <?php if($_S['sms_bind']) { ?>
          <li class="<?php if($_GET['show']==3) { ?>c1<?php } else { ?>c7<?php } ?> flex"><a href="javascript:SMS.null(3)" class="get" type="switch" box="content-3"><span>绑定手机</span></a></li>
          <?php } ?>
          <li class="<?php if($_GET['show']==4) { ?>c1<?php } else { ?>c7<?php } ?> flex"><a href="javascript:SMS.null(4)" class="get" type="switch" box="content-4"><span>隐私设置</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>

      <div class="box-area" id="profile-box">
        <div <?php if(!$_GET['show']) { ?>class="box-content current ready"<?php } else { ?>class="box-content ready" style="display:none"<?php } ?> id="content-1">
          <form action="my.php?mod=<?php echo $_GET['mod'];?>&action=index" method="post" id="my_<?php echo $_GET['mod'];?>_index" enctype="multipart/form-data">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
            <div class="weui-cells__title">基本信息</div>
            <div class="weui-cells weui-cells_form">
            <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>            <?php if($value['canuse'] && $value['position']==1) { ?>
            <?php include temp('my/field'); ?>            <?php } ?>
            <?php } ?>
            </div>
            <div class="weui-cells__title">其他信息</div>
            <div class="weui-cells weui-cells_form">
            <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>            <?php if($value['canuse'] && $value['position']==2) { ?>
            <?php include temp('my/field'); ?>            <?php } ?>
            <?php } ?>
            </div>
            <div class="weui-cells__title">工作信息</div>
            <div class="weui-cells weui-cells_form">
            <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>            <?php if($value['canuse'] && $value['position']==3) { ?>
            <?php include temp('my/field'); ?>            <?php } ?>
            <?php } ?>
            </div>
            <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>            <?php if($value['canuse'] && $value['position']==4) { ?>
            <div class="weui-cells__title"><?php if($value['need']) { ?><span class="c9">*</span><?php } ?><?php echo $value['name'];?></div>
            <?php include temp('my/field'); ?>            <?php } ?>
            <?php } ?>
            

            <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">提交</button></div>
          </form>
        </div>
        <?php if($_S['member']['password']!='null') { ?>
        <div <?php if($_GET['show']==2) { ?>class="box-content current ready"<?php } else { ?>class="box-content ready" style="display:none"<?php } ?> id="content-2">
          <form action="my.php?mod=<?php echo $_GET['mod'];?>&action=security" method="post" id="my_<?php echo $_GET['mod'];?>_security">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
            <div class="weui-cells weui-cells_form">
              <div class="weui-cell">
                <div class="weui-cell__hd">
                  <label class="weui-label">旧密码</label>
                </div>
                <div class="weui-cell__bd">
                  <input class="weui-input" name="password_old" type="password" placeholder="请输入您的原始密码">
                </div>
              </div>
              <div class="weui-cell">
                <div class="weui-cell__hd">
                  <label class="weui-label">新密码</label>
                </div>
                <div class="weui-cell__bd">
                  <input class="weui-input" name="password1" type="password" placeholder="请输入您的新密码">
                </div>
              </div>
              <div class="weui-cell">
                <div class="weui-cell__hd">
                  <label class="weui-label">再输入一次</label>
                </div>
                <div class="weui-cell__bd">
                  <input class="weui-input" name="password2" type="password" placeholder="再输入一次新密码">
                </div>
              </div>
            </div>
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">提交</button></div>
          </form>
        </div>
        <?php } ?>
        <?php if($_S['sms_bind']) { ?>
        <div <?php if($_GET['show']==3) { ?>class="box-content current ready"<?php } else { ?>class="box-content ready" style="display:none"<?php } ?>  id="content-3" >
          <?php if($my['tel']) { ?>
          <div class="weui-cells" id="mytel">
            <a href="javascript:$('#mytel').hide();$('#my_<?php echo $_GET['mod'];?>_tel').show()" class="weui-cell weui-cell_access">
              <div class="weui-cell__bd">更换绑定的手机号</div>
              <div class="weui-cell__ft"><?php echo $my['tel'];?></div>
            </a>
          </div>
          <?php } ?>
          <form action="my.php?mod=<?php echo $_GET['mod'];?>&action=tel" method="post" id="my_<?php echo $_GET['mod'];?>_tel" <?php if($my['tel']) { ?>style="display:none"<?php } ?>>
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
            <input name="lid" type="hidden" value="" id="smslid" />
            <div class="weui-cells weui-cells_form">
              <div class="weui-cell">
                <div class="weui-cell__hd">
                  <label class="weui-label">手机号</label>
                </div>
                <div class="weui-cell__bd">
                  <input class="weui-input" name="tel" type="tel" id="tel" placeholder="请输入手机号">
                </div>
              </div>            
              <div class="weui-cell weui-cell_vcode">
                <div class="weui-cell__hd">
                  <label class="weui-label">验证码</label>
                </div>
                <div class="weui-cell__bd">
                  <input class="weui-input" type="number" name="code" placeholder="输入验证码">
                </div>
                <div class="weui-cell__ft">
                  <button class="weui-vcode-btn" type="button" onclick="SMS.getsmscode('bind')" id="smsbtn">获取验证码</button>
                </div>
              </div>
            </div>
            <?php if($_S['member']['password']!='null') { ?>
            <div class="weui-cells weui-cells_form">
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" name="password" type="password" placeholder="输入您的登录密码">
                </div>
              </div>
            </div>
            <?php } ?>
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">绑定手机</button></div>
          </form>
        </div>
        <?php } ?>
        <div <?php if($_GET['show']==4) { ?>class="box-content current ready"<?php } else { ?>class="box-content ready" style="display:none"<?php } ?>  id="content-4">
          <form action="my.php?mod=<?php echo $_GET['mod'];?>&action=privacy" method="post" id="my_<?php echo $_GET['mod'];?>_security">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
            <div class="weui-cells weui-cells_form">
              <div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">公开地理定位</div>
                <div class="weui-cell__ft">
                  <label for="switchlbs" class="weui-switch-cp">
                  <input id="switchlbs" class="weui-switch-cp__input" type="checkbox" value="1" name="lbs" <?php if($my['lbs']) { ?>checked="checked"<?php } ?>>
                  <div class="weui-switch-cp__box"></div>
                  </label>
                </div>
              </div>
              <div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">公开个人资料</div>
                <div class="weui-cell__ft">
                  <label for="switchprofile" class="weui-switch-cp">
                  <input id="switchprofile" class="weui-switch-cp__input" type="checkbox" value="1" name="profile" <?php if($my['profile']) { ?>checked="checked"<?php } ?>>
                  <div class="weui-switch-cp__box"></div>
                  </label>
                </div>
              </div>
              <div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">允许接收临时消息</div>
                <div class="weui-cell__ft">
                  <label for="switchpm" class="weui-switch-cp">
                  <input id="switchpm" class="weui-switch-cp__input" type="checkbox" value="1" name="pm" <?php if($my['pm']) { ?>checked="checked"<?php } ?>>
                  <div class="weui-switch-cp__box"></div>
                  </label>
                </div>
              </div>
              <div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">加好友免验证</div>
                <div class="weui-cell__ft">
                  <label for="switchfriend" class="weui-switch-cp">
                  <input id="switchfriend" class="weui-switch-cp__input" type="checkbox" value="1" name="friend" <?php if($my['friend']) { ?>checked="checked"<?php } ?>>
                  <div class="weui-switch-cp__box"></div>
                  </label>
                </div>
              </div>
              <div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">公开个人朋友圈</div>
                <div class="weui-cell__ft">
                  <label for="switchcircle" class="weui-switch-cp">
                  <input id="switchcircle" class="weui-switch-cp__input" type="checkbox" value="1" name="circle" <?php if($my['circle']) { ?>checked="checked"<?php } ?>>
                  <div class="weui-switch-cp__box"></div>
                  </label>
                </div>
              </div>
            </div>
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">提交</button></div>
          </form>
        </div>

      </div>
    </div>
    
  </div>
  <div id="footer"> 
    <?php include temp('tabbar'); ?> 
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
  $(document).ready(function() {
      SMS.translate_int()
});
  </script>
  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>