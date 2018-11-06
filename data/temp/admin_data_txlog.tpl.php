

<div class="block">
  <h3>关于用户提现功能的说明</h3>
  <ul class="block_info">
    <li>目前提现只提供了手动转账提现功能，在进一步验证提现功能的安全性之后将开放自动提现功能</li>
    <li>在手动转账之前请核对用户的账户记录，当发现有异常记录之后请联系Smsot官方，以便我们尽快完善自动提现功能</li>
  </ul>
  
</div>
<?php if($list) { ?>
<form action="<?php echo $urlstr;?>&page=<?php echo $_S['page'];?>" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
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
    <?php if(is_array($list)) foreach($list as $lid => $value) { ?>    <tbody>
      <tr>
        <td class="s"><input name="uids[<?php echo $lid;?>]" type="hidden" value="<?php echo $value['uid'];?>" /><label class="checkbox"><input type="checkbox" class="check" name="lid[]" value="<?php echo $value['lid'];?>"/><span class="icon"></span></label></td>
        <td class="w150"><?php echo head($value['uid'],1);?><a href="user.php?uid=<?php echo $value['uid'];?>" target="_blank"><?php echo $value['username'];?></a></td>
        <td class="w100"><?php echo $value['arose'];?>元</td>
        <td class="w100"><?php echo $value['commission'];?>元</td>
        <td class="w100"><?php echo $value['actual'];?>元</td>
        <td><?php if($value['relation']['type']=='bank') { ?><?php echo $value['relation']['bankname'];?>：<?php echo $value['relation']['bank'];?>（<?php echo $value['relation']['bankuser'];?>）<?php } else { if($value['relation']['type']=='alipay') { ?>支付宝<?php } else { ?>OpenId<?php } ?>：<?php echo $value['relation']['account'];?><?php } ?></td>
        <td class="tc"><?php if($value['state']) { ?>已处理<?php } else { ?>未处理<?php } ?></td>
        <td class="w150"><?php echo smsdate($value['logtime'],'Y-m-d H:i');?></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'lid[]')"/><span class="icon"></span></label></td>
        <td colspan="8"><?php echo $pages;?><button type="submit" class="button" name="handlesubmit" value="true">处理</button><button type="button" class="button w" onclick="checkdelete(this.form,'lid','deletesubmit')">删除</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } else { ?>
<p class="empty">暂无任何提现申请</p>
<?php } ?>