
<div class="block">
  <h3><?php if($user) { ?>编辑用户<?php } else { ?>添加用户<?php } ?></h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <input name="uid" type="hidden" value="<?php echo $_GET['uid'];?>" />
    <input name="ref" type="hidden" value="<?php echo $_GET['ref'];?>" />
    <table class="table" cellpadding="0" cellspacing="0">
      <?php if($user['uid']) { ?>
      <tr>
        <th>头像</th>
        <td><?php echo head($user['uid'],1);?><input type="file" name="avatar"></td>
      </tr>
      <?php } ?>
      <tr>
        <th>用户组</th>
        <td>
          <div class="select">
            <select name="groupid">
              <?php if(is_array($_S['cache']['usergroup'])) foreach($_S['cache']['usergroup'] as $value) { ?>              <option value="<?php echo $value['gid'];?>" <?php if($value['gid']==$user['groupid'] || (!$user && $value['gid']=='10')) { ?>selected<?php } ?>><?php echo $value['name'];?></option>
              <?php } ?>
            </select>
          </div>  
        </td>
      </tr>

      <tr>
        <th>用户名</th>
        <td><input type="text" class="input w300" name="username" value="<?php echo $user['username'];?>"></td>
      </tr>
      <tr>
        <th>密码</th>
        <td><input type="text" class="input w300" name="password" value="<?php echo $user['name'];?>"></td>
      </tr>
      <?php if($_GET['item']=='edit') { ?>
      <tr>
        <th>Openid</th>
        <td><input type="text" class="input w300" name="openid" value="<?php echo $user['openid'];?>"><em>用户的Openid，请勿随意修改错误的修改会导致用户无法微信登录和支付</em></td>
      </tr> 
      <tr>
        <th>mini</th>
        <td><input type="text" class="input w300" name="mini" value="<?php echo $user['mini'];?>"><em>用户小程序的miniID，请勿随意修改错误的修改会导致用户无法微信登录</em></td>
      </tr> 
      <tr>
        <th>DZuid</th>
        <td><input type="text" class="input w300" name="dzuid" value="<?php echo $user['dzuid'];?>"><em>设置用户的Discuz论坛的UID,若无Discuz这里可留空</em></td>
      </tr>         
      <tr>
        <th>Email</th>
        <td><input type="text" class="input w300" name="email" value="<?php echo $user['email'];?>"></td>
      </tr>
      <tr>
        <th>电话</th>
        <td><input type="text" class="input w300" name="tel" value="<?php echo $user['tel'];?>"></td>
      </tr>
      <tr class="line"><td colspan="2"></td></tr>
      <tr>
        <th>关注人数</th>
        <td><input type="text" class="input" name="follow" value="<?php echo $user['follow'];?>"></td>
      </tr>
      <tr>
        <th>粉丝人数</th>
        <td><input type="text" class="input" name="fans" value="<?php echo $user['fans'];?>"></td>
      </tr>
      <tr>
        <th>钱包余额</th>
        <td><input type="text" class="input" name="balance" value="<?php echo $user['balance'];?>"><a href="admin.php?mod=data&item=count&iframe=true&uid=<?php echo $user['uid'];?>&fild=balance&searchsubmit=true">查看记录</a></td>
      </tr>
      <tr>
        <th>代金券</th>
        <td><input type="text" class="input" name="gold" value="<?php echo $user['gold'];?>"><a href="admin.php?mod=data&item=count&iframe=true&uid=<?php echo $user['uid'];?>&fild=gold&searchsubmit=true">查看记录</a></td>
      </tr>
      <tr>
        <th>经验值</th>
        <td><input type="text" class="input" name="experience" value="<?php echo $user['experience'];?>"><a href="admin.php?mod=data&item=count&iframe=true&uid=<?php echo $user['uid'];?>&fild=experience&searchsubmit=true">查看记录</a></td>
      </tr>
      <tr class="line"><td colspan="2"></td></tr>
      <?php if(is_array($_S['cache']['userfield'])) foreach($_S['cache']['userfield'] as $field => $value) { ?>      <?php if($value['canuse']) { ?>
      <tr>
        <th><?php echo $value['name'];?></th>
        <td>
        <?php if($value['type']=='text') { ?>
        <input type="text" class="input w300" name="<?php echo $field;?>" value="<?php echo $user[$field];?>">
        <?php } elseif($value['type']=='number') { ?>
        <input type="text" class="input" name="<?php echo $field;?>" value="<?php echo $user[$field];?>"><em><?php echo $value['unit'];?></em>
        <?php } elseif($value['type']=='date') { ?>
        <?php $user[$field]=smsdate($user[$field],$value['datetype']);?>        <input type="text" class="input" name="<?php echo $field;?>" value="<?php echo $user[$field];?>"><em>例：<?php echo $value['datetype'];?></em>
        <?php } elseif($value['type']=='textarea') { ?>
        <textarea class="textarea" name="<?php echo $field;?>"><?php echo $user[$field];?></textarea>
        <?php } elseif($value['type']=='file') { ?>
        <?php if($user[$field]) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $user[$field];?>" /><?php } ?><input type="file" name="<?php echo $field;?>">
        <?php } elseif($value['type']=='radio') { ?>
        <?php if(is_array($value['choises'])) foreach($value['choises'] as $k => $n) { ?>        <label class="radio"><input type="radio" class="check" name="<?php echo $field;?>" value="<?php echo $k;?>" <?php if($user[$field]==$k) { ?>checked="checked"<?php } ?>/><span class="icon"></span><?php echo $n;?></label>
        <?php } ?>
        <?php } elseif($value['type']=='checkbox') { ?>
        <?php $user[$field]=explode(',',$user[$field]);?>        <?php if(is_array($value['choises'])) foreach($value['choises'] as $k => $n) { ?>        <label class="checkbox"><input type="checkbox" class="check" name="<?php echo $field;?>[]" value="<?php echo $k;?>" <?php if(in_array($k,$user[$field])) { ?>checked="checked"<?php } ?>/><span class="icon"></span><?php echo $n;?></label>
        <?php } ?>
        <?php } elseif($value['type']=='select') { ?>
        <div class="select">
          <select name="<?php echo $field;?>">
            <option>请选择</option>
            <?php if(is_array($value['choises'])) foreach($value['choises'] as $k => $n) { ?>            <option value="<?php echo $k;?>" <?php if($user[$field]==$k) { ?>selected="selected"<?php } ?>><?php echo $n;?></option>
            <?php } ?>
          </select>
        </div>  
        <?php } ?>
  
        </td>
      </tr>
      <?php } ?>
      <?php } ?>
  
      <tr class="line"><td colspan="2"></td></tr>
      <tr>
        <th>经度坐标</th>
        <td>
          <input type="text" class="input" name="lat" value="<?php echo $user['lat'];?>">
        </td>
      </tr>
      <tr>
        <th>纬度坐标</th>
        <td>
          <input type="text" class="input" name="lng" value="<?php echo $user['lng'];?>">
        </td>
      </tr>
      <tr>
        <th>geohash</th>
        <td>
          <input type="text" class="input" name="geohash" value="<?php echo $user['geohash'];?>">
        </td>
      </tr>
      <tr>
        <th>国家</th>
        <td>
          <input type="text" class="input w300" name="nation" value="<?php echo $user['nation'];?>">
        </td>
      </tr>
      <tr>
        <th>省份</th>
        <td>
          <input type="text" class="input w300" name="province" value="<?php echo $user['province'];?>">
        </td>
      </tr>
      <tr>
        <th>城市</th>
        <td>
          <input type="text" class="input w300" name="city" value="<?php echo $user['city'];?>">
        </td>
      </tr>
      <tr>
        <th>区</th>
        <td>
          <input type="text" class="input w300" name="district" value="<?php echo $user['district'];?>">
        </td>
      </tr>
      <tr>
        <th>地址</th>
        <td>
          <input type="text" class="input w300" name="addr" value="<?php echo $user['addr'];?>">
        </td>
      </tr>
      <tr class="line"><td colspan="2"></td></tr>
      <tr>
        <th>公开地理定位</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="lbs" value="1" <?php if($user['lbs']==1) { ?>checked<?php } ?>/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="lbs" value="0" <?php if(!$user['lbs']) { ?>checked<?php } ?>/><span class="icon"></span>否</label>
        </td>
      </tr>
      <tr>
        <th>公开个人资料</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="profile" value="1" <?php if($user['profile']==1) { ?>checked<?php } ?>/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="profile" value="0" <?php if(!$user['profile']) { ?>checked<?php } ?>/><span class="icon"></span>否</label>
        </td>
      </tr>
      <tr>
        <th>允许接收临时消息</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="pm" value="1" <?php if($user['pm']==1) { ?>checked<?php } ?>/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="pm" value="0" <?php if(!$user['pm']) { ?>checked<?php } ?>/><span class="icon"></span>否</label>
        </td>
      </tr>
      <tr>
        <th>加好友免验证</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="friend" value="1" <?php if($user['friend']==1) { ?>checked<?php } ?>/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="friend" value="0" <?php if(!$user['friend']) { ?>checked<?php } ?>/><span class="icon"></span>否</label>
        </td>
      </tr>
      <tr>
        <th>公开个人朋友圈</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="circle" value="1" <?php if($user['circle']==1) { ?>checked<?php } ?>/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="circle" value="0" <?php if(!$user['circle']) { ?>checked<?php } ?>/><span class="icon"></span>否</label>
        </td>
      </tr>
      <?php } ?>
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