<?exit?>
<div class="block">
  <h3>积分策略说明</h3>
  <ul class="block_info">
    <li>系统自带两种积分，一种是经验值一种是代金券</li>
    <li>经验值与用户等级提升有关</li>
    <li>代金券可以直接参与购买支付抵扣现金，关于代金券的获得请慎重设置</li>
  </ul>
</div>

<!--{if $_GET['ac']=='edit'}-->
<div class="block">  
  <h3>$credit['name']</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <input name="cid" type="hidden" value="$_GET['cid']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>周期</th>
        <td>
          <div class="select">
            <select name="cycle">
              <option value="1"{if $credit['cycle']==1} selected{/if}>首次</option>
              <option value="2"{if $credit['cycle']==2} selected{/if}>每天</option>
              <option value="3"{if $credit['cycle']==3} selected{/if}>不限</option>
            </select>
          </div>
        </td>
      </tr>
      <tr>
        <th>周期内奖励次数</th>
        <td><input type="text" class="input" name="rewardnum" value="$credit['rewardnum']"><em>0为不限制,只有周期为每天的才需要设置奖励次数</em></td>
      </tr>
      <tr>
        <th>经验</th>
        <td><input type="text" class="input" name="experience" value="$credit['experience']"></td>
      </tr>
      <tr>
        <th>代金券</th>
        <td><input type="text" class="input" name="gold" value="$credit['gold']"></td>
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
<!--{else}-->
<form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">ID</td>
        <td class="w150">动作</td>
        <td class="l">周期</td>
        <td class="l">次数</td>
        <td class="l">经验</td>
        <td class="l">代金券</td>
        <td>设置</td>
      </tr>
    </thead>
    <!--{loop $credits $cid $value}-->
    <tbody>
      <tr>
        <td class="s">$value['cid']<input name="cids[]" type="hidden" value="$cid" /></td>
        <td class="w150">$value['name']</td>
        <td class="l">{if $value['cycle']==1}首次{elseif $value['cycle']==2}每天{else}不限{/if}</td>
        <td class="l">{if $value['cycle']==2}{if $value['rewardnum']}$value['rewardnum']{else}不限{/if}{else}/{/if}</td>
        <td class="l"><input type="text" class="input" name="experience[$cid]" value="$value['experience']"></td>
        <td class="l"><input type="text" class="input" name="gold[$cid]" value="$value['gold']"></td>
        <td><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&cid=$value['cid']&iframe=yes">[设置]</a></td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"></td>
        <td colspan="5"><button type="submit" class="button" name="submit" value="true">设置</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{/if}-->  
