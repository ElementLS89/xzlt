<?exit?>
<div class="block">
  <h3>宣传海报</h3>
  <ul class="block_info">
    <li>设置宣传海报的默认数据</li>
    <li>通过宣传海报可以将内容页生成海报的形式让用户下载分享到朋友圈或发送给朋友</li>
  </ul>

</div>
<div class="block">
  <h3>设置站点信息</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>默认标题</th>
        <td><input type="text" class="input w300" name="poster_title" value="$_S['setting']['poster_title']"><em>设置海报的默认宣传标题，此处文字最好不要超过36个字</em></td>
      </tr>
      <tr>
        <th>默认描述</th>
        <td><textarea class="textarea" name="poster_summary">$_S['setting']['poster_summary']</textarea><em>设置标题下方的文字描述，此处文字控制再80个字以内</em></td>
      </tr>
      <tr>
        <th>默认图片</th>
        <td><!--{if $_S['setting']['poster_pic']}--><img src="$_S[atc]/$_S['setting']['poster_pic']"><!--{/if}--><input type="file" name="poster_pic"><em>当内容页没有图片时将由本图代替生成海报，尺寸为640*600</em>$_S['setting']['poster_pic']</td>
      </tr>
      <tr>
        <th>默认名称</th>
        <td><input type="text" class="input w300" name="poster_name" value="$_S['setting']['poster_name']"><em>海报名称，6个字以内</em></td>
      </tr>
      <tr>
        <th>默认说明</th>
        <td><input type="text" class="input w300" name="poster_info" value="$_S['setting']['poster_info']"><em>关于本海报的使用说明文字10个字以内</em></td>
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