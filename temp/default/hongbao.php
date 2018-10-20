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
    <div class="smsbody body_t $outback" nocache="true">
      <div class="b_c1 c3 tc top-shan">
        <p><!--{if $hongbao['password']}-->口令红包{else}普通红包<!--{/if}--></p>
        <div class="avatar_area"><!--{avatar($hongbao,2)}--></div>
        <div class="shan b_c3"></div>
      </div>
      <div class="b_c3 bob o_c1 p10">
        <h3 class="tc">$hongbao['username']的红包</h3>
        <!--{if $hongbao['message']}-->
        <p class="tc">$hongbao['message']</p>
        <!--{/if}-->
      </div>
      
      <!--{if $hongbao['uid']==$_S['uid']}-->
      <!--{if $canwithdraw}-->
      <div class="p15"><a href="hongbao.php?hid=$hongbao['hid']&withdraw=true" class="weui-btn weui-btn_primary load">撤回红包</a></div>
      <!--{elseif $withdrawed}-->
      <p class="{if !$list}alert{else}p10 s13{/if} c4">红包已被撤回</p>
      <!--{elseif $receiveed}-->
      <p class="{if !$list}alert{else}p10 s13{/if} c4">红包已被领取$hongbao['receive']/$hongbao['number']</p>
      <!--{else}-->
      <p class="{if !$list}alert{else}p10 s13{/if} c4">{date($hongbao['dateline']+86400,'Y-m-d H:i:s')}之后未领取则可以撤回</p>
      <!--{/if}-->
      <!--{else}-->
      
      <!--{if $hongbao['rec']}-->
      <p class="p10 s13 c4">您领到了$hongbao['rec']元</p>
      <!--{elseif !$hongbao['surplus'] && !$hongbao['receive']}-->
      <p class="{if !$list}alert{else}p10 s13{/if} c4">红包已被撤回</p>
      <!--{elseif !$hongbao['surplus']}-->
      <p class="p10 s13 c4">红包已被领完了</p>
      <!--{else}-->
      <!--{if $hongbao['password']}-->
      <form action="hongbao.php?hid=$hongbao['hid']" method="post" id="member_$_GET['mod']">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <input name="receive" type="hidden" value="true"/>
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="password" placeholder="请输入口令" value="$hongbao['password']">
            </div>
          </div>
        </div>
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost" id="member-btn">领取红包</button></div>
      </form>
      <!--{else}-->
      <div class="p15"><a href="hongbao.php?hid=$hongbao['hid']&receive=true" class="weui-btn weui-btn_primary load">领取红包</a></div>
      <!--{/if}-->
      <!--{/if}-->
      <!--{/if}-->
      <!--{if $list}-->
      <div class="users b_c3 bot o_c3" id="hongbao_log">
        <!--{loop $list $value}-->
        <a href="user.php?uid=$value['fuid']" class="weui-cell load">
          <div class="weui-cell__hd"><!--{avatar($value,2)}--></div>
          <div class="weui-cell__bd">
            <h4 class="c6">$value['username']</h4>
            <p class="c4">{date($value['logtime'],'Y-m-d H:i:s')}</p>
          </div>
          <div class="weui-cell__ft">$value['money']元</div>
        </a>
        <!--{/loop}-->
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