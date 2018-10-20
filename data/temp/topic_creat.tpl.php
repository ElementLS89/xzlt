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
      <form action="topic.php?mod=creat" method="post" id="<?php echo PHPSCRIPT;?>_<?php echo $_GET['mod'];?>_form" enctype="multipart/form-data">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
        <div class="setcover">
          <a href="javascript:" class="upload" name="cover"><div class="cover_area bo o_c1 b_c3"><span></span></div>上传一个话题封面（140*140）</a>
        </div>
        <input type="hidden" name="cover" value="" id="cover_val">
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="name" placeholder="话题名称">
            </div>
          </div>
        </div>
        <div class="weui-cells">
          <div class="weui-cell weui-cell_select">
            <div class="weui-cell__bd">
              <select class="weui-select" name="typeid">
                <option value="">请选择话题所属类别</option>
                <?php if(is_array($_S['cache']['topic_types'])) foreach($_S['cache']['topic_types'] as $type) { ?>                <option value="<?php echo $type['typeid'];?>"><?php echo $type['name'];?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="weui-cells__title">话题简介</div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea" name="about" placeholder="请输入话题简介" maxlength="200" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">创建话题</button></div>
      </form>
      <form action="upload.php?item=cover&uptype=img&load=true&submit=true&hash=<?php echo $_S['hash'];?>" id="cover-form" style="display:none;" >
        <input type="file" id="cover-file" name="cover" accept="image/gif,image/jpeg,image/jpg,image/png">
      </form>
    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript"><?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>