<?exit?>
<ul class="catalog cl">
  <li{if $_GET['ac']!='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&iframe=yes">分类管理</a></li>
  <li{if $_GET['ac']=='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=add&iframe=yes">添加分类</a></li>
</ul>
<!--{if in_array($_GET['ac'],array('add','edit'))}-->
<div class="block">
  <h3><!--{if $_GET['ac']=='add'}-->添加分类<!--{else}-->管理分类<!--{/if}--></h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post" >
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <!--{if $_GET['typeid']}-->
    <input name="typeid" type="hidden" value="$_GET['typeid']" />
    <!--{/if}-->
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>名称</th>
        <td><input type="text" class="input w300" name="name" value="$type['name']"></td>
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
<form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="s">Typeid</td>
        <td class="l">顺序</td>
        <td class="l">话题数</td>
        <td>名称</td>
      </tr>
    </thead>
    <!--{loop $types $value}-->
    <input type="hidden" name="typeids[]" value="$value['typeid']">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="typeid[]" value="$value['typeid']"/><span class="icon"></span></label></td>
        <td class="s">$value['typeid']</td>
        <td class="l"><input type="text" class="input" name="list[]" value="$value['list']"></td>
        <td class="l">
        $value['topics']
        </td>
        <td>$value['name']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&typeid=$value['typeid']&iframe=yes"><em>[编辑]</em></a></td>
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