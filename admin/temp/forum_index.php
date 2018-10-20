<?exit?>
<ul class="catalog cl">
  <li{if !$_GET['show']} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&iframe=yes">论坛管理</a></li>
  <li{if $_GET['show']=='other'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&show=other&iframe=yes">未关联板块</a></li>
</ul>
<!--{if in_array($_GET['ac'],array('add','edit'))}-->
<div class="block">
  <h3><!--{if $_GET['ac']=='add'}--><!--{if $_GET['gid']}-->添加板块<!--{else}-->添加分区<!--{/if}--><!--{else}--><!--{if $_GET['gid']}-->设置分区<!--{else}-->设置板块<!--{/if}--><!--{/if}--></h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <!--{if $_GET['gid']}-->
    <input name="gid" type="hidden" value="$_GET['gid']" />
    <!--{elseif $_GET['tid']}-->
    <input name="tid" type="hidden" value="$_GET['tid']" />
    <!--{/if}-->
    <table class="table" cellpadding="0" cellspacing="0">
      <!--{if ($_GET['ac']=='add' && !$_GET['gid']) || ($_GET['ac']=='edit' && $_GET['gid'])}-->
      <tr>
        <th>分区名称</th>
        <td><input type="text" class="input w300" name="name" value="$group['name']"></td>
      </tr>
      <tr>
        <th>隐藏</th>
        <td><label class="checkbox"><input type="checkbox" class="check" name="hidden" value="1" {if $group['hidden']}checked{/if}/><span class="icon"></span></label><em>是否隐藏分区不显示</em></td>
      </tr>
      <tr>
        <th>版主</th>
        <td><input type="text" class="input w300" name="manager" value="$group['manager']"><em>输入版主的用户名，多个用空格隔开</em></td>
      </tr>    
      <tr>
        <th>介绍</th>
        <td><textarea class="textarea" name="about">$group['about']</textarea></td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button>
          </td>
        </tr>  
      </tfoot>
      <!--{else}-->
      <tr>
        <th>板块名称</th>
        <td><input type="text" class="input w300" name="name" value="$forum['name']"></td>
      </tr>
      <!--{if $forum}-->
      <tr>
        <th>设置为话题</th>
        <td><label class="checkbox"><input type="checkbox" class="check" name="settopic" value="1" onclick="set_topic()"/><span class="icon"></span>将本板块设置为话题</label></td>
      </tr>
      <tr id="settopic" style="display:none">
        <th>所属分类</th>
        <td>
          <div class="select">
            <select name="typeid">
              <!--{loop $_S['cache']['topic_types'] $value}-->
              <option value="$value['typeid']" >$value['name']</option>
              <!--{/loop}-->
            </select>
          </div>  
        </td>
      </tr>
      <!--{/if}-->
      <tr id="setforum">
        <th>所属分区</th>
        <td>
          <div class="select">
            <select name="groupid">
              <!--{loop $_S['cache']['topic_groups'] $value}-->
              <option value="$value['gid']"{if $value['gid']==$forum['gid'] || $value['gid']==$_GET['gid']} selected{/if}>$value['name']</option>
              <!--{/loop}-->
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>图标</th>
        <td><!--{if $forum['cover']}--><img src="$_S[atc]/$forum['cover']"><!--{/if}--><input type="file" name="cover"></td>
      </tr>
      <tr>
        <th>顶部banner</th>
        <td><!--{if $forum['banner']}--><img src="$_S[atc]/$forum['banner']"><!--{/if}--><input type="file" name="banner"></td>
      </tr>
      <tr>
        <th>介绍</th>
        <td><textarea class="textarea" name="about">$forum['about']</textarea></td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button><em>更多管理项目请直接通过前端进行管理</em>
          </td>
        </tr>  
      </tfoot>    
      <!--{/if}-->
    </table>
  </form>
</div>
<script language="javascript">
  function set_topic(){
		if($('#settopic').css('display')=='none'){
			$('#settopic').show();
			$('#setforum').hide();
		}else{
			$('#settopic').hide();
			$('#setforum').show();
		}
	}

</script>
<!--{else}-->
<!--{if $_GET['show']=='other'}-->
<!--{if $others}-->
<form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&show=other" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="dosubmit" type="hidden" value="true" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="w80">帖子数</td>
        <td>板块名称</td>
        
      </tr>
    </thead>
    <!--{loop $others $forum}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="tid[]" value="$forum['tid']"/><span class="icon"></span></label></td>
        <td class="w80">$forum['themes']</td>
        <td>$forum['name']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&tid=$forum['tid']&iframe=yes"><em>[编辑]</em></a></td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'tid[]')"/><span class="icon"></span></label></td>
        <td colspan="2"><button type="button" class="button" onclick="checkdelete(this.form,'tid')">提交</button></td>
      </tr>
    </tfoot>
  </table>
</form>
<!--{else}-->
<p class="empty">目前没有未关联板块</p>
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
        <td class="s">Tid</td>
        <td class="l">顺序</td>
        <td>名称</td>
      </tr>
    </thead>
    <!--{if $groups}-->
    <!--{loop $groups $value}-->
    <input type="hidden" name="gids[]" value="$value['gid']">
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="gid[]" value="$value['gid']"/><span class="icon"></span></label></td>
        <td class="s"></td>
        <td class="l"><input type="text" class="input" name="grouplist[]" value="$value['list']"></td>
        <td>
        $value['name']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&gid=$value['gid']&iframe=yes"><em>[编辑]</em></a><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=add&gid=$value['gid']&iframe=yes"><em>[添加板块]</em></a>
        </td>
      </tr>
    </tbody>
    <!--{loop $forums[$value['gid']] $forum}-->
    <input type="hidden" name="tids[]" value="$forum['tid']">
    <tbody>
      <tr>
        <td class="s"></td>
        <td class="s">$forum['tid']</td>
        <td class="l"><input type="text" class="input" name="forumlist[]" value="$forum['list']"></td>
        <td>
        |---- $forum['name']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&tid=$forum['tid']&iframe=yes"><em>[编辑]</em></a>
        </td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <!--{/loop}-->
    <!--{/if}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'gid[]')"/><span class="icon"></span></label></td>
        <td colspan="3"><button type="button" class="button" onclick="checkdelete(this.form,'gid')">提交</button><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=add&iframe=yes">+添加分区</a></td>
      </tr>
    </tfoot>
    
  </table>
</form>


<!--{/if}-->
<!--{/if}-->

