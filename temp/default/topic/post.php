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
      <form action="topic.php?mod=post" method="post" id="{PHPSCRIPT}_{$_GET['mod']}_form" enctype="multipart/form-data">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <input name="tid" type="hidden" value="$_GET['tid']" />
        <input name="vid" type="hidden" value="$_GET['vid']" />
        <!--{if $topic['types']}-->
        <div class="weui-cells">
          <div class="weui-cell weui-cell_select">
            <div class="weui-cell__bd">
              <select class="weui-select" name="typeid">
                <option value="">请选择帖子分类</option>
                <!--{loop $topic['types'] $id $name}-->
                <option value="$id"{if $theme['typeid']==$id} selected="selected"{/if}>$name</option>
                <!--{/loop}-->
              </select>
            </div>
          </div>
        </div>
        <!--{/if}-->
        <div class="weui-cells" id="subject" {if !$theme['subject'] && $_S['setting']['freetitle']}style="display:none"{/if}>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="subject" id="subjectvar" value="$theme['subject']" placeholder="请输入帖子标题">
            </div>
          </div>
        </div>
        <div class="weui-cells__title">正文</div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <div class="textarea">
              <div class="textareacontent" contenteditable="true" placeholder="请输入帖子内容">$theme['content']</div>
              <textarea class="weui-textarea" id="content" name="content" placeholder="请输入帖子内容" maxlength="200" rows="3"></textarea>
              </div>
              <div class="weui-textarea-counter pt10">
                <!--{if $_S['setting']['freetitle']}--><a href="javascript:addsubject()" class="l s12 b_c2" id="addsubject">加标题</a><!--{/if}--><a href="javascript:" class="l s12 b_c2 upload" name="illustration">插图</a><!--{if $_S['qiniu']}--><!--{if $_S['usergroup']['allowaddvideo']}--><a href="javascript:video()" class="l s12 b_c2" id="addvideos">视频</a><!--{else}--><a href="javascript:" class="l s12 b_c2 qiniu"  name="video" call="upvideo">视频</a><!--{/if}--><!--{/if}--><a href="javascript:{if $_S['in_wechat']}SMS.WxPosition(){else}SMS.Position('$_S['setting']['lbs_appkey']', '$_S['setting']['lbs_appname']',SMS.GetPosition){/if}" class="l s12 b_c2" id="setlbs">位置</a>
              </div>
            </div>
          </div>
          
          <div class="weui-cell" id="lbsarea" {if !$theme['lbs']}style="display:none"{/if}>
            <div class="weui-cell__bd">$theme['lbs']</div>
          </div>
        </div>
        <!--{if $_S['usergroup']['allowaddvideo']}-->
        <div class="weui-cells" id="video" style="display:none">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" id="videovar" placeholder="输入mp4格式的视频文件地址（只限七牛）">
            </div>
            <div class="weui-cell__ft"><a href="javascript:addvideo()" class="weui-btn weui-btn_mini weui-btn_primary">添加</a></div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <a href="javascript:" class="qiniu c8" name="video" call="upvideo"><span class="icon icon-upload"></span>上传手机上的视频文件</a>
            </div>
            
          </div>
        </div>
        <!--{/if}-->
        <input type="hidden" name="lbs" id="lbs" value="$theme['lbs']" />
        <!--{if $_S['wxpay'] && $_S['usergroup']['allowsetprice']}-->
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="number" name="price" value="$theme['price']" placeholder="设置付费阅读">
            </div>
            <div class="weui-cell__ft">元</div>
          </div>
        </div>
        <!--{/if}-->
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <div class="weui-uploader">
                <div class="weui-uploader__hd">
                  <p class="weui-uploader__title">上传图集</p>
                </div>
                <div class="weui-uploader__bd">
                  <ul class="weui-uploader__files" id="uploaderFiles">
                    <!--{loop $theme['images'] $img}-->
                    <li class="weui-uploader__file" style="background-image:url($_S['atc']/$img['atc'])" id="img_{$img['aid']}"><a class="icon icon-no" href="javascript:SMS.deleteimg('{$img['aid']}')"></a></li>
                    <!--{/loop}-->
                  </ul>
                  <div class="weui-uploader__input-box">
                    <a href="javascript:" class="upload" name="pic" form="theme-form"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>          
        </div>
        <!--{if $_S['gzh']}-->
        <label for="weuiAgree" class="weui-agree pt10">
          <input id="weuiAgree" type="checkbox"  class="weui-agree__checkbox">
          <span class="weui-agree__text"><a href="javascript:gz()" class="load">关注服务号后可以及时收到别人的回复通知</a></span>
        </label>
        <!--{/if}-->
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">{$navtitle}帖子</button></div>
      </form>
      <form action="upload.php?item=theme&uptype=img&load=true&submit=true&hash=$_S['hash']" id="theme-form" style="display:none;" >
        <input type="file" id="pic-file" name="pic[]" multiple="" accept="image/gif,image/jpeg,image/jpg,image/png">
      </form>
      <form action="upload.php?item=illustration&uptype=img&load=true&submit=true&hash=$_S['hash']" id="illustration-form" style="display:none;" >
        <input type="file" id="illustration-file" name="illustration" accept="image/gif,image/jpeg,image/jpg,image/png">
      </form>
      <form method="post" action="https://{$_S['setting']['qiniu_endpoint']}" id="video-form" enctype="multipart/form-data" style="display:none">
        <input name="token" type="hidden" value="$token">
        <input name="file" type="file" id="videoinput" accept="video/mp4"/>
      </form>
    </div>
  </div>
  <div id="footer">

  </div>
</div>
<div id="smsscript">
  <script language="javascript">
	  function video(){
			$('.currentbody #video').toggle();
			$('.currentbody #addvideos').toggleClass('c1');
		}
		function addvideo(){
			var video=$('#videovar').val();
			if(video){
				var code='<div class="video_form icon icon-play"><video data="'+video+'"></video></div><br>';
				smsot.editor(code);
				$('#videovar').val('');
			}

		}
		
    function upvideo(s){
			var code='<div class="video_form icon icon-play"><video data="'+QN+s.key+'.mp4"></video></div><br>';
			smsot.editor(code);
		}
    function addsubject(){
			$('.currentbody #subject').toggle();
			$('.currentbody #addsubject').toggleClass('c1');
			$('.currentbody #subjectvar').focus();
		}

		
  </script>
  <!--{template wechat}-->
  <!--{template wechat_lbs}-->
  <!--{template wechat_shar}-->
  
</div>

<!--{template footer}-->