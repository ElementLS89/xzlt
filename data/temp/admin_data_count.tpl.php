
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
        <td class="w300">ID</td>
        <td class="w100 tc">类型</td>
        <td class="w100 tc">发生额</td>
        <td class="w300">描述</td>
        <td class="w200">用户</td>
        <td>时间</td>
      </tr>
    </thead>
    <?php if(is_array($list)) foreach($list as $value) { ?>    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="lid[]" value="<?php echo $value['lid'];?>"/><span class="icon"></span></label></td>
        <td class="w300"><?php echo $value['lid'];?></td>
        <td class="w100 tc"><?php if($value['fild']=='gold') { ?>代金券<?php } elseif($value['fild']=='balance') { ?>余额<?php } else { ?>经验<?php } ?></td>
        <td class="w100 tc"><?php echo $value['arose'];?></td>
        <td class="w300"><?php echo $value['title'];?></td>
        <td class="w200"><?php if($value['uid']) { ?><?php echo head($value['uid'],1);?><a href="user.php?uid=<?php echo $value['uid'];?>" target="_blank"><?php echo $value['username'];?></a><?php } else { ?>游客<?php } ?></td>
        <td><?php echo smsdate($value['logtime'],'Y-m-d H:i');?></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'lid[]')"/><span class="icon"></span></label></td>
        <td colspan="8"><?php echo $pages;?><button type="button" class="button w" onclick="checkdelete(this.form,'lid')">删除</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } else { ?>
<p class="empty">暂无符合条件的支付信息</p>
<?php } } else { ?>
<div class="block">
  <h3>账户变动记录</h3>
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
        <th>类型</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="fild" value="0" checked="checked" /><span class="icon"></span>不限</label>
        <label class="radio"><input type="radio" class="check" name="fild" value="experience"/><span class="icon"></span>积分</label>
        <label class="radio"><input type="radio" class="check" name="fild" value="balance"/><span class="icon"></span>余额</label>
        <label class="radio"><input type="radio" class="check" name="fild" value="gold"/><span class="icon"></span>代金券</label>
        </td>
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