<?exit?>
<!--{if !$_GET['load']}-->
<!--{template header}-->
<!--{/if}-->
<!--{if $_GET['load']}-->
<!--{if $param['type']=='toast'}-->
<div class="weui-toast">
<div class="toast-content">$message|$param['fun']</div>
</div>

<!--{else}-->
<div class="weui-dialog">
  <div class="dialog-content">
    <div class="weui-dialog__hd"><strong class="weui-dialog__title">$param['title']</strong></div>
    <div class="weui-dialog__bd">$message</div>
    <div class="weui-dialog__ft">
      <!--{if $url}-->
      <!--{if !$param['must']}--><a href="javascript:;" onclick="{if $param['clear']}SMS.clear();{else}SMS.close();{/if}" class="weui-dialog__btn weui-dialog__btn_default">$default</a><!--{/if}-->
      <a href="$url" class="weui-dialog__btn weui-dialog__btn_primary{if !$param['clear']} load{/if}" loading="tab" {if $param['param']}param="$param['param']"{/if} id="primary">$primary</a>
      <!--{else}-->
      <a href="javascript:;" onclick="SMS.close();" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
      <!--{/if}-->
    </div>
  </div>
</div>
<div id="smsscript"><div class="js-content">$param['js']</div></div>
<!--{/if}-->
<!--{else}-->
<div id="view">
  <div id="main">
    <div class="smsbody $outback">

      <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        
        <div class="weui-msg__text-area">
          <h2 class="weui-msg__title">$param['title']</h2>
          <p class="weui-msg__desc">$message</p>
        </div>
        <div class="weui-msg__opr-area">
          <p class="weui-btn-area">
          <!--{if $url}-->
          <a href="$url" class="weui-btn weui-btn_primary">$primary</a>
          <!--{/if}-->
          <!--{if $param['go'] || !$url}-->
          <a href="{if $param['go']}$param['go']{else}javascript:history.back();{/if}" class="weui-btn weui-btn_default">$default</a> </p>
          <!--{/if}-->
        </div>
        <div class="weui-msg__extra-area">
          <div class="weui-footer">
            <p class="weui-footer__links"> <a href="http://www.smsot.com" class="weui-footer__link">Smsot.com</a> </p>
            <p class="weui-footer__text">Copyright &copy; 2017-2027 Smsot 1.0</p>
          </div>
        </div>
      </div>

      

    </div>
  </div>
</div>
<div id="smsscript">
  <!--{if $param['js'] || $param['fun']}-->
	<script language="javascript">
	<!--{if $param['js']}-->
  $param['js']
	<!--{elseif $param['fun']}-->
	$param['fun']
	<!--{/if}-->
  </script>
  <!--{/if}-->
</div>
<!--{/if}-->
<!--{if !$_GET['load']}-->
<!--{template footer}-->
<!--{/if}-->