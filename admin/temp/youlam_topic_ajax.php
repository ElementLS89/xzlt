<div id="tips_ajax_list">
	<form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
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
		<input type="hidden" name="vids[]" value="$value['vid']">
		<tbody>
		  <tr>
			<td class="s"><label class="checkbox"><input type="checkbox" class="check"  name="vid[]" value="$value['vid']"/><span class="icon"></span></label></td>
			<td class="l"><input type="text" class="input" name="list[]" value="$value['vid']"></td>
			<td class="w300">
			<img src="$_S[atc]/$value['pic']" />$value['subject']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&vid=$value['vid']&iframe=yes"><em>[编辑]</em></a>
			</td>
			<td>$value['link']</td>
		  </tr>
		</tbody>
		<!--{/loop}-->
		<tfoot>
		  <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'vid[]')"/><span class="icon"></span></label></td>
			<td colspan="3" id="tipsAddNav">
				<button type="button" class="button" onclick="checkdelete(this.form,'vid')">提交</button>
				<a href="javascript:void(0)" class="btn_login" onclick="youlam_btn_showTipsAdd()">+增加导航</a>
			</td>
		</tfoot>

	  </table>
	</form>
</div>

<div id="youlam_ajax_miniWin_types_div_name">
<!--{loop $typesList['types'] $id $name}-->
	<input type="hidden" name="typeid[]" value="$id" >
    <input type="text" class="input 1" name="typename[]" value="$name">
<!--{/loop}-->
	<input type="hidden" id="youlam_ajax_miniWin_types_name_id" name="typeid[]" value="" >
    <input type="hidden" id="youlam_ajax_miniWin_input_name_array" class="input w300" name="typename[]" value="">
</div>