
$(document).on('click', '.setbanner a.icon-close', function() {
	$(this).remove();
	$('.currentbody .banner_area').html('<span class="block b_c8">点击设置Banner（640*320）</span>');
	$('.currentbody #banner_val').val('');
  return false;
});

var topic = {
	
	jotopic : function(ac,tid,users) {
		if(ac=='join'){
			$('#topicbtn_'+tid).removeClass('weui-btn weui-btn_mini load').addClass('icon icon-more').text('');
			$('#topicbtn_'+tid).attr('href','javascript:SMS.opensheet(\'#topicsheet\')');
			
			$('#topicbot_'+tid).removeClass('weui-btn weui-btn_mini weui-btn_default load').addClass('icon icon-more').text('');
			$('#topicbot_'+tid).attr('href','javascript:SMS.opensheet(\'#topicsheet\')');
			
		}else{
			$('#topicbtn_'+tid).removeClass('icon icon-more').addClass('weui-btn weui-btn_mini load').text('加入');
			$('#topicbtn_'+tid).attr('href','topic.php?mod=action&ac=join&tid='+tid);

			$('#topicbot_'+tid).removeClass('icon icon-more').addClass('weui-btn weui-btn_mini weui-btn_default load').text('加入');
			$('#topicbot_'+tid).attr('href','topic.php?mod=action&ac=join&tid='+tid);
		}
		$('#users_'+tid).text(users);
		topic.uptopic(tid,false);	
	},

	settheme : function(vid,value,ac) {
		if(ac=='settop'){
			var text=value==1?'取消置顶':'置顶';
			if(value==1){
				$('.currentbody .article_title').prepend('<span class="b_c8 c3">置顶</span>');
			}else{
				$('.currentbody .article_title .b_c8').remove();
			}
		}else if(ac=='setbest'){
			var text=value==1?'取消推荐':'推荐';
			if(value==1){
				$('.currentbody .article_title').prepend('<span class="b_c1 c3">推荐</span>');
			}else{
				$('.currentbody .article_title .b_c1').remove();
			}
		}
		$('#'+ac+'_'+vid).text(text);
		SMS.deleteitem('topic.php?vid='+vid);
	},
	creattopic : function(tid,cover,name,about) {
		$('#mytopic').prepend('<a href="topic.php?tid='+tid+'" class="weui-cell weui-cell_access load"><div class="weui-cell__hd"><img src="'+cover+'"></div><div class="weui-cell__bd"><h4>'+name+'</h4><p class="c4">'+about+'</p></div></a>');
		SMS.deleteitem('topic.php');
		SMS.deleteitem('topic.php?mod=list',false)
	},
	uptopic : function(tid,update) {
		SMS.deleteitem('topic.php?tid='+tid,update);
		SMS.deleteitem('topic.php?tid='+tid+'&show=member',update);
	},
	usermanage : function(ac,uid,tid,users) {
		if(ac==1 || ac==2){
			$('.currentbody #user_'+uid).remove();
		}else if(ac==3 || ac==4){
			$('.currentbody #apply_'+uid).remove();
		}else if(ac==5){
			$('.currentbody #member_'+uid).remove();
		}else{
			$('.currentbody #manager_'+uid).remove();
		}
		if(tid && users){
			$('#users_'+tid).text(users);
		}
		if(ac!=1){
			topic.uptopic(tid,false);	
		}
	},
	setpraise : function(vid) {
		SMS.upcount('#themepraise_'+vid);
		$('#themepraise_'+vid+' a').addClass('c1');
		SMS.deleteitem('topic.php?vid='+vid,true,true);
	},
	
	addtheme : function(vid,style,tid) {
		
		if(tid){
			SMS.ajax('get.php?type=theme&show=list&liststyle='+style+'&vid='+vid,'.currentbody .themeslist','prepend');
			var themes =parseInt($('#themes_'+tid).text())+1;
			$('#themes_'+tid).text(themes);
			SMS.deleteitem('topic.php?tid='+tid,true,true);
		}else{
			
			if($('#uv_'+UID+'my').length>0){
				SMS.ajax('get.php?type=theme&show=list&liststyle='+style+'&vid='+vid,'.currentbody #uv_'+UID+'my','prepend');
			}else{
				SMS.open('<div class="weui-dialog__bd">发布成功是否前往查看</div><div class="weui-dialog__ft"><a href="javascript:;" onclick="SMS.close();" class="weui-dialog__btn weui-dialog__btn_default">取消</a><a href="topic.php?vid='+ vid +'" class="weui-dialog__btn weui-dialog__btn_primary load">查看</a></div>','html');
			}
			SMS.deleteitem('user.php'+tid,true);
		}
	},
	deletetheme : function(vid,tid) {
		$('.currentbody #theme_'+vid).remove();
		if(tid){
			var themes =parseInt($('#themes_'+tid).text())-1;
			$('#themes_'+tid).text(themes);
			SMS.deleteitem('topic.php?tid='+tid);
		}else{
			SMS.deleteitem('user.php');
		}
	},
	updatetheme : function(vid,subject) {
		$('#subject_'+vid).text(subject);
		SMS.ajax('get.php?type=theme&show=view&vid='+vid,'.currentbody .themecontent','replace');
		SMS.deleteitem('topic.php?vid='+vid);
	},
	addthemetype : function() {
		typeid++;
		var type='<div class="weui-cell" id="type_'+typeid+'"><div class="weui-cell__bd">';
			 type+='<input type="hidden" name="typeid[]" value="'+typeid+'" >';
			 type+='<input class="weui-input" type="text" name="typename[]" placeholder="话题分类名称" value="">';
			 type+='</div><div class="weui-cell__ft"><a href="javascript:$(\'#type_'+typeid+'\').remove()" class="icon icon-close c9"></a></div>';
		$('.currentbody #themetypes').append(type);
	},

};