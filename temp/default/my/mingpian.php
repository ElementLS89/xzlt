<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><a href="javascript:SMS.closepage()" class="icon icon-close"></a></div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_t $outback">
    
      <div class="weui-cells" id="mingpianlist">
        <a href="javascript:SMS.list('my.php?mod=friend','mingpian_t0')" class="weui-cell weui-cell_listopen" id="mingpian_t0">
          <div class="weui-cell__hd open"></div>
          <div class="weui-cell__bd c6">我的好友</div>
          <div class="weui-cell__ft">$friendnum</div>
        </a>
        <div class="users ml15 hasvar" id="list_mingpian_t0">
        <!--{template my/mingpian_ajax}-->
        </div>
        <!--{loop $friendtype $value}-->
        <a href="javascript:SMS.list('my.php?mod=friend&typeid=$value[typeid]','mingpian_t{$value['typeid']}')" class="weui-cell weui-cell_listopen" id="mingpian_t{$value['typeid']}">
          <div class="weui-cell__hd"></div>
          <div class="weui-cell__bd c6">$value['name']</div>
          <div class="weui-cell__ft">$value['number']</div>
        </a>
        <div class="friends ml15" id="list_mingpian_t{$value['typeid']}"></div>
        <!--{/loop}-->
      </div>
    
    </div>
  </div>
  <div id="footer"> 

  </div>
</div>
<div id="smsscript">
<!--{template wechat_shar}-->
</div>
<!--{template footer}-->