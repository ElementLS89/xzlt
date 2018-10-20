<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 c3 flexbox">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback" nocache="true">
      <!--{if !$_GET['ac']}-->
      <div class="reply flexbox pt10 pb10 bob o_c3 b_c3">
        <div class="reply_user">
        <a href="user.php?uid=$reply[uid]" class="load"><!--{avatar($reply,1)}--></a>
        </div>
        <div class="reply_content flex" id="reply_$reply['pid']">
          <h3><a href="user.php?uid=$reply[uid]" class="c8 load">$reply['username']</a></h3>
          <div class="weui-article">
          $reply['content']
          </div>
          <p class="pt10 s13"><span class="c4">{date($reply['dateline'],'Y-m-d H:i:s')}</span></p>
        </div>
      </div>
      <div class="weui-cells__title pb10">全部评论</div>
      <div class="replys b_c3 bot o_c3" id="replylist">
        <!--{loop $list $value}-->
        <!--{template reply/reply_ajax}-->
        <!--{/loop}-->
      </div> 
      
      <!--{else}-->
      <form action="reply.php?mod=$_GET['mod']&ac=$_GET['ac']&s=$_GET['s']" method="post" id="{PHPSCRIPT}_{$_GET['mod']}_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <input name="pid" type="hidden" value="$_GET['pid']" />
        <input name="vid" type="hidden" value="$_GET['vid']" />

        <div class="weui-cells__title">评论内容</div>
        <div class="weui-cells weui-cells_form">
          
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea" name="content" placeholder="请输入.." rows="3" id="postmessage">{if $_GET['ac']=='ed'}$reply['content']{/if}</textarea>
            </div>
          </div>
        </div>
        <div class="smiles b_c5">
          <ul class="cl">
            <!--{loop $_S['cache']['smiles'][1] $value}-->
            <li><a href="javascript:SMS.smile('$value['str']')"><img src="$value['pic']" /></a></li>
            <!--{/loop}-->
          </ul>
        </div>
        <div class="p10 bob o_c1 b_c2 bot cl">
          <span class="s14 c4">随机展示的小贴士</span>
          <button type="button" class="weui-btn weui-btn_mini weui-btn_primary r formpost">提交</button>
        </div>
      </form>      
      <!--{/if}-->

    </div>
  </div>
  <div id="footer">
    <!--{if !$_GET['ac']}-->
    <div class="footer b_c2 bot o_c1">
      <ul class="send flexbox">
        <li class="flex message pl15"><a href="reply.php?mod=$_GET['mod']&ac=rp&s=l&vid=$_GET['vid']&pid=$reply['pid']" class="bo o_c1 b_c3 c4 load" loading="tab">写评论...</a></li>
        <li class="btn" id="replypraise_{$reply[pid]}"><a href="reply.php?mod=$_GET['mod']&ac=praise&vid=$_GET[vid]&pid=$reply[pid]&po=b" class="icon icon-praise load" loading="tab"></a>{if $reply['praise']}<span class="weui-badge">$reply['praise']</span>{/if}</li>
      </ul>
    </div>
    <!--{/if}-->
  </div>
</div>
<div id="smsscript">
  <!--{if $_GET['ac']}-->
  <script language="javascript" reload="1">
	  $(document).ready(function() {
			if($('.smiles').css('padding-left')=='0px'){
				$('.smiles').css('padding-left', (((window.innerWidth-10)%46)/2)+'px');
			}
			$('body').scrollTop($("body").height());
		});
  </script>
  <!--{/if}-->
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>

<!--{template footer}-->