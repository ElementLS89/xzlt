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
      <form action="index.php?mod=feed" method="post" id="feed_post">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
        <?php if($_GET['ref']) { ?>
        <input name="type" type="hidden" value="3" />
        <input name="ref" type="hidden" value="<?php echo $_GET['ref'];?>" />
        <div class="weui-cells__title">举报内容</div>
        <div class="weui-cells weui-cells_radio">
          <label class="weui-cell weui-check__label" for="c1">
            <div class="weui-cell__bd">
              <p>广告垃圾</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" class="weui-check" name="content" value="广告垃圾" id="c1">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
          <label class="weui-cell weui-check__label" for="c1">
            <div class="weui-cell__bd">
              <p>色情暴力</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" class="weui-check" name="content" value="色情暴力" id="c2">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
          <label class="weui-cell weui-check__label" for="c1">
            <div class="weui-cell__bd">
              <p>迷信邪教</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" class="weui-check" name="content" value="迷信邪教" id="c3">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
          <label class="weui-cell weui-check__label" for="c1">
            <div class="weui-cell__bd">
              <p>反动政治</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" class="weui-check" name="content" value="反动政治" id="c4">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
          <label class="weui-cell weui-check__label" for="c1">
            <div class="weui-cell__bd">
              <p>恶意灌水</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" class="weui-check" name="content" value="恶意灌水" id="c4">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
        </div>
        <?php } else { ?>
        <div class="weui-cells__title">反馈类型</div>
        <div class="weui-cells weui-cells_radio">
          <label class="weui-cell weui-check__label" for="type1">
            <div class="weui-cell__bd">
              <p>BUG报告</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" class="weui-check" name="type" value="1" id="type1">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
          <label class="weui-cell weui-check__label" for="type2">
            <div class="weui-cell__bd">
              <p>意见建议</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" name="type" class="weui-check" id="type2" value="2">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
        </div>
        <div class="weui-cells__title">反馈内容</div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea" name="content" placeholder="输入反馈内容" maxlength="200" rows="3"></textarea>
            </div>
          </div>
        </div>
        <?php } ?>
        
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">提交</button></div>
      </form>

    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">

</div><?php include temp('footer'); ?>