<?exit?>
<div class="block">
  <h3>接口申请</h3>
  <ul class="block_info">
    <li>这里需要申请腾讯地图API（http://lbs.qq.com/）</li>
    <li>登录腾讯位置服务之后进入密钥(key)管理生成Key名称或获取一个字符串key，应用于请选择浏览器</li>
  </ul>
</div>
<div class="block">
  <h3>LBS地理定位</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>Key名称</th>
        <td>
        <input type="text" class="input" name="lbs_appname" value="$_S['setting']['lbs_appname']">
        <em>填写申请的KEY名称</em>
        </td>
      </tr>
      <tr>
        <th>Key秘钥</th>
        <td>
        <input type="text" class="input w300" name="lbs_appkey" value="$_S['setting']['lbs_appkey']">
        <em>填写申请的KEY秘钥</em>
        </td>
      </tr>
      <tr>
        <th>附近的人精度</th>
        <td>
        <div class="select">
          <select name="lbs_geohash">
            <option value="1" {if $_S['setting']['lbs_geohash']==1}selected="selected"{/if}>一级</option>
            <option value="2" {if $_S['setting']['lbs_geohash']==2}selected="selected"{/if}>二级</option>
            <option value="3" {if $_S['setting']['lbs_geohash']==3}selected="selected"{/if}>三级</option>
            <option value="4" {if $_S['setting']['lbs_geohash']==4}selected="selected"{/if}>四级</option>
            <option value="5" {if $_S['setting']['lbs_geohash']==5}selected="selected"{/if}>五级</option>
            <option value="6" {if $_S['setting']['lbs_geohash']==6}selected="selected"{/if}>六级</option>
            <option value="7" {if $_S['setting']['lbs_geohash']==7}selected="selected"{/if}>七级</option>
            <option value="8" {if $_S['setting']['lbs_geohash']==8}selected="selected"{/if}>八级</option>
            <option value="9" {if $_S['setting']['lbs_geohash']==9}selected="selected"{/if}>九级</option>
            <option value="10" {if $_S['setting']['lbs_geohash']==10}selected="selected"{/if}>十级</option>
          </select>
        </div><em>级别越高距离范围越小</em> 
        </td>
      </tr>
      <tr>
        <th>主动获取用户位置</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="getposition" value="1" {if $_S['setting']['getposition']}checked{/if}/><span class="icon"></span>是</label>
        <label class="radio"><input type="radio" class="check" name="getposition" value="0" {if !$_S['setting']['getposition']}checked{/if}/><span class="icon"></span>否</label>
        <em>是否在用户每次访问时主动获取用户的地理位置</em>
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