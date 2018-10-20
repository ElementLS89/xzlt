var smsot = {
	addfriend : function(uid) {
		$('#addfriend_'+uid).addClass('c2').removeClass('load');
		$('#addfriend_'+uid).attr('href','javascript:');
		$('#addfriend_'+uid).text('已添加');
		SMS.deleteitem('user.php?uid='+uid);
	},
	isfriend : function(uid,tid){
		$('#addfriend_'+uid).addClass('weui-btn_primary').removeClass('weui-btn_default');
		$('#addfriend_'+uid).attr('href','my.php?mod=talk&tid='+tid);
		$('#addfriend_'+uid).text('聊天');
		SMS.deleteitem('user.php?uid='+uid);
	},
	follow : function(uid,text,ac,myuid) {
		$('#follow_'+uid).text(text);
		$('#follow_l'+uid+' .weui-btn').text(text);
		
		if(ac=='qx'){
			$('#follow_'+uid).addClass('c2');
			$('#follow_l'+uid+' .weui-btn').removeClass('weui-btn_primary').addClass('weui-btn_default');
			var fans =parseInt($('#fans_'+uid).text())+1;
			var follows =parseInt($('#follows_'+myuid).text())+1;
			
		}else{
			$('#follow_'+uid).removeClass('c2');
			$('#follow_l'+uid+' .weui-btn').removeClass('weui-btn_default').addClass('weui-btn_primary');
			var fans =parseInt($('#fans_'+uid).text())-1;
			var follows =parseInt($('#follows_'+myuid).text())-1;
		}
		$('#fans_'+uid).text(fans);
		$('#fans_'+myuid).text(follows);
		
		if($('.myfollows #follow_l'+uid).length>0){
			$('.myfollows #follow_l'+uid).remove();
		}
		SMS.deleteitem('user.php?uid='+uid);
	},
	havenewfriend : function(){
		
		//newfriendlist
		if($('#newfriend').length>0){
			var newfriend =parseInt($('#newfriend').text())+1;
			$('#newfriend').text(newfriend);
		}else{
			if($('.newfriendnoticearea').length>0){
				$('#newfriendlink').remove();
				$('.newfriendnoticearea').prepend('<a href="my.php?mod=newfriend" class="notice load" id="newfriendnotice">有新的好友请求(<span id="newfriend">1</span>)</a>');  
			}
		}
		if($('.currentbody .newfriendnoticearea').length==0){
			//newfriendnotice
			if($('.icon-newfriend').length==0){
				$('#newmsg').empty();
				$('#newmsg').append('<a href="my.php?mod=newfriend" class="newmsg icon icon-newfriend load"><span class="weui-badge">1</span></a>');
			}else{
				SMS.upcount('.icon-newfriend');
			}	
			//my
			if($('#my_newfriend').length>0){
				SMS.upcount('#my_newfriend .weui-cell__bd');
			}			
		}
		/*vioce*/
		$('#receivedAudio')[0].play();
	},
	inserfriend : function(typeid,typename,uid,username,avatar) {
		if($('#friend_t'+typeid).length<1){
			$('#friend_'+uid).remove();
			$('#friendlist').append('<a href="javascript:SMS.list(\'my.php?mod=friend&typeid='+typeid+'\',\'friend_t'+typeid+'\')" class="weui-cell weui-cell_listopen managefriendtype" id="friend_t'+typeid+'"><div class="weui-cell__hd"></div><div class="weui-cell__bd c6">'+typename+'</div></a><div class="users ml15" id="list_friend_tfriend_t'+typeid+'"><a href="user.php?uid='+uid+'" id="friend_'+uid+'" class="weui-cell load"><div class="weui-cell__hd"><img src="'+avatar+'"></div><div class="weui-cell__bd"><h4 class="c6">'+username+'</h4><p class="c4"></p></div></a></div>');
		}else{
			if($('#friend_'+uid).length > 0){
				$('#friend_'+uid).appendTo('#list_friend_t'+typeid);
			}else{
				$('#list_friend_t'+typeid).append('<a href="user.php?uid='+uid+'" id="friend_'+uid+'" class="weui-cell load"><div class="weui-cell__hd"><img src="'+avatar+'"></div><div class="weui-cell__bd"><h4 class="c6">'+username+'</h4><p class="c4"></p></div></a>'); 
			}
		}
	},
	
	removefriend : function(uid) {
		if($('#friend_'+uid).length > 0){
			$('#friend_'+uid).remove();
		}
		$('#delete_'+uid).remove();
		$('#addfriend_'+uid).attr('href','user.php?mod=action&action=add&uid='+uid);
		$('#addfriend_'+uid).text('加好友');
		SMS.deleteitem('user.php?uid='+uid);
	},
	
	addblack : function(uid) {
		$('#black_'+uid).attr('href','user.php?mod=action&action=deleteblack&uid='+uid);
		$('#black_'+uid).text('移出黑名单');
		SMS.deleteitem('user.php?uid='+uid);
	},
	
	deleteblack : function(uid) {
		$('#friend_'+uid).remove();
		$('#black_'+uid).attr('href','user.php?mod=action&action=addblack&uid='+uid);
		$('#black_'+uid).text('加入黑名单');
		SMS.deleteitem('user.php?uid='+uid);
	},
	
	addfriendtype : function(typeid,typename) {
		$('#friendlist').append('<a href="javascript:SMS.list(\'my.php?mod=friend&typeid='+typeid+'\',\'friend_t'+typeid+'\')" class="weui-cell weui-cell_listopen managefriendtype" id="friend_t'+typeid+'"><div class="weui-cell__hd"></div><div class="weui-cell__bd c6">'+typename+'</div></a><div class="users ml15" id="list_friend_tfriend_t'+typeid+'"></div>');
	},
	
	deletefriendtype : function(typeid) {
		var friends=$('#list_friend_t'+typeid).html();
		if(friends){
			$('#list_friend_t0').append(friends); 
		}
		$('#friend_t'+typeid).remove();
		$('#list_friend_t'+typeid).remove();
	},
	
	upfriendtype : function(ids,names) {
		var typeids = ids.split(',');
		var typenames = names.split(',');
		for (var i=0;i<typeids.length;i++){
			$('#friend_t'+ids[i]+' .weui-cell__bd').text(typenames[i]);
		}
	},
	
	ignorefriend : function(aid) {
		$('#apply_'+aid).remove();
		smsot.newfriendnotice();
	},
	
	adoptfriend : function(aid) {
		$('#apply_'+aid+' .weui-cell__ft').html('<span class="c2 s12">已同意</span>');
		smsot.newfriendnotice();
	},
	
	upnotice: function(nids) {
		$.ajax({
			type: 'GET',
			url: 'my.php?mod=notice&upnotice=true',
			dataType: 'text',
			success: function(s) {
				setTimeout(function(){$('#mynotice .weui-badge').remove();},10000);
			},
			error: function(data) {
				return false;
			}
		});
		
	},
	
	newfriendnotice : function() {
		//my
		if($('#my_newfriend').length>0){
			SMS.upcount('#my_newfriend .weui-cell__bd','reduce');
		}	
		//notice
		if($('.icon-newfriend').length>0){
			SMS.upcount('.icon-newfriend','reduce');
		}
		//list
		if($('#newfriend').length>0){
			var newfriend =parseInt($('#newfriend').text())-1;
			if(newfriend>0){
				$('#newfriend').text(newfriend);
			}else{
				$('#newfriendnotice').remove();
				$('.newfriendnoticearea').prepend('<div class="weui-cells" id="newfriendlink"><a class="weui-cell weui-cell_access load" href="my.php?mod=newfriend"><div class="weui-cell__bd"><p>新朋友</p></div><div class="weui-cell__ft"></div></a></div>');  
			}	
		}
	},
	
	insertmessage : function(res,message) {
		var s = $.parseJSON(res);
		//getnewmsg
		var timelang	=s.time?'<span class="timelang">'+s.time+'</span>':'';
		var html='<div class="viewmessage'+s.userclass+s.typeclass+'" id="msg_'+s.mid+'">';
		    html += '<div class="cl"><a href="user.php?uid='+s.formuid+'" class="user load"><img src="'+s.formavatar+'" class="avatar"></a>';
				html +='<span class="bubble"></span><div class="message-area">'+message+'</div>'+timelang+'</div>';
				html +='<p class="date c2">'+s.date+'</p></div>';
		$('.currentbody .messagelist').append(html);
		//uptalklist
		if($('#messagelist').length>0){
			if($('#talk_'+s.tid).length==0){
				var talk='<a href="my.php?mod=talk&tid='+s.tid+'" class="weui-cell weui-cell_access load" id="talk_'+s.tid+'">';
						takk +='<div class="weui-cell__hd"><img src="'+s.toavatar+'" class="avatar"></div>';
						takk +='<div class="weui-cell__bd">';
						takk +='<h4><span class="r s12 c2">'+s.date+'</span><span class="c1">'+s.tousername+'</span></h4>';
						takk +='<p class="c4">'+s.summary+'</p></div></a>';
				$('#messagelist').prepend(talk);						
			}else{
				$('#talk_'+s.tid+' p').text(s.summary);
			}
		}
		//upfriendlist
		if($('#friend_'+s.touid).length>0){
			$('#friend_'+s.touid+' p').text(s.summary);
		}
		$('body').scrollTo({toT:$("body").height()});
		$('#sendAudio')[0].play();
	},
	
	havenewmsg : function(res) {

		var s = $.parseJSON(res);
		//getnewmsg
		if($('.currentbody #talkview_'+s.tid).length>0){
			SMS.ajax('get.php?type=talk&tid='+s.tid+'&mid='+s.mid,'#talkview_'+s.tid);		
		}else{
			/*newmsg*/
			if($('.icon-newmsg').length==0){
				$('#newmsg').empty();
				$('#newmsg').append('<a href="my.php?mod=message" class="newmsg icon icon-newmsg load"><span class="weui-badge">1</span></a>');
			}else{
				SMS.upcount('.icon-newmsg');
			}			
		}
		//uptalklist
		if($('#messagelist').length>0){
			if($('#talk_'+s.tid).length==0){
				if($('.currentbody #talkview_'+s.tid).length==0){
					var badge='<span class="weui-badge">1</span>';
				}
				var talk='<a href="my.php?mod=talk&tid='+s.tid+'" class="weui-cell weui-cell_access load" id="talk_'+s.tid+'">';
						takk +='<div class="weui-cell__hd"><img src="'+s.formavatar+'" class="avatar">'+badge+'</div>';
						takk +='<div class="weui-cell__bd">';
						takk +='<h4><span class="r s12 c2">'+s.date+'</span><span class="c1">'+s.formusername+'</span></h4>';
						takk +='<p class="c4">'+s.summary+'</p></div></a>';
				$('#messagelist').prepend(talk);						
			}else{
				$('#talk_'+s.tid+' p').text(s.summary);
				if($('.currentbody #talkview_'+s.tid).length==0){
					SMS.upcount('#talk_'+s.tid+' .weui-cell__hd');	
				}		
			}
		}
		/*friendlist*/
		if($('#friend_'+s.formuid).length>0){
			$('#friend_'+s.formuid+' p').text(s.summary);
			if($('.currentbody #talkview_'+s.tid).length==0){
				SMS.upcount('#friend_'+s.formuid+' .weui-cell__hd');
			}
		}
    /*vioce*/
		$('#receivedAudio')[0].play();
	},
	newnotice : function() {
		/*newnotice*/
		if($('.icon-newnotice').length==0){
			$('#newmsg').empty();
			$('#newmsg').append('<a href="my.php?mod=notice" class="newmsg icon icon-newnotice load"><span class="weui-badge">1</span></a>');
		}else{
			SMS.upcount('.icon-newnotice');
		}
		$('#receivedAudio')[1].play();
	},
	accountchange : function(money,type) {
		$('#'+type).text(money);
		if(type=='balance'){
			$('#balance_bot').text(money);
		}
		SMS.deleteitem('my.php?mod=account',false);
	},

	gratuity : function(vid,number,money,mod) {
		var mod=mod||'topic';
		var money=money/100;
		if($('.currentbody #gratuity_text_'+vid).length>0){
			$('.currentbody #gratuity_text_'+vid).remove();
			$('.currentbody .reward').append('<p id="gratuity_info_'+vid+'"><a href="gratuity.php?mod='+mod+'&vid='+vid+'" class="load">有<span class="c1 number">1</span>人给作者打赏了<span class="c1 money">'+money+'</span>元</a></p>');
		}else{
			$('.currentbody #gratuity_info_'+vid+' .number').text(number);
			$('.currentbody #gratuity_info_'+vid+' .money').text(money);
		}
		SMS.deleteitem('my.php?mod=account',false);
		SMS.deleteitem('topic.php?vid='+vid,true,true);
	},
	
	hongbaoreceive : function(hid) {
		$('#hb_'+hid+' .weui-btn').text('查看');
		$('#hb_'+hid+' .weui-btn').removeClass('weui-btn_primary').addClass('weui-btn_default');
		SMS.deleteitem('my.php?mod=hongbao',false);
	},
	
	hongbaowithdraw : function(hid) {
		$('#hb_'+hid+' .weui-btn').text('查看');
		$('#hb_'+hid+' .weui-btn').removeClass('weui-btn_warn').addClass('weui-btn_default');
		SMS.deleteitem('my.php?mod=hongbao',false);
	},
	editreply : function(upid,vid,pid) {
		SMS.ajax('reply.php?vid='+vid+'&pid='+pid+'&s=c&get=ajax','.currentbody #replycontent_'+pid,'replace');
		SMS.deleteitem('topic.php?vid='+vid);
	},
	addreply : function(s,vid,pid,upid,replys,modurl) {
		
		if(s=='l'){
			SMS.ajax('reply.php?vid='+vid+'&pid='+pid+'&get=ajax&s=l','.currentbody #replylist');
			$('.currentbody #replyscount_'+vid).text(replys);
			setTimeout(function(){$(window).scrollTop($("body").height());},100);			
		}else{
			if($('.currentbody #comments_'+upid).length==0){
				$('.currentbody #reply_'+upid+' .reply_content').append('<div class="comments b_c7 mt10 s13" id="comments_'+upid+'"></div>');
			}
			SMS.ajax('reply.php?vid='+vid+'&pid='+pid+'&get=ajax&s=n','.currentbody #comments_'+upid,'prepend');
			$('.currentbody #commentscount_'+upid).text(replys);
		}
		if(modurl){
			SMS.deleteitem(modurl);
		}
	},
	deletereply : function(pid,modurl) {
		$('.currentbody #reply_'+pid).remove();
		if(modurl){
			SMS.deleteitem(modurl);
		}
	},
	deletenotice : function(nid) {
		$('.currentbody #notice_'+nid).remove();
		SMS.deleteitem('my.php?mod=notice');
	},
	topreply : function(vid,pid,top,best,modurl) {
		if(top==0){
			$('.currentbody #reply_'+pid+' .reply_content h3 span.b_c8').remove();
		}else{
			$('.currentbody #reply_'+pid+' .reply_content h3').append('<span class="b_c8 c3">置顶</span>');
		}
		$('.currentbody #manage_'+pid).attr('href','javascript:replymanage(\''+vid+'\',\''+pid+'\',\''+top+'\',\''+best+'\')');
		if(modurl){
			SMS.deleteitem(modurl);
		}
	},
	bestreply : function(vid,pid,best,top,modurl) {
		if(best==0){
			$('.currentbody #reply_'+pid+' .reply_content h3 span.b_c1').remove();
		}else{
			$('.currentbody #reply_'+pid+' .reply_content h3').append('<span class="b_c1 c3">推荐</span>');
		}
		$('.currentbody #manage_'+pid).attr('href','javascript:replymanage(\''+vid+'\',\''+pid+'\',\''+top+'\',\''+best+'\')');
		if(modurl){
			SMS.deleteitem(modurl);
		}
	},
	praisereply : function(pid,praise,po,modurl) {
		if(po){
			SMS.upcount('#replypraise_'+pid);
			$('#replypraise_'+pid+' a').addClass('c1');
		}else{
			$('.currentbody #reply_'+pid+' .icon-praise').addClass('c1').html('<span class="s13 pl5">+'+praise+'</span>')
			SMS.deleteitem(modurl);
		}
	},
	collection : function(vid,cid,modurl) {
		if(cid){
			$('#collectionbtn_'+vid).removeClass('c1');
		}else{
			$('#collectionbtn_'+vid).addClass('c1');
		}
		SMS.deleteitem(modurl,true,true);
		SMS.deleteitem('collection.php',false);
	},
	editor : function(code) {
		var obj= $(".currentbody .textareacontent")[0];
		var range, node;
		if(!obj.hasfocus) {
			obj.focus();
		}
		if(window.getSelection && window.getSelection().getRangeAt){
			range = window.getSelection().getRangeAt(0);
			range.collapse(false);
			node = range.createContextualFragment(code);
			var c = node.lastChild;
			range.insertNode(node);
			if(c){
				range.setEndAfter(c);
				range.setStartAfter(c);
			}
			var j = window.getSelection();
			j.removeAllRanges();
			j.addRange(range);
			 
		}else if(document.selection && document.selection.createRange){
			document.selection.createRange().pasteHTML(code);
		}
	},
	
	setaccount : function(res) {
		var s = $.parseJSON(res);
		if(SMS.empty(s.res)){
			$('#withdrawals_form').css('display', 'none');
			$('#withdrawals_alert').css('display', '');
		}else{
			$('#withdrawals_form').css('display', '');
			$('#withdrawals_alert').css('display', 'none');
			if(SMS.empty(s.weixin)){
				$('#accountweixin').css('display', 'none');
			}else{
				$('#weixinaccount').text(s.weixin);
				$('#accountweixin').css('display', '');
			}
			if(SMS.empty(s.alipay)){
				$('#accountalipay').css('display', 'none');
			}else{
				$('#weixinaccount').text(s.alipay);
				$('#accountalipay').css('display', '');
			}
			if(SMS.empty(s.bankset)){
				$('#accountbank').css('display', 'none');
			}else{
				$('#bankname').text(s.bankname);
				$('#bankaccount').text(s.bank);
				$('#accountbank').css('display', '');
			}
		}
		SMS.deleteitem('my.php?mod=account',false);
		SMS.deleteitem('my.php?mod=account&action=account');
	},
	
	setid : function(username) {
		$('#setid .weui-cell__bd').text('修改用户名');
		$('#uc-username').text(username);
		$('#side-username').text(username);
	},
  loginout : function(){
		SMS.closepage();
		setTimeout(function(){SMS.clear()},100);
	},
	setlogin : function(user) {
		var user=user.split("@");
		
		if(user[0]!=0){
			$('.topuser').html('<a href="user.php" class="load"><img src="'+user[1]+'" class="avatar"></a>');
			$('.side-user').html('<a href="user.php" class="load"><img src="'+user[1]+'"><h3 id="side-username">'+user[2]+'</h3></a>');
			$('.side-btn').html('<a href="set.php" class="flex load icon-set">设置</a><a href="member.php?mod=out" class="flex load icon-out">退出</a>');		
		}else{
			$('.topuser').html('<a href="member.php" class="icon icon-login load"></a>');
			$('.side-user').html('<a href="member.php" class="load"><img src="'+user[1]+'"><h3 id="side-username">'+user[2]+'</h3></a>');
			$('.side-btn').html('<a href="member.php" class="flex load icon-login">登录</a><a href="member.php?mod=reg" class="flex load icon-reg">注册</a>');		
		}
	},
	withdrawals : function() {
		$('#withdrawalsmoney').val('');
		$('#withdrawalspassword').val('');
	},
	setspacecover : function(uid,path) {
		$('#viewuser_'+uid+' .usertop-bg').css({'background-image':'url('+path+')'});
		SMS.deleteitem('user.php');
	},

	setstyle : function(style,name) {
		$('#colorname').text(name);
		$('#stylecss').attr('href','data/cache/style_'+style+'.css');
		SMS.deleteitem('set.php');
	},
	uploads : function(s,type) {
		var pic = $.parseJSON(s);
    if(type=='dz'){
			var picitem = '<li class="weui-uploader__file" style="background-image:url('+pic.src+')"><span class="icon icon-no"></span>';
			    picitem += '<input type="hidden" name="pics[]" value="'+pic.aid+'"></li>';
		}else{
			var picitem = '<li class="weui-uploader__file" style="background-image:url('+pic.src+')"><span class="icon icon-no"></span>';
					picitem += '<input type="hidden" name="pics[filename][]" value="'+pic.filename+'">';
					picitem += '<input type="hidden" name="pics[filesize][]" value="'+pic.filesize+'">';
					picitem += '<input type="hidden" name="pics[atc][]" value="'+pic.atc+'">';
					picitem += '<input type="hidden" name="pics[width][]" value="'+pic.width+'">';
					picitem += '<input type="hidden" name="pics[height][]" value="'+pic.height+'">';
					picitem += '<input type="hidden" name="pics[thumb][]" value="'+pic.thumb+'"></li>';			
		}

		
		$('#uploaderFiles').append(picitem);
		
	},
	reloadavatar : function(avatar,uid) {
		$(".usercenter .avatar").attr('src',avatar+'_2.jpg?t='+Math.random()); 
		$(".side-user .avatar").attr('src',avatar+'_2.jpg?t='+Math.random());
		$("#viewuser_"+uid+" .avatar").attr('src',avatar+'_2.jpg?t='+Math.random());
		SMS.deleteitem('my.php');
		SMS.deleteitem('user.php');
	},
	replymanage : function(vid,pid,top,best,mod) {
		var toptext = top==1 ? '取消置顶' : '置顶';
		var besttext = best==1 ? '取消推荐' : '推荐';
		var sheet='<div class="weui-actionsheet" id="replysheet_'+pid+'"><div class="weui-actionsheet__menu">';
			 sheet+='<a href="reply.php?mod='+mod+'&ac=ed&vid='+vid+'&pid='+pid+'" class="weui-actionsheet__cell c6 load">编辑</a>';
			 sheet+='<a href="reply.php?mod='+mod+'&ac=dl&vid='+vid+'&pid='+pid+'" class="weui-actionsheet__cell c6 load" loading="tab" >删除</a>';
			 sheet+='<a href="reply.php?mod='+mod+'&ac=top&vid='+vid+'&pid='+pid+'" class="weui-actionsheet__cell c6 load" loading="tab" >'+toptext+'</a>';
			 sheet+='<a href="reply.php?mod='+mod+'&ac=best&vid='+vid+'&pid='+pid+'" class="weui-actionsheet__cell c6 load" loading="tab" >'+besttext+'</a>';
			 sheet+='<a href="index.php?mod=feed&type=3&ref=reply.php?vid='+vid+'&pid='+pid+'" class="weui-actionsheet__cell c6 load">举报</a>';
			 sheet+='</div><div class="weui-actionsheet__action"><a href="javascript:" class="weui-actionsheet__cell c1">取消</a></div></div>';
		$('.currentbody').append(sheet);
		setTimeout(function(){SMS.opensheet('#replysheet_'+pid,'remove');},100);
	},
	talknotice : function(message,tid) {
		$('#talkview_'+tid).append('<p class="tc talknotice"><span class="s12 b_c4 c3">'+message+'</span></p>');
	},
};