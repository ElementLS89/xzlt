<?exit?>
<!--{if $_S['in_wechat']}-->
<script language="javascript" reload="1" id="wechat_shar">
  setTimeout(function(){
		wx.ready(function(){
			<!--{if !$signature || $noshar}-->
			//wx.hideOptionMenu();
			<!--{else}-->
			//wx.showOptionMenu();
			var sharedata = {
				title: '$title',
				desc: '$_S[shar][desc]',
				link: window.location.href.split('#')[0],
				imgUrl: '$_S[shar][pic]',
				success: function (res) {SMS.toast('分享成功');}
			};
			wx.onMenuShareAppMessage(sharedata);
			wx.onMenuShareQQ(sharedata);
			wx.onMenuShareWeibo(sharedata);
			wx.onMenuShareQZone(sharedata);
			wx.onMenuShareTimeline(sharedata);
			<!--{/if}-->
		});		
		
	},1000);


</script>
<!--{/if}-->