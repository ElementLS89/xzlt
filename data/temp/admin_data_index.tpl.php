
<?php if($_GET['searchsubmit']) { if($list) { ?>
<form action="<?php echo $urlstr;?>&page=<?php echo $_S['page'];?>" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <input name="deletesubmit" type="hidden" value="true" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">选择</td>
        <td class="w300">订单号</td>
        <td class="w100 tc">支付方式</td>
        <td class="w100 tc">支付用途</td>
        <td class="w300">支付用户Openid</td>
        <td class="w200">用户</td>
        
        <td class="w100 tc">金额</td>
        <td class="w100 tc">状态</td>
        <td>时间</td>
      </tr>
    </thead>
    <?php if(is_array($list)) foreach($list as $value) { ?>    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="tradeno[]" value="<?php echo $value['tradeno'];?>"/><span class="icon"></span></label></td>
        <td class="w300"><?php echo $value['prepayid'];?></td>
        <td class="w100 tc"><?php echo $value['paytype'];?></td>
        <td class="w100 tc"><?php echo $value['ac'];?></td>
        <td class="w300"><?php echo $value['openid'];?></td>
        <td class="w200"><?php if($value['uid']) { ?><?php echo head($value['uid'],1);?><a href="user.php?uid=<?php echo $value['uid'];?>" target="_blank"><?php echo $value['username'];?></a><?php } else { ?>游客<?php } ?></td>
        <td class="w100 tc"><?php echo $value['money'];?>元</td>
        <td class="w100 tc"><?php if($value['state']==1) { ?>已支付<?php } else { ?>未支付<?php } ?></td>
        <td><?php echo smsdate($value['dateline'],'Y-m-d H:i');?></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'tradeno[]')"/><span class="icon"></span></label></td>
        <td colspan="8"><?php echo $pages;?><button type="button" class="button w" onclick="checkdelete(this.form,'tradeno')">删除</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } else { ?>
<p class="empty">暂无符合条件的支付信息</p>
<?php } } else { ?>
<div class="block">
  <h3>筛选订单</h3>
  <form action="admin.php" method="get">
    <input name="mod" type="hidden" value="<?php echo $_GET['mod'];?>" />
    <input name="item" type="hidden" value="<?php echo $_GET['item'];?>" />
    <input name="iframe" type="hidden" value="true" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>UID</th>
        <td><input type="text" class="input" name="uid" value=""><em>输入要搜索用户的UID</em></td>
      </tr>
      <tr>
        <th>状态</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="state" value="1" checked="checked" /><span class="icon"></span>已支付</label>
        <label class="radio"><input type="radio" class="check" name="state" value="0"/><span class="icon"></span>未支付</label>
        </td>
      </tr>
      <tr>
        <th>支付用途</th>
        <td><input type="text" class="input" name="ac" value=""><em>输入支付用途</em></td>
      </tr>
      <tr>
        <th>Openid</th>
        <td><input type="text" class="input w300" name="openid" value=""><em>输入支付用户的OPenid</em></td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="searchsubmit" value="true">搜索</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>
</div>
<?php } ?>

