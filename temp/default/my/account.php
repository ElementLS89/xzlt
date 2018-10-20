<?exit?>
<!--{template header}-->
<!--{if $_GET['action']=='account' || $_GET['lid']}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <!--{if $_GET['lid']}-->
      <div class="weui-cells s14">
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>ID:</p>
          </div>
          <div class="weui-cell__bd tr">$log['lid']</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>类型:</p>
          </div>
          <div class="weui-cell__bd tr">$log['type']</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>发生额:</p>
          </div>
          <div class="weui-cell__bd tr">$log['arose_before']{$log['arose']}</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>描述:</p>
          </div>
          <div class="weui-cell__bd tr">$log['title']</div>
        </div>
        <!--{if $log['relation']['account']}-->
        <!--{if $log['relation']['type']=='bank'}-->
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>银行:</p>
          </div>
          <div class="weui-cell__bd tr">$log['relation']['bankname']</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>姓名:</p>
          </div>
          <div class="weui-cell__bd tr">$log['relation']['bankuser']</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>银行账号:</p>
          </div>
          <div class="weui-cell__bd tr">$log['relation']['account']</div>
        </div>
        <!--{elseif $log['relation']['type']=='weixin'}-->
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>微信账号:</p>
          </div>
          <div class="weui-cell__bd tr">$log['relation']['account']</div>
        </div>
        <!--{elseif $log['relation']['type']=='alipay'}-->
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>支付宝账号:</p>
          </div>
          <div class="weui-cell__bd tr">$log['relation']['account']</div>
        </div>
        <!--{/if}-->
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>状态:</p>
          </div>
          <div class="weui-cell__bd tr"><!--{if $log['state']}-->已处理<!--{else}-->处理中<!--{/if}--></div>
        </div> 
        <!--{elseif $log['relation']['payment']}-->
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>支付方式:</p>
          </div>
          <div class="weui-cell__bd tr"><!--{if $log['relation']['payment']=='weixin'}-->微信支付<!--{else}-->支付宝<!--{/if}--></div>
        </div>    
        <!--{/if}-->
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>时间:</p>
          </div>
          <div class="weui-cell__bd tr">{date($log['logtime'],'Y-m-d H:i:s')}</div>
        </div>
      </div>
      <!--{else}-->
      <form action="my.php?mod=account&action=account" method="post" id="account_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <!--{if $_S['setting']['withdrawals']['weixin'] && $_S['member']['openid']}-->
        <div class="weui-cells__title">微信钱包</div>
        <div class="weui-cells weui-cells_checkbox">
          <label class="weui-cell weui-check__label" for="wechat">
            <div class="weui-cell__hd">
              <input type="checkbox" class="weui-check" name="weixin" id="wechat" value="$_S['member']['openid']" checked="checked">
              <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
              <p>当前所绑定微信账号的钱包</p>
            </div>
          </label>
        </div>
        <!--{/if}-->
        <!--{if $_S['setting']['withdrawals']['alipay']}-->
        <div class="weui-cells__title">支付宝账号</div>
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="alipay" value="$_S['member']['alipay']" placeholder="请输入您的收款支付宝账号">
            </div>
          </div>
        </div>
        <!--{/if}-->
        <!--{if $_S['setting']['withdrawals']['bank']}-->
        <div class="weui-cells__title">银行账号</div>
        <div class="weui-cells">
          <div class="weui-cell weui-cell_select">
            <div class="weui-cell__bd">
              <select class="weui-select" name="bankname">
                <!--{loop $_S['setting']['banks'] $value}-->
                <option value="$value" {if $_S['member']['bankname']==$value}selected="selected"{/if}>$value</option>
                <!--{/loop}-->
              </select>
            </div>
          </div>
        </div>
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="number" name="bank" value="$_S['member']['bank']" placeholder="请输入您的银行账号">
            </div>
          </div>          
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="bankuser" value="$_S['member']['bankuser']" placeholder="请输入您的账户开户人姓名">
            </div>
          </div>          
        </div>
        <!--{/if}-->
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="password" name="password" placeholder="请输入密码">
            </div>
          </div>
        </div>
        <div class="weui-cells__title tc">以上最少需要设置一个用于提现收款</div>
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">设置提现账号</button></div>   
      </form>
      <!--{/if}-->
    </div>
  </div>
</div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
<!--{template wechat_shar}-->
</div>
<!--{else}-->
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
      <div class="account b_c1 c3 flexbox" id="myaccount">
        <div class="flex">
          <p>余额</p>
          <h3><span id="balance">{$my['balance']}</span>元</h3>
        </div>
        <div class="flex">
          <p>代金券</p>
          <h3><span id="gold">{$my['gold']}</span>元</h3>
        </div>
      </div>
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="flex c1"><a href="javascript:SMS.null(1)" class="get" type="switch" box="content-1"><span>充值</span></a></li>
          <li class="flex c7"><a href="javascript:SMS.null(2)" class="get" type="switch" box="content-2"><span>提现</span></a></li>
          <li class="flex c7"><a href="my.php?mod=account&action=log" class="get" type="switch" box="content-3"><span>记录</span></a></li>
          <li class="flex c7"><a href="javascript:SMS.null(4)" class="get" type="switch" box="content-4"><span>规则</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>
      </div>
      <div class="box-area" id="profile-box">
        <div class="box-content ready current" id="content-1">

          <!--{if $_S['wxpay'] || $_S['alipay']}-->
          <form action="my.php?mod=account&action=recharge" method="post" id="pay_form" onsubmit="return false">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="$_S['hash']" />
            <input name="form" type="hidden" value="$_GET['form']" />
            <div class="weui-cells__title">充值金额</div>
            <!--{if $_GET['form']!='hongbao'}-->
            <!--{if $rule}-->
            <div class="weui-cells weui-cells_radio">
              <!--{eval $i=1;}-->
              <!--{loop $rule $value}-->
              <label class="weui-cell weui-check__label" for="m{$i}">
                <div class="weui-cell__bd">
                  <p>{$value[0]}元（送{$value[1]}元）</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" class="weui-check" name="money" id="m{$i}"{if $i==1} checked="checked"{/if} value="$value[0]">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <!--{eval $i++}-->
              <!--{/loop}-->
            </div>
            <div class="weui-cells__title">充值其他金额将按满足的最大赠送比例赠送</div>
            <!--{/if}-->
            <!--{/if}-->
        
            <div class="weui-cells">
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" type="number" name="othermoney" id="othermoney" placeholder="其他金额">
                </div>
              </div>
            </div>
            <div class="weui-cells__title">支付方式</div>
            <div class="weui-cells weui-cells_radio">
              <!--{if $_S['wxpay']}-->
              <label class="weui-cell weui-check__label" for="rechargeweixin">
                <div class="weui-cell__bd">
                  <p><span class="icon icon-weixinpay pr5"></span>微信</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" class="weui-check" name="payment" id="rechargeweixin"  checked="checked" value="wxpay">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <!--{/if}-->
              <!--{if $_S['alipay']}-->
              <label class="weui-cell weui-check__label" for="rechargealipay">
                <div class="weui-cell__bd">
                  <p><span class="icon icon-alipay pr5"></span>支付宝</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" name="payment" class="weui-check" id="rechargealipay" value="alipay">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <!--{/if}-->
            </div>
            
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary" onclick="callpay('recharge')">充值</button></div>   
          </form>
          <!--{else}-->
          <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">网站暂未开启充值功能,请稍后</span></div>
          <!--{/if}-->
        </div>
        
        <div class="box-content ready" id="content-2" style="display:none">
          <!--{if count($_S['setting']['withdrawals'])>0}-->
          <div id="withdrawals_alert" style="$withdrawals_alert">
            <p class="alert">您需要先设置您的提现账号才能提现</p>
            <div class="pl50 pr50"><a href="my.php?mod=account&action=account" class="weui-btn weui-btn_plain-primary load">设置提现账号</a></div>
          </div>
          <!--{if $_S['setting']['txed']>$my['balance']}-->
          <div id="withdrawals_alert" id="withdrawals_form">
            <p class="alert">当额度达到{$_S['setting']['txed']}元才能提现，当前余额{$my['balance']}元</p>
          </div>
          <!--{elseif $_S['member']['password']=='null'}-->
          <div id="withdrawals_alert">
            <p class="alert">请先给您的账号设置一个密码</p>
            <div class="pl50 pr50"><a href="my.php?mod=id" class="weui-btn weui-btn_plain-primary load">完善账号</a></div>
          </div>
          <!--{else}-->
          <form action="my.php?mod=account&action=withdrawals" method="post" id="withdrawals_form" style="$withdrawals_form">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="$_S['hash']" /> 
            <div class="weui-cells__title"><a href="my.php?mod=account&action=account" class="r c1 load">修改账号&gt;</a>选择提现账号</div>
            <div class="weui-cells weui-cells_radio">
              <label class="weui-cell weui-check__label" for="withdrawalsweixin" id="accountweixin" {if !$_S['member']['weixin']}style="display:none"{/if}>
                <div class="weui-cell__hd"><span class="icon icon-weixinpay pr5"></span></div>
                <div class="weui-cell__bd">
                  <p>微信钱包</p>
                  <p class="c2 s14" id="weixinaccount">当前账号所绑定的微信账号钱包</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" class="weui-check" name="account" value="weixin" id="withdrawalsweixin">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <label class="weui-cell weui-check__label" for="withdrawalsalipay" id="accountalipay" {if !$_S['member']['alipay']}style="display:none"{/if}>
                <div class="weui-cell__hd"><span class="icon icon-alipay pr5"></span></div>
                <div class="weui-cell__bd">
                  <p>支付宝账号</p>
                  <p class="c2 s14" id="alipayaccount">$_S['member']['alipay']</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" name="account" class="weui-check" id="withdrawalsalipay" value="alipay">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <label class="weui-cell weui-check__label" for="withdrawalsbank" id="accountbank" {if !$_S['member']['bank']}style="display:none"{/if}>
                <div class="weui-cell__hd"><span class="icon icon-bank pr5"></span></div>
                <div class="weui-cell__bd">
                  <p id="bankname">$_S['member']['bankname']</p>
                  <p class="c2 s14" id="bankaccount">$_S['member']['bank']</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" name="account" class="weui-check" id="withdrawalsbank" value="bank">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
            </div>
            <div class="weui-cells__title">提现手续费为{$commission}%</div>
            <div class="weui-cells">
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" type="number" name="money" id="withdrawalsmoney" placeholder="输入提现金额">
                </div>
              </div>
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" type="password" name="password" id="withdrawalspassword" placeholder="请输入密码">
                </div>
              </div>
              <div class="pl15 pb10 s12 bot o_c3 pt10 c4">可用余额为<span id="balance_bot">{$my['balance']}</span>元</div>
            </div>
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">$_S['setting']['cycle']小时内到账，确认提现</button></div>
          </form>
          <!--{/if}-->
          <!--{else}-->
          <p class="alert">暂未开启提现功能</p>
          <!--{/if}-->
        </div>
        <div class="box-content weui-cells" id="content-3" style="display:none">
        
        </div>
        <div class="box-content ready" id="content-4" style="display:none">
          <div class="weui-cells credits-rule">
          
            <div class="weui-cell">
              <div class="weui-cell__hd">
                <p>项目</p>
              </div>
              <div class="weui-cell__bd"><div class="flexbox"><span class="flex">经验</span><span class="flex">代金券</span></div></div>
            </div>
            <!--{loop $_S['cache']['credits'] $cid $value}-->
            <div class="weui-cell">
              <div class="weui-cell__hd">
                <p>$value['name']</p>
              </div>
              <div class="weui-cell__bd"><div class="flexbox"><span class="flex"><!--{if $value['experience']>0}-->+<!--{/if}-->$value['experience']</span><span class="flex"><!--{if $value['gold']>0}-->+<!--{/if}-->$value['gold']</span></div></div>
            </div>
            <!--{/loop}-->

          
          </div>

        </div>
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
      SMS.translate_int()
		});
  </script>
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
	<!--{template wechat_pay}-->
</div>
<!--{/if}-->
<!--{template footer}-->