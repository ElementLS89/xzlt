<?exit?>
<div class="block">
  <h3>水印文件</h3>
  <ul class="block_info">
    <li>水印图片为 ui/watermark.png(请通过FTP上传替换本文件)</li>
  </ul>
</div>
<div class="block">
  <h3>水印设置</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>水印位置</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="0" {if !$_S['setting']['watermarkstatus']}checked{/if}/><span class="icon"></span>不启用水印</label><br />
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="1" {if $_S['setting']['watermarkstatus']==1}checked{/if}/><span class="icon"></span>#1</label>
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="2" {if $_S['setting']['watermarkstatus']==2}checked{/if}/><span class="icon"></span>#2</label>
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="3" {if $_S['setting']['watermarkstatus']==3}checked{/if}/><span class="icon"></span>#3</label><br />
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="4" {if $_S['setting']['watermarkstatus']==4}checked{/if}/><span class="icon"></span>#4</label>
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="5" {if $_S['setting']['watermarkstatus']==5}checked{/if}/><span class="icon"></span>#5</label>
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="6" {if $_S['setting']['watermarkstatus']==6}checked{/if}/><span class="icon"></span>#6</label><br />
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="7" {if $_S['setting']['watermarkstatus']==7}checked{/if}/><span class="icon"></span>#7</label>
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="8" {if $_S['setting']['watermarkstatus']==8}checked{/if}/><span class="icon"></span>#8</label>
        <label class="radio"><input type="radio" class="check" name="watermarkstatus" value="9" {if $_S['setting']['watermarkstatus']==9}checked{/if}/><span class="icon"></span>#9</label>
        <em>您可以设置自动为用户上传的 JPG/PNG/GIF 图片附件添加水印，请在此选择水印添加的位置(3x3 共 9 个位置可选)。不支持动画 GIF 格式</em>
        </td>
      </tr>
      <tr>
        <th>水印添加条件</th>
        <td>
        <input type="text" class="input" name="watermarkminwidth" value="$_S['setting']['watermarkminwidth']"><em>X</em><input type="text" class="input" name="watermarkminheight" value="$_S['setting']['watermarkminheight']">
        <em>设置水印添加的条件，小于此尺寸的图片附件将不添加水印</em>
        </td>
      </tr>
      <tr>
        <th>水印融合度</th>
        <td><input type="text" class="input" name="watermarktrans" value="$_S['setting']['watermarktrans']"><em>设置 GIF 类型水印图片与原始图片的融合度，范围为 1～100 的整数，数值越大水印图片透明度越低。PNG 类型水印本身具有真彩透明效果，无须此设置。</em></td>
      </tr>
      <tr>
        <th>水印质量</th>
        <td><input type="text" class="input" name="watermarkquality" value="$_S['setting']['watermarkquality']"><em>设置 JPEG 类型的图片附件添加水印后的质量参数，范围为 0～100 的整数，数值越大结果图片效果越好，但尺寸也越大。</em></td>
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