<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('close')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>" nocache="true">
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="c1 flex"><a href="topic.php?mod=manage&tid=<?php echo $_GET['tid'];?>" class="get" type="switch" box="mainpannel" nopage="true"><span>基础设置</span></a></li>
          <li class="c7 flex"><a href="topic.php?mod=manage&tid=<?php echo $_GET['tid'];?>&item=level" class="get" type="switch" box="level" nopage="true"><span>用户等级</span></a></li>
          <li class="c7 flex"><a href="topic.php?mod=manage&tid=<?php echo $_GET['tid'];?>&item=member" class="get" type="switch" box="member"><span>用户管理</span></a></li>
          <li class="c7 flex"><a href="topic.php?mod=manage&tid=<?php echo $_GET['tid'];?>&item=apply" class="get" type="switch" box="apply"><span>用户审核</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>
      <div class="box-area">
        <div class="box-content current ready" id="mainpannel">
          <form action="upload.php?item=cover&uptype=img&load=true&submit=true&hash=<?php echo $_S['hash'];?>" id="cover-form" style="display:none;" >
            <input type="file" id="cover-file" name="cover" accept="image/gif,image/jpeg,image/jpg,image/png">
          </form>
          <form action="upload.php?item=banner&uptype=img&load=true&submit=true&hash=<?php echo $_S['hash'];?>" id="banner-form" style="display:none;" >
            <input type="file" id="banner-file" name="banner" accept="image/gif,image/jpeg,image/jpg,image/png">
          </form>
          <form action="topic.php?mod=manage&tid=<?php echo $_GET['tid'];?>" method="post" id="<?php echo PHPSCRIPT;?>_<?php echo $_GET['mod'];?>_form" enctype="multipart/form-data">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
            <input type="hidden" name="banner" value="<?php echo $topic['banner'];?>" id="banner_val">
            <input type="hidden" name="cover" value="<?php echo $topic['cover'];?>" id="cover_val">
            <div class="setbanner">
              <?php if($topic['banner']) { ?><a class="icon icon-close b_c8 c3" href="javascript:"></a><?php } ?>
              <div class="block" id="banner">
                <a href="javascript:" class="upload banner_area" name="banner"><?php if($topic['banner']) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $topic['banner'];?>"><?php } else { ?><span class="block b_c8">点击设置Banner（640*320）</span><?php } ?></a>
              </div>
              
            </div>
            <div class="setcover">
              <a href="javascript:" class="upload" name="cover"><div class="cover_area bo o_c1 b_c3"><?php if($topic['cover']) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $topic['cover'];?>"><?php } else { ?><span></span><?php } ?></div>上传一个话题封面（140*140）</a>
            </div>
            <div class="weui-cells">
              <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">话题名称</label></div>
                <div class="weui-cell__bd">
                  <input class="weui-input" type="text" name="name" placeholder="话题名称" value="<?php echo $topic['name'];?>">
                </div>
              </div>
              <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                  <label for="" class="weui-label">加入权限</label>
                </div>
                <div class="weui-cell__bd">
                  <select class="weui-select" name="open">
                    <option value="1" <?php if($topic['open']=='1') { ?>selected<?php } ?>>直接加入无需审核</option>
                    <option value="0" <?php if($topic['open']=='0') { ?>selected<?php } ?>>需要审核</option>
                    <option value="-1" <?php if($topic['open']=='-1') { ?>selected<?php } ?>>拒绝申请</option>
                  </select>
                </div>
              </div>
              <?php if($_S['wxpay']) { ?>
              <div class="weui-cells">
                <div class="weui-cell">
                  <div class="weui-cell__hd"><label class="weui-label">付费加入</label></div>
                  <div class="weui-cell__bd">
                    <input class="weui-input" type="number" name="price" value="<?php echo $topic['price'];?>" placeholder="设置付费加入价格">
                  </div>
                  <div class="weui-cell__ft">元</div>
                </div>
              </div>
              <?php } ?>
              <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                  <label for="" class="weui-label">看帖权限</label>
                </div>
                <div class="weui-cell__bd">
                  <select class="weui-select" name="show">
                    <option value="1" <?php if($topic['show']=='1') { ?>selected<?php } ?>>开放访问</option>
                    <option value="0" <?php if($topic['show']=='0') { ?>selected<?php } ?>>仅成员可以访问</option>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                  <label for="" class="weui-label">发帖权限</label>
                </div>
                <div class="weui-cell__bd">
                  <select class="weui-select" name="addtheme">
                    <option value="1" <?php if($topic['addtheme']=='1') { ?>selected<?php } ?>>开放发帖</option>
                    <option value="0" <?php if($topic['addtheme']=='0') { ?>selected<?php } ?>>仅成员可以发帖</option>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                  <label for="" class="weui-label">回帖权限</label>
                </div>
                <div class="weui-cell__bd">
                  <select class="weui-select" name="reply">
                    <option value="1" <?php if($topic['reply']=='1') { ?>selected<?php } ?>>开放回帖</option>
                    <option value="0" <?php if($topic['reply']=='0') { ?>selected<?php } ?>>仅成员可以回帖</option>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                  <select class="weui-select" name="allowapply">
                    <option>管理团队申请权限</option>
                    <?php if(is_array($topicgroup)) foreach($topicgroup as $level => $value) { ?>                    <option value="<?php echo $level;?>"<?php if($topic['allowapply']==$level) { ?> selected<?php } ?>><?php echo $value['name'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                  <select class="weui-select" name="maxleaders">
                    <option>最大组长数</option>
                    <option value="1"<?php if($topic['maxleaders']=='1') { ?> selected<?php } ?>>一个</option>
                    <option value="2"<?php if($topic['maxleaders']=='2') { ?> selected<?php } ?>>两个</option>
                    <option value="3"<?php if($topic['maxleaders']=='3') { ?> selected<?php } ?>>三个</option>
                    <option value="4"<?php if($topic['maxleaders']=='4') { ?> selected<?php } ?>>四个</option>
                    <option value="5"<?php if($topic['maxleaders']=='5') { ?> selected<?php } ?>>五个</option>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                  <select class="weui-select" name="maxmanagers">
                    <option>最大小组长数</option>
                    <option value="1"<?php if($topic['maxmanagers']=='1') { ?> selected<?php } ?>>一个</option>
                    <option value="2"<?php if($topic['maxmanagers']=='2') { ?> selected<?php } ?>>两个</option>
                    <option value="3"<?php if($topic['maxmanagers']=='3') { ?> selected<?php } ?>>三个</option>
                    <option value="4"<?php if($topic['maxmanagers']=='4') { ?> selected<?php } ?>>四个</option>
                    <option value="5"<?php if($topic['maxmanagers']=='5') { ?> selected<?php } ?>>五个</option>
                    <option value="6"<?php if($topic['maxmanagers']=='6') { ?> selected<?php } ?>>六个</option>
                    <option value="7"<?php if($topic['maxmanagers']=='7') { ?> selected<?php } ?>>七个</option>
                    <option value="8"<?php if($topic['maxmanagers']=='8') { ?> selected<?php } ?>>八个</option>
                    <option value="9"<?php if($topic['maxmanagers']=='9') { ?> selected<?php } ?>>九个</option>
                    <option value="10"<?php if($topic['maxmanagers']=='10') { ?> selected<?php } ?>>十个</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="weui-cells__title">话题分类</div>
            <div class="weui-cells" id="themetypes">
              <?php if($topic['types']) { ?>
              <?php if(is_array($topic['types'])) foreach($topic['types'] as $id => $name) { ?>              <div class="weui-cell" id="type_<?php echo $id;?>">
                <div class="weui-cell__bd">
                  <input type="hidden" name="typeid[]" value="<?php echo $id;?>" >
                  <input class="weui-input" type="text" name="typename[]" placeholder="话题分类名称" value="<?php echo $name;?>">
                </div>
                <div class="weui-cell__ft"><a href="javascript:$('#type_<?php echo $id;?>').remove()" class="icon icon-close c9"></a></div>
              </div>          
              <?php } ?>
              <?php } else { ?>
              <div class="weui-cell" id="type_1">
                <div class="weui-cell__bd">
                  <input type="hidden" name="typeid[]" value="1" >
                  <input class="weui-input" type="text" name="typename[]" placeholder="话题分类名称">
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="b_c3 p10"><a href="javascript:topic.addthemetype();" class="c8 pl5">添加话题分类</a></div>
            <div class="weui-cells__title">列表样式风格</div>
            <div class="weui-cells">
              <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                  <select class="weui-select" name="liststype">
                    <?php if(is_array($_S['setting']['themestyle'])) foreach($_S['setting']['themestyle'] as $value) { ?>                    <option value="<?php echo $value['id'];?>" <?php if($topic['liststype']==$value['id']) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
                    <?php } ?>
                  </select>
                </div>
               </div>
            </div>
            
            <div class="weui-cells__title">话题简介</div>
            <div class="weui-cells weui-cells_form">
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <textarea class="weui-textarea" name="about" placeholder="请输入话题简介" maxlength="200" rows="3"><?php echo $topic['about'];?></textarea>
                </div>
              </div>
            </div>
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">设置话题</button></div>
          </form>      
        </div>
        <div class="box-content" id="level" style="display:none"></div>
        <div class="box-content" id="apply" style="display:none"></div>
        <div class="box-content" id="member" style="display:none"></div>
      </div>
      <div id="page"></div>


    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
    var typeid=<?php echo $typeid;?>;
  $(document).ready(function() {	
      SMS.translate_int();
});

  </script>
  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>