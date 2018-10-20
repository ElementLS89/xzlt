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
    <div class="smsbody body_t $outback" nocache="true">
      <div class="weui-cells users">
        <!--{loop $list $value}-->
        <a href="user.php?mod=action&action=adopt&aid=$value['aid']" class="weui-cell load" id="apply_{$value['aid']}">
          <div class="weui-cell__hd">{avatar($value['user'],2)}</div>
          <div class="weui-cell__bd">
            <h4 class="c6">$value['username']</h4>
            <p class="c4">$value['message']</p>
          </div>          
          <div class="weui-cell__ft">
            <!--{if $value['state']}-->
            <span class="c2 s12">已同意</span>
            <!--{else}-->
            <span class="weui-btn weui-btn_mini weui-btn_primary">同意</span>
            <!--{/if}-->
          </div>
        </a>
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



  
  
    
    
  
