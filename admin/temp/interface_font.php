<?exit?>
<ul class="catalog cl">
  <li{if !$_GET['op']} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&iframe=yes">图标库设置</a></li>
  <li{if $_GET['op']=='icon'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&op=icon&iframe=yes">自定义图标样式</a></li>

</ul>
<!--{if $_GET['op']}-->
<!--{if in_array($_GET['ac'],array('add','edit'))}-->
  <div class="block">
    <h3>{if $_GET['ac']=='add'}添加自定义图标{else}编辑自定义图标{/if}</h3>
    <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&op=icon&ac=$_GET['ac']" method="post">
      <input name="iframe" type="hidden" value="true" />
      <input name="hash" type="hidden" value="$_S['hash']" />
      <!--{if $_GET['fid']}-->
      <input name="fid" type="hidden" value="$_GET['fid']" />
      <!--{/if}-->
      <table class="table" cellpadding="0" cellspacing="0">
        <tr>
          <th class="need">名称</th>
          <td><input type="text" class="input w300" name="name" value="$icon['name']"><em>起一个名字，只能由英文字母组成</em></td>
        </tr>
        <tr>
          <th class="need">图标代码</th>
          <td><input type="text" class="input w300" name="code" value="$icon['code']"><em>阿里图标代码是类似这样的“&#x<span class="c">e629</span>;”只需填写“e629”即可</em></td>
        </tr>
        <tr>
          <th>触发时代码</th>
          <td><input type="text" class="input w300" name="code_on" value="$icon['code_on']"><em>触发时只是当前图标可以点亮，若无可不设置，设置方法同上</em></td>
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
<!--{else}-->
<form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&op=icon" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="l">图标</td>
        <td class="w100">名称</td>
        <td class="w100">代码</td>
        <td class="w100">触发</td>
        <td>调用代码</td>
      </tr>
    </thead>
    <!--{loop $icons $fid $value}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="fids[]" value="$value['fid']"/><span class="icon"></span></label></td>
        <td class="l"><span class="selficon s-{$value['name']}"></span></td>
        <td class="w100"><input type="text" class="input" name="name[$fid]" value="$value['name']"></td>
        <td class="w100"><input type="text" class="input" name="code[$fid]" value="$value['code']"></td>
        <td class="w100"><input type="text" class="input" name="code_on[$fid]" value="$value['code_on']"></td>
        <td>selficon+s-{$value['name']}</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'fids[]')"/><span class="icon"></span></label></td>
        <td colspan="4"><button type="button" class="button" onclick="checkdelete(this.form,'fids')">提交</button><a href="admin.php?mod=interface&item=font&op=icon&ac=add&iframe=yes">+添加自定义图标</a></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{/if}-->
<!--{else}-->
<div class="block">
  <h3>自定义图标库</h3>
  <ul class="block_info">
    <li>这里需要前往阿里矢量图标库注册账号（http://www.iconfont.cn/）</li>
    <li>注册账号之后创建自己的图标项目，就可以将选中的图标添加到自己的项目中，然后就可以添加自定义图标到系统中</li>
    <li>添加方法,只需要将类似如下标红位置的代码添加进去即可<span class="c">（注意下方代码只是示例，需要的是您所生成的Unicode代码内的标红代码位置处的代码）</span><br />
@font-face {<br />
&nbsp;&nbsp;&nbsp;&nbsp;font-family: 'iconfont';  /* project id 561027 */<br />
&nbsp;&nbsp;&nbsp;&nbsp;src: url('//at.alicdn.com/t/<span class="c">font_561027_l7dn0zqynl8fr</span>.eot');<br />
&nbsp;&nbsp;&nbsp;&nbsp;src: url('//at.alicdn.com/t/<span class="c">font_561027_l7dn0zqynl8fr</span>.eot?#iefix') format('embedded-opentype'),<br />
&nbsp;&nbsp;&nbsp;&nbsp;url('//at.alicdn.com/t/<span class="c">font_561027_l7dn0zqynl8fr</span>.woff') format('woff'),<br />
&nbsp;&nbsp;&nbsp;&nbsp;url('//at.alicdn.com/t/<span class="c">font_561027_l7dn0zqynl8fr</span>.ttf') format('truetype'),<br />
&nbsp;&nbsp;&nbsp;&nbsp;url('//at.alicdn.com/t/<span class="c">font_561027_l7dn0zqynl8fr</span>.svg#iconfont') format('svg');<br />
}</li>
    <li>以上标红代码都是一样的，填写一个即可</li>
  </ul>
</div>
<div class="block">
  <h3>设置自己的自定义图标库</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>图标代码</th>
        <td>
        <input type="text" class="input w300" name="self_font" value="$_S['setting']['self_font']">
        <em>将生成的Unicode代码填写进去</em>
        </td>
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


<!--{/if}-->