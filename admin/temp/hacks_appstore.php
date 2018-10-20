<?exit?>
<div class="block">
  <h3>关于Smsot应用商店</h3>
  <ul class="block_info">
    <li>应用商店目前还未正式上线</li>
    <li>以下应用是应用商店上线后第一轮上线的应用，目前可以先期购买安装</li>
    <li>请按照不同应用所提供的联系方式联系作者进行购买</li>
  </ul>
</div>
<ul class="apps cl">
  <!--{loop $apps $value}-->
  <li id="$value['id']" demo="$value['demo']">
    <span class="icon icon-close" onClick="hidedemo('$value[id]')"></span>
    <div><img src="$value['cover']" onerror="this.onerror=null;this.src='./admin/style/appcover.jpg'"></div>
    <h4>$value['name']<em>$value['price']元</em></h4>
    <p class="about">$value['about']</p>
    <p class="demo"><a href="javascript:showdemo('$value[id]');">点击查看演示&gt;&gt;</a></p>
    <p class="buy"><a href="http://wpa.qq.com/msgrd?v=3&uin=$value['qq']&site=qq&menu=yes">QQ：$value['qq']</a><a href="javascript:">电话：$value['tel']</a></p>
  </li>
  <!--{/loop}-->
</ul>

<script language="javascript">
 function showdemo(id){
	 if($('#'+id).hasClass('showdemo')){
		 hidedemo(id);
	 }else{
		 $('#'+id).addClass('showdemo');
		 var demo=$('#'+id).attr('demo')?$('#'+id).attr('demo'):'./admin/style/demo.jpg';
		 $('#'+id+' img').attr('data',$('#'+id+' img').attr('src')).attr('src',demo);		 
	 }
 }
 function hidedemo(id){
	 $('#'+id).removeClass('showdemo');
	 $('#'+id+' img').attr('src',$('#'+id+' img').attr('data'));
 }
</script>