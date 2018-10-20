<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><a href="javascript:SMS.closepage()" class="icon icon-close"></a></div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody body_t $outback" nocache="true">
      <!--{if $_GET['ac']=='gratuity'}-->
      <form action="gratuity.php?mod=$_GET['mod']&ac=gratuity" method="post" id="pay_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <input name="vid" type="hidden" id="vid" value="$_GET['vid']" />
        <input name="modid" type="hidden" id="mod" value="$_GET['mod']" />
        
        <div class="weui-cells__title">打赏金额</div>
        <ul class="flexradio flexbox b_c3 bot o_c3">
          <li class="flex"><label><input type="radio" class="weui-check"  name="money" value="100">1元<span class="icon c1"></span></label></li>
          <li class="flex"><label class="bol bor o_c3"><input type="radio" class="weui-check" name="money" value="300" checked="checked">3元<span class="icon c1"></span></label></li>
          <li class="flex"><label><input type="radio" class="weui-check" name="money" value="500">5元<span class="icon c1"></span></label></li>
        </ul>
        <ul class="flexradio flexbox b_c3 bot bob o_c3">
          <li class="flex"><label><input type="radio" class="weui-check"  name="money" value="1000">10元<span class="icon c1"></span></label></li>
          <li class="flex"><label class="bol bor o_c3"><input type="radio" class="weui-check" name="money" value="3000">30元<span class="icon c1"></span></label></li>
          <li class="flex"><label><input type="radio" class="weui-check" name="money" value="5000">50元<span class="icon c1"></span></label></li>
        </ul>

        <div class="weui-cells__title">支付方式</div>
        <div class="weui-cells weui-cells_radio">
          <label class="weui-cell weui-check__label" for="balance">
            <div class="weui-cell__bd">
              <p>余额支付（$my['balance']元）</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" class="weui-check" name="payment" id="balance" value="balance" checked="checked" onclick="$('#paybutton').addClass('formpost').attr('onclick','')" >
              <span class="weui-icon-checked"></span>
            </div>
          </label>
          <!--{if $_S['wxpay']}-->
          <label class="weui-cell weui-check__label" for="weixin">
            <div class="weui-cell__bd">
              <p><span class="icon icon-weixinpay pr5"></span>微信</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" class="weui-check" name="payment" id="weixin" value="wxpay" onclick="$('#paybutton').removeClass('formpost').attr('onclick','callpay(\'gratuity\')')">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
          <!--{/if}-->
          <!--{if $_S['alipay']}-->
          <label class="weui-cell weui-check__label" for="alipay">
            <div class="weui-cell__bd">
              <p><span class="icon icon-alipay pr5"></span>支付宝</p>
            </div>
            <div class="weui-cell__ft">
              <input type="radio" name="payment" class="weui-check" id="alipay" value="alipay">
              <span class="weui-icon-checked"></span>
            </div>
          </label>
          <!--{/if}-->
        </div>
        
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost" id="paybutton">打赏</button></div>   
      </form>
      <!--{else}-->
      <div class="autolist">
        <div class="weui-cells users">
          <!--{loop $list $value}-->
          <a href="user.php?uid=$value['uid']" class="weui-cell load">
            <div class="weui-cell__hd"><!--{avatar($value,2)}--></div>
            <div class="weui-cell__bd">
              <h4 class="c1">$value['username']</h4>
              <p class="c4">{date($value['dateline'],'Y-m-d H:i:s')}</p>
            </div>
            <div class="weui-cell__ft c9">$value['money']元</div>
          </a>
          <!--{/loop}-->
        </div>
      </div>
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->
      <!--{/if}-->
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
  <!--{template wechat_pay}-->
</div>
<!--{template footer}-->
  