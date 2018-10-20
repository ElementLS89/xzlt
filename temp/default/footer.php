<?exit?>
  <div id="sharpic" style="display:none">$_S[shar][pic]</div>
  <div id="wxconfig" style="display:none">
    <!--{if $_S['in_wechat']}-->
    <input type="hidden" id="url" value="{eval echo(getrequest())}" />
    <input type="hidden" id="wx_appid" value="$_S[setting][wx_appid]" />
    <input type="hidden" id="wx_timestamp" value="$_S[timestamp]" />
    <input type="hidden" id="wx_noncestr" value="$_S[hash]" />
    <input type="hidden" id="wx_signature" value="$signature" />
    <input type="hidden" id="wx_jsapilist" value="$apilist" />
    <!--{else}-->
    <input type="hidden" id="notinweixin" value="true" />
    <!--{/if}-->
  </div>
</div>

<!--{if !$_GET['load']}-->
<div id="rightpannel">
  <!--{if $_S['app']['hideheader']}-->
  <a href="javascript:SMS.showheader('$_S['app']['body']')" class="icon icon-showheader mainpannel"></a>
  <!--{/if}-->
  <!--{if !$_SERVER['HTTP_REFERER']}-->
  <a href="javascript:SMS.openside()" class="icon icon-openside mainpannel"></a>
  <!--{/if}-->
  <!--{hook/footer_right}-->
  <div id="newmsg">
  <!--{if $_S['member']['newnotice']}-->
  <a href="my.php?mod=notice" class="newmsg icon icon-newnotice load"><span class="weui-badge">$_S['member']['newnotice']</span></a>
  <!--{elseif $_S['member']['newmessage']}-->
  <a href="my.php?mod=message" class="newmsg icon icon-newmsg load"><span class="weui-badge">$_S['member']['newmessage']</span></a>
  <!--{elseif $_S['member']['newfriend']}-->
  <a href="my.php?mod=newfriend" class="newmsg icon icon-newfriend load"><span class="weui-badge">$_S['member']['newfriend']</span></a>
  <!--{/if}-->
  </div>  
</div>
<div id="leftpannel">
<!--{hook/footer_left}-->
<a href="javascript:SMS.back()" class="icon icon-back mainpannel"></a>
</div>
<div id="mask" style="display:none"></div>
<div id="loading" style="display:none"></div>
<div id="loadpage" class="b_c3" style="display:none;-webkit-transform:translateX(100%);-webkit-transition:-webkit-transform 0s 0s;"><div class="loadingpage"><span class="l1"></span><span class="l2"></span><span class="l3"></span></div></div>
<div id="sidenv" class="c3" style="display:none;-webkit-transform:translateX(100%);-webkit-transition:-webkit-transform 0s 0s;">
  <div class="sidenv-content">
    <div class="side-user">
      <!--{if $_S['member']['uid']}-->
      <a href="user.php" class="load"><!--{avatar($_S['member'],2)}-->
      <h3 id="side-username">$_S['member']['username']</h3></a>
      <!--{else}-->
      <a href="member.php" class="load"><img src="ui/avatar_2.jpg" />
      <h3>登录</h3></a>
      <!--{/if}-->
    </div>
    <div class="side-nv">
      <ul>
        <!--{loop $_S['cache']['navs']['nav_side'] $value}-->
        <!--{if $_S['setting']['closebbs'] && in_array($value['url'],array('topic.php','topic.php?mod=forum','topic.php?mod=post','discuz.php'))}-->
        <!--{eval $value['close']=true;}-->
        <!--{/if}-->
        <!--{if $value['canuse'] && !$value['close']}-->
        <li><a href="$value['url']" class="load $value['icon']">$value['name']</a></li>
        <!--{/if}-->
        <!--{/loop}-->
      </ul>
    </div>
    <div class="side-btn flexbox">
    <!--{if $_S['member']['uid']}-->
    <a href="set.php" class="flex load icon-set">设置</a><a href="member.php?mod=out" class="flex load icon-out">退出</a>
    <!--{else}-->
    <a href="member.php" class="flex load icon-login">登录</a><a href="member.php?mod=reg" class="flex load icon-reg">注册</a>
    <!--{/if}-->
    </div>
  </div>
</div>

</body>
</html>
<!--{/if}-->