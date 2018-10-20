
<?php if($_S['in_wechat']) { ?>
<script language="javascript" reload="1" id="wechat_shar">
  setTimeout(function(){
wx.ready(function(){
<?php if(!$signature || $noshar) { ?>
//wx.hideOptionMenu();
<?php } else { ?>
//wx.showOptionMenu();
var sharedata = {
title: '<?php echo $title;?>',
desc: '<?php echo $_S['shar']['desc'];?>',
link: window.location.href.split('#')[0],
imgUrl: '<?php echo $_S['shar']['pic'];?>',
success: function (res) {SMS.toast('分享成功');}
};
wx.onMenuShareAppMessage(sharedata);
wx.onMenuShareQQ(sharedata);
wx.onMenuShareWeibo(sharedata);
wx.onMenuShareQZone(sharedata);
wx.onMenuShareTimeline(sharedata);
<?php } ?>
});		

},1000);


</script>
<?php } ?>