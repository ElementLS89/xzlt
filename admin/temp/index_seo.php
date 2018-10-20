<?exit?>
<div class="block">
  <h3>SEO设置</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>站点关键词</th>
        <td><input type="text" class="input w300" name="keywords" value="$_S['setting']['keywords']"><em>设置网站的关键词，多个用逗号隔开</em></td>
      </tr>
      <tr>
        <th>站点描述</th>
        <td><textarea class="textarea" name="description">$_S['setting']['description']</textarea></td>
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

