<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback" nocache="true">
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="c1 flex"><a href="topic.php?mod=manage&tid=$_GET['tid']" class="get" type="switch" box="mainpannel" nopage="true"><span>基础设置</span></a></li>
          <li class="c7 flex"><a href="topic.php?mod=manage&tid=$_GET['tid']&item=level" class="get" type="switch" box="level" nopage="true"><span>用户等级</span></a></li>
          <li class="c7 flex"><a href="topic.php?mod=manage&tid=$_GET['tid']&item=member" class="get" type="switch" box="member"><span>用户管理</span></a></li>
          <li class="c7 flex"><a href="topic.php?mod=manage&tid=$_GET['tid']&item=apply" class="get" type="switch" box="apply"><span>用户审核</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>      
      </div>
      <div class="box-area">
        <div class="box-content current ready" id="mainpannel">
          <form action="upload.php?item=cover&uptype=img&load=true&submit=true&hash=$_S['hash']" id="cover-form" style="display:none;" >
            <input type="file" id="cover-file" name="cover" accept="image/gif,image/jpeg,image/jpg,image/png">
          </form>
          <form action="upload.php?item=banner&uptype=img&load=true&submit=true&hash=$_S['hash']" id="banner-form" style="display:none;" >
            <input type="file" id="banner-file" name="banner" accept="image/gif,image/jpeg,image/jpg,image/png">
          </form>
          <form action="topic.php?mod=manage&tid=$_GET['tid']" method="post" id="{PHPSCRIPT}_{$_GET['mod']}_form" enctype="multipart/form-data">
            <input name="submit" type="hidden" value="true" />
            <input name="hash" type="hidden" value="$_S['hash']" />
            <input type="hidden" name="banner" value="$topic['banner']" id="banner_val">
            <input type="hidden" name="cover" value="$topic['cover']" id="cover_val">
            <div class="setbanner">
              <!--{if $topic['banner']}--><a class="icon icon-close b_c8 c3" href="javascript:"></a><!--{/if}-->
              <div class="block" id="banner">
                <a href="javascript:" class="upload banner_area" name="banner"><!--{if $topic['banner']}--><img src="$_S['atc']/$topic['banner']"><!--{else}--><span class="block b_c8">点击设置Banner（640*320）</span><!--{/if}--></a>
              </div>
              
            </div>
            <div class="setcover">
              <a href="javascript:" class="upload" name="cover"><div class="cover_area bo o_c1 b_c3"><!--{if $topic['cover']}--><img src="$_S['atc']/$topic['cover']"><!--{else}--><span></span><!--{/if}--></div>上传一个话题封面（140*140）</a>
            </div>
            <div class="weui-cells">
              <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">话题名称</label></div>
                <div class="weui-cell__bd">
                  <input class="weui-input" type="text" name="name" placeholder="话题名称" value="$topic['name']">
                </div>
              </div>
              <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                  <label for="" class="weui-label">加入权限</label>
                </div>
                <div class="weui-cell__bd">
                  <select class="weui-select" name="open">
                    <option value="1" {if $topic['open']=='1'}selected{/if}>直接加入无需审核</option>
                    <option value="0" {if $topic['open']=='0'}selected{/if}>需要审核</option>
                    <option value="-1" {if $topic['open']=='-1'}selected{/if}>拒绝申请</option>
                  </select>
                </div>
              </div>
              <!--{if $_S['wxpay']}-->
              <div class="weui-cells">
                <div class="weui-cell">
                  <div class="weui-cell__hd"><label class="weui-label">付费加入</label></div>
                  <div class="weui-cell__bd">
                    <input class="weui-input" type="number" name="price" value="$topic['price']" placeholder="设置付费加入价格">
                  </div>
                  <div class="weui-cell__ft">元</div>
                </div>
              </div>
              <!--{/if}-->
              <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                  <label for="" class="weui-label">看帖权限</label>
                </div>
                <div class="weui-cell__bd">
                  <select class="weui-select" name="show">
                    <option value="1" {if $topic['show']=='1'}selected{/if}>开放访问</option>
                    <option value="0" {if $topic['show']=='0'}selected{/if}>仅成员可以访问</option>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                  <label for="" class="weui-label">发帖权限</label>
                </div>
                <div class="weui-cell__bd">
                  <select class="weui-select" name="addtheme">
                    <option value="1" {if $topic['addtheme']=='1'}selected{/if}>开放发帖</option>
                    <option value="0" {if $topic['addtheme']=='0'}selected{/if}>仅成员可以发帖</option>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select weui-cell_select-after">
                <div class="weui-cell__hd">
                  <label for="" class="weui-label">回帖权限</label>
                </div>
                <div class="weui-cell__bd">
                  <select class="weui-select" name="reply">
                    <option value="1" {if $topic['reply']=='1'}selected{/if}>开放回帖</option>
                    <option value="0" {if $topic['reply']=='0'}selected{/if}>仅成员可以回帖</option>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                  <select class="weui-select" name="allowapply">
                    <option>管理团队申请权限</option>
                    {loop $topicgroup $level $value}
                    <option value="$level"{if $topic['allowapply']==$level} selected{/if}>$value[name]</option>
                    {/loop}
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                  <select class="weui-select" name="maxleaders">
                    <option>最大组长数</option>
                    <option value="1"{if $topic['maxleaders']=='1'} selected{/if}>一个</option>
                    <option value="2"{if $topic['maxleaders']=='2'} selected{/if}>两个</option>
                    <option value="3"{if $topic['maxleaders']=='3'} selected{/if}>三个</option>
                    <option value="4"{if $topic['maxleaders']=='4'} selected{/if}>四个</option>
                    <option value="5"{if $topic['maxleaders']=='5'} selected{/if}>五个</option>
                  </select>
                </div>
              </div>
              <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                  <select class="weui-select" name="maxmanagers">
                    <option>最大小组长数</option>
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
              </div>
            </div>
            <div class="weui-cells__title">话题分类</div>
            <div class="weui-cells" id="themetypes">
              <!--{if $topic['types']}-->
              <!--{loop $topic['types'] $id $name}-->
              <div class="weui-cell" id="type_$id">
                <div class="weui-cell__bd">
                  <input type="hidden" name="typeid[]" value="$id" >
                  <input class="weui-input" type="text" name="typename[]" placeholder="话题分类名称" value="$name">
                </div>
                <div class="weui-cell__ft"><a href="javascript:$('#type_$id').remove()" class="icon icon-close c9"></a></div>
              </div>          
              <!--{/loop}-->
              <!--{else}-->
              <div class="weui-cell" id="type_1">
                <div class="weui-cell__bd">
                  <input type="hidden" name="typeid[]" value="1" >
                  <input class="weui-input" type="text" name="typename[]" placeholder="话题分类名称">
                </div>
              </div>
              <!--{/if}-->
            </div>
            <div class="b_c3 p10"><a href="javascript:topic.addthemetype();" class="c8 pl5">添加话题分类</a></div>
            <div class="weui-cells__title">列表样式风格</div>
            <div class="weui-cells">
              <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                  <select class="weui-select" name="liststype">
                    <!--{loop $_S['setting']['themestyle'] $value}-->
                    <option value="$value['id']" {if $topic['liststype']==$value['id']}selected{/if}>$value['name']</option>
                    <!--{/loop}-->
                  </select>
                </div>
               </div>
            </div>
            
            <div class="weui-cells__title">话题简介</div>
            <div class="weui-cells weui-cells_form">
              <div class="weui-cell">
                <div class="weui-cell__bd">
                  <textarea class="weui-textarea" name="about" placeholder="请输入话题简介" maxlength="200" rows="3">$topic['about']</textarea>
                </div>
              </div>
            </div>
            <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">设置话题</button></div>
          </form>      
        </div>
        <div class="box-content" id="level" style="display:none"></div>
        <div class="box-content" id="apply" style="display:none"></div>
        <div class="box-content" id="member" style="display:none"></div>
      </div>
      <div id="page"></div>


    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
    var typeid=$typeid;
	  $(document).ready(function() {	
      SMS.translate_int();
		});

  </script>
  <!--{template wechat_shar}-->
</div>

<!--{template footer}-->