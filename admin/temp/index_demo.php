<?exit?>
<ul class="catalog cl">
  <li class="a"><a href="">123</a></li>
  <li><a href="">123</a></li>
  <li><a href="">123</a></li>
  <li><a href="">123</a></li>
  <li><a href="">123</a></li>
  <li><a href="">123</a></li>
</ul>
<div class="explain">
  <h3 class="c">说明</h3>
  <ul>
    <li>12222222222</li>
    <li>12222222222</li>
    <li>12222222222</li>
    <li>12222222222<a href="" class="c">aaaaaaaaaaaaaaa</a>123</li>
  </ul>
  
</div>
<table class="table" cellpadding="0" cellspacing="0">
  <tr>
    <th>标题</th>
    <td><input type="text" class="input"><em>元</em><a href="">说明</a></td>
  </tr>
  <tr>
    <th class="need">标题</th>
    <td><textarea class="textarea"></textarea></td>
  </tr>
  <tr>
    <th>标题</th>
    <td><label class="checkbox"><input type="checkbox" class="check" name="lid[]" value="$log['lid']"/><span class="icon"></span></label></td>
  </tr>
  <tr>
    <th>标题</th>
    <td><label class="radio"><input type="radio" class="check" name="lid[]" value="$log['lid']"/><span class="icon"></span></label></td>
  </tr>
  <tr>
    <th>标题</th>
    <td>
        <div class="select">
          <select name="gifttype">
            <option value="0">下拉选择</option>
            <option value="1">2</option>
          </select>
        </div>      
    </td>
  </tr>
  <tfoot>
    <tr>
      <td colspan="2">
          <button type="button" class="button w">提交</button>
      </td>
    </tr>  
  </tfoot>

</table>
<table cellpadding="0" cellspacing="0" class="list">
  <thead>
    <tr>
      <td class="s">删除</td>
      <td class="l">顺序</td>
      <td>名称</td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="lid[]" value="$log['lid']"/><span class="icon"></span></label></td>
      <td class="l"><input type="text" class="input"></td>
      <td>名称</td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="lid[]" onclick="checkAll(this, 'aids[]')" value="$log['lid']"/><span class="icon"></span></label></td>
      <td colspan="2"><button type="button" class="button w">提交</button></td>
    </tr>
  </tfoot>
  
</table>