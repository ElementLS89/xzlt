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
<h3>选择话题</h3>
<table class="table" cellpadding="0" cellspacing="0">
  <tr>
  	<th>一级分类</th>
    <td>
      <div class="select">
        <select id="youlam_topic_class_select1" onchange="submitTopicSelect1();">
          <option value="">请选择</option>
          <!--{loop $firstTypes $value}-->
            <option value="$value['typeid']">$value['name']</option>
          <!--{/loop}-->
        </select>
      </div>  
    </td>
  	<th>话题名称</th>
    <td>
      <div class="select">
        <select id="youlam_topic_class_select2" onchange="submitTopicSelect2();">
          <option value="">请选择</option>
        </select>
      </div>  
    </td>
	<th>话题分栏</th>
    <td>
      <div class="select">
        <select id="youlam_topic_class_select3" onchange="submitTopicSelect3();">
          <option value="">请选择</option>
        </select>
      </div>  
    </td>
  </tr>
</table>
<a href="javascript:void(0)" id="youlam_add_types" class="" onclick="youlam_add_types()"></a>
</div>

<div id="youlam_topic_add_types"></div>

<div id="youlam_topic_ajax_list"></div>


<!-- 弹出小窗口 -->
<div class="mini_login" id="mini_login">
    <div class="item firstLine" id="firstLine">
        <span class="login_title">{if $_GET['ac']=='edit'}修改{else}添加{/if}</span>
        <span class="login_close" id="youlam_miniWin_close">X</span>
    </div>
	<div class="block">
	  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post" id="youlam_miniWin_form" enctype="multipart/form-data">
		<input name="iframe" type="hidden" value="true" />
		<input name="hash" type="hidden" value="$_S['hash']" />
		<input name="type" type="hidden" value="topic" />
		<!--{if $_GET['vid']}-->
		<input name="sid" type="hidden" value="$_GET['sid']" />
		<!--{/if}-->
		<table class="minWinTable" cellpadding="0" cellspacing="0">
		  <tr id="youlam_miniWin_tr_id">
			<th id="youlam_miniWin_th_id"></th>
			<td id="youlam_miniWin_td_id">
				<input type="text" id="youlam_miniWin_input_id" class="input w300" name="id" value="">
			</td>
		  </tr>
		  <tr id="youlam_miniWin_tr_name">
			<th id="youlam_miniWin_th_name"></th>
			<td id="youlam_miniWin_td_name">
				<div id="youlam_miniWin_div_name"></div>
				<input type="text" id="youlam_miniWin_input_name" class="input w300" name="name" value="">
			</td>
		  </tr>
		  <tr id="youlam_miniWin_tr_url">
			<th id="youlam_miniWin_th_url"></th>
			<td><input type="text" id="youlam_miniWin_input_url" class="input w300" name="url" value=""></td>
		  </tr>
		  <tr id="youlam_miniWin_tr_pic">
			<th id="youlam_miniWin_th_pic">图片</th>
			<td>
				{if $slider['pic']}
					<img  id="youlam_miniWin_img" src="$_S[atc]/$slider['pic']">
				{/if}
				<input type="file" id="youlam_miniWin_input_pic" name="pic">
			</td>
		  </tr>
		  <tr id="youlam_miniWin_tr_select">
			<th>选择分类</th>
			<td>
			  <div class="select">
				<select id="youlam_miniWin_select" onchange="submitMiniSelect();">
				  <option value="">请选择</option>
				  <!--{loop $columnList $value}-->
            		<option value="$value['columnid']">$value['name']</option>
          		  <!--{/loop}-->
				</select>
			  </div> 
			</td>
		  </tr>
		  <tfoot>  
			<tr>
			  <td colspan="2">
		<!--		<button type="submit" class="button" name="submit" value="true" onClick="youlam_tips_miniBtn()">提交</button>
		 		  <input id="youlam_tips_miniBtn" type="submit" class="button" name="submit" value="提交">-->
				  <button type="submit" class="button" name="submit" value="true" id="youlam_tips_miniBtn">提交</button>
			  </td>
			</tr>  
		  </tfoot>
		</table>
	  </form>
	</div>	
</div>
<!-- 遮罩层 -->
<div class="cover"></div>