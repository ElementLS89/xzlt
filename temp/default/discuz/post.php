<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback" nocache="true">
      <form action="discuz.php?mod=post" method="post" id="{PHPSCRIPT}_{$_GET['mod']}_form">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <input name="ac" type="hidden" value="$_GET['ac']" />
        <input name="fid" type="hidden" value="$_GET['fid']" />
        <input name="tid" type="hidden" value="$_GET['tid']" />
        <input name="pid" type="hidden" value="$_GET['pid']" />
        <!--{if in_array($_GET['ac'],array('addthread','editthread'))}-->
        <!--{if $forum['threadtypes']['types']}-->
        <div class="weui-cells">
          <div class="weui-cell weui-cell_select">
            <div class="weui-cell__bd">
              <select class="weui-select" name="typeid">
                <option value="">请选择帖子分类</option>
                <!--{loop $forum['threadtypes']['types'] $id $name}-->
                <option value="$id"{if $thread['typeid']==$id} selected="selected"{/if}>$name</option>
                <!--{/loop}-->
              </select>
            </div>
          </div>
        </div>
        <!--{/if}-->
        <div class="weui-cells" id="subject" {if !$thread['subject'] && $_S['setting']['freetitle']}style="display:none"{/if}>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="subject" id="subjectvar" value="$thread['subject']" placeholder="请输入帖子标题">
            </div>
          </div>
        </div>
        <!--{/if}-->
        <div class="weui-cells__title">正文</div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <!--{if in_array($_GET['ac'],array('addthread','editthread'))}-->
              <div class="textarea">
                <div class="textareacontent" contenteditable="true" placeholder="请输入帖子内容">$thread['message']</div>
                <textarea class="weui-textarea" id="content" name="content" placeholder="请输入帖子内容" maxlength="200" rows="3"></textarea>
              </div>
              <div class="weui-textarea-counter pt10">
                <!--{if $_S['setting']['freetitle']}--><a href="javascript:addsubject()" class="l s12 b_c2" id="addsubject">加标题</a><!--{/if}--><a href="javascript:" class="l s12 b_c2 upload" name="illustration">插图</a><!--{if $_S['qiniu'] && $forum['allowmediacode']}--><a href="javascript:" class="l s12 b_c2 qiniu"  name="video" call="updzvideo">视频</a><!--{/if}-->{if $havehack}<a href="javascript:{if $_S['in_wechat']}SMS.WxPosition(){else}SMS.Position('$_S['setting']['lbs_appkey']', '$_S['setting']['lbs_appname']',SMS.GetPosition){/if}" class="l s12 b_c2" id="setlbs">位置</a>{/if}
              </div>
              <!--{else}-->
              <textarea class="weui-textarea autoheight" id="postmessage" name="content" placeholder="请输入内容" maxlength="200" rows="3">{if $_GET['ac']=='editpost'}$post['message']{/if}</textarea>
              <!--{/if}-->
            </div>
          </div>
          <div class="weui-cell" id="lbsarea" {if !$theme['lbs']}style="display:none"{/if}>
            <div class="weui-cell__bd">$theme['lbs']</div>
          </div>
        </div>
        <input type="hidden" name="lbs" id="lbs" value="$theme['lbs']" />
        <!--{if in_array($_GET['ac'],array('addthread','editthread'))}-->
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <div class="weui-uploader">
                <div class="weui-uploader__hd">
                  <p class="weui-uploader__title">上传图集</p>
                </div>
                <div class="weui-uploader__bd">
                  <ul class="weui-uploader__files" id="uploaderFiles">
                    <!--{loop $imgs $img}-->
                    <li class="weui-uploader__file" style="background-image:url($img['atc'])" id="img_{$img['aid']}"><a class="icon icon-no" href="javascript:discuz.delpic('{$img['aid']}')"></a></li>
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
        <!--{else}-->
        <!--{if $_S['cache']['discuz_smile']['default']}-->
        <div class="smiles b_c5">
          <ul class="cl">
            <!--{loop $_S['cache']['discuz_smile']['default'] $value}-->
            <li><a href="javascript:SMS.smile('$value['code']')"><img src="$value['url']" /></a></li>
            <!--{/loop}-->
          </ul>
        </div>
        <!--{/if}-->
        <!--{/if}-->
        <!--{if $_S['gzh']}-->
        <label for="weuiAgree" class="weui-agree pt10">
          <input id="weuiAgree" type="checkbox"  class="weui-agree__checkbox">
          <span class="weui-agree__text"><a href="javascript:gz()" class="load">关注服务号后可以及时收到别人的回复通知</a></span>
        </label>
        <!--{/if}-->
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">{$navtitle}</button></div>
      </form>
      <!--{if in_array($_GET['ac'],array('addthread','editthread'))}-->
      <form action="discuz.php?mod=upload&uptype=img&load=true&submit=true&hash=$_S['hash']" id="theme-form" style="display:none;" >
        <input type="file" id="pic-file" name="pic[]" multiple="" accept="image/gif,image/jpeg,image/jpg,image/png">
      </form>
      <form action="discuz.php?mod=upload&item=illustration&uptype=img&load=true&submit=true&hash=$_S['hash']" id="illustration-form" style="display:none;" >
        <input type="file" id="illustration-file" name="illustration" accept="image/gif,image/jpeg,image/jpg,image/png">
      </form>
      <form method="post" action="https://{$_S['setting']['qiniu_endpoint']}" id="video-form" enctype="multipart/form-data" style="display:none">
        <input name="token" type="hidden" value="$token">
        <input name="file" type="file" id="videoinput" accept="video/mp4"/>
      </form>
      <!--{/if}--> 
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
  <!--{template discuz/js}-->
  <script language="javascript">
    function addsubject(){
			$('.currentbody #subject').toggle();
			$('.currentbody #addsubject').toggleClass('c1');
			$('.currentbody #subjectvar').focus();
		}
		function updzvideo(s){
			var code='[media=x,500,375]'+QN+s.key+'.mp4[/media]<br>';
			smsot.editor(code);
		}
  </script>
  <!--{template wechat}-->
  <!--{template wechat_lbs}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->