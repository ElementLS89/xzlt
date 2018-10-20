<?php include temp('header'); if($_GET['action']=='account' || $_GET['lid']) { ?>
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('close')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>">
      <?php if($_GET['lid']) { ?>
      <div class="weui-cells s14">
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>ID:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['lid'];?></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>类型:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['type'];?></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>发生额:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['arose_before'];?><?php echo $log['arose'];?></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>描述:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['title'];?></div>
        </div>
        <?php if($log['relation']['account']) { ?>
        <?php if($log['relation']['type']=='bank') { ?>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>银行:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['relation']['bankname'];?></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>姓名:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['relation']['bankuser'];?></div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>银行账号:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['relation']['account'];?></div>
        </div>
        <?php } elseif($log['relation']['type']=='weixin') { ?>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>微信账号:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['relation']['account'];?></div>
        </div>
        <?php } elseif($log['relation']['type']=='alipay') { ?>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>支付宝账号:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo $log['relation']['account'];?></div>
        </div>
        <?php } ?>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>状态:</p>
          </div>
          <div class="weui-cell__bd tr"><?php if($log['state']) { ?>已处理<?php } else { ?>处理中<?php } ?></div>
        </div> 
        <?php } elseif($log['relation']['payment']) { ?>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>支付方式:</p>
          </div>
          <div class="weui-cell__bd tr"><?php if($log['relation']['payment']=='weixin') { ?>微信支付<?php } else { ?>支付宝<?php } ?></div>
        </div>    
        <?php } ?>
        <div class="weui-cell">
          <div class="weui-cell__hd c4">
            <p>时间:</p>
          </div>
          <div class="weui-cell__bd tr"><?php echo smsdate($log['logtime'],'Y-m-d H:i:s');?></div>
        </div>
      </div>
      <?php } else { ?>
      <form action="my.php?mod=account&action=account" method="post" id="account_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
        <?php if($_S['setting']['withdrawals']['weixin'] && $_S['member']['openid']) { ?>
        <div class="weui-cells__title">微信钱包</div>
        <div class="weui-cells weui-cells_checkbox">
          <label class="weui-cell weui-check__label" for="wechat">
            <div class="weui-cell__hd">
              <input type="checkbox" class="weui-check" name="weixin" id="wechat" value="<?php echo $_S['member']['openid'];?>" checked="checked">
              <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
              <p>当前所绑定微信账号的钱包</p>
            </div>
          </label>
        </div>
        <?php } ?>
        <?php if($_S['setting']['withdrawals']['alipay']) { ?>
        <div class="weui-cells__title">支付宝账号</div>
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="alipay" value="<?php echo $_S['member']['alipay'];?>" placeholder="请输入您的收款支付宝账号">
            </div>
          </div>
        </div>
        <?php } ?>
        <?php if($_S['setting']['withdrawals']['bank']) { ?>
        <div class="weui-cells__title">银行账号</div>
        <div class="weui-cells">
          <div class="weui-cell weui-cell_select">
            <div class="weui-cell__bd">
              <select class="weui-select" name="bankname">
                <?php if(is_array($_S['setting']['banks'])) foreach($_S['setting']['banks'] as $value) { ?>                <option value="<?php echo $value;?>" <?php if($_S['member']['bankname']==$value) { ?>selected="selected"<?php } ?>><?php echo $value;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="number" name="bank" value="<?php echo $_S['member']['bank'];?>" placeholder="请输入您的银行账号">
            </div>
          </div>          
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="bankuser" value="<?php echo $_S['member']['bankuser'];?>" placeholder="请输入您的账户开户人姓名">
            </div>
          </div>          
        </div>
        <?php } ?>
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
      <?php } ?>
    </div>
  </div>
</div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript"><?php include temp('wechat_shar'); ?></div>
<?php } else { ?>
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><?php back('back')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $outback;?>">
      <div class="account b_c1 c3 flexbox" id="myaccount">
        <div class="flex">
          <p>余额</p>
          <h3><span id="balance"><?php echo $my['balance'];?></span>元</h3>
        </div>
        <div class="flex">
          <p>代金券</p>
          <h3><span id="gold"><?php echo $my['gold'];?></span>元</h3>
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

          <?php if($_S['wxpay'] || $_S['alipay']) { ?>
          <form action="my.php?mod=account&action=recharge" method="post" id="pay_form" onsubmit="return false">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
            <input name="form" type="hidden" value="<?php echo $_GET['form'];?>" />
            <div class="weui-cells__title">充值金额</div>
            <?php if($_GET['form']!='hongbao') { ?>
            <?php if($rule) { ?>
            <div class="weui-cells weui-cells_radio">
              <?php $i=1;?>              <?php if(is_array($rule)) foreach($rule as $value) { ?>              <label class="weui-cell weui-check__label" for="m<?php echo $i;?>">
                <div class="weui-cell__bd">
                  <p><?php echo $value['0'];?>元（送<?php echo $value['1'];?>元）</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" class="weui-check" name="money" id="m<?php echo $i;?>"<?php if($i==1) { ?> checked="checked"<?php } ?> value="<?php echo $value['0'];?>">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <?php $i++?>              <?php } ?>
            </div>
            <div class="weui-cells__title">充值其他金额将按满足的最大赠送比例赠送</div>
            <?php } ?>
            <?php } ?>
        
            <div class="weui-cells">
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <input class="weui-input" type="number" name="othermoney" id="othermoney" placeholder="其他金额">
                </div>
              </div>
            </div>
            <div class="weui-cells__title">支付方式</div>
            <div class="weui-cells weui-cells_radio">
              <?php if($_S['wxpay']) { ?>
              <label class="weui-cell weui-check__label" for="rechargeweixin">
                <div class="weui-cell__bd">
                  <p><span class="icon icon-weixinpay pr5"></span>微信</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" class="weui-check" name="payment" id="rechargeweixin"  checked="checked" value="wxpay">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <?php } ?>
              <?php if($_S['alipay']) { ?>
              <label class="weui-cell weui-check__label" for="rechargealipay">
                <div class="weui-cell__bd">
                  <p><span class="icon icon-alipay pr5"></span>支付宝</p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" name="payment" class="weui-check" id="rechargealipay" value="alipay">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <?php } ?>
            </div>
            
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary" onclick="callpay('recharge')">充值</button></div>   
          </form>
          <?php } else { ?>
          <div class="weui-loadmore weui-loadmore_line"><span class="weui-loadmore__tips">网站暂未开启充值功能,请稍后</span></div>
          <?php } ?>
        </div>
        
        <div class="box-content ready" id="content-2" style="display:none">
          <?php if(count($_S['setting']['withdrawals'])>0) { ?>
          <div id="withdrawals_alert" style="<?php echo $withdrawals_alert;?>">
            <p class="alert">您需要先设置您的提现账号才能提现</p>
            <div class="pl50 pr50"><a href="my.php?mod=account&action=account" class="weui-btn weui-btn_plain-primary load">设置提现账号</a></div>
          </div>
          <?php if($_S['setting']['txed']>$my['balance']) { ?>
          <div id="withdrawals_alert" id="withdrawals_form">
            <p class="alert">当额度达到<?php echo $_S['setting']['txed'];?>元才能提现，当前余额<?php echo $my['balance'];?>元</p>
          </div>
          <?php } elseif($_S['member']['password']=='null') { ?>
          <div id="withdrawals_alert">
            <p class="alert">请先给您的账号设置一个密码</p>
            <div class="pl50 pr50"><a href="my.php?mod=id" class="weui-btn weui-btn_plain-primary load">完善账号</a></div>
          </div>
          <?php } else { ?>
          <form action="my.php?mod=account&action=withdrawals" method="post" id="withdrawals_form" style="<?php echo $withdrawals_form;?>">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" /> 
            <div class="weui-cells__title"><a href="my.php?mod=account&action=account" class="r c1 load">修改账号&gt;</a>选择提现账号</div>
            <div class="weui-cells weui-cells_radio">
              <label class="weui-cell weui-check__label" for="withdrawalsweixin" id="accountweixin" <?php if(!$_S['member']['weixin']) { ?>style="display:none"<?php } ?>>
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
              <label class="weui-cell weui-check__label" for="withdrawalsalipay" id="accountalipay" <?php if(!$_S['member']['alipay']) { ?>style="display:none"<?php } ?>>
                <div class="weui-cell__hd"><span class="icon icon-alipay pr5"></span></div>
                <div class="weui-cell__bd">
                  <p>支付宝账号</p>
                  <p class="c2 s14" id="alipayaccount"><?php echo $_S['member']['alipay'];?></p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" name="account" class="weui-check" id="withdrawalsalipay" value="alipay">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
              <label class="weui-cell weui-check__label" for="withdrawalsbank" id="accountbank" <?php if(!$_S['member']['bank']) { ?>style="display:none"<?php } ?>>
                <div class="weui-cell__hd"><span class="icon icon-bank pr5"></span></div>
                <div class="weui-cell__bd">
                  <p id="bankname"><?php echo $_S['member']['bankname'];?></p>
                  <p class="c2 s14" id="bankaccount"><?php echo $_S['member']['bank'];?></p>
                </div>
                <div class="weui-cell__ft">
                  <input type="radio" name="account" class="weui-check" id="withdrawalsbank" value="bank">
                  <span class="weui-icon-checked"></span>
                </div>
              </label>
            </div>
            <div class="weui-cells__title">提现手续费为<?php echo $commission;?>%</div>
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
              <div class="pl15 pb10 s12 bot o_c3 pt10 c4">可用余额为<span id="balance_bot"><?php echo $my['balance'];?></span>元</div>
            </div>
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost"><?php echo $_S['setting']['cycle'];?>小时内到账，确认提现</button></div>
          </form>
          <?php } ?>
          <?php } else { ?>
          <p class="alert">暂未开启提现功能</p>
          <?php } ?>
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
            <?php if(is_array($_S['cache']['credits'])) foreach($_S['cache']['credits'] as $cid => $value) { ?>            <div class="weui-cell">
              <div class="weui-cell__hd">
                <p><?php echo $value['name'];?></p>
              </div>
              <div class="weui-cell__bd"><div class="flexbox"><span class="flex"><?php if($value['experience']>0) { ?>+<?php } ?><?php echo $value['experience'];?></span><span class="flex"><?php if($value['gold']>0) { ?>+<?php } ?><?php echo $value['gold'];?></span></div></div>
            </div>
            <?php } ?>

          
          </div>

        </div>
      </div>
      <div id="page"></div>
    </div>
  </div>
  <div id="footer"> 
    <?php include temp('tabbar'); ?> 
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
  $(document).ready(function() {
      SMS.translate_int()
});
  </script>
  <?php include temp('wechat'); ?>  <?php include temp('wechat_shar'); include temp('wechat_pay'); ?></div>
<?php } include temp('footer'); ?>