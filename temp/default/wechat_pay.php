<?exit?>
<script language="javascript" id="callpay" reload="1">
  var usermini='{$_S[member][mini]}';
  function callpay(ac){
    var payment = $('.currentbody input[name="payment"]:checked').val()||$('.dialogbox #paytype').val()||$('.currentbody #paytype').val();
    if(payment=='wxpay'){
			<!--{if $_S['in_wechat']}-->
			if(mini && !usermini){
				SMS.open('<div class="weui-dialog__bd">小程序需要绑定您的微信才能支付</div><div class="weui-dialog__ft"><a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" onclick="bindmini();">前往绑定</a></div>','html');
			}else{
				call_wxpay(ac);
			}
			<!--{else}-->
			call_h5pay(ac);
			<!--{/if}-->
    }
  }
  function bindmini(){
		var params = '?url='+encodeURIComponent(window.location.href.split('#')[0]);
		var path = '/pages/bind/bind'+params;
		wx.miniProgram.navigateTo({url: path});		
	}
	
	$(document).ready(function() {
		<!--{if $_GET['mini']}-->
		var reloadurl=window.location.href.split('#')[0].substr(0, window.location.href.split('#')[0].length - 34);
		SMS.open('<div class="weui-dialog__bd">绑定成功，请重新点击支付按钮进行支付</div><div class="weui-dialog__ft"><a href="'+reloadurl+'" class="weui-dialog__btn weui-dialog__btn_primary">确定</a></div>','html');
		<!--{/if}-->		
		<!--{if $_GET['payres']}-->
		wxpay_success('$_GET[payres]');
		<!--{/if}-->
	});
	
</script>
<script language="javascript" id="wechat_pay">

	function call_h5pay(ac){
		var data=$('.dialogbox #pay_form').serialize()||$('.currentbody #pay_form').serialize();
    $.ajax({
      type: 'GET',
      url: 'jsapi.php?mod=wechat&ac='+ac,
      dataType:'json',
      data:data,
      success: function(s) {
				if(s.url){
					window.location.href=s.url;
				}else{
					SMS.open('您当前的账号还没有与您的微信账号绑定无法进行下单，请通过微信打开本页面进行支付','alert');
				}
      },
      error: function(data) {
        SMS.open('下单失败','alert');
      }
    });
	}
  function call_wxpay(ac){
		
    if(typeof WeixinJSBridge == "undefined"){
      if(document.addEventListener ){
        document.addEventListener('WeixinJSBridgeReady', call_wxjsapi, false);
      }else if(document.attachEvent){
        document.attachEvent('WeixinJSBridgeReady', call_wxjsapi); 
        document.attachEvent('onWeixinJSBridgeReady', call_wxjsapi);
      }
    }else{
      call_wxjsapi(ac);
    }
  }
  function call_wxjsapi(ac){
		var miniurl=mini?'&mini=true':'';
		var data=$('.dialogbox #pay_form').serialize()||$('.currentbody #pay_form').serialize();
    $.ajax({
      type: 'GET',
      url: 'jsapi.php?mod=wechat&ac='+ac+miniurl,
      dataType:'json',
      data:data,
      success: function(s) {
        if(s.error){
          SMS.open(s.error,'alert');
        }else{
					if(mini){
						var params = '?timestamp='+s.timeStamp+'&nonceStr='+s.nonceStr+'&'+s.package+'&signType='+s.signType+'&paySign='+s.paySign+'&payurl='+s.payurl+'&ac='+ac;
						var path = '/pages/wxpay/wxpay'+params;
						wx.miniProgram.navigateTo({url: path});
					}else{
						WeixinJSBridge.invoke(
							'getBrandWCPayRequest',
							s,
							function(res){
								wxpay_res(ac,res);
							}
						);						
					}

        }
      },
      error: function(data) {
        SMS.open('下单失败','alert');
      }
    });	
  }
  function wxpay_res(ac,res){
		if(res.err_msg == "get_brand_wcpay_request:ok" ) {
      wxpay_success(ac)
		}else{
			SMS.toast('支付失败');
		}
	}
	function wxpay_success(ac){
		if(ac=='recharge'){
			SMS.ajax('get.php?type=account&show=gold','#myaccount #gold','replace','text');
			SMS.deleteitem('my.php?mod=account',true);
			SMS.toast('充值成功');						
		}else if(ac=='gratuity'){
			var vid=$('.currentbody #vid').val();
			var mid=$('.currentbody #mod').val();
			var pageid=$('.currentbody').attr('form');
			var number=$('#'+pageid+' #gratuity_info_'+vid+' .number').text();
			var money =$('#'+pageid+' #gratuity_info_'+vid+' .money').text();
			var pay=$('.currentbody input[name="money"]:checked').val();
			var gratuity_number =number?parseFloat(number)+1:1;
			var gratuity_money =money?parseFloat(money*100)+pay:pay;
			SMS.closepage();
			setTimeout(function(){smsot.gratuity(vid,gratuity_number,gratuity_money,mid);},300);
			SMS.toast('打赏成功');
		}else if(ac=='topicpay'){
			var idtype=$('.dialogbox #idtype').val()||$('.currentbody #idtype').val();
			var id=$('.dialogbox #id').val()||$('.currentbody #payid').val();
			SMS.close();
			if(idtype=='tid'){
				var users=parseFloat($('.currentbody #users_'+id).text())+1
				setTimeout(function(){topic.jotopic('join',id,users)},300);
			}else{
				SMS.deleteitem('topic.php?vid='+id);
				SMS.reload('topic.php?vid='+id);
			}
			
		}else{
			var callcack=ac+'_pay()'
			eval(callcack);;
		}
	}
</script>