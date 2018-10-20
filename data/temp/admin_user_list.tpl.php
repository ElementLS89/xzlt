
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
        <td class="s">UID</td>
        <td class="w200">Openid</td>
        <td class="w200">Mini</td>
        <td class="w300">用户</td>
        <td class="m">微信</td>
        <td class="w100">电话</td>
        <td class="w150">用户组</td>
        <td class="m">余额</td>
        <td class="m">代金券</td>
        <td class="m">经验</td>
        <td class="w150">注册时间</td>
        <td>最后访问时间</td>
      </tr>
    </thead>
    <?php if(is_array($list)) foreach($list as $value) { ?>    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="uid[]" value="<?php echo $value['uid'];?>"/><span class="icon"></span></label></td>
        <td class="s"><?php echo $value['uid'];?></td>
        <td class="w200"><?php echo $value['openid'];?></td>
        <td class="w200"><?php echo $value['mini'];?></td>
        <td class="w300"><?php echo head($value['uid'],1);?><a href="user.php?uid=<?php echo $value['uid'];?>" target="_blank"><?php echo $value['username'];?></a><a href="admin.php?mod=<?php echo $_GET['mod'];?>&item=edit&uid=<?php echo $value['uid'];?>&iframe=yes&ref=<?php echo $ref;?>"><em>[编辑]</em></a></td>
        <td class="m"><?php if($value['openid']) { ?>已绑定<?php } else { ?>未绑定<?php } ?></td>
        <td class="w100"><?php if($value['tel']) { ?><?php echo $value['tel'];?><?php } else { ?>未绑定<?php } ?></td>
        <td class="w150"><?php echo $_S['cache']['usergroup'][$value['groupid']]['name'];?></td>
        <td class="m"><?php echo $value['balance'];?></td>
        <td class="m"><?php echo $value['gold'];?></td>
        <td class="m"><?php echo $value['experience'];?></td>
        <td class="w150"><?php echo smsdate($value['regdate'],'Y-m-d H:i');?></td>
        <td><?php echo smsdate($value['lastactivity'],'Y-m-d H:i');?></td>
      </tr>
    </tbody>
    <?php } ?>
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'uid[]')"/><span class="icon"></span></label></td>
        <td colspan="13"><?php echo $pages;?><button type="button" class="button w" onclick="checkdelete(this.form,'uid','deletesubmit')">删除</button><?php if($_GET['item']=='review' || $_GET['search']['state']==0) { ?><button type="submit" class="button" name="examinesubmit" value="true">通过</button><?php } ?></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<?php } else { ?>
<p class="empty">没有找到符合条件的用户</p>
<?php } ?>