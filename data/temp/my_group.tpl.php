<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('close')?></div>
      <div class="header-m flex"><?php echo $mygroup['name'];?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_t <?php echo $outback;?>" nocache="true">
      <?php if($_GET['showlog']) { ?>
      <div class="autolist b_c3">
      <?php include temp('my/group_ajax'); ?>      </div>
      <?php if($maxpage>1) { ?><a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>"><span class="weui-loadmore__tips">下一页</span></a><?php } ?>
      <?php } else { ?>
      <?php if($_S['uid']==$_GET['uid']) { ?>
      <div class="weui-cells">
        <a class="weui-cell weui-cell_access load" href="my.php?mod=group&showlog=true">
          <div class="weui-cell__bd"><p>经验值</p></div>
          <div class="weui-cell__ft"><?php echo $my['experience'];?></div>
        </a>
      </div>
      <?php } ?>
      <div class="weui-cells__title">用户权限</div>
      <div class="weui-cells">
        <div class="weui-cell">
          <div class="weui-cell__bd">用户组</div>
          <div class="weui-cell__ft"><?php echo $mygroup['name'];?></div>
        </div>     
        <div class="weui-cell">
          <div class="weui-cell__bd">允许访问</div>
          <div class="weui-cell__ft"><em class="icon <?php if($mygroup['allowvisit']==1) { ?>icon-yes c1<?php } else { ?>icon-no<?php } ?>"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许发帖</div>
          <div class="weui-cell__ft"><em class="icon <?php if($mygroup['allowaddtheme']==1) { ?>icon-yes c1<?php } else { ?>icon-no<?php } ?>"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许回帖</div>
          <div class="weui-cell__ft"><em class="icon <?php if($mygroup['allowreply']==1) { ?>icon-yes c1<?php } else { ?>icon-no<?php } ?>"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许创建话题数</div>
          <div class="weui-cell__ft"><?php echo $mygroup['allowcreattopic'];?>个</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">创建话题免审核</div>
          <div class="weui-cell__ft"><em class="icon <?php if($mygroup['examinetopic']==1) { ?>icon-no<?php } else { ?>icon-yes c1<?php } ?>"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许添加好友</div>
          <div class="weui-cell__ft"><em class="icon <?php if($mygroup['allowaddfriend']==1) { ?>icon-yes c1<?php } else { ?>icon-no<?php } ?>"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许发送消息</div>
          <div class="weui-cell__ft"><em class="icon <?php if($mygroup['allowsendmessage']==1) { ?>icon-yes c1<?php } else { ?>icon-no<?php } ?>"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许点赞</div>
          <div class="weui-cell__ft"><em class="icon <?php if($mygroup['allowpraise']==1) { ?>icon-yes c1<?php } else { ?>icon-no<?php } ?>"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">发帖免审核</div>
          <div class="weui-cell__ft"><em class="icon <?php if($mygroup['examinetheme']==1) { ?>icon-no<?php } else { ?>icon-yes c1<?php } ?>"></em></div>
        </div>
        <?php if($mygroup['creditshigher']) { ?>
        <div class="weui-cell">
          <div class="weui-cell__bd">升级所需经验</div>
          <div class="weui-cell__ft"><?php echo $mygroup['creditshigher'];?></div>
        </div>
        <?php } ?>
        
      </div>
      <?php } ?>

      
          
    </div>
  </div>
  <div id="footer"> 
  
  </div>
</div>
<div id="smsscript"><?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>