<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <div class="weui-cells">
        <a class="weui-cell weui-cell_access" href="javascript:SMS.openlayer('setstyle');">
          <div class="weui-cell__bd">
            <p>风格配色</p>
          </div>
          <div class="weui-cell__ft" id="colorname">$_S['cache']['colors'][$cid]['name']</div>
        </a>
      </div>

      <div class="weui-cells">
        <a class="weui-cell weui-cell_access" href="javascript:SMS.clear()">
          <div class="weui-cell__bd">
            <p>清空数据缓存</p>
          </div>
          <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="javascript:;">
          <div class="weui-cell__bd">
            <p>当前版本</p>
          </div>
          <div class="weui-cell__ft">$_S['setting']['version']</div>
        </a>
        <a class="weui-cell weui-cell_access load" href="index.php?mod=feed">
          <div class="weui-cell__bd">
            <p>我有建议</p>
          </div>
          <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access load" href="index.php?mod=agreement">
          <div class="weui-cell__bd">
            <p>用户协议</p>
          </div>
          <div class="weui-cell__ft"></div>
        </a>
      </div>
      <div class="weui-msg__extra-area">
        <div class="weui-footer">
          <p class="weui-footer__links"> <span class="weui-footer__link">Copyright &copy; 2017-2027 Smsot {$_S['setting']['version']}</span> </p>
          <p class="weui-footer__text">$_S['setting']['sitename']</p>
        </div>      
      </div>

      <div id="layer">
      <!--{template set/setstyle}-->
      </div>
    </div>
  </div>
  <div id="footer">
  
  </div>
</div>
<div id="smsscript">
	<script language="javascript">
    function selectstyle(color){
      $('#setstyle .layer_header').css({'background':color});
      $('#setstyle .weui-btn_primary').css({'background':color});
    }
  </script>
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->