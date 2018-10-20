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
    <div class="smsbody $outback" nocache="true">
    <form method="post"  enctype="multipart/form-data">
      <input name="file" type="file" />
      <input type="submit" value="上传"/>
    </form>
    
    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">

</div>

<!--{template footer}-->