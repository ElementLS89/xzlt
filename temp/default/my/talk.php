<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><a href="javascript:history.back(-1)" class="icon icon-back"></a></div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="user.php?uid=$touid" class="icon icon-user load"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback" nocache="true">
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block" curpage="$_S['page']" total="$maxpage" method="prepend"><span class="weui-loadmore__tips">历史聊天记录</span></a>
      <!--{/if}-->
      <div class="messagelist autolist" id="talkview_{$_GET[tid]}">
      <!--{template my/talk_ajax}-->
      </div>
      <div id="layer">
      <!--{template my/sendmessage}-->
      </div>
      <form action="send.php?tid=$_GET[tid]&load=true&submit=true&hash=$_S['hash']" id="talk-form" style="display:none;" >
        <input type="file" id="talk-file" name="talk" accept="image/gif,image/jpeg,image/jpg,image/png">
      </form>
    </div>
  </div>
  <div id="footer">
    <div class="footer b_c2 bot o_c1">
      <ul class="send flexbox">
        <!--<li class="btn c5"><a href="" class="icon icon-recording"></a></li>-->
        <li class="flex message pl15"><a href="javascript:SMS.openlayer('sendmessage');SMS.setfocus('#sendmessage #postmessage');" class="bo o_c1 b_c3"></a></li>
        <li class="btn c5"><a href="javascript:SMS.openlayer('sendmessage');" class="icon icon-smile"></a></li>
        <li class="btn c5"><a href="javascript:$('.moreadd').toggle()" class="icon icon-add"></a></li>
      </ul>
      <ul class="moreadd c5 flexbox tc" style="display:none">
        <li class="flex"><a href="javascript:" class="upload" name="talk"><span class="icon icon-pic bo o_c1 b_c3"></span><br />图片</a></li>
        <!--<li class="flex"><a href=""><span class="icon icon-video bo o_c1 b_c3"></span><br />视频</a></li>-->
        <li class="flex"><a href="my.php?mod=hongbao&touid=$touid" class="load"><span class="icon icon-red bo o_c1 b_c3"></span><br />红包</a></li>
        <li class="flex"><a href="my.php?mod=mingpian&touid=$touid" class="load"><span class="icon icon-card bo o_c1 b_c3"></span><br />名片</a></li>
      </ul>
    </div>
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
	  $(document).ready(function() {
			if($('.smiles').css('padding-left')=='0px'){
				$('.smiles').css('padding-left', (((window.innerWidth-10)%46)/2)+'px');
			}
			$('body').scrollTop($("body").height());
		});
		$('#friend_$touid .weui-badge').remove();
		$('#talk_$_GET[tid] .weui-badge').remove();
		SMS.upcount('.icon-newmsg','reduce',$user['newmessage']);
		SMS.upcount('#my_newmessage .weui-cell__bd','reduce',$user['newmessage']);
		
  </script>
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->