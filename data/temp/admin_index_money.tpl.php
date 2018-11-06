
<ul class="catalog cl">
  <li<?php if(!$_GET['op']) { ?> class="a"<?php } ?>><a href="admin.php?mod=index&item=<?php echo $_GET['item'];?>&iframe=yes">充值规则</a></li>
  <li<?php if($_GET['op']=='tixian') { ?> class="a"<?php } ?>><a href="admin.php?mod=index&item=<?php echo $_GET['item'];?>&op=tixian&iframe=yes">提现规则</a></li>
</ul>
<?php if($_GET['op']=='tixian') { ?>
<div class="block">
  <h3>提现规则设置</h3>
  <ul class="block_info">
    <li>提现指的是提现用户的余额，代金券无法提现</li>
    <li>用户提现100元网站提成10元则佣金比例为10%</li>
  </ul>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>&op=tixian" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>提现方式</th>
        <td>
        <label class="checkbox"><input type="checkbox" class="check" name="withdrawals[]" value="weixin" <?php if($_S['setting']['withdrawals']['weixin']) { ?>checked="checked"<?php } ?>/><span class="icon"></span>微信</label>
        <label class="checkbox"><input type="checkbox" class="check" name="withdrawals[]" value="alipay" <?php if($_S['setting']['withdrawals']['alipay']) { ?>checked="checked"<?php } ?>/><span class="icon"></span>支付宝</label>
        <label class="checkbox"><input type="checkbox" class="check" name="withdrawals[]" value="bank" <?php if($_S['setting']['withdrawals']['bank']) { ?>checked="checked"<?php } ?>/><span class="icon"></span>银行</label>
        </td>
      </tr>
      <tr>
        <th>提现限额</th>
        <td>
        <input type="text" class="input" name="txed" value="<?php echo $_S['setting']['txed'];?>"><em>元</em><em>设置最少达到多少元方可提现</em>
        </td>
      </tr>
      <tr>
        <th>佣金比例</th>
        <td>
        <input type="text" class="input" name="commission" value="<?php echo $_S['setting']['commission'];?>"><em>%</em>
        </td>
      </tr>
      <tr>
        <th>支持银行</th>
        <td>
        <textarea class="textarea" name="banks"><?php echo $_S['setting']['banks'];?></textarea>
        <em>填写支持提现的银行，一行设置一个</em>
        </td>
      </tr>
      <tfoot>
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>
</div>
<?php } else { ?>
<div class="block">
  <h3>充值规则设置</h3>
  <ul class="block_info">
    <li>充值是指用户充值代金券，可以设置冲值赠送阶梯，比如冲100送10元</li>
  </ul>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>充值</th>
        <td>
        <textarea class="textarea" name="recharge"><?php echo $_S['setting']['recharge'];?></textarea>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          每行一个阶梯设置冲多少送多少，如下：<br />
          1000=100<br />
          2000=300
        </td>
      </tr>
      <tfoot>
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>
</div>

<?php } ?>
