<?exit?>
<!--{if $list}-->
<form action="$urlstr&page=$_S['page']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
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
    <!--{loop $list $value}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="uid[]" value="$value['uid']"/><span class="icon"></span></label></td>
        <td class="s">$value['uid']</td>
        <td class="w200">$value['openid']</td>
        <td class="w200">$value['mini']</td>
        <td class="w300"><!--{avatar($value['uid'],1)}--><a href="user.php?uid=$value['uid']" target="_blank">$value['username']</a><a href="admin.php?mod=$_GET['mod']&item=edit&uid=$value['uid']&iframe=yes&ref=$ref"><em>[编辑]</em></a></td>
        <td class="m">{if $value['openid']}已绑定{else}未绑定{/if}</td>
        <td class="w100">{if $value['tel']}$value['tel']{else}未绑定{/if}</td>
        <td class="w150">$_S['cache']['usergroup'][$value['groupid']]['name']</td>
        <td class="m">$value['balance']</td>
        <td class="m">$value['gold']</td>
        <td class="m">$value['experience']</td>
        <td class="w150">{date($value['regdate'],'Y-m-d H:i')}</td>
        <td>{date($value['lastactivity'],'Y-m-d H:i')}</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'uid[]')"/><span class="icon"></span></label></td>
        <td colspan="13">$pages<button type="button" class="button w" onclick="checkdelete(this.form,'uid','deletesubmit')">删除</button>{if $_GET['item']=='review' || $_GET['search']['state']==0}<button type="submit" class="button" name="examinesubmit" value="true">通过</button>{/if}</td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">没有找到符合条件的用户</p>
<!--{/if}-->