<form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post" id="tips_ajax_list">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="l">顺序</td>
        <td class="w300">名称</td>
        <td>链接地址</td>
      </tr>
    </thead>
    <!--{loop $tipsList $value}-->
    <input type="hidden" name="sids[]" value="$value['sid']">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="sid[]" value="$value['sid']"/><span class="icon"></span></label></td>
        <td class="l"><input type="text" class="input" name="list[]" value="$value['vid']"></td>
        <td class="w300">
        <img src="$_S[atc]/$value['pic']" />$value['subject']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&sid=$value['sid']&iframe=yes"><em>[编辑]</em></a>
        </td>
        <td>$value['link']</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'sid[]')"/><span class="icon"></span></label></td>
        <td colspan="3" id="tipsAddNav">
			<button id="youlam_tips_modify_btn" type="button" class="button" onclick="checkdelete(this.form,'sid')">提交</button>
			<a href="javascript:void(0)" class="btn_login" id="youlam_btn_showTipsAdd">+增加导航</a>
		</td>
    </tfoot>
    
  </table>
</form>