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
    <div class="smsbody body_t $outback">
      <div class="full p15 b_c3">
        <h1 class="article_title">$announcement['subject']</h1>
        
        <div class="weui-article">
         $announcement['content']
        </div>
      </div>
    
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
<!--{template wechat}-->
<!--{template wechat_shar}-->
</div>
<!--{template footer}-->
  