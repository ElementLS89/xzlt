// JavaScript Document
var backfun='',firsturl='',intervalobj,count = 60,curcount,evalscripts = [],hackcsss = [],POPMENU = new Object,autobtn={},auto=[],loadstatus = true,UA = navigator.appVersion,scrollTop_end = 0,scroll_times;
var ios = UA.indexOf( "AppleWebKit" ) > -1;
var andriod = UA.indexOf( "Android" ) > -1;
var isweixin = UA.indexOf("MicroMessenger") > -1;
var mini=mini?mini:false;




$(window).scroll(function() {
	
	var scrollTop_num = $(window).scrollTop();
	clearTimeout(scroll_times);
	
	if($('.currentbody #autoload.auto').length > 0){
		autoload();
		var curtop = $(window).scrollTop();
		if(curtop + $(window).height()+100 >= $(document).height() && loadstatus) {
			loadstatus = false;
			autobtn.html('<i class="weui-loading"></i><span class="weui-loadmore__tips">正在加载</span>');
			if(auto['type']=='list'){
				loadnextpage();
			}else{
				scrollwater();
			}
		}
	}
	if($('.header').hasClass('transparent')){
		if($(window).scrollTop()<100 && $(window).scrollTop()>0){
			if($(window).scrollTop()<=1){
				$('.header').addClass('c7').removeClass('c3');
			}
			var opacity=$(window).scrollTop()/100;
			$('.header').css({'background':'rgba(255,255,255,'+opacity+')'});
		}else if($(window).scrollTop()==0){
			$('.header').css({'background':''}).addClass('c3').removeClass('c7');
		}
		
	}
	
	if($('.currentbody .topnv').length>0){		
		if($(document).height()-150>$(window).height() && $(window).scrollTop()>100){

			$('.header').css('position', 'static');
			$('.topnv').css('position', 'fixed');
		}else{
			$('.header').css('position', 'fixed');
			$('.topnv').css('position', 'static');
		}
	}
  
	if(scrollTop_end < scrollTop_num){
		scroll_times = setTimeout(function(){
		  $('#rightpannel').css({'-webkit-transform':'translateX(100px)','-webkit-transition':'-webkit-transform 0.3s ease-out 0s'});
		}, 100);
	}else{
		scroll_times = setTimeout(function(){
		  $('#rightpannel').css({'-webkit-transform':'translateX(0px)','-webkit-transition':'-webkit-transform 0.3s ease-out 0s'});
		}, 100);
	}
	scrollTop_end = scrollTop_num;

});

if(BRO=='ucbro'){
	var resize_times;
	var winheight=$(window).height(),reheight=$(window).height();
	window.onresize = function(){
		clearTimeout(resize_times);
		reheight=$(window).height();
		if(reheight>winheight){
			resize_times = setTimeout(function(){
				$('.footer').hide();
			}, 100);
		}else{
			resize_times = setTimeout(function(){
				$('.footer').show();
			}, 100);
		}
		winheight = reheight;
	}	
}



$(document).on('click', '.get', function() {
	SMS.close();
	var obj = $(this);
	var url=obj.attr('href'),type=obj.attr('type'),nopage=obj.attr('nopage'),box=obj.attr('box'),btn=obj.attr('btn');
	var clickfun=url.indexOf('javascript')<0?false:true;
  
	if(type=='side'){
		var nst=$('.currentbody .right').scrollTop();
	}else{
		var nst=$(window).scrollTop();		
	}
	var st=$('.currentbody #'+box).attr('st');
	var thisid=$('.currentbody').attr('id')+$('.currentbody .current').attr('id');
	//save uppage
	var uppage=$('.currentbody #page').html();
	if(uppage){
		SMS.setItem(thisid+'_page', JSON.stringify(uppage));						
	}
	//save other
	var upother=$('.currentbody #otherarea').html();
	if(upother){
		SMS.setItem(thisid+'_other', JSON.stringify(upother));						
	}
	//window.innerWidth
  //switch
	if(type=='switch'){
		var urls=[];
		var tabs=$('.currentbody .swipernv ul li').children('a');
		for(var i=0;i<tabs.length;i++){
			urls.push($(tabs[i]).attr('href'));
		}
		var current=urls.indexOf(url);
		var translate=Math.round(($('#body').width()/tabs.length-14)/2+($('#body').width()/tabs.length)*current,2);
		$('.currentbody .swipernv li').removeClass('c1').addClass('c7');
		$(obj.parent()).removeClass('c7').addClass('c1');
		$('.currentbody .swipernv-on').css({'-webkit-transform':'translateX('+translate+'px)','-webkit-transition':'-webkit-transform 0.3s ease-out 0s'});
	}else if(type=='side'){//side
		$('.currentbody .left li').removeClass('b_c3');
		$('.currentbody .left li span').removeClass('b_c1');
		$('.currentbody .left #'+btn).addClass('b_c3');
		$('.currentbody .left #'+btn+' span').addClass('b_c1');
	}else if(type=='get'){
		
	}else{//types
		$('.currentbody .navs li').removeClass('c1 o_c1');
		$('.currentbody .navs li#'+btn).addClass('c1 o_c1');
	}
	if(!$('.currentbody #'+box).hasClass('ready') || type=='get'){
		SMS.loading();
		$('.currentbody #'+box).addClass('ready');
		var reg=/searchcall\b/;
		if(!reg.test(box))
		{
			$.ajax({
				type: 'GET',
				url: url+'&get=ajax',
				dataType: 'html',
				success: function(s) {
					if(nopage){
						$('.currentbody #'+box).html(s);
					}else{
						var list=$(s).find('#list').html();
						var page=$(s).find('#page').html();
						var script=$(s).find('#script').html();
						var other=$(s).find('#other').html();
						if(other){
							$('.currentbody #otherarea').html(other);
						}
						$('.currentbody #'+box).html(list);
						$('.currentbody #page').html(page);
						$('.currentbody #'+box+' .lazyload').picLazyLoad();
						SMS.evalscript(script);		
					}
				},
				error: function(data) {
					window.location.href = url;
				}
			});
		}
		SMS.close();//关闭“数据加载”页面
	}else{
		if(!nopage){
			var page=sessionStorage.getItem($('.currentbody').attr('id')+box+'_page');
			if(page!=null){
				var pagevar = JSON.parse(page);
				$('.currentbody #page').html(pagevar);
			}else{
				$('.currentbody #page').empty();
			}
		}
		var other=sessionStorage.getItem($('.currentbody').attr('id')+box+'_other');
		if(other!=null){
			var othervar = JSON.parse(other);
			$('.currentbody #otherarea').html(othervar);
		}else{
			$('.currentbody #otherarea').empty();
		}
	}
	
	$('.currentbody .current').attr('st',nst);
	$('.currentbody .current').removeClass('current').hide();
	$('.currentbody #'+box).fadeIn().addClass('current');
	
	if(st){
		if(type=='side'){
			setTimeout(function(){$('.currentbody .right').scrollTop(st);})
		}else{
			setTimeout(function(){$(window).scrollTop(st);})
		}		
	}
	if(!clickfun){
		return false;
	}
});



/*search*/

$(document).on('click', '.currentbody #searchText', function() {

	$('.currentbody #searchBar').addClass('weui-search-bar_focusing');
	$('.currentbody #searchInput').focus();
});
$(document).on('blur', '.currentbody #searchInput', function() {
	if(!this.value.length) cancelSearch();
});
$(document).on('input', '.currentbody #searchInput', function() {
	if(this.value.length) {
		$('.currentbody #searchResult').show();
	}else{
		$('.currentbody #searchResult').hide();
	}
});
$('.currentbody #searchClear').on('click', function(){
	hideSearchResult();
	$('.currentbody #searchInput').focus();
});
$('.currentbody #searchCancel').on('click', function(){
	cancelSearch();
	$('.currentbody #searchInput').blur();
});
function hideSearchResult(){
	$('.currentbody #searchResult').hide();
	$('.currentbody #searchInput');
}
function cancelSearch(){
	hideSearchResult();
	$('.currentbody #searchBar').removeClass('weui-search-bar_focusing');
	$('.currentbody #searchText').show();
}

/*liveSearch*/

$(document).on('click', '.currentbody #liveSearchText', function() {
	$('.currentbody #liveSearchBar').addClass('weui-search-bar_focusing');
	$('.currentbody #liveSearchInput').focus();
});
$(document).on('blur', '.currentbody #liveSearchInput', function() {
	if(!this.value.length) cancelLiveSearch();
});
$('.currentbody #liveSearchClear').on('click', function(){
	$('.currentbody #liveSearchInput').val("").focus();
//	$('.currentbody #searchInput').focus();
});
function cancelLiveSearch(){
	$('.currentbody #liveSearchBar').removeClass('weui-search-bar_focusing');
	$('.currentbody #liveSearchText').show();
}

/*autoload*/
$(document).on('click', '.currentbody #autoload', function() {
	autoload();
	autobtn.html('<i class="weui-loading"></i><span class="weui-loadmore__tips">正在加载</span>');	
	if(auto['type']=='list'){
		loadnextpage();
	}else{
		scrollwater();
	}
  return false;		
});



(function($) {
	$.fn.longPress = function(fn1,fn2) {
		var timeout ;
		var $this = this;
		for(var i = 0;i<$this.length;i++){
			$this[i].addEventListener('touchstart', function(event) {
			timeout = setTimeout(fn1, 800);
			}, false);
			$this[i].addEventListener('touchend', function(event) {
				if(true) {
					fn2();
				}
				clearTimeout(timeout);
			}, false);
		}
	}
	
	$.fn.scrollTo =function(options){
		var defaults = {
				toT : 0,
				durTime :800,
				delay : 30,
				callback:null
		};
		var opts = $.extend(defaults,options),
				timer = null,
				_this = this,
				curTop = _this.scrollTop(),
				subTop = opts.toT - curTop,
				index = 0,
				dur = Math.round(opts.durTime / opts.delay),
				smoothScroll = function(t){
				index++;
				var per = Math.round(subTop/dur);
				if(index >= dur){
					_this.scrollTop(t);
					window.clearInterval(timer);
					if(opts.callback && typeof opts.callback == 'function'){
						opts.callback();
					}
					return;
				}else{
					_this.scrollTop(curTop + index*per);
				}
			};
		timer = window.setInterval(function(){
			smoothScroll(opts.toT);
		}, opts.delay);
		return _this;
	}	

  $.fn.picLazyLoad = function(settings) {
		
    var $this = $(this),_ScrollTop = 0,_Height = $(window).height();
		
		settings = $.extend({
			threshold: 0,
			placeholder: 'ui/sl.png'
		},settings || {});
    setpic();
    lazyLoadPic();
		$(window).on('scroll',function() {
			 _ScrollTop = $(window).scrollTop();
			 setpic();
			 lazyLoadPic();
		});
		
		function lazyLoadPic() {
			$this.each(function() {
				var $self = $(this).removeClass('lazyload');
				if ($self.is('img')) {
					if ($self.attr('data-original')) {
						
						var _offsetTop = $self.offset().top;
						if ((_offsetTop - settings.threshold) <= (_Height + _ScrollTop)) {
							$self.attr('src', $self.attr('data-original')).fadeIn();
							$self.removeAttr('data-original');
						}
					}
				} else {
					if ($self.attr('data-original')) {
						if ($self.css('background-image') == 'none') {
							$self.css('background-image', 'url(' + settings.placeholder + ')');
						}
						var _offsetTop = $self.offset().top;
						if ((_offsetTop - settings.threshold) <= (_Height + _ScrollTop)) {
							$self.css('background-image', 'url(' + $self.attr('data-original') + ')');
							$self.removeAttr('data-original');
						}
				  }
				}
			});
		}
		function setpic(){
			
			$this.each(function() {
				if($(this).attr('scaling')){
					var height=($(this).width()*$(this).attr('scaling')).toFixed(2);
					$(this).attr('height',height);					
				}

			});
		}
  }
})(Zepto);

$(document).on('click', '.viewpic', function() {
	SMS.setfun("SMS.closepic()");
	var src = $(this).attr("src"),thumb = $(this).attr("thumb"),swiper = $(this).attr("swiper");

	if(!SMS.empty(swiper)){
		var swipers=$('.currentbody .swiper p').children('img');
		var html='<div class="weui-gallery" id="gallery" style="display: block; opacity: 1;">';
		    html += '<div class="weui-gallery__img"><div class="viewpic_swiper"><div class="swiper-wrapper">';
				for(var i=0;i<swipers.length;i++){
					var path=$(swipers[i]).attr('data-original')?$(swipers[i]).attr('data-original'):swipers[i]['src'];
					if($(swipers[i]).attr('thumb')){
						var src=path.replace(thumb+'.jpg','');
					}else{
						var src=path;
					}
					html += '<div class="swiper-slide"><div class="swiper-zoom-container"><img src="'+src+'"/></div></div>';
		    }
		    html += '</div><div class="swiper-pagination"></div></div></div><div class="weui-gallery__opr"><a href="javascript:" class="icon icon-close c3"></a></div></div>';
		$('body').append(html);
		var script='var showpics = new Swiper(\'.viewpic_swiper\', {zoom: true,initialSlide :'+swiper+',pagination: \'.viewpic_swiper .swiper-pagination \',paginationType: \'fraction\',spaceBetween: 20});';
		eval(script);
	}else{
		if(thumb){
			var src=src.replace('_'+thumb+'.jpg','');
		}		
		var html='<div class="weui-gallery" id="gallery" style="display: block; opacity: 1;">';
				html += '<span class="weui-gallery__img" id="galleryImg" style="background-image:url('+src+')"></span>';
				html += '<div class="weui-gallery__opr"><a href="javascript:" class="icon icon-close c3"></a></div></div>';
	
		$('body').append(html);
	}
	$('.weui-gallery__img').off().on('click', function() {SMS.closepic();});		
	$('.weui-gallery__opr a').off().on('click', function() {SMS.closepic();});	

});



$(document).on('click', '.selectall', function() {
	var obj = $(this);
	var name=obj.attr('item');
	if(obj.hasClass('icon-select')){
		obj.removeClass('icon-select').addClass('icon-chosen');
		$('.currentbody input[name="'+name+'"]').prop('checked',true);
	}else{
		obj.removeClass('icon-chosen').addClass('icon-select');
		$('.currentbody input[name="'+name+'"]').prop('checked',false);
	}
});


$(document).on('click', '.weui-uploader__file span', function() {
	$(this).parent().remove();
});

$(document).on('click', '.uploadcover', function() {
	
	var obj = $(this);
	var id=obj.attr('id');
	$('.currentbody #'+id+'-file').click();
	$('.currentbody #'+id+'-file').on("change", function(e){
		var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
		if(url) {
			src = url.createObjectURL(files[0]);
		}else {
			src = e.target.result;
		}
		$('.currentbody #'+id+'_area').html('<img src="'+src+'">');
	});
});

$(document).on('change', '#uploader', function(e) {
  var tmpl = '<li class="weui-uploader__file" style="background-image:url(#url#)"><span href="javascript:" class="icon icon-no"></span></li>';
	var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
	for (var i = 0, len = files.length; i < len; ++i) {
		var file = files[i];
		if(url) {
			src = url.createObjectURL(file);
		}else {
			src = e.target.result;
		}
		$("#uploaderFiles").append($(tmpl.replace('#url#', src)));
	}
});


$(document).on('click', '.upload', function() {
  
	var obj = $(this);
	var form = obj.attr('form')||obj.attr('name')+'-form',name=obj.attr('name');
	var isimg = obj.attr('img')||true;
	var formobj = $('#'+form);
	
		
	var a=$('#'+name+'-file').click();
  
	$('#'+name+"-file").off("change");
	$('#'+name+"-file").change(function(){
		if(typeof FileReader != 'undefined' && $('#'+name+"-file")[0].files[0] && isimg!='false') {
			SMS.loading();
			for (var i=0;i<$('#'+name+"-file")[0].files.length;i++){
				UPLOAD.buildfileupload({
					uploadurl:formobj.attr('action'),
					file:$('#'+name+"-file")[0].files[i],
					uploadinputname:name,
					maxfilesize:5,
					success:function(s) {
						SMS.returnload(s,'tab');
					},
					error:function() {
						SMS.open('AJAX操作失败', 'alert');
					}
				});
			}

		}else{
			var formData = new FormData(formobj[0]);
			$.ajax({
				type: 'POST',
				url:formobj.attr('action'),
				data: formData,  
				dataType: 'html',
				cache: false,  
				contentType: false,  
				processData: false,  
				success: function(s) {
					SMS.returnload(s,'tab');
				},
				error: function(data) {
					SMS.open('AJAX操作失败', 'alert');
				}
			});			
		}
		obj=null;
		formobj=null;
	});
});

		 
$(document).on('click', '.playvideo', function() {
	var obj = $(this);
	var src = obj.attr('href');
	var videoid=SMS.hash(src);
	if(ios){
		var iosadd='webkit-playsinline x-webkit-airplay ';
	}
	obj.parent().append('<video '+iosadd+'controls src="'+src+'" preload="true" id="'+videoid+'"></video>');
	obj.remove();
	$('#'+videoid)[0].play();
	return false;	
});
	
$(document).on('click', '.qiniu', function() {
	var obj = $(this);
	var form = obj.attr('form')||obj.attr('name')+'-form',name=obj.attr('name'),callback=obj.attr('call');
	var formobj = $('#'+form);
	
	$('#'+name+'input').click();
	$('#'+name+'input').off("change");
	$('#'+name+'input').change(function(){
		SMS.loading();
		var data=new FormData(formobj[0]),contentType=false,processData=false;
		$.ajax({
			type: 'POST',
			url:formobj.attr('action'),
			data:data,
			dataType: 'html',
			cache: false,
			contentType: contentType,  
			processData: processData,  
			success: function(s) {
				var func=callback+'('+s+')';
				eval(func);
				SMS.close();
			},
			error: function(data) {
				SMS.open(data.responseText, 'alert');
			}
		});
	});
});
$(document).on('click', '.formpost', function() {
	SMS.loading();
	var formobj = $(this.form);
  postform(formobj);
});
function postform(formobj){
	
  if($('.currentbody .textareacontent').length>0){
		$('.currentbody #content').val($('.currentbody .textareacontent').html());
	}
	if(formobj.attr('enctype')=='multipart/form-data'){
		var data=new FormData(formobj[0]),contentType=false,processData=false;
	}else{
		var data=formobj.serialize(),contentType='application/x-www-form-urlencoded',processData=true;
	}
	$.ajax({
		type: 'POST',
		url:formobj.attr('action') + '&load=true',
		data:data,
		dataType: 'html',
		cache: false,
		contentType: contentType,  
		processData: processData,  
		success: function(s) {
      SMS.returnload(s,'tab');
		},
		error: function(data) {
			SMS.open('AJAX操作失败', 'alert');
		}
	});
	return false;
}

function getform(id){
	SMS.close();
	var obj = $('.currentbody #'+id),action=obj.attr('action');
	var url = action+'?'+obj.serialize();
  var type='',update='',closethis='',loading='tab',id=SMS.hash(url);
	SMS.load(url,closethis,type,update,loading,id);
	return false;
}

/**实时显示搜索结果 */
function showLiveSearchResult(str)
{
    if (str.length==0)
    { //如果输入框是空的（str.length==0），该函数会清空 liveSearch 占位符的内容，并退出该函数
        document.getElementById("liveSearch").innerHTML="";
        document.getElementById("liveSearch").style.border="0px";
        return;
	}
	/**如果输入框不是空的，那么 showSearchResult() 会执行以下步骤：
    1、创建 XMLHttpRequest 对象
    2、创建在服务器响应就绪时执行的函数
    3、向服务器上的文件发送请求
    4、请注意添加到 URL 末端的参数（q）（包含输入框的内容）
 	*/
    if (window.XMLHttpRequest)
    {// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// IE6, IE5 浏览器执行
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("liveSearch").innerHTML=xmlhttp.responseText;
            document.getElementById("liveSearch").style.border="1px solid #A5ACB2";
        }
    }
    xmlhttp.open("GET","livesearch.php?q="+str,true);
    xmlhttp.send();
}

// load
$(document).on('click', '.load', function() {
	
	var obj = $(this);
  var url=obj.attr('href'),closethis=obj.attr('close'),type=obj.attr('type'),update=obj.attr('update'),loading=obj.attr('loading');
	var clickfun=url.indexOf('javascript')<0?false:true;
	if(clickfun){
		return ;
	}
	SMS.close();
	var id=SMS.hash(url);
  
	//uplastactive
  SMS.uplastavtive();
	//uplastactive end
	SMS.load(url,closethis,type,update,loading,id);
	return false;
});

$(document).on('click', '.closepage', function() {
	window.history.back(-1);
	return false;
});

function writeobj(obj){ 
 var description = ""; 
 for(var i in obj){ 
 var property=obj[i]; 
 description+=i+" = "+property+"\n"; 
 } 
 alert(description); 
} 
function mygetnativeevent(event) {
	while(event && typeof event.originalEvent !== "undefined") {
		event = event.originalEvent;
	}
	return event;
}
$(window).on("popstate", function(event) {
	var state = event.state;
	if(!state){}else{
		if(backfun){
			eval(backfun);
		}
		SMS.uplastavtive();

		$('#header').html(state.head);
		$('#footer').html(state.foot);
		
		var session=sessionStorage.getItem(state.id);
		if(session){
			var sessionvar = JSON.parse(session)		
			if(!sessionvar.wx || !sessionvar.tt || !sessionvar.img){
				SMS.error();
			}else{
				$('#wxconfig').html(sessionvar.wx);
				$('#sharpic').html(sessionvar.img);
				SMS.uptitle(sessionvar.tt);
				SMS.postmessage(state.url,sessionvar.tt,sessionvar.img);
			}
			SMS.addcss(sessionvar.hk);	
		}		
		if($('#'+state.id).length>0){
			var st = $('#'+state.id).attr('st'),upid = $('.currentbody').attr('id');
			
			$('.currentbody').remove();
			$('#'+state.id).addClass('currentbody');
			$('.currentbody').fadeIn();
			$('.currentbody').attr('form',upid);
			setTimeout(function(){$(window).scrollTop(st);},100);		
			$('.currentbody .lazyload').picLazyLoad();
			
		}else{
			var st=$(window).scrollTop();
			var upid = $('.currentbody').attr('id');
			$('.currentbody').attr('st',st);
			$('.currentbody').hide();
			$('.currentbody').removeClass('currentbody');
			$('#main').append(state.html);
			$('.currentbody .lazyload').picLazyLoad();
		}
		var state = {
			url: state.url,
			id: state.id,
			head: state.head,
			foot: state.foot,
			sc: state.sc,
			html: state.html,
		};
		history.replaceState(state,null,state.url);
		SMS.wxconfig();
		SMS.cache(state.sc,state.url);
		SMS.evalscript(state.sc);
	}		
});
$(document).on('input propertychange focus', '.autoheight', function() {
	this.style.height=this.scrollHeight + 'px';
})

var SMS = {
	/*int*/
	init : function() {
		var hackcss=$('#hackcss').text();
		if(ios){
			firsturl=window.location.href.split('#')[0];
			if(firsturl.indexOf('.php')==-1){
				firsturl=firsturl+'index.php';
			}
		}
		SMS.addcss();
		SMS.wxconfig();

		clientheight=document.documentElement.clientHeight;
		minheight=HEADER?clientheight-50:clientheight;
    
		var id=SMS.hash(PHPSCRIPT);
		$('.smsbody').addClass('currentbody');
		$('.smsbody').attr('id',id);
		$('.side-nv').css('height',clientheight-218 + 'px');
		$('.full').css('min-height',minheight-30 + 'px');
		var header = $('#header').html(),footer = $('#footer').html(),script = $('#smsscript').html();
		
		var title=$('title').text(),weixin=$('#wxconfig').html(),img=$('#sharpic').html();
		
		if(typeof $('.currentbody').attr('nocache')== 'undefined'){
			SMS.setItem(id, JSON.stringify({tt:title,hd:header,ft:footer,sc:script,url:PHPSCRIPT,wx:weixin,img:img,hk:hackcss}));
			SMS.setItem(id, JSON.stringify($(".smsbody").prop("outerHTML")),'local');
		}
		SMS.cache(script,PHPSCRIPT);
    
		var state = {
			url: PHPSCRIPT,
			id: id,
			head: header,
			foot: footer,
			sc: script,
			html: $(".smsbody").prop("outerHTML"),
		};
		history.replaceState(state,null,PHPSCRIPT);
    
    var childrens=$('#smsscript').children('script');
		var i = 0;
		while(i < childrens.length) {
			var children=childrens[i];
			if(SMS.empty($(children).attr('id'))){
				if(SMS.empty($(children).attr('src'))){
					var scid = SMS.hash(children.text);
				}else{
					var scid = SMS.hash($(children).attr('src'));
				}
				$(children).attr('id',scid);
				evalscripts.push(scid);				
			}else{
				evalscripts.push($(children).attr('id'));
			}
			i ++;
		}
		$('.currentbody .lazyload').picLazyLoad();
		
		SMS.postmessage(PHPSCRIPT,title,img);
		
	},
	uplastavtive : function(){
		var upid=$('.currentbody').attr('id');
		var cache=sessionStorage.getItem('cache');
		
		if(cache){
			var header = $('#header').html(),footer = $('#footer').html();
			var cachevar = JSON.parse(cache);
			var upscript = cachevar.sc,upurl = cachevar.url;
	    
			var state = {
				url: upurl,
				id: upid,
				head: header,
				foot: footer,
				sc: upscript,
				html: $(".currentbody").prop("outerHTML"),
			};
			history.replaceState(state,null,upurl);		
		}
	},
	cache : function(script,url){
	  SMS.setItem('cache', JSON.stringify({sc:script,url:url}));
	},

	addcss : function(s) {
		if(s){
			var hackcss=s;
		}else{
			var hackcss=$('#hackcss').html();
		}
		if(hackcss){
			var cssid=SMS.hash(hackcss);
			if($.inArray(cssid,hackcsss)==-1){
				$('#stylecss').before('<link rel="stylesheet" href="'+hackcss+'" type="text/css" media="all">')
				$('#hackcss').remove();
				hackcsss.push(cssid);				
			}
		}
	},
	load : function(url,closethispage,type,update,loading,id){
		var session=sessionStorage.getItem(id),local=localStorage.getItem(id);
		if(session && local && !update){
			var sessionvar = JSON.parse(session),localvar = JSON.parse(local);
			var upid = $('.currentbody').attr('id'),nst=$(window).scrollTop();
			SMS.addcss(sessionvar.hk);
			$('#header').html(sessionvar.hd);
			$('#footer').html(sessionvar.ft);
			$('#wxconfig').html(sessionvar.wx);
			$('#sharpic').html(sessionvar.img);
			
			SMS.uptitle(sessionvar.tt);
			
			$('.currentbody').attr('st',nst);
			$('.currentbody').hide();		
			$('.currentbody').removeClass('currentbody');
			
			if($('#'+id).length>0){
				var st = $('#'+id).attr('st');
				$('#'+id).fadeIn();
				$('#'+id).addClass('currentbody');
				$('#'+id).attr('st','');
				$('#'+id).attr('form',upid);
				setTimeout(function(){$(window).scrollTop(st);})
			}else{
				$('#main').append(localvar);
				$('#'+id).fadeIn();
				$('#'+id).attr('st','');
				$('#'+id).attr('form',upid);
				setTimeout(function(){$(window).scrollTop(0);})
			}
			var state = {
				url: url,
				id: id,
				head: sessionvar.hd,
				foot: sessionvar.ft,
				sc: sessionvar.sc,
				html: localvar,
			};
			history.pushState(state,null,url);
			SMS.wxconfig();
			SMS.postmessage(url,sessionvar.tt,sessionvar.img);
			SMS.cache(sessionvar.sc,url);
			SMS.evalscript(sessionvar.sc);
			$('.currentbody .lazyload').picLazyLoad();

			return false;
		}else{
			var needload=true;
		}
    
		if(needload){
			if(loading=='tab'){
				SMS.loading();
			}else{
				SMS.loadingpage();
			}
			
			var value = {
				url: url,
				closethispage: closethispage,
				type: type,
				update: update,
				loading: loading,
				id: id
			};
			setTimeout(function(){SMS.loadpage(value);},300);
			
			return false;
		}
	},
  /*popinit*/
	popinit : function() {
		var $this = this;
		$('.popup').each(function(index, obj) {
			obj = $(obj);
			var pop = $(obj.attr('href'));
			if(pop && pop.attr('popup')) {
				pop.css({'display':'none'});
				obj.on('click', function(e) {
					$this.open(pop,'html');
				});
			}
		});
		this.maskinit();
	},
	/*maskinit*/
	maskinit : function() {
		var $this = this;
		$('#mask').off().on('click', function() {$this.close();});
	},
	/*open*/
	open : function(pop, type, url) {
		
		this.close();
		this.maskinit();
		if(typeof pop == 'string') {
			$('#ntcmsg').remove();
			if(type == 'alert') {
				pop = '<div class="weui-dialog"><div class="weui-dialog__bd">'+ pop +'</div><div class="weui-dialog__ft"><a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" onclick="SMS.close();">知道了</a></div></div>';
			} else if(type == 'confirm') {
				pop = '<div class="weui-dialog"><div class="weui-dialog__bd">'+ pop +'</div><div class="weui-dialog__ft"><a href="javascript:;" onclick="SMS.close();" class="weui-dialog__btn weui-dialog__btn_default">取消</a><a href="'+ url +'" class="weui-dialog__btn weui-dialog__btn_primary load">确定</a></div></div>'
			}else if(type == 'html'){
				pop = '<div class="weui-dialog">'+pop+'</div>';
			}
			$('body').append('<div id="ntcmsg" style="display:none;">'+ pop +'</div>');
			pop = $('#ntcmsg');
		}

    pop.parent().append('<div class="dialogbox" id="'+ pop.attr('id') +'_popmenu">'+ pop.html() +'</div>');
		if(type == 'loading'){
			$('#loading').css('display', 'block');
		}else{
			$('#mask').css('display', 'block');
		}
		POPMENU[pop.attr('id')] = pop;
	},
	/*close*/
	close : function() {
		$('#loading').css('display', 'none');
		$('#mask').css('display', 'none');
		$.each(POPMENU, function(index, obj) {
			$('#' + index + '_popmenu').remove();
			$('#ntcmsg').remove();
		});
	},
  /*setfun*/
	setfun : function(fun) {
		backfun=fun+";";
	},
	/*unsetfun*/
	unsetfun : function(fun) {
		backfun="";
	},
	/*upcount*/
	upcount : function(id,type,num) {
		var num=num||1,type=type||'add',count =parseInt($(id+' .weui-badge').text());
		if(count){
			if(type=='reduce'){
				if(count-num<=0){
					$(id+' .weui-badge').remove();
				}else{
					$(id+' .weui-badge').text(count-num);
				}
			}else{
				$(id+' .weui-badge').text(count+num);
			}		
		}else{
			$(id).append('<span class="weui-badge">'+num+'</span>');
		}
	},
	/*error*/
	error: function() {
		SMS.open('程序需要初始化本地数据,请点击确定按钮','confirm','javascript:SMS.clear();');
	},
	null: function(id) {
		return false;
	},
	/*setItem*/
	setItem: function(key,value,type) {
		var type=type||'session';
		if(type=='session'){
			try{
				sessionStorage.setItem(key,value);
			}catch(oException){
				if(oException.name == 'QuotaExceededError'){
					sessionStorage.clear();
					sessionStorage.setItem(key,value);
				}
			}				
		}else{
			try{
				localStorage.setItem(key,value);
			}catch(oException){
				if(oException.name == 'QuotaExceededError'){
					localStorage.clear();
					localStorage.setItem(key,value);
				}
			}	
		}
	},
	deleteitem: function(url,update,current){
    setTimeout(function(){
			var thisurl=url.replace(/&amp;/g,'&');
			var id=SMS.hash(thisurl);
			var update=update==false?false:true;
			if(update && $('#'+id).length>0){
				if(current){
					var session=sessionStorage.getItem(id);
					if(session){
						var sessionvar = JSON.parse(session);
						var header = $('#header').html(),footer = $('#footer').html();
						SMS.setItem(id, JSON.stringify({tt:$('title').text(),hd:header,ft:footer,sc:sessionvar.sc,url:url,wx:sessionvar.wx,hk:sessionvar.hk}));					
					}else{
						sessionStorage.removeItem(id);
					}
				}
				SMS.setItem(id, JSON.stringify($('#'+id).prop("outerHTML")),'local');
			}else{
				sessionStorage.removeItem(id);
				localStorage.removeItem(id);				  
			}			
		},300);
	},
	/*autoscroll*/
	autoscroll: function(obj) {
		var children=$(obj+' ul').children('li')[0];
		if($(obj+' ul').children('li').length>1){
			$(obj+' ul').animate({
				marginTop:"-20px"
			},100,function(){
				$(obj+' ul').css({marginTop:"0px"});
				$(children).appendTo(obj+' ul');
			});			
		}

	},
	/*clear*/
	clear: function() {
		sessionStorage.clear();
		localStorage.clear();
		if($('.currentbody .weui-msg').length==0){
			location.reload();
		}
	},
	/*loading*/
	loading : function() {
		var loadinghtml='<div class="weui-toast"><i class="weui-loading weui-icon_toast"></i><p class="weui-toast__content">数据加载中</p></div>';
		SMS.open(loadinghtml,'loading');
		$('#loading').off().on('click', function() {SMS.close();});
	},
	/*loadingpage*/
	loadingpage : function() {
		if($('#loadpage').css('display')=='none'){
			loaderr=true;
			$('#loadpage').css({'display':''});
			setTimeout(function(){$('#loadpage').css({'-webkit-transform':'translateX(0%)','-webkit-transition':'-webkit-transform 0.3s ease-out 0s'});},1);
			$('#loadpage').off().on('click', function() {SMS.loadingpage();});
			setTimeout(function(){$('#loadpage').css({'display':'none'});if(loaderr){SMS.toast('加载失败')}},10000);
			
		}else{
			loaderr=false;
			$('#loadpage').css({'display':'none'});
			$('#loadpage').css({'-webkit-transform':'translateX(100%)','-webkit-transition':'-webkit-transform 0s 0s'});
		}
	},
	/*get*/
	get : function(url,id) {
		if($('#'+id).hasClass('hasvar')){
			return true;
		}else{
			$.ajax({
				type: 'GET',
				url: url+'&get=ajax',
				dataType: 'html',
				success: function(s) {
					if(s){
						$('#'+id).html(s);
						$('#'+id).addClass('hasvar');
					}
				},
				error: function(data) {
					window.location.href = url;
				}
			});	
		}
	},
	/*ajax*/
	ajax : function(url,id,method,fun) {
		var method=method||'append';
		var fun=fun||'';
		$.ajax({
			type: 'GET',
			url: url,
			dataType: 'html',
			success: function(s) {
				if(s){
					if(method=='prepend'){
						$(id).prepend(s);
					}else if(method=='replace'){
						if(fun=='text'){
							$(id).text(s);
						}else{
							$(id).html(s);
						}
						
					}else{
						$(id).append(s);
					}
				}else{
					return false;
				}
			},
			error: function(data) {
				return false;
			}
		});	
	},
	/*list*/
	list : function(url,id) {
		if($('#'+id+' div.weui-cell__hd').hasClass('open')){
			$('#'+id+' div.weui-cell__hd').removeClass('open');
			$('#list_'+id).fadeOut();
			return false;
		}else{
			if($('#list_'+id).hasClass('hasvar')){
				$('#'+id+' div.weui-cell__hd').addClass('open');
				$('#list_'+id).fadeIn();
			}else{
				$.ajax({
					type: 'GET',
					url: url+'&get=ajax',
					dataType: 'html',
					success: function(s) {
						if(s){
							$('#'+id+' div.weui-cell__hd').addClass('open');
							$('#list_'+id).addClass('hasvar').append(s);
						}
					},
					error: function(data) {
						window.location.href = url;
					}
				});				
			}
		}
	},

	/*reload*/
  reload : function(url){
    var url=url.replace(/&amp;/g,'&');
		SMS.deleteitem(url,false);
		SMS.unsetfun();
		var urllink=url.indexOf('?')>0?'&':'?';
    var iosurl=firsturl?'&iosurl='+encodeURIComponent(firsturl):'';
		$.ajax({
			type: 'GET',
			url: url+urllink+'load=true'+iosurl,
			dataType: 'html',
			success: function(s) {
				if(SMS.returnload(s,'reload')){
					if(s.indexOf('<div class="smsbody')==-1){
						window.location.href = url;
						return false;
					}
					var hackcss=$(s).find('#hackcss').text();
					SMS.addcss(hackcss);

		      var header = $(s).find('#header').html(),footer = $(s).find('#footer').html(),script = $(s).find('#smsscript').html(),title=$(s).find('#pagetitle').text(),img=$(s).find('#sharpic').html();
					var weixin=$(s).find('#wxconfig').html();
					var main = $(s).find('.smsbody').html();
					var thisclass = $(s).find('.smsbody').attr('class');
					
					$('#header').html(header);
					$('#footer').html(footer);
					$('#wxconfig').html(weixin);
					$('#sharpic').html(img);
					$('.currentbody').remove();
					$('#main').append('<div class="'+thisclass+' currentbody" id="'+SMS.hash(url)+'">'+main +'</div>');
					
					if($(main).is('.full')){
						$('.full').css('min-height',minheight-30 + 'px');
					}
					
					//cache
					if(typeof $(s).find('.smsbody').attr('nocache')== 'undefined'){
						SMS.setItem(SMS.hash(url), JSON.stringify({tt:title,hd:header,ft:footer,sc:script,url:url,wx:weixin,img:img,hk:hackcss}));
						SMS.setItem(SMS.hash(url), JSON.stringify($('.currentbody').prop("outerHTML")),'local');
					}
					SMS.cache(script,url);
					var state = {
						url: url,
						id: SMS.hash(url),
						head: header,
						foot: footer,
						sc: script,
						html: $('.currentbody').prop("outerHTML")
					};
					history.replaceState(state,null,url);
					SMS.wxconfig();
					SMS.postmessage(url,title,img);
					$('.currentbody .lazyload').picLazyLoad();
					SMS.evalscript(script);
				}
			},
			error: function(data) {
				window.location.href = url;
			}
		});
	},
	uptitle : function(title){
		document.title = title;
		/*
		if(andriod){
			document.title = title;
		}else{
			
			var $body = $('body');
			document.title = title;
			var $iframe = $('<iframe src=""></iframe>');
			$iframe.on('load',function() {
				setTimeout(function() {
					$iframe.off('load').remove();
				}, 0);
			}).appendTo($body);
		}
		*/		
	},
  /*loadpage*/
	loadpage : function(value) {
		
		SMS.unsetfun();
		
		var urllink=value.url.indexOf('?')>0?'&':'?';
		var iosurl=firsturl?'&iosurl='+encodeURIComponent(firsturl):'';
		
		$.ajax({
			type: 'GET',
			url: value.url+urllink+'load=true'+iosurl,
			dataType: 'html',
			success: function(s) {
        
				if(SMS.returnload(s,value.loading)){
          
					if(s.indexOf('<div class="smsbody')==-1){
						window.location.href = value.url;
						return false;
					}
					var hackcss=$(s).find('#hackcss').text();
					SMS.addcss(hackcss);
					if(s.indexOf('closepage')!=-1){
						if(value.closethispage){
							SMS.closepage(true);
							var closepage=true;
						}
					}
          
		      var header = $(s).find('#header').html(),footer = $(s).find('#footer').html(),script = $(s).find('#smsscript').html();
          var weixin=$(s).find('#wxconfig').html();
					var upid = $('.currentbody').attr('id');
					var main = $(s).find('.smsbody').html();
					var thisclass = $(s).find('.smsbody').attr('class');
					var st=$(window).scrollTop();
					var title = $(s).find('#pagetitle').text();
					var img = $(s).find('#sharpic').html();
					
          SMS.uptitle(title);

					$('#header').html(header);
					$('#footer').html(footer);
					$('#wxconfig').html(weixin);
					$('#sharpic').html(img);
					$('.currentbody').hide();
					$('.currentbody').attr('st',st).removeClass('currentbody');
					if($('#'+value.id).length>0){
            $('#'+value.id).remove();
			    }
			
					$('#main').append('<div class="'+thisclass+' currentbody" id="'+value.id+'" form="'+upid+'">'+main +'</div>');
					setTimeout(function(){$(window).scrollTop(0);})
					if($(main).is('.full')){
						$('.full').css('min-height',minheight-30 + 'px');
					}
					//cache
					if(typeof $(s).find('.smsbody').attr('nocache')== 'undefined'){
						SMS.setItem(value.id, JSON.stringify({tt:title,hd:header,ft:footer,sc:script,url:value.url,wx:weixin,img:img,hk:hackcss}));
						SMS.setItem(value.id, JSON.stringify($('.currentbody').prop("outerHTML")),'local');
					}
					SMS.cache(script,value.url);
					var state = {
						url: value.url,
						id: value.id,
						head: header,
						foot: footer,
						sc: script,
						html: $('.currentbody').prop("outerHTML")
					};
					if(closepage){
						history.replaceState(state,null,value.url);
					}else{
						history.pushState(state,null,value.url);			
					}
					SMS.wxconfig();
					SMS.postmessage(value.url,title,img);
					$('.currentbody .lazyload').picLazyLoad();
					SMS.evalscript(script);
					
				}
			},
			error: function(data) {
				window.location.href = value.url;
			}
		});
	},
  /*returnload*/
	returnload : function(s,type) {

		if(type!='reload'){
			if(type=='tab'){
				SMS.close();
			}else{
				setTimeout(function(){$('#loadpage').css({'display':'none','-webkit-transform':'translateX(100%)','-webkit-transition':'-webkit-transform 0s 0s'});loaderr=false;},1);
			}			
		}

		if(!s){
			SMS.open('目标网页无法打开','alert');
			return false;
		}
		if(s.indexOf('<div class="weui-dialog">')!=-1){
			var tip = $(s).find('.dialog-content').html();
			var fun = $(s).find('.js-content').html();
			var dialogjs = $(s).find('.dialogjs').html();
			SMS.open(tip,'html');
			
			if(fun){
				eval(fun);
			}
			if(dialogjs){
				SMS.evalscript(dialogjs);
			}
			return false;
		}
		if(s.indexOf('<div class="weui-toast">')!=-1){
			if(type!='load'){
				SMS.close();
			}
			var toast = $(s).find('.toast-content').html();
			var toastarr = toast.split('|');
			if(toastarr[0]){
				$('body').append('<div class="weui-toast"><i class="weui-icon-success-no-circle weui-icon_toast"></i><p class="weui-toast__content">'+toastarr[0]+'</p></div>');
				setTimeout(function(){$('.weui-toast').fadeOut();},500);
				setTimeout(function(){$('.weui-toast').remove();},1000);				
			}
			if(toastarr[1]){
				eval(toastarr[1]);
			}
			return false;
		}
		return true;
	},
	
  setcookie :function(cookieName, cookieValue, seconds, secure){
		if(cookieValue == '' || seconds < 0) {
			cookieValue = '';
			seconds = -2592000;
		}
		if(seconds) {
			var expires = new Date();
			expires.setTime(expires.getTime() + seconds * 1000);
		}
		document.cookie = escape(cookiepre + cookieName) + '=' + escape(cookieValue)
			+ (expires ? '; expires=' + expires.toGMTString() : '')
			+ (cookiepath ? '; path=' + cookiepath : '/')
			+ (cookiedomain ? '; domain=' + cookiedomain : '');
	},
	getcookie :function(name, nounescape){
		name = cookiepre + name;
		var cookie_start = document.cookie.indexOf(name);
		var cookie_end = document.cookie.indexOf(";", cookie_start);
		if(cookie_start == -1) {
			return '';
		} else {
			var v = document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length));
			return !nounescape ? unescape(v) : v;
		}
	},
	wxconfig :function(){
		if(isweixin){
			setTimeout(function(){
				var signture=$("#wx_signature").val();
				if(!SMS.empty(signture)){
					var apistr=$("#wx_jsapilist").val()||'onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';
					var apilist=new Array();
							apilist=$("#wx_jsapilist").val().split(",");
					wx.config({
						debug: false,
						appId: $("#wx_appid").val(), 
						timestamp: $("#wx_timestamp").val(), 
						nonceStr: $("#wx_noncestr").val(), 
						signature: signture,
						jsApiList: apilist 
					});
				}			
			},500);			
		}
	},
	/*toast*/
	toast : function(message,type) {
		var type=type||'success';
		if(type=='success'){
			var classname='weui-icon-success-no-circle';
		}else{
			var classname='weui-icon-warn';
		}
		$('body').append('<div class="weui-toast"><i class="'+classname+' weui-icon_toast"></i><p class="weui-toast__content">'+message+'</p></div>');
		setTimeout(function(){$('.weui-toast').fadeOut();},500);
		setTimeout(function(){$('.weui-toast').remove();},1000);
	},
	/*getsmscode*/
	getsmscode : function(action) {
		curcount = count;
		var tel=$('.currentbody #tel').val();	
		var teltest = /^0?(13[0-9]|15[0-9]|17[0678]|18[0-9]|14[57])[0-9]{8}$/;
		if(!teltest.test(tel)){
			SMS.open('请输入正确的手机号码', 'alert');
			return false;
		}
		$.ajax({
			type: 'GET',
			url: 'sms.php?action=get&item='+action+'&tel='+tel+'&load=true',
			dataType: 'html',
			success: function(s) {
				if(!s){
					SMS.open('短信接口配置错误，请联系管理员','alert');
					return false;
				}
				if(s.indexOf('<div class="weui-dialog">')!=-1){				
					var tip = $(s).find('.dialog-content').html();
					SMS.open(tip,'html');
					return false;
				}
				var res = $.parseJSON(s);
				if(res.Lid){
					$(".currentbody #smslid").val(res.Lid);
					intervalobj = window.setInterval(function(){SMS.setlimittime()},1000);
					$('.currentbody #smsbtn').attr("disabled", "true");
					$('.currentbody #smsbtn').removeClass('weui-btn_primary').addClass('weui-vcode-btn-gray');
				}else{
					SMS.open(res.Message,'alert');
					return false;
				}
			},
			error: function(data) {
				return false;
			}
		});	
	},
	/*setlimittime*/
	setlimittime : function(clear) {
		if(curcount == 0 || clear){                  
			window.clearInterval(intervalobj);
			$('.currentbody #smsbtn').removeAttr("disabled");
			$('.currentbody #smsbtn').removeClass('weui-vcode-btn-gray').addClass('weui-btn_primary');
			$('.currentbody #smsbtn').text("获取验证码");  
		}else{
			curcount--;
			$('.currentbody #smsbtn').text(curcount+"秒后可重新获取");  
		}  
	},
	/*opensheet*/
	opensheet : function(id,remove) {
		if($('.currentbody '+id).hasClass('weui-actionsheet_toggle')){
			SMS.unsetfun();
			$('#mask').css('display', 'none');
			if(remove){
				$('.currentbody '+id).remove();
			}else{
				$('.currentbody '+id).removeClass('weui-actionsheet_toggle');
			}
			
		}else{
			SMS.setfun("SMS.opensheet('"+id+"')");
			$('#mask').css('display', '');
			$('#mask').off().on('click', function() {SMS.opensheet(id,remove);});
			$('.close').off().on('click', function() {SMS.opensheet(id,remove);});
			$('.weui-actionsheet__menu a').off().on('click', function() {SMS.opensheet(id,remove);});
			$('.weui-actionsheet__action').off().on('click', function() {SMS.opensheet(id,remove);});
			$('.share-items a').off().on('click', function() {SMS.opensheet(id,remove);});
			$('.currentbody '+id).addClass('weui-actionsheet_toggle');
		}
	},
	share_weixin :function(){
		if(mini){
			SMS.open('<div class="share-wq"><img src="ui/share_min.png"></div>');
		}else{
			SMS.open('<div class="share-wq"><img src="ui/share_qw.png"></div>');
		}
	},
	poster :function(api){
		
		if(api){
			var src=api;
		}else{
			var url=encodeURI(window.location.href.split('#')[0]);
			var src='poster.php?url='+url;
		}
		var area_h=$(window).height()-90;
		var area_w=$(window).width();
		if((area_w*0.9/640)*1024>area_h){
			var pic_h=area_h.toFixed(2);
		}else{
			var pic_h=((area_w*0.9/640)*1024).toFixed(2);
		}
		var top=(area_h-pic_h)/2;
		
		var html='<div class="weui-gallery weui-poster" id="gallery" style="display: block; opacity: 1;">';
				html += '<div class="weui-picarea"><img src="'+src+'" style="margin-top:'+top+'px"></div>';
				html += '<div class="weui-picinfo tc c3">长按下载封面图片分享到朋友圈</div>';
				html += '<div class="weui-gallery__opr"><a href="javascript:" class="icon icon-close c3"></a></div></div>';
	
		$('body').append(html);
	
		$('.weui-gallery__opr a').off().on('click', function() {SMS.closepic();});	
	},
	/*openlayer*/
	openlayer : function(id) {
		if($('#'+id).length>0){
			SMS.unsetfun();
			var layer=$('#'+id).html();
			var st = $('#'+id).attr('st');
			$('#'+id).remove();
			$('#layer').append(layer);
			$('.currentbody').fadeIn();
			setTimeout(function(){$(window).scrollTop(st);})
		}else{
			SMS.setfun("SMS.openlayer('"+id+"',true)");
			var layer=$('#layer').html();
			var st=$(window).scrollTop();
			$('#layer').empty();
			
			$('.currentbody').css({'display':'none'});
			$('#main').append('<div class="layer b_c7" id="'+id+'" style="display:none" st='+st+'>'+layer+'</div>');
			setTimeout(function(){$('#'+id).fadeIn()});
		}
	},
	/*openside*/
	openside : function() {
		if($('#sidenv').css('display')=='none'){
			if($('.currentbody').hasClass('outback')){
				$('.icon-out').attr('href','member.php?mod=out&closepage=true');
			}
			SMS.setfun("SMS.openside(true)");
			$('#mask').css('display', '');
			$('#sidenv').css('display', '');
			setTimeout(function(){$('#sidenv').css({'-webkit-transform':'translateX(0%)','-webkit-transition':'-webkit-transform 0.3s ease-out 0s'});},1);
			$('#mask').off().on('click', function() {SMS.openside();});
			$('#sidenv a').off().on('click', function() {SMS.openside();});
			
		}else{
			SMS.unsetfun();
			$('#mask').css('display', 'none');
			$('#sidenv').css({'-webkit-transform':'translateX(100%)','-webkit-transition':'-webkit-transform 0.3s ease-out 0s'});
			setTimeout(function(){$('#sidenv').css({'display':'none'});},300);				
		}
	},
	showheader : function(bodyclass) {
		if(bodyclass=='noheader'){
			if($('#body').hasClass('noheader')){
				$('#body').removeClass('noheader');
			}else{
				$('#body').addClass('noheader');
			}
		}else{
			if($('#body').hasClass('nohf')){
				$('#body').removeClass('nohf').addClass('nofooter');
			}else{
				$('#body').addClass('nohf').removeClass('nofooter');
			}
		}
	},
	/*evalscript*/
	evalscript : function(s) {
		
		if(s){
			if(s.indexOf('<script') == -1) return s;
			var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
			var arr = [];
			while(arr = p.exec(s)) {
				var p1 = /<script[^\>]*?src=\"([^\>]*?)\"[^\>]*?(reload=\"1\")?(?:id=\"([\w\-]+?)\")?><\/script>/i;
				var arr1 = [];
				arr1 = p1.exec(arr[0]);
				if(arr1) {
					SMS.appendscript(arr1[1], '', arr1[2], arr1[3]);
				}else{
					p1 = /<script[^\>]*?(?:id=\"([\w\-]+?)\")?>([^\x00]+?)<\/script>/i;
					arr1 = p1.exec(arr[0]);
					SMS.appendscript('', arr1[2], arr1[0].indexOf('reload=') != -1,arr1[1]);
				}
			}
			return s;			
		}
	},
	/*appendscript*/
	appendscript : function(src, text, reload, id) {

		var JSLOADED = [];
		if(!id){
			var id = SMS.hash(src + text);
		}	
		if(!reload && $.inArray(id,evalscripts)!=-1) return;
		if(reload && $('#' + id)[0]) {
			$('#' + id)[0].parentNode.removeChild($('#' + id)[0]);
		}else{
			evalscripts.push(id);
		}

		var scriptNode = document.createElement("script");
		scriptNode.type = "text/javascript";
		scriptNode.id = id;
		scriptNode.charset = !document.charset ? document.characterSet : document.charset;
		try {
			if(src) {
				scriptNode.src = src;
				scriptNode.onloadDone = false;
				scriptNode.onload = function () {
					scriptNode.onloadDone = true;
					JSLOADED[src] = 1;
				};
				scriptNode.onreadystatechange = function () {
					if((scriptNode.readyState == 'loaded' || scriptNode.readyState == 'complete') && !scriptNode.onloadDone) {
						scriptNode.onloadDone = true;
						JSLOADED[src] = 1;
					}
				};
			} else if(text){
				scriptNode.text = text;
			}
			document.getElementById('smsscript').appendChild(scriptNode);
			if(reload){
				reload=1;
				setTimeout(function(){$('#'+id).attr('reload',reload);});
			}
		} catch(e) {}
	},
	randomString : function(len) {
　　len = len || 32;
　　var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
　　var maxPos = $chars.length;
　　var str = '';
　　for (i = 0; i < len; i++) {
　　　　str += $chars.charAt(Math.floor(Math.random() * maxPos));
　　}
　　return str;
  },
	/*hash*/
	hash : function(string, length) {
		var length = length ? length : 32;
		var start = 0;
		var i = 0;
		var result = '';

		while(start < string.length) {
			result = SMS.stringxor(result, string.substr(start, length));
			start += length;
		}
		return result;
	},
	/*stringxor*/
	stringxor : function(s1, s2) {
		var s = '';
		var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		var max = Math.max(s1.length, s2.length);
		for(var i=0; i<max; i++) {
			var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
			s += hash.charAt(k % 52);
		}
		return s;
	},
  /*empty*/
	empty : function(value) {
		return (typeof value == 'undefined' || value == '') ? true : false;
	},
	
  /*deleteimg*/
	deleteimg : function(aid) {
		$('.currentbody #img_'+aid).remove();
		$('.currentbody .weui-uploader').append('<input name="deleteimg[]" type="hidden" value="'+aid+'" />');
	},
	/*translate_int*/
	translate_int : function() {
		var tabs=$('.currentbody .swipernv ul').children('li');
		for(var i=0; i<tabs.length; i++){
			if($(tabs[i]).hasClass('c1')){
				var now=i+1;
			}
		}
		
		var num=tabs.length;
		var translate=Math.round((($('#body').width()/2)-14)/num,2);
		if(now>1){
			var translate=Math.round(translate+(now-1)*($('#body').width()/num),2);
		}
		$('.currentbody .swipernv-on').css({'-webkit-transform':'translateX('+translate+'px)','-webkit-transition':'-webkit-transform 0.3s ease-out 0s'});
	},
	/*closepage*/
	closepage : function(his) {
		SMS.unsetfun();
		if(his){
			var id = $('.currentbody').attr('form');
			var st = $('.currentbody').attr('st');
			
			var Storage=sessionStorage.getItem(id);
			if(Storage){
				var Storagevar = JSON.parse(Storage);
				$('#header').html(Storagevar.hd);
				$('#footer').html(Storagevar.ft);
				$('.currentbody').remove();
				$('#'+id).fadeIn();
				$('#'+id).addClass('currentbody');
				setTimeout(function(){$(window).scrollTop(st);})	
			}else{
				SMS.error();
			}				
		}else{
		  window.history.back(-1);
		}
	},
	/*closepic*/
	closepic : function() {
		SMS.unsetfun();
		var showpics={};
		$('#gallery').remove();
	},
	/*smile*/
	smile : function(code,id) {
		if(id){
			var obj=$('#'+id+' #postmessage');
		}else{
			var obj=$('.currentbody #postmessage');
		}
		var message=obj.val();
		obj.val(message+code);
		SMS.setfocus('#'+id+' #postmessage');
	},
	
	uploadsuccess  : function(src,input) {
		$('.currentbody .'+input+'_area').html('<img src="'+ATC+'/'+src+'"/>');
		$('.currentbody #'+input+'_val').val(src);
	},
	/*unfold*/
	unfold : function(id,element,maxheight) {
		if($('.currentbody #'+id).hasClass('icon-expanding')){
			$('.currentbody #'+id).removeClass('icon-expanding').addClass('icon-collapsing');
			var height=$('.currentbody '+element).children().length*$('.currentbody '+element).children().height();
		}else{
			$('.currentbody #'+id).removeClass('icon-collapsing').addClass('icon-expanding');
			var height=maxheight;
		}
		$('.currentbody '+element).animate({height: height+'px'}, 300,'ease-out');
	},
	toggle : function(show,hide){
		$(show).show();
		$(hide).hide();
	},
	/*timelimit*/
	timelimit : function(id,time) {
		var timer=null;
		timer=window.setInterval(function(){
			var hour=0,minute=0,second=0;
			if(time > 0){
				hour = Math.floor(time / (60 * 60));
				minute = Math.floor(time / 60) - (hour * 60);
				second = Math.floor(time) - (hour * 60 * 60) - (minute * 60);
			}
			if (hour <= 9) hour = '0' + hour;
			if (minute <= 9) minute = '0' + minute;
			if (second <= 9) second = '0' + second;
			$('#'+id+' .hour').text(hour);
			$('#'+id+' .minute').text(minute);
			$('#'+id+' .second').text(second);
			time--;
		},1000);
		if(time<=0){
			clearInterval(timer);
		}
	},
	/*setfocus*/
	setfocus : function(id) {
		setTimeout(function(){$(id).focus();},100);
	},
	/*setfocus*/
	gz : function() {
		SMS.open('<div class="gzgzh"><span class="icon icon-close" onClick="SMS.close()"></span><div class="qrcode"><img src="$gzh_logo"></div><div class="c3"><h2>长按二维码</h2><p>$gzh_text</p></div></div>','html','gzh');
	},
	/*tomini*/
	tomini : function(appid,path){
		if(mini){
			var params = '?appid='+appid+'&path='+path;
			var path = '/pages/openmini/openmini'+params;
			wx.miniProgram.navigateTo({url: path});				
		}else{
			SMS.open('请在微信小程序内点击本按钮','alert');
		}
	
	},
	/*WxPosition*/
	WxPosition : function(url) {
		if(!url && $('.currentbody #setlbs').hasClass('c1')){
			$('.currentbody #setlbs').removeClass('c1');
			$('.currentbody #lbs').val('');
			$('.currentbody #lbsarea').hide();
			$('.currentbody #lbsarea .weui-cell__bd').text('');
		}else{
			
			wx.ready(function(){
				wx.getLocation({
					type: 'gcj02',
					success: function (res) {
						SMS.loading();
						geocoder = new qq.maps.Geocoder();
						var latLng = new qq.maps.LatLng(res.latitude, res.longitude);
						geocoder.getAddress(latLng);
						geocoder.setComplete(function(result) {
							var position={
								lat:res.latitude,
								lng:res.longitude,
								nation:result.detail.addressComponents.country,
								province:result.detail.addressComponents.province,
								city:result.detail.addressComponents.city,
								district:result.detail.addressComponents.district,
								addr:result.detail.addressComponents.street+result.detail.addressComponents.streetNumber+result.detail.addressComponents.town+result.detail.addressComponents.village
							};
							var loc = JSON.stringify(position);
							$.ajax({
								type: 'GET',
								url:'index.php?mod=lbs&loc='+loc,
								dataType:'html',
								success: function(s) {
									if(url){
										var id=SMS.hash(url);
										SMS.uplastavtive();
										SMS.load(url,'','','','tab',id);								
									}else{
										SMS.close();
										var lbs=position.city+(position.district?','+position.district:'')+(position.addr?','+position.addr:'');
										$('.currentbody #setlbs').addClass('c1');
										$('.currentbody #lbs').val(lbs);
										$('.currentbody #lbsarea').show();
										$('.currentbody #lbsarea .weui-cell__bd').text(lbs);	
									}
									return;
								},
								error: function(data) {
									SMS.oepn('定位失败','alert');
								}
							});
						});
						geocoder.setError(function() {
							SMS.oepn('位置获取失败','alert');
						});
					},
				});					
				
			});
			wx.error(function(res){
				SMS.oepn('定位失败','刷新网页后重新点击定位');
			});
		}
	},
	/*Position*/
	Position : function(appid,appname,call) {
		SMS.loading();
		geolocation = new qq.maps.Geolocation(appid, appname);
		geolocation.getLocation(call, null);
	},
	/*GetPosition*/
	GetPosition : function(position) {

		if($('.currentbody #setlbs').hasClass('c1')){
			$('.currentbody #setlbs').removeClass('c1');
			$('.currentbody #lbs').val('');
			$('.currentbody #lbsarea').hide();
			$('.currentbody #lbsarea .weui-cell__bd').text('');
		}else{
			var lbs=position.city+(position.district?','+position.district:'')+(position.addr?','+position.addr:'');
			$('.currentbody #setlbs').addClass('c1');
			$('.currentbody #lbs').val(lbs);
			$('.currentbody #lbsarea').show();
			$('.currentbody #lbsarea .weui-cell__bd').text(lbs);
			SMS.SetPosition(position);
		}
		SMS.close();
	},
	/*SetPosition*/
	SetPosition : function(position) {
		var url=$('#primary').attr('param');
		if(!position.lat && !position.lng){
			SMS.open('您的手机没有开启地图定位功能','alert');
		}else{
			var loc = JSON.stringify(position);
			$.ajax({
				type: 'GET',
				url:'index.php?mod=lbs&loc='+loc,
				dataType:'html',
				success: function(s) {
					if(url){
						var id=SMS.hash(url);
						SMS.uplastavtive();
						SMS.load(url,'','','','tab',id);
					}
					return true;
				},
				error: function(data) {
					SMS.oepn('定位失败','alert');
				}
			});		
		}
	},
	/*postmessage*/
	postmessage : function(url,title,img){
		var url=url||window.location.href.split('#')[0];
		var title=title||$('title').text();
		if(img.indexOf("ui/ico.png")>-1){
			var img='';
		}
		setTimeout(function(){
			if(mini){
				wx.miniProgram.postMessage({ data:{url:url,title:title,img:img}})
			}
		},300);		
	},
	/*back*/
	back:function(){
		if(window.history.length>0){
			window.history.back(-1);
		}else{
			SMS.load('index.php','','','','',SMS.hash('index.php'));
		}
	}
};

$(document).ready(function() {
	SMS.popinit();
	SMS.init();
	if(ios){
		$('#main').dropload({
			scrollArea : window,
			domUp : {
					domClass   : 'dropload-up',
					domRefresh : '<div class="dropload-refresh c4">↓下拉刷新</div>',
					domUpdate  : '<div class="dropload-update c4">↑释放更新</div>',
					domLoad    : '<div id="droploadpage" class="b_c3" onclick="$(\'.dropload-up\').remove();" style="-webkit-transform:translateX(0%);-webkit-transition:0.3s ease-out 0s;"><div class="loadingpage"><span class="l1"></span><span class="l2"></span><span class="l3"></span></div></div>'
			},
			loadUpFn : function(me){
				window.location.reload();
			},
			distance : 300
		});		
	}
	$('.scrollx_area').on('touchstart', function(e){
		event.stopPropagation();
	});

});