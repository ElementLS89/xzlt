
<div class="block">
  <h3>缓存说明</h3>
  <ul class="block_info">
    <li>数据缓存：更新站点的全部数据缓存</li>
    <li>模板缓存：更新模板的缓存文件，当您修改了模板文件，但是没有立即生效的时候使用</li>
  </ul>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>选择缓存类型</th>
        <td>
        <label class="checkbox"><input type="checkbox" class="check" name="cache[]" value="cache"/><span class="icon"></span>数据缓存</label>
        <label class="checkbox"><input type="checkbox" class="check" name="cache[]" value="temp"/><span class="icon"></span>模板缓存</label>
        </td>
      </tr>
      <tfoot>
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">更新缓存</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>  
</div>

