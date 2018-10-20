var smsshare = function (config) {

	var ApiSrc = {
		lower: "https://3gimg.qq.com/html5/js/qb.js",
		higher: "https://jsapi.qq.com/get?api=app.share"
	};
	var Level = {
		qq: {forbid: 0, lower: 1, higher: 2},
		uc: {forbid: 0, allow: 1}
	};

	var isqqBrowser = (UA.split("MQQBrowser/").length > 1) ? Level.qq.higher : Level.qq.forbid;
	var isucBrowser = (UA.split("UCBrowser/").length > 1) ? Level.uc.allow : Level.uc.forbid;
	var version = {
		uc: "",
		qq: ""
	};
	config = config || {};
	this.url = config.url;
	this.title = config.title;
	this.desc = config.desc;
	this.img = config.img;
	this.img_title = config.title;
	this.from = config.from;
	this.ucAppList = {
		sinaWeibo: ['kSinaWeibo', 'SinaWeibo', 11, '新浪微博'],
		weixin: ['kWeixin', 'WechatFriends', 1, '微信好友'],
		weixinFriend: ['kWeixinFriend', 'WechatTimeline', '8', '微信朋友圈'],
		QQ: ['kQQ', 'QQ', '4', 'QQ好友'],
		QZone: ['kQZone', 'QZone', '3', 'QQ空间']
	};
	
	this.share = function (to_app) {
		var title = this.title, url = this.url, desc = this.desc, img = this.img, img_title = this.img_title, from = this.from;

		if(isucBrowser){
			to_app = to_app == '' ? '' : (platform_os == 'iPhone' ? this.ucAppList[to_app][0] : this.ucAppList[to_app][1]);
			if (to_app == 'QZone') {
				B = "mqqapi://share/to_qzone?src_type=web&version=1&file_type=news&req_type=1&image_url="+img+"&title="+title+"&description="+desc+"&url="+url+"&app_name="+from;
				k = document.createElement("div"), k.style.visibility = "hidden", k.innerHTML = '<iframe src="' + B + '" scrolling="no" width="1" height="1"></iframe>', document.body.appendChild(k), setTimeout(function () {
						k && k.parentNode && k.parentNode.removeChild(k)
				}, 5E3);
			}
			if(typeof(ucweb) != "undefined") {
				ucweb.startRequest("shell.page_share", [title, title, url, to_app, "", "@" + from, ""])
			} else {
				if (typeof(ucbrowser) != "undefined") {
					ucbrowser.web_share(title, title, url, to_app, "", "@" + from, '')
				}
			}
		}else{				
			to_app = to_app == '' ? '' : this.ucAppList[to_app][2];
			
			var ah = {
				url: url,
				title: title,
				description: desc,
				img_url: img,
				img_title: img_title,
				to_app: to_app,
				cus_txt: "请输入此时此刻想要分享的内容"
			};
			ah = to_app == '' ? '' : ah;
			if (typeof(browser) != "undefined") {
				if (typeof(browser.app) != "undefined" && isqqBrowser == Level.qq.higher) {
					browser.app.share(ah)
				}
			} else {
				if (typeof(window.qb) != "undefined" && isqqBrowser == Level.qq.lower) {
					window.qb.share(ah)
				}
			}
		}
	};
	
	this.isloadqqApi = function () {
		
		if(isqqBrowser && $('#qqbroshare').length==0) {
			var b = (version.qq < 5.4) ? ApiSrc.lower : ApiSrc.higher;
			var d = document.createElement("script");
					d.id = 'qqbroshare';
			var a = document.getElementsByTagName("body")[0];
			d.setAttribute("src", b);
			a.appendChild(d);
		}
	};

	this.getPlantform = function () {
		if ((UA.indexOf("iPhone") > -1 || UA.indexOf("iPod") > -1)) {
			return "iPhone"
		}
		return "Android"
	};

	this.getVersion = function (c) {
		var a = c.split("."), b = parseFloat(a[0] + "." + a[1]);
		return b
	};
	
	this.init = function () {
		
		platform_os = this.getPlantform();
		
		version.qq = isqqBrowser ? this.getVersion(UA.split("MQQBrowser/")[1]) : 0;
		version.uc = isucBrowser ? this.getVersion(UA.split("UCBrowser/")[1]) : 0;
		if((isqqBrowser && version.qq < 5.4 && platform_os == "iPhone") || (isqqBrowser && version.qq < 5.3 && platform_os == "Android")) {
			isqqBrowser = Level.qq.forbid
		}else{
			if(isqqBrowser && version.qq < 5.4 && platform_os == "Android") {
				isqqBrowser = Level.qq.lower
			}else{
				if(isucBrowser && ((version.uc < 10.2 && platform_os == "iPhone") || (version.uc < 9.7 && platform_os == "Android"))) {
					isucBrowser = Level.uc.forbid
				}
			}
		}
		this.isloadqqApi();
	};
	this.init();
	
	var share = this;
	setTimeout(function(){
		var items=$('.currentbody .share-items ul').children('li');
		items.each(function(index){
			$(items[index]).on('click', function(e){
				 share.share($(items[index]).attr('data-app'));
			})
		})		
	}, 100);

	return this;
};