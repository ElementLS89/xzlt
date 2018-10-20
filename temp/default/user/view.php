<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header flexbox transparent c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$user['username']</div>
      <div class="header-r"><a href="javascript:SMS.opensheet('#usersheet')" class="icon icon-more"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_0 $outback">
      <div class="usertop" id="viewuser_$uid">
        <a class="usertop-bg{if $user['uid']==$_S['uid']} load{/if}" {if $user['uid']==$_S['uid']}href="set.php?type=spacecover"{/if} {if $user['spacecover']}style="background-image:url($user['spacecover']);"{/if}></a>
        
        <div class="usertop-btn b_c3">
          <!--{if $uid!=$_S['uid']}-->
          <a href="user.php?mod=action&action=follow&uid=$uid" class="weui-btn weui-btn_mini weui-btn_default load{if $isfollow} c2{/if}" id="follow_$uid" loading="tab">{if $isfollow}取消关注{else}关注{/if}</a>
          <!--{else}-->
          <a href="my.php?mod=profile" class="weui-btn weui-btn_mini weui-btn_default load">设置</a>
          <!--{/if}-->
          <!--{if !$_S['setting']['closebbs']}-->
          <!--{if $isfriend=='-1'}-->
          <a href="javascript:" class="weui-btn weui-btn_mini weui-btn_default c2" id="addfriend_$uid">待审核</a>
          <!--{elseif !$isfriend && $_S['uid']!=$uid}-->
          <a href="user.php?mod=action&action=add&uid=$uid" class="weui-btn weui-btn_mini weui-btn_default load" id="addfriend_$uid">加好友</a>
          <!--{elseif $isfriend=='1'}-->
          <a href="my.php?mod=talk&tid=$tid" class="weui-btn weui-btn_mini weui-btn_primary load" id="addfriend_$uid">发消息</a>
          <!--{/if}-->
          <!--{/if}-->
        </div>
        
        <div class="water"><div class="water_1"></div><div class="water_2"></div></div>
        <!--{avatar($user,2)}-->
        
      </div>
      
      <div class="usermiddle b_c3">
        <h3>$user['username']<span class="bo o_c2 c1 s12">$user['group']</span></h3>
      </div>
      <p class="userbottom b_c3 bob o_c3 c6"><a href="javascript:SMS.opensheet('#usersheet')" class="r">更多&gt;&gt;</a><a href="user.php?mod=follow&show=follow&uid=$_GET[uid]" class="load"><strong class="c8" id="follows_$uid">$user['follow']</strong>关注</a><a href="user.php?mod=follow&show=fans&uid=$uid" class="load"><strong class="c8" id="fans_$uid">$user['fans']</strong>粉丝</a></p>
      <!--{if !$_S['setting']['closebbs']}-->
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          
          <!--{if $_S['uid']==$uid}-->
          <li class="c1 flex"><a href="user.php?uid=$uid" class="get" type="switch" box="uv_{$uid}"><span>朋友圈</span></a></li>
          <li class="c7 flex"><a href="user.php?uid=$uid&show=my" class="get" type="switch" box="uv_{$uid}my"><span>我的</span></a></li>
          <li class="c7 flex"><a href="user.php?uid=$uid&show=follow" class="get" type="switch" box="uv_{$uid}follow"><span>关注</span></a></li>
          
          <!--{else}-->
          <li class="c1 flex"><a href="user.php?uid=$uid" class="get" type="switch" box="uv_{$uid}"><span>动态</span></a></li>
          <!--{/if}-->
          <!--{if $_S['dz'] && $user['dzuid']}-->
          <li class="c7 flex"><a href="user.php?uid=$uid&show=sms" class="get" type="switch" box="uv_{$uid}sms"><span>日记</span></a></li>
          <!--{/if}-->
          <li class="c7 flex"><a href="javascript:SMS.null(1)" class="get" type="switch" box="uv_{$uid}profile"><span>资料</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>
      <!--{/if}-->
      <div class="box-area">
        <!--{if !$_S['setting']['closebbs']}-->
        <div class="box-content current ready" id="uv_{$uid}">
          <!--{template user/view_ajax}-->
        </div>
        <div class="box-content" id="uv_{$uid}follow" style="display:none"></div>
        <div class="box-content" id="uv_{$uid}my" style="display:none"></div>
        <!--{if $_S['dz'] && $user['dzuid']}--><div class="box-content" id="uv_{$uid}sms" style="display:none"></div><!--{/if}-->
        <!--{/if}-->
        <div class="box-content ready" id="uv_{$uid}profile" {if !$_S['setting']['closebbs']}style="display:none"{/if}>
          
          <div class="weui-cells__title">用户信息</div>
          <div class="weui-cells">
            <a href="my.php?mod=group&gid=$user['groupid']&uid=$uid" class="weui-cell weui-cell_access load">
              <div class="weui-cell__hd c4"><label class="weui-label">用户组</label></div>
              <div class="weui-cell__bd">$_S['cache']['usergroup'][$user['groupid']]['name']</div>
              <div class="weui-cell__ft"></div>
            </a>
            <!--{if $_S['uid']==$uid}-->
            <a href="my.php?mod=account" class="weui-cell weui-cell_access load">
            <!--{else}-->
            <div class="weui-cell weui-cell_access">
            <!--{/if}-->
              <div class="weui-cell__hd c4"><label class="weui-label">经验值</label></div>
              <div class="weui-cell__bd">$user['experience']</div>
              <div class="weui-cell__ft"></div>
            <!--{if $_S['uid']==$uid}--></a><!--{else}--></div><!--{/if}-->       
          </div>
          <!--{if $user['profile'] || $_S['uid']==$uid}-->
          <div class="weui-cells__title">基本资料</div>
          <div class="weui-cells">
            <!--{loop $_S['cache']['userfield'] $field $value}-->
            <!--{if $value['canuse'] && $value['position']==1}-->
            <div class="weui-cell weui-cell_access">
              <div class="weui-cell__hd c4"><label class="weui-label">$value['name']</label></div>
              <div class="weui-cell__bd">$user[$field]</div>
            </div>
            <!--{/if}-->
            <!--{/loop}-->       
          </div>
          <div class="weui-cells__title">工作信息</div>
          <div class="weui-cells">
            <!--{loop $_S['cache']['userfield'] $field $value}-->
            <!--{if $value['canuse'] && $value['position']==3}-->
            <div class="weui-cell weui-cell_access">
              <div class="weui-cell__hd c4"><label class="weui-label">$value['name']</label></div>
              <div class="weui-cell__bd">$user[$field]</div>
            </div>
            <!--{/if}-->
            <!--{/loop}-->    
          </div>
          <div class="weui-cells__title">其他信息</div>
          <div class="weui-cells">
            <!--{loop $_S['cache']['userfield'] $field $value}-->
            <!--{if $value['canuse'] && $value['position']==2}-->
            <div class="weui-cell weui-cell_access">
              <div class="weui-cell__hd c4"><label class="weui-label">$value['name']</label></div>
              <div class="weui-cell__bd">$user[$field]</div>
            </div>
            <!--{/if}-->
            <!--{/loop}-->    
          </div>
          <!--{loop $_S['cache']['userfield'] $field $value}-->
          <!--{if $value['canuse'] && $value['position']==4}-->
          <div class="weui-cells__title">$value['name']</div>
          <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
              <div class="weui-cell__bd">$user[$field]</div>
            </div>        
          </div>
          <!--{/if}-->
          <!--{/loop}-->
          
          <!--{else}-->
          <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">对方未公开个人资料</span></div>
          <!--{/if}-->
        </div>
      </div>
      <!--{if !$_S['setting']['closebbs']}-->
      <div id="page">
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#uv_{$uid}"><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->
      </div>
      <!--{/if}-->
      <div class="weui-actionsheet" id="usersheet">
        <div class="weui-actionsheet__menu">
          <!--{if $isfriend}-->
          <a href="user.php?mod=action&action=delete&uid=$uid" class="weui-actionsheet__cell c6 load" id="delete_$uid">删除好友</a>
          <!--{/if}-->
          <!--{if $isblack}-->
          <a href="user.php?mod=action&action=deleteblack&uid=$uid" class="weui-actionsheet__cell c6 load" id="black_$uid">移出黑名单</a>
          <!--{elseif !$isblack && $_S['uid'] && $_S['uid']!=$uid}-->
          <a href="user.php?mod=action&action=addblack&uid=$uid" class="weui-actionsheet__cell c6 load" id="black_$uid">加入黑名单</a>
          <!--{/if}-->
          
          <!--{if $isfriend}-->
          <a href="user.php?mod=action&action=friendtype&uid=$uid" class="weui-actionsheet__cell c6 load">设置分组</a>
          <!--{/if}-->
          <a href="user.php?mod=action&action=qrcode&uid=$uid" class="weui-actionsheet__cell c6 load">二维码</a>
          <!--{if $_S['uid'] && $_S['uid']!=$uid}-->
          <a href="index.php?mod=feed&type=3&ref=user.php?uid=$_GET[uid]" class="weui-actionsheet__cell c6 load">举报</a>
          <!--{/if}-->
        </div>
        <div class="weui-actionsheet__action">
          <a href="javascript:" class="weui-actionsheet__cell c1">取消</a>
        </div>
      </div>


    </div>
  </div>
  <div id="footer"> 
  <!--{if $_S['uid']==$uid && !$_S['setting']['closebbs']}-->
  <a href="topic.php?mod=post" class="icon icon-write addtopic b_c8 load"></a>
  <!--{/if}-->
  
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
	  $(document).ready(function() {
      SMS.translate_int()
		});
  </script>
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->