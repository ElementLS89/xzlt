<?exit?>
<!--{if $_GET['searchsubmit']}-->
<!--{if $list}-->
<form action="$urlstr&page=$_S['page']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
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
    <!--{loop $list $value}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="lid[]" value="$value['lid']"/><span class="icon"></span></label></td>
        <td class="w300">$value['lid']</td>
        <td class="w100 tc">{if $value['fild']=='gold'}代金券{elseif $value['fild']=='balance'}余额{else}经验{/if}</td>
        <td class="w100 tc">$value['arose']</td>
        <td class="w300">$value['title']</td>
        <td class="w200"><!--{if $value['uid']}--><!--{avatar($value['uid'],1)}--><a href="user.php?uid=$value['uid']" target="_blank">$value['username']</a><!--{else}-->游客<!--{/if}--></td>
        <td>{date($value['logtime'],'Y-m-d H:i')}</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'lid[]')"/><span class="icon"></span></label></td>
        <td colspan="8">$pages<button type="button" class="button w" onclick="checkdelete(this.form,'lid')">删除</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">暂无符合条件的支付信息</p>
<!--{/if}-->
<!--{else}-->
<div class="block">
  <h3>账户变动记录</h3>
  <form action="admin.php" method="get">
    <input name="mod" type="hidden" value="$_GET['mod']" />
    <input name="item" type="hidden" value="$_GET['item']" />
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
<!--{/if}-->