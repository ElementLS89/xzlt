<?exit?>
<style> 
	
	/* 弹出 样式 */
    .mini_login{
        display:none;
        position:absolute;
		top:50%;
		left:50%;
        z-index:2;
        background:white;
    }
    .mini_login .item{
      /*  width:320px;*/
        margin:0 auto;
        height:48px;
        line-height:48px;
        padding:0 20px;
    }
    /* 登录窗第一行*/
    .mini_login .firstLine{
        color:#666;
        background:#f7f7f7;
        font-size:18px;
        font-weight:bold;
        cursor:move;
    }
    .mini_login .item .login_close{
        display:inline-block;
        float:right;
        cursor:pointer;
    }
    
    .mini_login .item label{
        font-size:14px;
        margin-right:15px;
    }
    .mini_login .item input{
        display:inline-block;
        height:60%;
        width:70%;
    }
    /* 遮罩层样式 */
    .cover{
        display:none;
        width:100%;
        height:100%;
        position:absolute;
        top:0;
        left:0;
        z-index:1;
        background-color:#000;
        opacity:0.3;
    }
	
	.minWinTable th{ width:90px; text-align:right; padding:10px; line-height:36px; vertical-align:top; }
	.minWinTable td{ padding:10px; position:relative}
	.minWinTable tfoot td{ padding-left:230px; padding-bottom:20px;}
    </style> 
<div class="block">
<h3>选择分类</h3>
<table class="table" cellpadding="0" cellspacing="0">
  <tr>
  <th>一级分类</th>
    <td>
      <div class="select">
        <select name="search[groupid]">
          <option value="">请选择</option>
          <!--{loop $types $value}-->
            <option value="$value['gid']">$value['name']</option>
          <!--{/loop}-->
        </select>
      </div>  
    </td>
  </tr>
  <tr>
  <th>二级分类</th>
    <td>
      <div class="select">
        <select name="search[groupid]">
          <option value="">请选择</option>
          <!--{loop $_S['cache']['usergroup'] $value}-->
            <option value="$value['gid']">$value['name']</option>
          <!--{/loop}-->
        </select>
      </div>  
    </td>
  </tr>
</table>
</div>


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
		<td class="s">可用</td>
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
        <td colspan="3">
			<button type="button" class="button" onclick="checkdelete(this.form,'sid')">提交</button>
			<a href="javascript:void(0)" class="btn_login" id="youlam_btn_showTipsAdd">+增加导航</a>
		</td>

      </tr>
    </tfoot>
    
  </table>
</form>


<!-- 弹出登录小窗口 -->
<div class="mini_login" id="mini_login">
    <div class="item firstLine" id="firstLine">
        <span class="login_title">添加导航</span>
        <span class="login_close" id="youlam_btn_close_TipsAdd">X</span>
    </div>
	<div class="block">
	  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=$_GET['ac']" method="post" enctype="multipart/form-data">
		<input name="iframe" type="hidden" value="true" />
		<input name="hash" type="hidden" value="$_S['hash']" />
		<input name="type" type="hidden" value="forum" />
		<!--{if $_GET['sid']}-->
		<input name="sid" type="hidden" value="$_GET['sid']" />
		<!--{/if}-->
		<table class="minWinTable" cellpadding="0" cellspacing="0">
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
</div>
<!-- 遮罩层 -->
<div class="cover"></div>