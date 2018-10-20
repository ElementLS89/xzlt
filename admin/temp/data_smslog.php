<?exit?>
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
        <td class="w200">用户</td>
        <td class="w150">电话号码</td>
        <td class="w100">类型</td>
        <td>内容</td>
        <td class="w100 tc">是否使用</td>
        <td class="w150">时间</td>
      </tr>
    </thead>
    <!--{loop $list $value}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="lid[]" value="$value['lid']"/><span class="icon"></span></label></td>
        <td class="w200"><!--{if $value['uid']}--><!--{avatar($value['uid'],1)}--><a href="user.php?uid=$value['uid']" target="_blank">$value['username']</a><!--{else}-->游客<!--{/if}--></td>
        <td class="w150">$value['phonenumber']</td>
        <td class="w100">{if $value['item']=='reg'}注册账号{elseif $value['item']=='bind'}绑定手机{else}登录网站{/if}</td>
        <td>$value['code']['number']</td>
        <td class="tc">{if $value['isuse']}已使用{else}未使用{/if}</td>
        <td class="w150">{date($value['dateline'],'Y-m-d H:i')}</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'lid[]')"/><span class="icon"></span></label></td>
        <td colspan="6">$pages<button type="button" class="button w" onclick="checkdelete(this.form,'lid')">删除</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">暂无任何短信记录</p>
<!--{/if}-->