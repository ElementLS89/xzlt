<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$mygroup['name']</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_t $outback" nocache="true">
      <!--{if $_GET['showlog']}-->
      <div class="autolist b_c3">
      <!--{template my/group_ajax}-->
      </div>
      <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
      <!--{else}-->
      <!--{if $_S['uid']==$_GET['uid']}-->
      <div class="weui-cells">
        <a class="weui-cell weui-cell_access load" href="my.php?mod=group&showlog=true">
          <div class="weui-cell__bd"><p>经验值</p></div>
          <div class="weui-cell__ft">$my['experience']</div>
        </a>
      </div>
      <!--{/if}-->
      <div class="weui-cells__title">用户权限</div>
      <div class="weui-cells">
        <div class="weui-cell">
          <div class="weui-cell__bd">用户组</div>
          <div class="weui-cell__ft">$mygroup['name']</div>
        </div>     
        <div class="weui-cell">
          <div class="weui-cell__bd">允许访问</div>
          <div class="weui-cell__ft"><em class="icon {if $mygroup['allowvisit']==1}icon-yes c1{else}icon-no{/if}"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许发帖</div>
          <div class="weui-cell__ft"><em class="icon {if $mygroup['allowaddtheme']==1}icon-yes c1{else}icon-no{/if}"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许回帖</div>
          <div class="weui-cell__ft"><em class="icon {if $mygroup['allowreply']==1}icon-yes c1{else}icon-no{/if}"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许创建话题数</div>
          <div class="weui-cell__ft">$mygroup['allowcreattopic']个</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">创建话题免审核</div>
          <div class="weui-cell__ft"><em class="icon {if $mygroup['examinetopic']==1}icon-no{else}icon-yes c1{/if}"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许添加好友</div>
          <div class="weui-cell__ft"><em class="icon {if $mygroup['allowaddfriend']==1}icon-yes c1{else}icon-no{/if}"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许发送消息</div>
          <div class="weui-cell__ft"><em class="icon {if $mygroup['allowsendmessage']==1}icon-yes c1{else}icon-no{/if}"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">允许点赞</div>
          <div class="weui-cell__ft"><em class="icon {if $mygroup['allowpraise']==1}icon-yes c1{else}icon-no{/if}"></em></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__bd">发帖免审核</div>
          <div class="weui-cell__ft"><em class="icon {if $mygroup['examinetheme']==1}icon-no{else}icon-yes c1{/if}"></em></div>
        </div>
        <!--{if $mygroup['creditshigher']}-->
        <div class="weui-cell">
          <div class="weui-cell__bd">升级所需经验</div>
          <div class="weui-cell__ft">$mygroup['creditshigher']</div>
        </div>
        <!--{/if}-->
        
      </div>
      <!--{/if}-->

      
          
    </div>
  </div>
  <div id="footer"> 
  
  </div>
</div>
<div id="smsscript">
<!--{template wechat_shar}-->
</div>
<!--{template footer}-->