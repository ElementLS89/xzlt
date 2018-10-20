<?exit?>
<ul class="catalog cl">
  <li{if $_GET['ac']!='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&iframe=yes">话题管理</a></li>
  <li{if $_GET['ac']=='add'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=add&iframe=yes">添加话题</a></li>
</ul>
<!--{if in_array($_GET['ac'],array('add','edit'))}-->
<div class="block">
  <h3>{if $_GET['ac']=='add'}添加话题{else}编辑话题{/if}</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <input name="tid" type="hidden" value="$_GET['tid']" />
    <input name="ref" type="hidden" value="$_GET['ref']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>话题名称</th>
        <td><input type="text" class="input w300" name="name" value="$topic['name']"></td>
      </tr>
      <tr>
        <th>所属分类</th>
        <td>
          <div class="select">
            <select name="typeid">
              {loop $_S['cache']['topic_types'] $value}
              <option value="$value['typeid']"{if $value['typeid']==$topic['typeid']} selected{/if}>$value['name']</option>
              {/loop}
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>加入权限</th>
        <td>
          <div class="select">
            <select name="open">
              <option value="1" {if $topic['open']=='1'}selected{/if}>直接加入无需审核</option>
              <option value="0" {if $topic['open']=='0'}selected{/if}>需要审核</option>
              <option value="-1" {if $topic['open']=='-1'}selected{/if}>拒绝申请</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>看帖权限</th>
        <td>
          <div class="select">
            <select name="show">
              <option value="1" {if $topic['show']=='1'}selected{/if}>开放访问</option>
              <option value="0" {if $topic['show']=='0'}selected{/if}>仅成员可以访问</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>发帖权限</th>
        <td>
          <div class="select">
            <select name="addtheme">
              <option value="1" {if $topic['addtheme']=='1'}selected{/if}>开放发帖</option>
              <option value="0" {if $topic['addtheme']=='0'}selected{/if}>仅成员可以发帖</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>回帖权限</th>
        <td>
          <div class="select">
            <select name="reply">
              <option value="1" {if $topic['reply']=='1'}selected{/if}>开放回帖</option>
              <option value="0" {if $topic['reply']=='0'}selected{/if}>仅成员可以回帖</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>管理团队申请权限</th>
        <td>
          <div class="select">
            <select name="allowapply">
              {loop $topicgroup $level $value}
              <option value="$level"{if $topic['allowapply']==$level} selected{/if}>$value[name]</option>
              {/loop}
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>最大组长数</th>
        <td>
          <div class="select">
            <select name="maxleaders">
              <option value="1"{if $topic['maxleaders']=='1'} selected{/if}>一个</option>
              <option value="2"{if $topic['maxleaders']=='2'} selected{/if}>两个</option>
              <option value="3"{if $topic['maxleaders']=='3'} selected{/if}>三个</option>
              <option value="4"{if $topic['maxleaders']=='4'} selected{/if}>四个</option>
              <option value="5"{if $topic['maxleaders']=='5'} selected{/if}>五个</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>最大小组长数</th>
        <td>
          <div class="select">
            <select name="maxmanagers">
              <option value="1"{if $topic['maxmanagers']=='1'} selected{/if}>一个</option>
              <option value="2"{if $topic['maxmanagers']=='2'} selected{/if}>两个</option>
              <option value="3"{if $topic['maxmanagers']=='3'} selected{/if}>三个</option>
              <option value="4"{if $topic['maxmanagers']=='4'} selected{/if}>四个</option>
              <option value="5"{if $topic['maxmanagers']=='5'} selected{/if}>五个</option>
              <option value="6"{if $topic['maxmanagers']=='6'} selected{/if}>六个</option>
              <option value="7"{if $topic['maxmanagers']=='7'} selected{/if}>七个</option>
              <option value="8"{if $topic['maxmanagers']=='8'} selected{/if}>八个</option>
              <option value="9"{if $topic['maxmanagers']=='9'} selected{/if}>九个</option>
              <option value="10"{if $topic['maxmanagers']=='10'} selected{/if}>十个</option>
            </select>
          </div>  
        </td>
      </tr>
      <tr>
        <th>列表样式风格</th>
        <td>
          <div class="select">
            <select name="liststype">
              <!--{loop $_S['setting']['themestyle'] $value}-->
              <option value="$value['id']" {if $topic['liststype']==$value['id']}selected{/if}>$value['name']</option>
              <!--{/loop}-->
            </select>
          </div>  
        </td>
      </tr>
      
      <tr>
        <th>图标</th>
        <td>{if $topic['cover']}<img src="$_S[atc]/$topic['cover']">{/if}<input type="file" name="cover"></td>
      </tr>
      <tr>
        <th>顶部banner</th>
        <td>{if $topic['banner']}<img src="$_S[atc]/$topic['banner']">{/if}<input type="file" name="banner"></td>
      </tr>
      <tr>
        <th>介绍</th>
        <td><textarea class="textarea" name="about">$topic['about']</textarea></td>
      </tr>
      <tfoot>  
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button><em>更多管理项目请直接通过前端进行管理</em>
          </td>
        </tr>  
      </tfoot>    
  
    </table>
  </form>
</div>
<!--{elseif $_GET['searchsubmit']}-->
<!--{if $list}-->
<form action="$urlstr&page=$_S['page']" method="post">
  <input name="iframe" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <input name="deletesubmit" id="deletesubmit" type="hidden" value="" />
  <input name="confirm" type="hidden" id="confirm" value="" />
  <table cellpadding="0" cellspacing="0" class="list">
    <thead>
      <tr>
        <td class="s">选择</td>
        <td class="s">Tid</td>
        <td class="w300">话题</td>
        <td class="l">状态</td>
        <td class="l">今日</td>
        <td class="l">用户数</td>
        <td class="l">帖子数</td>
        <td>介绍</td>
      </tr>
    </thead>
    <!--{loop $list $value}-->
    <tbody>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" name="tid[]" value="$value['tid']"/><span class="icon"></span></label></td>
        <td class="s">$value['tid']</td>
        <td class="w300"><img src="$value['cover']" />$value['name']<a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=edit&tid=$value['tid']&iframe=yes&ref=$ref"><em>[编辑]</em></a></td>
        <td class="l">{if $value['state']}已审核{else}未审核{/if}</td>
        <td class="l">$value['today']</td>
        <td class="l">$value['users']</td>
        <td class="l">$value['themes']</td>
        <td>$value['about']</td>
      </tr>
    </tbody>
    <!--{/loop}-->
    <tfoot>
      <tr>
        <td class="s"><label class="checkbox"><input type="checkbox" class="check" onclick="checkall(this, 'tid[]')"/><span class="icon"></span></label></td>
        <td colspan="7">$pages<button type="button" class="button w" onclick="checkdelete(this.form,'tid','deletesubmit')">删除</button>{if !$_GET['state']}<button type="submit" class="button" name="examinesubmit" value="true">审核</button>{/if}</td>
      </tr>
    </tfoot>
    
  </table>
</form>
<!--{else}-->
<p class="empty">没有找到符合条件的话题</p>
<!--{/if}-->
<!--{else}-->
<div class="block">
  <h3>关于话题的管理</h3>
  <ul class="block_info">
    <li>通过下方搜索出相关话题</li>
    <li>然后对列表展示出来的话题进行管理操作</li>
  </ul>
  <form action="admin.php" method="get">
    <input name="mod" type="hidden" value="$_GET['mod']" />
    <input name="item" type="hidden" value="$_GET['item']" />
    <input name="iframe" type="hidden" value="true" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>分类</th>
        <td>
          <div class="select">
            <select name="typeid">
              <option value="0">不限</option>
              <!--{loop $_S['cache']['topic_types'] $type}-->
              <option value="$type['typeid']">$type['name']</option>
              <!--{/loop}-->
            </select>
          </div> 
        </td>
      </tr>
      <tr>
        <th>名称</th>
        <td><input type="text" class="input w300" name="name" value=""></td>
      </tr>
      <tr>
        <th>状态</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="state" value="0" checked="checked"
        /><span class="icon"></span>未审核</label>
        <label class="radio"><input type="radio" class="check" name="state" value="1"/><span class="icon"></span>已审核</label>
        </td>
      </tr>
      <tr>
        <th>排序</th>
        <td>
          <div class="select">
            <select name="order">
              <option value="1">按创建时间倒叙</option>
              <option value="2">按用户数量倒叙</option>
              <option value="3">按帖子数量倒叙</option>
            </select>
          </div>  
        </td>
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