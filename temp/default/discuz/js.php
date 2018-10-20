<?exit?>
<script language="javascript">
var discuz = {
	deletethread : function(fid,tid) {
		SMS.closepage();
		setTimeout(function(){
			$('.currentbody #thread_'+tid).remove();
			var threads =parseInt($('#threads_'+fid).text())-1;
			$('#threads_'+fid).text(threads);		
			SMS.deleteitem('discuz.php?mod=forum&fid='+fid);
		},300);
	},
	deletepost : function(tid,pid) {
		$('.currentbody #reply_'+pid).remove();
		var replys=parseInt($('#replyscount_'+tid).text())-1;
		$('#replyscount_'+tid).text(replys);
		SMS.deleteitem('discuz.php?mod=view&tid='+tid);
	},
	settop : function(id,val,type) {
		if(type=='thread'){
			var text=val==1?'取消置顶':'置顶';
			if(val==1){
				$('.currentbody .article_title').prepend('<span class="b_c8 c3">置顶</span>');
			}else{
				$('.currentbody .article_title .b_c8').remove();
			}
			$('#settop_'+id).text(text);	
		}else{
			if(val==0){
				$('.currentbody #reply_'+id+' .reply_content h3 span.b_c8').remove();
			}else{
				$('.currentbody #reply_'+id+' .reply_content h3').append('<span class="b_c8 c3">置顶</span>');
			}
		}
		SMS.deleteitem('discuz.php?mod=view&tid='+id);
	},
	setbest : function(id,val) {
		var text=val==1?'取消推荐':'推荐';
		if(val==1){
			$('.currentbody .article_title').prepend('<span class="b_c1 c3">推荐</span>');
		}else{
			$('.currentbody .article_title .b_c1').remove();
		}
		$('#setbest_'+id).text(text);
		SMS.deleteitem('discuz.php?mod=view&tid='+id);
	},
	praise : function(id,val,tid) {
		if(tid){
	    $('.currentbody #reply_'+id+' .icon-praise').addClass('c1').html('<span class="s13 pl5">+'+val+'</span>');
			SMS.deleteitem('discuz.php?mod=view&tid='+tid,true,true);
		}else{
			SMS.upcount('#threadpraise_'+id);
			$('#threadpraise_'+id+' a').addClass('c1');
			SMS.deleteitem('discuz.php?mod=view&tid='+id,true,true);
		}
	},
	fav : function(id,type) {
		if(type=='tid'){
			$('#threadfavbtn_'+id).addClass('c1');
			SMS.deleteitem('discuz.php?mod=view&tid='+id);
		}else if(type=='fid'){
			$('#forumbtn_'+id).removeClass('weui-btn weui-btn_mini load').addClass('icon icon-openside').text('');
			$('#forumbtn_'+id).attr('href','javascript:SMS.openside()');
			$('#forumfav_'+id).remove();
			SMS.deleteitem('discuz.php?mod=forum&fid='+id,true,true);
		}else{
			$('#newsfavbtn_'+id).addClass('c1');
			SMS.deleteitem('discuz.php?mod=news&aid='+id,true,true);
		}
	},
	addthread : function(tid,fid) {
		SMS.ajax('discuz.php?mod=get&tid='+tid,'.currentbody .themeslist','prepend');
		var threads =parseInt($('#threads_'+fid).text())+1;
		$('#threads_'+fid).text(threads);
		SMS.deleteitem('discuz.php?mod=forum&fid='+fid);
	},
	editthread : function(tid,fid,subject) {
		$('#subject_'+tid).text(subject);
		SMS.ajax('discuz.php?mod=get&show=c&tid='+tid,'.currentbody .weui-article','replace');
		SMS.deleteitem('discuz.php?mod=view&tid='+tid);
	},
	addreply : function(pid,tid) {
		SMS.ajax('discuz.php?mod=get&pid='+pid,'.currentbody #replylist');
		var replys =parseInt($('#replyscount_'+tid).text())+1;
		$('.currentbody #replyscount_'+tid).text(replys);
		setTimeout(function(){$(window).scrollTop($("body").height());},100);			
		SMS.deleteitem('discuz.php?mod=view&tid='+tid);
	},
	editreply : function(pid,tid) {
		SMS.ajax('discuz.php?mod=get&show=c&pid='+pid,'.currentbody #replycontent_'+pid,'replace');
		SMS.deleteitem('discuz.php?mod=view&tid='+tid);
	},
	insertpic : function(aid) {
		$('#discuz_post_form').append('<input type="hidden" name="pics[]" value="'+aid+'">');
	},
	delpic : function(aid) {
		$('.currentbody #img_'+aid).remove();
		$('#discuz_post_form').append('<input type="hidden" name="delpics[]" value="'+aid+'">');
	},
	editcomment : function(cid,aid) {
		SMS.ajax('discuz.php?mod=get&cid='+cid+'&ac=edit','.currentbody #commentcontent_'+cid,'replace');
		SMS.deleteitem('discuz.php?mod=news&aid='+aid);
	},
	addcomment : function(cid,aid) {
		SMS.ajax('discuz.php?mod=get&cid='+cid,'.currentbody #replylist');
		var replys =parseInt($('#replyscount_'+aid).text())+1;
		$('.currentbody #replyscount_'+aid).text(replys);
		setTimeout(function(){$(window).scrollTop($("body").height());},100);			
		SMS.deleteitem('discuz.php?mod=news&aid='+aid);
	},
	click3 : function(aid) {
		SMS.upcount('#newsclick3_'+aid);
		$('#newsclick3_'+aid+' a').addClass('c1');
		SMS.deleteitem('discuz.php?mod=news&aid='+aid,true,true);
	},
	deletecomment : function(aid,cid) {
		$('.currentbody #comment_'+cid).remove();
		var replys=parseInt($('#replyscount_'+aid).text())-1;
		$('#replyscount_'+aid).text(replys);
		SMS.deleteitem('discuz.php?mod=news&aid='+aid);
	},
};
</script>