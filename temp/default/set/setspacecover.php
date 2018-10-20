<?exit?>
<div class="layer_header layer_header_abs c3"><a href="javascript:SMS.openlayer('setspacecover')" class="icon icon-close"></a><span>预览</span></div>

<div class="usertop bob o_c3">
  <div class="usertop-bg"></div>
  <div class="usertop-text b_c3">
    $_S['member']['username']
  </div>
  <div class="water"><div class="water_1"></div><div class="water_2"></div></div>
  <!--{avatar($_S['member'],2)}-->
</div>
<form action="set.php?type=spacecover" method="post" id="spacecover-form" enctype="multipart/form-data">
  <input name="submit" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="tid" type="hidden" value="" id="spacecover_tid" />
  <input name="cid" type="hidden" value="" id="spacecover_cid"/>
  <input type="file" id="spacecover-file" name="cover" accept="image/gif,image/jpeg,image/jpg,image/png" style="display:none">
  <div class="selectcover-btn"><div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">使用</button></div></div> 
</form>
<div class="scrollx selectcover b_c3 bot o_c3">
  <div class="scrollx_area">
    <ul class="c">
    </ul>          
  </div>
</div>