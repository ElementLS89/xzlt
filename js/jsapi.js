// JavaScript Document
function share(){
	SMS.opensheet('#sharesheet');
}


function share_more(){
	SMS.open('<div class="share-bro"><img src="ui/share_bro.png"></div>');
}

function share_qq(desc,title,img){
	var url=window.location.href.split('#')[0];
	window.open('https://connect.qq.com/widget/shareqq/index.html?url='+encodeURIComponent(url)+'&desc='+UrlEncode(desc)+'&title='+UrlEncode(title)+'&pics='+encodeURIComponent(img));
}

function share_qzone(desc,title,img,from){
	var url=window.location.href.split('#')[0];
	window.open('https://h5.qzone.qq.com/q/qzs/open/connect/widget/mobile/qzshare/index.html?page=qzshare.html&loginpage=loginindex.html&logintype=qzone&title='+UrlEncode(title)+'&summary='+UrlEncode(desc)+'&url='+encodeURIComponent(url)+'&desc='+UrlEncode(desc)+'&imageUrl='+encodeURIComponent(img)+'&site='+encodeURIComponent(from)+'&sid=&referer='+encodeURIComponent(url));
}

function share_sina(title,img){
	var url=window.location.href.split('#')[0];
	window.open('http://service.weibo.com/share/share.php?url='+encodeURIComponent(url)+'&appkey=&title='+comiis_UrlEncode(title)+'&pic='+encodeURIComponent(img)+'&language=zh_cn');
}

function UrlEncode(str){  
	str = (str + '').toString();   
	return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');  
} 


