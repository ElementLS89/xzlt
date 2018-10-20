<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
    
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="flex c1"><a href="discuz.php?mod=index" class="get" type="switch" box="forum"><span>板块</span></a></li>
          <li class="flex c7"><a href="discuz.php?mod=index&show=new" class="get" type="switch" box="new"><span>最新</span></a></li>
          <li class="flex c7"><a href="discuz.php?mod=index&show=best" class="get" type="switch" box="best"><span>推荐</span></a></li>
          <li class="flex c7"><a href="discuz.php?mod=index&show=pics" class="get" type="switch" box="pics"><span>图集</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>
      <div class="box-area">
        <div class="box-content current ready" id="forum">
          <!--{if $_S['cache']['slider']['forum']}-->
          <div class="swiper">
            <div class="swiper-wrapper">
              <!--{loop $_S['cache']['slider']['forum'] $value}-->
              <div class="swiper-slide b_f tc flex_box"><a href="$value['url']" class="load"><img src="{$_S['atc']}/{$value['pic']}"/></a></div>
              <!--{/loop}-->
            </div>
            <div class="swiper-pagination"></div>
          </div>
          <!--{/if}-->
          <!--{if $_S['cache']['announcement']}-->
          <div class="announcement b_c3 bob o_c3 flexbox">
            <span class="c9">公告</span>
            <div>
              <ul class="flex s15">
                <!--{loop $_S['cache']['announcement'] $value}-->
                <li><a href="index.php?mod=announcement&aid=$value['aid']" class="load">$value['subject']</a></li>
                <!--{/loop}-->
              </ul>            
            </div>
          </div>
          <!--{/if}-->
          <!--{loop $groups $group}-->
          <!--{if $forums[$group[fid]]}-->
          <div class="box b_c3 mt10" id="group_$group['fid']">
            <h3 class="box_title bob o_c3 cl"><a href="javascript:collapsed('group_{$group[fid]}')" class="r icon icon-collapsed-no c4"></a><span class="c4"><em class="b_c1"></em>$group['name']</span></h3>
            <div class="users">
              <!--{loop $forums[$group[fid]] $forum}-->
              <a href="discuz.php?mod=forum&fid=$forum['fid']" class="weui-cell load">
                <div class="weui-cell__hd"><img src="$forum['icon']"><!--{if $forum['todayposts']}--><span class="weui-badge">$forum['todayposts']</span><!--{/if}--></div>
                <div class="weui-cell__bd">
                  <h4>$forum['name']</h4>
                  <!--{if $forum['description']}-->
                  <p class="c4">$forum['description']</p>
                  <!--{elseif $forum['lastpost'][1]}-->
                  <p class="c8">$forum['lastpost'][1]</p>
                  <!--{else}-->
                  <p class="c4">本版暂无帖子发布</p>
                  <!--{/if}-->
                </div>
                <div class="weui-cell__ft"></div>
              </a>
              <!--{/loop}-->
            </div>
          </div>
          <!--{/if}-->
          <!--{/loop}-->
        </div>
        <div class="box-content" id="new" style="display:none"></div>
        <div class="box-content" id="best" style="display:none"></div>
        <div class="box-content" id="pics" style="display:none"></div>
      </div>
      <div id="page"></div>
    </div>
  </div>
  <div id="footer"> 
  <!--{template tabbar}-->
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
	  $(document).ready(function() {
			<!--{if $_S['cache']['announcement']}-->
			$(function(){
				setInterval('SMS.autoscroll(".currentbody .announcement")',3000)
			});
			<!--{/if}-->
			<!--{if $_S['cache']['slider']['forum']}-->
			var swiper = new Swiper('.currentbody .swiper', {
				pagination: {el: '.currentbody .swiper-pagination'},
				autoplay: {delay: 3000}
			});
			<!--{/if}-->
      SMS.translate_int();
		});
  </script>
  <script language="javascript">
    function collapsed(id){
			if($('#'+id+' .users').css('display')=='none'){
				$('#'+id+' .users').css('display','');
				$('#'+id+' .icon').removeClass('icon-collapsed-yes').addClass('icon-collapsed-no');
			}else{
				$('#'+id+' .users').css('display','none');
				$('#'+id+' .icon').removeClass('icon-collapsed-no').addClass('icon-collapsed-yes');
			}
		}
  </script>
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->