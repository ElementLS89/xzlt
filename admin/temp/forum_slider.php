<?exit?>
<ul class="catalog cl">
  <li{if $_GET['ac']!='add' && $_GET['ac']!='size'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&iframe=yes">幻灯片管理</a></li>
  <li{if $_GET['ac']=='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=add&iframe=yes">添加幻灯片</a></li>
  <li{if $_GET['ac']=='size'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=size&iframe=yes">设置幻灯片尺寸</a></li>
</ul>
<!--{if in_array($_GET['ac'],array('add','edit'))}-->
<div class="block">
  <h3>{if $_GET['ac']=='add'}添加幻灯片{else}设置幻灯片{/if}</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <input name="type" type="hidden" value="forum" />
    <!--{if $_GET['sid']}-->
    <input name="sid" type="hidden" value="$_GET['sid']" />
    <!--{/if}-->
    <table class="table" cellpadding="0" cellspacing="0">
  
      <tr>
        <th>名称</th>
        <td><input type="text" class="input w300" name="name" value="$slider['name']"></td>
      </tr>
      <tr>
        <th>链接地址</th>
        <td><input type="text" class="input w300" name="url" value="$slider['url']"></td>
      </tr>
      <tr>
        <th>图片</th>
        <td>{if $slider['pic']}<img src="$_S[atc]/$slider['pic']">{/if}<input type="file" name="pic"></td>
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
<!--{elseif $_GET['ac']=='size'}-->
<div class="block">
  <h3>关于尺寸的设置</h3>
  <ul class="block_info">
    <li>为确保手机retain显示屏的高清效果建议宽度设置为600-800</li>
    <li>高度建议不超过宽度的50%</li>
    <li>尺寸设置之后，之前上传过的幻灯片图片需要重新上传才能生效</li>
  </ul> 
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
  
      <tr>
        <th>宽度</th>
        <td><input type="text" class="input" name="width" value="$_S['setting']['forum_slider_width']"><em>像素</em></td>
      </tr>
      <tr>
        <th>高度</th>
        <td><input type="text" class="input" name="height" value="$_S['setting']['forum_slider_height']"><em>像素</em></td>
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
{if $sliders}
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
    <!--{loop $sliders $value}-->
    <input type="hidden" name="sids[]" value="$value['sid']">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="sid[]" value="$value['sid']"/><span class="icon"></span></label></td>
        <td class="l"><input type="text" class="input" name="list[]" value="$value['list']"></td>
        <td class="w300">
        <img src="$_S[atc]/$value['pic']" />$value['name']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&sid=$value['sid']&iframe=yes"><em>[编辑]</em></a>
        </td>
        <td>$value['url']</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'sid[]')"/><span class="icon"></span></label></td>
        <td colspan="3"><button type="button" class="button" onclick="checkdelete(this.form,'sid')">提交</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">暂未添加幻灯片</p>
<!--{/if}-->
<!--{/if}-->