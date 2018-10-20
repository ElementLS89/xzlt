<?exit?>
<ul class="nextcat cl">
  <li{if !$_GET['t']} class="a"{/if}><a href="admin.php?mod=topic&item=post&iframe=yes">表0</a></li>
  <li{if $_GET['t']=='1'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=1&iframe=yes">表1</a></li>
  <li{if $_GET['t']=='2'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=2&iframe=yes">表2</a></li>
  <li{if $_GET['t']=='3'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=3&iframe=yes">表3</a></li>
  <li{if $_GET['t']=='4'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=4&iframe=yes">表4</a></li>
  <li{if $_GET['t']=='5'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=5&iframe=yes">表5</a></li>
  <li{if $_GET['t']=='6'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=6&iframe=yes">表6</a></li>
  <li{if $_GET['t']=='7'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=7&iframe=yes">表7</a></li>
  <li{if $_GET['t']=='8'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=8&iframe=yes">表8</a></li>
  <li{if $_GET['t']=='9'} class="a"{/if}><a href="admin.php?mod=topic&item=post&t=9&iframe=yes">表9</a></li>

</ul>

<!--{if $list}-->
<form action="$urlstr&page=$_S['page']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="deletesubmit" id="deletesubmit" type="hidden" value="" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">选择</td>
        <td class="w150">作者</td>
        <td class="w400">帖子</td>
        <td>回复内容</td>
      </tr>
    </thead>
    <!--{loop $list $value}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="pid[]" value="$value['pid']"/><span class="icon"></span></label></td>
        <td class="w150">{if $value['uid']}<a href="user.php?uid=$value['uid']" target="_blank">$value['username']</a>{else}/{/if}</td>
        <td class="w400"><a href="topic.php?vid=$value['vid']" target="_blank">$value['subject']</a></td>
        <td>$value['content']</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'pid[]')"/><span class="icon"></span></label></td>
        <td colspan="3">$pages<button type="button" class="button w" onclick="checkdelete(this.form,'pid','deletesubmit')">删除</button><button type="submit" class="button" name="examinesubmit" value="true">审核</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">暂无需要审核的回帖</p>
<!--{/if}-->