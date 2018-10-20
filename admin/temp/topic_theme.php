<?exit?>
<!--{if $_GET['searchsubmit']}-->
<!--{if $list}-->
<form action="$urlstr&page=$_S['page']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="deletesubmit" id="deletesubmit" type="hidden" value="" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">删除</td>
        <td class="s">Vid</td>
        <td class="w150">作者</td>
        <td class="w150">所属</td>
        <td class="l">查看</td>
        <td class="l">评论</td>
        <td>标题</td>
      </tr>
    </thead>
    <!--{loop $list $value}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="vid[]" value="$value['vid']"/><span class="icon"></span></label></td>
        <td class="s">$value['vid']</td>
        <td class="w150">{if $value['uid']}<a href="user.php?uid=$value['uid']" target="_blank">$value['username']</a>{else}/{/if}</td>
        <td class="w150">{if $value['tid']}<a href="topic.php?tid=$value['tid']" target="_blank">$value['name']</a>{else}朋友圈{/if}</td>
        <td class="l">$value['views']</td>
        <td class="l">$value['replys']</td>
        <td><a href="topic.php?vid=$value['vid']" target="_blank">$value['subject']</a></td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'vid[]')"/><span class="icon"></span></label></td>
        <td colspan="6">$pages<button type="button" class="button w" onclick="checkdelete(this.form,'vid','deletesubmit')">删除</button>{if $_GET['state']}<button type="submit" class="button" name="examinesubmit" value="true">审核</button>{else}<button type="submit" class="button" name="movesubmit" value="true">转移到</button><input type="text" class="input" name="moveto" value=""><em>请输入转移目标板块或小组的Tid</em>{/if}</td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">没有找到符合条件的帖子</p>
<!--{/if}-->
<!--{else}-->
<div class="block">
  <h3>帖子管理</h3>
  <ul class="block_info">
    <li>通过下方搜索出符合条件的帖子</li>
    <li>然后对列表展示出来的帖子进行管理操作</li>
  </ul>
  <form action="admin.php" method="get">
    <input name="mod" type="hidden" value="$_GET['mod']" />
    <input name="item" type="hidden" value="$_GET['item']" />
    <input name="iframe" type="hidden" value="true" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>状态</th>
        <td>
          <div class="select">
            <select name="state">
              <option value="0">已审核</option>
              <option value="1">未审核</option>
            </select>
          </div> 
        </td>
      </tr>
      <tr>
        <th>所属</th>
        <td>
          <div class="select">
            <select name="form">
              <option value="0">不限</option>
              <option value="1">论坛帖子</option>
              <option value="2">话题帖子</option>
              <option value="3">朋友圈帖子</option>
            </select>
          </div> 
        </td>
      </tr>
      <tr>
        <th>关键词</th>
        <td><input type="text" class="input w300" name="subject" value=""></td>
      </tr>
      <tr>
        <th>作者</th>
        <td><input type="text" class="input w300" name="user" value=""><em>请输入作者UID，多个用空格隔开</em></td>
      </tr>
      <tr>
        <th>话题或板块</th>
        <td><input type="text" class="input w300" name="topic" value=""><em>请输入话题或板块的TID，多个用空格隔开</em></td>
      </tr>
      
  
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="searchsubmit" value="true">搜索</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>
</div>

<!--{/if}-->