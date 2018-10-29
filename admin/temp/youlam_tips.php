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
        <select id="youlam_tips_class_select1" onchange="submitTipsSelect1();">
          <option value="">请选择</option>
          <!--{loop $firstTypes $value}-->
            <option value="$value['typeid']">$value['name']</option>
          <!--{/loop}-->
        </select>
      </div>  
    </td>
  </tr>
  <tr>
  <th>二级分类</th>
    <td>
      <div class="select">
        <select id="youlam_tips_class_select2" onchange="submitTipsSelect2();">
          <option value="">请选择</option>
        </select>
      </div>  
    </td>
  </tr>
</table>
</div>



	<div id="div_tips_list">
    
	</div>



<!-- 弹出登录小窗口 -->
<div class="mini_login" id="mini_login">
    <div class="item firstLine" id="firstLine">
        <span class="login_title">添加导航</span>
        <span class="login_close" id="youlam_btn_close_TipsAdd">X</span>
    </div>
	<div class="block">
	  <form action="#" method="post" enctype="multipart/form-data">
		<table class="minWinTable" cellpadding="0" cellspacing="0">
		  <tr>
			<th>名称</th>
			<td><input type="text" class="input w300" name="name" value=""></td>
		  </tr>
		  <tr>
			<th>链接地址</th>
			<td><input type="text" class="input w300" name="url" value=""></td>
		  </tr>
		  <tr>
			<th>图片</th>
			<td>{if $slider['pic']}<img src="$_S[atc]/$slider['pic']">{/if}<input type="file" name="pic"></td>
		  </tr>
		  <tfoot>  
			<tr>
			  <td colspan="2">
		<!--		<button type="submit" class="button" name="submit" value="true" onClick="youlam_tips_miniBtn()">提交</button>-->
		 		  <input id="youlam_tips_miniBtn" type="submit" class="button" name="submit" value="提交">
			  </td>
			</tr>  
		  </tfoot>
		</table>
	  </form>
	</div>	
</div>
<!-- 遮罩层 -->
<div class="cover"></div>