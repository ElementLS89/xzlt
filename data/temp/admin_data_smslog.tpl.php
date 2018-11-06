
<?php if($list) { ?>
<form action="<?php echo $urlstr;?>&page=<?php echo $_S['page'];?>" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <input name="deletesubmit" type="hidden" value="true" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">选择</td>
        <td class="w200">用户</td>
        <td class="w150">电话号码</td>
        <td class="w100">类型</td>
        <td>内容</td>
        <td class="w100 tc">是否使用</td>
        <td class="w150">时间</td>
      </tr>
    </thead>
    <?php if(is_array($list)) foreach($list as $value) { ?>    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="lid[]" value="<?php echo $value['lid'];?>"/><span class="icon"></span></label></td>
        <td class="w200"><?php if($value['uid']) { ?><?php echo head($value['uid'],1);?><a href="user.php?uid=<?php echo $value['uid'];?>" target="_blank"><?php echo $value['username'];?></a><?php } else { ?>游客<?php } ?></td>
        <td class="w150"><?php echo $value['phonenumber'];?></td>
        <td class="w100"><?php if($value['item']=='reg') { ?>注册账号<?php } elseif($value['item']=='bind') { ?>绑定手机<?php } else { ?>登录网站<?php } ?></td>
        <td><?php echo $value['code']['number'];?></td>
        <td class="tc"><?php if($value['isuse']) { ?>已使用<?php } else { ?>未使用<?php } ?></td>
        <td class="w150"><?php echo smsdate($value['dateline'],'Y-m-d H:i');?></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'lid[]')"/><span class="icon"></span></label></td>
        <td colspan="6"><?php echo $pages;?><button type="button" class="button w" onclick="checkdelete(this.form,'lid')">删除</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } else { ?>
<p class="empty">暂无任何短信记录</p>
<?php } ?>