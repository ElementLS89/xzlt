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
        <td class="w150">用户</td>
        <td class="w100">类型</td>
        <td>内容</td>
        <td class="w150">时间</td>
      </tr>
    </thead>
    <!--{loop $list $value}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="fid[]" value="$value['fid']"/><span class="icon"></span></label></td>
        <td class="w150"><!--{if $value['uid']}--><!--{avatar($value['uid'],1)}--><a href="user.php?uid=$value['uid']" target="_blank">$value['username']</a><!--{else}-->游客<!--{/if}--></td>
        <td class="w100"><!--{if $value['type']==1}-->BUG<!--{elseif $value['type']==2}-->建议<!--{else}-->举报<!--{/if}--></td>
        <td>{if $value['link']}<a href="{$_S['setting'][siteurl]}{$value['link']}" target="_blank">{$value['link']}</a>{/if}$value['content']</td>
        <td class="w150">{date($value['dateline'],'Y-m-d H:i')}</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'fid[]')"/><span class="icon"></span></label></td>
        <td colspan="4"><button type="button" class="button w" onclick="checkdelete(this.form,'fid')">删除</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">暂无任何反馈信息</p>
<!--{/if}-->