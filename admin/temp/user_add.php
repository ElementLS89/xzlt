<?exit?>
<div class="block">
  <h3>{if $user}编辑用户{else}添加用户{/if}</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <input name="uid" type="hidden" value="$_GET['uid']" />
    <input name="ref" type="hidden" value="$_GET['ref']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <!--{if $user['uid']}-->
      <tr>
        <th>头像</th>
        <td><!--{avatar($user['uid'],1)}--><input type="file" name="avatar"></td>
      </tr>
      <!--{/if}-->
      <tr>
        <th>用户组</th>
        <td>
          <div class="select">
            <select name="groupid">
              <!--{loop $_S['cache']['usergroup'] $value}-->
              <option value="$value['gid']" {if $value['gid']==$user['groupid'] || (!$user && $value['gid']=='10')}selected{/if}>$value['name']</option>
              <!--{/loop}-->
            </select>
          </div>  
        </td>
      </tr>

      <tr>
        <th>用户名</th>
        <td><input type="text" class="input w300" name="username" value="$user['username']"></td>
      </tr>
      <tr>
        <th>密码</th>
        <td><input type="text" class="input w300" name="password" value="$user['name']"></td>
      </tr>
      <!--{if $_GET['item']=='edit'}-->
      <tr>
        <th>Openid</th>
        <td><input type="text" class="input w300" name="openid" value="$user['openid']"><em>用户的Openid，请勿随意修改错误的修改会导致用户无法微信登录和支付</em></td>
      </tr> 
      <tr>
        <th>mini</th>
        <td><input type="text" class="input w300" name="mini" value="$user['mini']"><em>用户小程序的miniID，请勿随意修改错误的修改会导致用户无法微信登录</em></td>
      </tr> 
      <tr>
        <th>DZuid</th>
        <td><input type="text" class="input w300" name="dzuid" value="$user['dzuid']"><em>设置用户的Discuz论坛的UID,若无Discuz这里可留空</em></td>
      </tr>         
      <tr>
        <th>Email</th>
        <td><input type="text" class="input w300" name="email" value="$user['email']"></td>
      </tr>
      <tr>
        <th>电话</th>
        <td><input type="text" class="input w300" name="tel" value="$user['tel']"></td>
      </tr>
      <tr class="line"><td colspan="2"></td></tr>
      <tr>
        <th>关注人数</th>
        <td><input type="text" class="input" name="follow" value="$user['follow']"></td>
      </tr>
      <tr>
        <th>粉丝人数</th>
        <td><input type="text" class="input" name="fans" value="$user['fans']"></td>
      </tr>
      <tr>
        <th>钱包余额</th>
        <td><input type="text" class="input" name="balance" value="$user['balance']"><a href="admin.php?mod=data&item=count&iframe=true&uid=$user['uid']&fild=balance&searchsubmit=true">查看记录</a></td>
      </tr>
      <tr>
        <th>代金券</th>
        <td><input type="text" class="input" name="gold" value="$user['gold']"><a href="admin.php?mod=data&item=count&iframe=true&uid=$user['uid']&fild=gold&searchsubmit=true">查看记录</a></td>
      </tr>
      <tr>
        <th>经验值</th>
        <td><input type="text" class="input" name="experience" value="$user['experience']"><a href="admin.php?mod=data&item=count&iframe=true&uid=$user['uid']&fild=experience&searchsubmit=true">查看记录</a></td>
      </tr>
      <tr class="line"><td colspan="2"></td></tr>
      <!--{loop $_S['cache']['userfield'] $field $value}-->
      <!--{if $value['canuse']}-->
      <tr>
        <th>$value['name']</th>
        <td>
        <!--{if $value['type']=='text'}-->
        <input type="text" class="input w300" name="$field" value="$user[$field]">
        <!--{elseif $value['type']=='number'}-->
        <input type="text" class="input" name="$field" value="$user[$field]"><em>$value['unit']</em>
        <!--{elseif $value['type']=='date'}-->
        <!--{eval $user[$field]=smsdate($user[$field],$value['datetype']);}-->
        <input type="text" class="input" name="$field" value="$user[$field]"><em>例：{$value['datetype']}</em>
        <!--{elseif $value['type']=='textarea'}-->
        <textarea class="textarea" name="$field">$user[$field]</textarea>
        <!--{elseif $value['type']=='file'}-->
        <!--{if $user[$field]}--><img src="$_S['atc']/$user[$field]" /><!--{/if}--><input type="file" name="$field">
        <!--{elseif $value['type']=='radio'}-->
        <!--{loop $value['choises'] $k $n}-->
        <label class="radio"><input type="radio" class="check" name="$field" value="$k" {if $user[$field]==$k}checked="checked"{/if}/><span class="icon"></span>$n</label>
        <!--{/loop}-->
        <!--{elseif $value['type']=='checkbox'}-->
        <!--{eval $user[$field]=explode(',',$user[$field]);}-->
        <!--{loop $value['choises'] $k $n}-->
        <label class="checkbox"><input type="checkbox" class="check" name="$field[]" value="$k" {if in_array($k,$user[$field])}checked="checked"{/if}/><span class="icon"></span>$n</label>
        <!--{/loop}-->
        <!--{elseif $value['type']=='select'}-->
        <div class="select">
          <select name="$field">
            <option>请选择</option>
            <!--{loop $value['choises'] $k $n}-->
            <option value="$k" {if $user[$field]==$k}selected="selected"{/if}>$n</option>
            <!--{/loop}-->
          </select>
        </div>  
        <!--{/if}-->
  
        </td>
      </tr>
      <!--{/if}-->
      <!--{/loop}-->
  
      <tr class="line"><td colspan="2"></td></tr>
      <tr>
        <th>经度坐标</th>
        <td>
          <input type="text" class="input" name="lat" value="$user['lat']">
        </td>
      </tr>
      <tr>
        <th>纬度坐标</th>
        <td>
          <input type="text" class="input" name="lng" value="$user['lng']">
        </td>
      </tr>
      <tr>
        <th>geohash</th>
        <td>
          <input type="text" class="input" name="geohash" value="$user['geohash']">
        </td>
      </tr>
      <tr>
        <th>国家</th>
        <td>
          <input type="text" class="input w300" name="nation" value="$user['nation']">
        </td>
      </tr>
      <tr>
        <th>省份</th>
        <td>
          <input type="text" class="input w300" name="province" value="$user['province']">
        </td>
      </tr>
      <tr>
        <th>城市</th>
        <td>
          <input type="text" class="input w300" name="city" value="$user['city']">
        </td>
      </tr>
      <tr>
        <th>区</th>
        <td>
          <input type="text" class="input w300" name="district" value="$user['district']">
        </td>
      </tr>
      <tr>
        <th>地址</th>
        <td>
          <input type="text" class="input w300" name="addr" value="$user['addr']">
        </td>
      </tr>
      <tr class="line"><td colspan="2"></td></tr>
      <tr>
        <th>公开地理定位</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="lbs" value="1" {if $user['lbs']==1}checked{/if}/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="lbs" value="0" {if !$user['lbs']}checked{/if}/><span class="icon"></span>否</label>
        </td>
      </tr>
      <tr>
        <th>公开个人资料</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="profile" value="1" {if $user['profile']==1}checked{/if}/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="profile" value="0" {if !$user['profile']}checked{/if}/><span class="icon"></span>否</label>
        </td>
      </tr>
      <tr>
        <th>允许接收临时消息</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="pm" value="1" {if $user['pm']==1}checked{/if}/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="pm" value="0" {if !$user['pm']}checked{/if}/><span class="icon"></span>否</label>
        </td>
      </tr>
      <tr>
        <th>加好友免验证</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="friend" value="1" {if $user['friend']==1}checked{/if}/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="friend" value="0" {if !$user['friend']}checked{/if}/><span class="icon"></span>否</label>
        </td>
      </tr>
      <tr>
        <th>公开个人朋友圈</th>
        <td>
          <label class="radio"><input type="radio" class="check" name="circle" value="1" {if $user['circle']==1}checked{/if}/><span class="icon"></span>是</label>
          <label class="radio"><input type="radio" class="check" name="circle" value="0" {if !$user['circle']}checked{/if}/><span class="icon"></span>否</label>
        </td>
      </tr>
      <!--{/if}-->
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