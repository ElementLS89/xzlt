<?exit?>
<ul class="catalog cl">
  <!--{if $_GET['ac']=='manage'}-->
  <li{if !$_GET['op']} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=manage&typeid=$_GET['typeid']&iframe=yes">管理表情</a></li>
  <li{if $_GET['op']=='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=manage&typeid=$_GET['typeid']&op=add&iframe=yes">添加表情</a></li>
  <!--{else}-->
  <li{if !$_GET['ac'] || $_GET['ac']=='edit'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&iframe=yes">表情分类</a></li>
  <li{if $_GET['ac']=='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=add&iframe=yes">添加表情分类</a></li>  
  <!--{/if}-->

</ul>
<!--{if in_array($_GET['ac'],array('add','edit'))}-->
<div class="block">
  <h3>{if $_GET['ac']=='add'}添加表情分类{else}编辑表情分类{/if}</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <!--{if $_GET['typeid']}-->
    <input name="typeid" type="hidden" value="$_GET['typeid']" />
    <!--{/if}-->
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>名称</th>
        <td><input type="text" class="input w300" name="name" value="$smiletype['name']"><em>起一个便于大家理解的名称</em></td>
      </tr>
      <tr>
        <th>目录</th>
        <td><input type="text" class="input w300" name="dir" value="$smiletype['dir']"><em>每个表情包都存放在static/smile/目录下，修改或者创建新的表情分类请通过FTP创建新的表情包文件夹以及上传表情图片</em></td>
      </tr>
      <tr>
        <th>顺序</th>
        <td><input type="text" class="input" name="list" value="$smiletype['list']"><em>数字越小越靠前</em></td>
      </tr>
      <tr>
        <th>启用</th>
        <td><label class="checkbox"><input type="checkbox" class="check" name="canuse" value="1" {if $smiletype['canuse']}checked="checked"{/if}/><span class="icon"></span></label><em>是否启用本表情</em></td>
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
<!--{elseif $_GET['ac']=='manage'}-->
<!--{if $_GET['op']=='add'}-->
<div class="block">
  <h3>添加表情</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']&typeid=$_GET['typeid']&op=add" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>表情图片</th>
        <td><input type="text" class="input w300" name="pic" value=""><em>填写表情图片的文件名称</em></td>
      </tr>
      <tr>
        <th>文字解析</th>
        <td><input type="text" class="input w300" name="str" value=""><em>用于再表情未解析的情况下显示的文字</em></td>
      </tr>
      <tr>
        <th>顺序</th>
        <td><input type="text" class="input" name="list" value=""><em>数字越小越靠前</em></td>
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
<form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']&typeid=$_GET['typeid']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="l">顺序</td>
        <td class="w200">文字解析</td>
        <td>图片</td>
        
      </tr>
    </thead>
    <!--{loop $smiles $id $value}-->
    <input type="hidden" name="ids[]" value="$value['id']">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="id[]" value="$value['id']"/><span class="icon"></span></label></td>
        <td class="l"><input type="text" class="input" name="list[$id]" value="$value['list']"></td>
        <td class="w200"><input type="text" class="input" name="str[$id]" value="$value['str']"></td>
        <td><img src="{$smiletype['dir']}/{$value['pic']}" style="width:32px; height:32px;" /><input type="text" class="input" name="pic[$id]" value="$value['pic']"></td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'id[]')"/><span class="icon"></span></label></td>
        <td colspan="3"><button type="button" class="button" onclick="checkdelete(this.form,'id')">提交</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{/if}-->

<!--{else}-->
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
        <td class="l">启用</td>
        <td class="w300">名称</td>
        <td>目录</td>
        
      </tr>
    </thead>
    <!--{loop $smiletypes $typeid $value}-->
    <input type="hidden" name="typeids[]" value="$value['typeid']">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="typeid[]" value="$value['typeid']"/><span class="icon"></span></label></td>
        <td class="l"><input type="text" class="input" name="list[$typeid]" value="$value['list']"></td>
        <td class="l"><label class="checkbox"><input type="checkbox" class="check" name="canuse[$typeid]" value="1" {if $value['canuse']}checked="checked"{/if}/><span class="icon"></span></label></td>
        <td class="w300">$value['name']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&typeid=$value['typeid']&iframe=yes"><em>[编辑]</em></a><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=manage&typeid=$value['typeid']&iframe=yes"><em>[管理]</em></a></td>
        <td>$value['dir']</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'typeid[]')"/><span class="icon"></span></label></td>
        <td colspan="4"><button type="button" class="button" onclick="checkdelete(this.form,'typeid')">提交</button></td>
      </tr>
    </tfoot>
    
  </table>
</form>


<!--{/if}-->