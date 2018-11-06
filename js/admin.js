// JavaScript Document

function checkall(e, itemName){
	var aa = document.getElementsByName(itemName);
	for (var i=0; i<aa.length; i++){
	 aa[i].checked = e.checked;
	}
}
function writeobj(obj){ 
 var description = ""; 
 for(var i in obj){ 
 var property=obj[i]; 
 description+=i+" = "+property+"\n"; 
 } 
 alert(description); 
} 


/* 显示登录窗口 */
    function shogMinWin(){
        var mini_login = document.getElementsByClassName("mini_login")[0];
        var cover = document.getElementsByClassName("cover")[0];
        mini_login.style.display = "block";
        cover.style.display = "block";
        
        mini_login.style.left = (document.body.scrollWidth - mini_login.scrollWidth) / 2 + "px";
        mini_login.style.top = (document.body.scrollHeight + mini_login.scrollHeight) / 2 + "px";
    }

    /* 关闭登录窗口 */
    function closeMinWin(){
        var mini_login = document.getElementsByClassName("mini_login")[0];
        var cover = document.getElementsByClassName("cover")[0];
        mini_login.style.display = "none";
        cover.style.display = "none";
    }

    /* 移动登录窗口 */
    function moveMinWin(event){
        var moveable = true;

        //获取事件源
        event = event ? event : window.event;
        var clientX = event.clientX;
        var clientY = event.clientY;
        
        var mini_login = document.getElementById("mini_login");
        console.log(mini_login);
        var top = parseInt(mini_login.style.top);
        var left = parseInt(mini_login.style.left);//鼠标拖动
        document.onmousemove = function(event){
            if(moveable){
                event = event ? event : window.event;
                var y = top + event.clientY - clientY;
                var x = left + event.clientX - clientX;
                if(x>0 && y>0){
                    mini_login.style.top = y + "px";
                    mini_login.style.left = x + "px";
                }
            }
        }
        //鼠标弹起
        document.onmouseup = function(){
            moveable = false;
        }
    }
/*youlam_topic.php文件中选择分类中select选择后提交*/
function submitTopicSelect1(){
	var val = $("#youlam_topic_class_select1 option:selected").val();
	var url="youlam.php?mod=youlam&item=topic&ac=select&selectFirstClass="+val;
	$('#youlam_topic_ajax_list').empty();
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'json',
		success: function(s) {
		//	console.log(s);
			if(!s){	//返回null
				document.getElementById("youlam_topic_class_select2").options.length = 0;
				document.getElementById("youlam_topic_class_select2").innerHTML="<option>请选择</option>"
				alert('此一级分类下的二级分类为空！');
				$('#youlam_topic_ajax_list').empty();
			//	$('#youlam_topic_types').empty();	//"选择话题分类"区域清空
				$('#youlam_add_types').empty();
			}else{
				var objKeys=Object.keys(s);	//Object.keys()方法把对象的key存储成一个array
		//		console.log(objKeys);	//Array [ "2", "3"]
		//		console.log(objKeys.length);	//2
				var objOption = document.getElementById("youlam_topic_class_select2");
				for(var i=0;i<objKeys.length;i++){
					objOptionText = s[objKeys[i]]["name"];
					objOptionValue = s[objKeys[i]]["tid"];
					objOption.options.add(new Option(objOptionText,objOptionValue));
				}
			}
		},
		error: function(data) {
			alert('发生错误！！');
		}
	});
}
function submitTopicSelect2(){
	/*
	var sel=document.getElementsByName("XXX")[0].value; //获取下拉表单的value值
	*/
	var val = $("#youlam_topic_class_select2 option:selected").val();	//IE8下可能无法获取到selected的值，可考虑上一行的方法
	var url="youlam.php?mod=youlam&item=topic&ac=select&selectSecondClass="+val;
	document.getElementById("youlam_topic_class_select3").options.length = 0;
	document.getElementById("youlam_topic_class_select3").innerHTML="<option>请选择</option>"
	$('#youlam_topic_ajax_list').empty();
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'json',
		success: function(s) {
			var list = s['types'];
			if(!list){	//返回false
				document.getElementById("youlam_topic_class_select3").options.length = 0;
				document.getElementById("youlam_topic_class_select3").innerHTML="<option>请选择</option>"
				alert('此话题下不存在自定义分栏！');
				$('#youlam_topic_ajax_list').empty();
			}else{
				var objKeys=Object.keys(list);	//Object.keys()方法把对象的key存储成一个array
				console.log(objKeys);
				var objOptionSelect3 = document.getElementById("youlam_topic_class_select3");
				for(var i=0;i<objKeys.length;i++){
					objOptionText = list[objKeys[i]];
					objOptionValue = objKeys[i];
					objOptionSelect3.options.add(new Option(objOptionText,objOptionValue));
					$("#youlam_miniWin_select option[value="+objKeys[i]+"]").remove();	//删除已经设置的话题分栏
				}
			}
			document.getElementById("youlam_add_types").innerHTML="+调整话题分栏";
		},
		error: function(data) {
			alert('发生错误！！');
		}
	});
}
function submitMiniSelect(){
	var val = $("#youlam_miniWin_select option:selected").val();
	var text = $("#youlam_miniWin_select option:selected").text();
	document.getElementById('youlam_ajax_miniWin_types_name_id').value = val;
	document.getElementById('youlam_ajax_miniWin_input_name_array').value = text;
}

function submitTopicSelect3(){
	var val2 = $("#youlam_topic_class_select2 option:selected").val();
	var val3 = $("#youlam_topic_class_select3 option:selected").val();
	var url="admin.php?mod=youlam&item=topic_ajax&iframe=1&selectSecondClass="+val2;
	$('#youlam_topic_ajax_list').empty();
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'html',
		success: function(s) {
	//		console.log(s);
			if(val3==1){
				var tipsList=$(s).find('#tips_ajax_list').html();
				$('#youlam_topic_ajax_list').html(tipsList);
				document.getElementById('youlam_miniWin_form').action += "&ac=addTips";
				document.getElementById('youlam_miniWin_form').action += "&selectSecondClass="+val2;
			}
		},
		error: function(data) {
			alert('发生错误！！');
		}
	});
}

function youlam_add_types(){
	var val = $("#youlam_topic_class_select2 option:selected").val();
	var len = document.getElementById('youlam_topic_class_select3').options.length;
	
	document.getElementById( "youlam_miniWin_tr_id").style.display= "none";
	document.getElementById("youlam_miniWin_input_id").value = "";
	
	document.getElementById( "youlam_miniWin_input_name").style.display= "none";
	document.getElementById("youlam_miniWin_input_name").value = "";
	
	document.getElementById( "youlam_miniWin_th_name").innerHTML="当前分栏";
	
	document.getElementById( "youlam_miniWin_tr_url").style.display= "none";
	document.getElementById("youlam_miniWin_input_url").value = "";
/*上面这句话用处很大的，因为你想隐藏掉下面的一个表单，那么这个表单的值也就不需要写入数据库了，所以记得在隐藏的同时将被隐藏表单的值清空；
当然要是你不嫌麻烦的话在表单的数据提交到php的数据处理页面的时候对“此ID”根据其值是0还是1来行进判断写不写入“此ID”的值 */
	document.getElementById( "youlam_miniWin_tr_pic").style.display= "none";
	document.getElementById("youlam_miniWin_input_pic").value = "";
	
	//修改form标签中action的值
	
/*	document.getElementById('youlam_miniWin_form').action += "&ac=addTopicTypes";
	document.getElementById('youlam_miniWin_form').action += "&typesId="+len;
	document.getElementById('youlam_miniWin_form').action += "&selectSecondClass="+val;
*/	
	var url="admin.php?mod=youlam&item=topic_ajax&iframe=1&selectSecondClass="+val;
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'html',
		success: function(s) {
		//	console.log(s);
			var typesList=$(s).find('#youlam_ajax_miniWin_types_div_name').html();
			
			$('#youlam_miniWin_div_name').html(typesList);
//			document.getElementById('youlam_ajax_miniWin_types_name_id').value = len;
			
			document.getElementById('youlam_miniWin_form').action += "&ac=addTopicTypes";
			document.getElementById('youlam_miniWin_form').action += "&selectSecondClass="+val;
		},
		error: function(data) {
			alert('发生错误！！');
		}
	});
	
	shogMinWin();
}

function youlam_btn_showTipsAdd(){
	document.getElementById( "youlam_miniWin_tr_id").style.display= "none";
	document.getElementById("youlam_miniWin_input_id").value = "";
	
	document.getElementById( "youlam_miniWin_tr_select").style.display= "none";
	document.getElementById("youlam_miniWin_select").value = "";
	
	document.getElementById( "youlam_miniWin_th_name").innerHTML="名称";
	document.getElementById( "youlam_miniWin_th_url").innerHTML="链接";
	
	shogMinWin();
}

function checkdelete(form,itemName,id){
	//alert($(form));
	console.log(checkvalue);
	var checkvalue='';
	$('input[name="'+itemName+'[]"]:checked').each(function(){    
		checkvalue+=this.value + ',';
	});
	if(checkvalue){
		var doit=confirm('提交之后会删除掉您所勾选的数据，并且此操作不可逆，您确认要进行本操作吗');
		 if(doit==true){
			 $('#confirm').val(1);
			 if(id){
				 $('#'+id).val(true);
			 }
			console.log(checkvalue);
		   $(form).submit();
		//	 document.getElementById("tips_ajax_list").submit();	
		//	 $("#tips_ajax_list").submit();
		 }
	}else{
		$(form).submit();
	}
}
$(document).on('click', '.get', function() {
	var obj = $(this);
	var url=obj.attr('href');
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'html',
		success: function(s) {
			if(s.indexOf('error:')!=-1){
				var error = s.split(':');
			}else{
				$('#window').html(s);
				var top=($(window).height()-$('.modset').outerHeight())/2;
				var left=($(window).width()-950)/2;
				$('#window').css({'top':top+'px','left':left+'px'});				
			}

		},
		error: function(data) {
			alert('发生错误');
		}
	});
	
	return false;
});

$(document).on('click', '.formpost', function() {
	var obj = $(this);
	var formobj = $(this.form);
	if(formobj.attr('enctype')=='multipart/form-data'){
		var data=new FormData(formobj[0]),contentType=false,processData=false;
	}else{
		var data=formobj.serialize(),contentType='application/x-www-form-urlencoded',processData=true;
	}
	$.ajax({
		type: 'POST',
		url:formobj.attr('action'),
		data:data,
		dataType: 'json',
		cache: false,
		contentType: contentType,  
		processData: processData,  
		success: function(s) {
      if(s.jsfunc){
				var func=s.jsfunc+'('+JSON.stringify(s.value)+');';
				eval(func);
			}else{
				alert(s.msg);
			}
		},
		error: function(data) {
			alert('提交数据发生错误');
		}
	});
	return false;
});

function closewindow(){
	$('#window').css({'top':'','left':''}).empty();
}

function delpic(aid,area){
	$('#'+area).append('<input type="hidden" name="delcover[]" value="'+aid+'">');
	$('#pic_'+aid).remove();
}

(function($) {
  $.fn.extend({
	  shortcuts : function(){
			this.keydown(function(e){
				var _this = $(this);
				e.stopPropagation();
				if(e.ctrlKey){
					switch(e.keyCode){
						case 66:
							_this.insertContent('[b]'+ _this.selectionRange() +'[/b]');
							return false;
							break;
						case 49:
							_this.insertContent('[h1]'+ _this.selectionRange() +'[/h1]');
							return false;
							break;
						case 50:
							_this.insertContent('[h2]'+ _this.selectionRange() +'[/h2]');
							return false;
							break;
						case 51:
							_this.insertContent('[h3]'+ _this.selectionRange() +'[/h3]');
							return false;
							break;
						case 52:
							_this.insertContent('[h4]'+ _this.selectionRange() +'[/h4]');
							return false;
							break;
						case 53:
							_this.insertContent('[h5]'+ _this.selectionRange() +'[/h5]');
							return false;
							break;
						case 54:
							_this.insertContent('[h6]'+ _this.selectionRange() +'[/h6]');
							return false;
							break;
					}
				}else if(e.altKey){
					switch(e.keyCode){
						case 67:
							_this.insertContent('[code]'+ _this.selectionRange() +'[/code]');
							return false;
							break;
						case 76:
							_this.insertContent('[li]'+ _this.selectionRange() +'[/li]');
							return false;
							break;
						case 80:
							_this.insertContent('[p]'+ _this.selectionRange() +'[/p]');
							return false;
							break;
						case 85:
							_this.insertContent('[url]'+ _this.selectionRange() +'[/url]');
							return false;
							break;
					}
				}	
			});
		},
		insertContent: function(myValue, t) {
			var $t = $(this)[0];
			if(document.selection) {
				this.focus();
				var sel = document.selection.createRange();
				sel.text = myValue;
				this.focus();
				sel.moveStart('character', -l);
				var wee = sel.text.length;
				if(arguments.length == 2) {
					var l = $t.value.length;
					sel.moveEnd("character", wee + t);
					t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length);
					sel.select();
				}
			}else if($t.selectionStart || $t.selectionStart == '0') {
				var startPos = $t.selectionStart;
				var endPos = $t.selectionEnd;
				var scrollTop = $t.scrollTop;
				$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
				this.focus();
				$t.selectionStart = startPos + myValue.length;
				$t.selectionEnd = startPos + myValue.length;
				$t.scrollTop = scrollTop;
				if (arguments.length == 2) {
					$t.setSelectionRange(startPos - t, $t.selectionEnd + t);
					this.focus();
				}
			}
			else {
				this.value += myValue;
				this.focus();
			}
		},
		selectionRange : function(start, end) {
			var str = "";
			var thisSrc = this[0];
			if(start === undefined) {
				if(/input|textarea/i.test(thisSrc.tagName) && /firefox/i.test(navigator.userAgent)){
					str = thisSrc.value.substring(thisSrc.selectionStart, thisSrc.selectionEnd);
				}else if(document.selection){
					str = document.selection.createRange().text;
				}else{
					str = document.getSelection().toString();
				}
			}else{
				if(!/input|textarea/.test(thisSrc.tagName.toLowerCase()))
				return false;
				(end === undefined) && (end = start);
				if(thisSrc.setSelectionRange) {
					thisSrc.setSelectionRange(start, end);
					this.focus();
				}else{
					var range = thisSrc.createTextRange();
					range.move('character', start);
					range.moveEnd('character', end - start);
					range.select();
				}
			}
			if(start === undefined){
				return str;
			}else{
				return this;
			}
		}
  })
})(jQuery);


$(function() {
	
//	document.getElementById("youlam_btn_showTipsAdd").onclick = shogMinWin;
    document.getElementById("youlam_miniWin_close").onclick = closeMinWin;
    document.getElementById("firstLine").onmousedown = moveMinWin;
		
	$(':text,textarea').keyup(function(event) {
		event.stopPropagation();
	});
	$('body').keydown(function(e) {
		if (e.which == 8 && !$(e.target).is("input")) {
			return false;
		}
	});
	$('.ubb .title').click(function() {
		$(this).closest('.ubb').find('textarea').insertContent('[h2]' + $(this).closest('.ubb').find('textarea').selectionRange() + '[/h2]');
	});
	$('.ubb .bold').click(function() {
		$(this).closest('.ubb').find('textarea').insertContent('[b]' + $(this).closest('.ubb').find('textarea').selectionRange() + '[/b]');
	});
	$('.ubb .link').click(function() {
		$(this).closest('.ubb').find('textarea').insertContent('[url]' + $(this).closest('.ubb').find('textarea').selectionRange() + '[/url]');
	});
	$('.ubb .code').click(function() {
		$(this).closest('.ubb').find('textarea').insertContent('[code]' + $(this).closest('.ubb').find('textarea').selectionRange() + '[/code]');
	});
	$('.ubb .codecolor').click(function() {
		$(this).closest('.ubb').find('textarea').insertContent('[c]' + $(this).closest('.ubb').find('textarea').selectionRange() + '[/c]');
	});
	$('.ubb .uppic').click(function() {
		var obj=$(this);
		var formobj = $('#ubbupload');
		
		$('#uppic').click();
		$('#uppic').off("change");
		$('#uppic').change(function(){
			var formData = new FormData(formobj[0]);
			$.ajax({
				type: 'POST',
				url:formobj.attr('action'),
				data: formData,  
				dataType: 'json',
				cache: false,  
				contentType: false,  
				processData: false,  
				success: function(s) {
					if(s.pic){
						obj.closest('.ubb').find('textarea').insertContent('[img]' + s.pic + '[/img]');
					}else{
						alert(s.msg);
					}
				},
				error: function(data) {
					alert('图片上传错误');
				}
			});	
		});
	});	
	$('textarea').shortcuts();
});