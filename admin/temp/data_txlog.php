<?exit?>

<div class="block">
  <h3>关于用户提现功能的说明</h3>
  <ul class="block_info">
    <li>目前提现只提供了手动转账提现功能，在进一步验证提现功能的安全性之后将开放自动提现功能</li>
    <li>在手动转账之前请核对用户的账户记录，当发现有异常记录之后请联系Smsot官方，以便我们尽快完善自动提现功能</li>
  </ul>
  
</div>
<!--{if $list}-->
<form action="$urlstr&page=$_S['page']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <input name="deletesubmit" id="deletesubmit" type="hidden" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">选择</td>
        <td class="w150">用户</td>
        <td class="w100">提现金额</td>
        <td class="w100">佣金</td>
        <td class="w100">实际金额</td>
        <td>提现收款账号</td>
        <td class="w100 tc">状态</td>
        <td class="w150">时间</td>
      </tr>
    </thead>
    <!--{loop $list $lid $value}-->
    <tbody>
      <tr>
        <td class="s"><input name="uids[$lid]" type="hidden" value="$value['uid']" /><label class="checkbox"><input type="checkbox" class="check" name="lid[]" value="$value['lid']"/><span class="icon"></span></label></td>
        <td class="w150"><!--{avatar($value['uid'],1)}--><a href="user.php?uid=$value['uid']" target="_blank">$value['username']</a></td>
        <td class="w100">$value['arose']元</td>
        <td class="w100">$value['commission']元</td>
        <td class="w100">$value['actual']元</td>
        <td><!--{if $value['relation']['type']=='bank'}-->{$value['relation']['bankname']}：{$value['relation']['bank']}（{$value['relation']['bankuser']}）<!--{else}--><!--{if $value['relation']['type']=='alipay'}-->支付宝<!--{else}-->OpenId<!--{/if}-->：{$value['relation']['account']}<!--{/if}--></td>
        <td class="tc">{if $value['state']}已处理{else}未处理{/if}</td>
        <td class="w150">{date($value['logtime'],'Y-m-d H:i')}</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'lid[]')"/><span class="icon"></span></label></td>
        <td colspan="8">$pages<button type="submit" class="button" name="handlesubmit" value="true">处理</button><button type="button" class="button w" onclick="checkdelete(this.form,'lid','deletesubmit')">删除</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">暂无任何提现申请</p>
<!--{/if}-->