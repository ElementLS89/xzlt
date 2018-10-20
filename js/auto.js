// JavaScript Document
function autoload(){
	autobtn = $('.currentbody #autoload');
	auto['nextpage'] = autobtn.attr('href');
	auto['curpage'] = parseInt(autobtn.attr('curpage'));
	auto['total'] = parseInt(autobtn.attr('total'));
	auto['method']=autobtn.attr('method')?'prepend':'append';
	auto['area']=autobtn.attr('area')?autobtn.attr('area'):'.autolist';
	auto['type']=autobtn.attr('type')?autobtn.attr('type'):'list';
}

function loadnextpage(){
	if(auto['curpage'] + 1 > auto['total']) {
		window.onscroll = null;
		autobtn.addClass('weui-loadmore_line').html('<span class="weui-loadmore__tips">没有更多了</span>');
		return;
	}
	setTimeout(function(){
		$.ajax({
			type: 'GET',
			url: auto['nextpage']+'&get=ajax',
			dataType: 'html',
			success: function(s) {
				if(s){
					if(auto['method']=='append'){
						$('.currentbody '+auto['area']).append(s);
					}else{
						$('.currentbody '+auto['area']).prepend(s);
					}
					$('.currentbody .lazyload').picLazyLoad();
					auto['curpage']++;
					autobtn.attr('href',auto['nextpage'].replace(/page=\d+/, 'page=' + (auto['curpage'] + 1)));
					autobtn.attr('curpage',auto['curpage']);
					auto['nextpage'] = auto['nextpage'].replace(/page=\d+/, 'page=' + (auto['curpage'] + 1));
					if(auto['curpage'] + 1 > auto['total']) {
						window.onscroll = null;
						autobtn.addClass('weui-loadmore_line').html('<span class="weui-loadmore__tips">没有更多了</span>');
					} else {
						autobtn.html('<span class="weui-loadmore__tips">点击加载更多</span>');
						loadstatus = true;
					}
				}else{
					return false;
				}
			},
			error: function(data) {
				return false;
			}
		})	
	},320);
}

function waterfall(v){
	
	var v = typeof(v) == "undefined" ? {} : v;
	var column = 1;
	var totalwidth = typeof(v.totalwidth) == "undefined" ? 0 : v.totalwidth;
	var totalheight = typeof(v.totalheight) == "undefined" ? 0 : v.totalheight;
	var parent = typeof(v.parent) == "undefined" ? $(".currentbody #waterfall")[0] : v.parent;
	var container = typeof(v.container) == "undefined" ? $(".currentbody #waterfallist")[0] : v.container;
	var maxcolumn = typeof(v.maxcolumn) == "undefined" ? 0 : v.maxcolumn;
	var space = typeof(v.space) == "undefined" ? 0 : v.space;
	var index = typeof(v.index) == "undefined" ? 0 : v.index;
	var tag = typeof(v.tag) == "undefined" ? "li" : v.tag;
	var columnsheight = typeof(v.columnsheight) == "undefined" ? [] : v.columnsheight;

	function waterfallMin() {
		var min = 0;
		var index = 0;
		if(columnsheight.length > 0) {
			min = Math.min.apply({}, columnsheight);
			for(var i = 0, j = columnsheight.length; i < j; i++) {
				if(columnsheight[i] == min) {
					index = i;
					break;
				}
			}
		}
		return {"value": min, "index": index};
	}
	function waterfallMax() {
		return Math.max.apply({}, columnsheight);
	}
	var mincolumn = {"value": 0, "index": 0};
	var totalelem = [];
	var singlewidth = 0;
	totalelem = parent.getElementsByTagName(tag);
	if(totalelem.length > 0) {
		column = 2;
		if(maxcolumn && column > maxcolumn) {
			column = maxcolumn;
		}
		if(!column) {
			column = 1;
		}
		if(columnsheight.length != column) {
			columnsheight = [];
			for(var i = 0; i < column; i++) {
				columnsheight[i] = 0;
			}
			index = 0;
		}
		
		singlewidth = totalelem[0].offsetWidth + space;
		totalwidth = singlewidth * column + space;
		for(var i = index, j = totalelem.length; i < j; i++) {
			var sz= totalelem[i].id.split("/");
			
			var hg=(((singlewidth-10)*sz[2])/sz[1]).toFixed(2)+'px';
			$('.currentbody #cover'+sz[0]).css('height', hg);

			mincolumn = waterfallMin();
			totalelem[i].style.position = "absolute";
			totalelem[i].style.left = singlewidth * mincolumn.index + "px";
			totalelem[i].style.top = mincolumn.value + "px";
			columnsheight[mincolumn.index] = columnsheight[mincolumn.index] + totalelem[i].offsetHeight + space;
			totalheight = Math.max(totalheight, waterfallMax());
			index++;
		}
		parent.style.height = totalheight + "px";
		parent.style.width = totalwidth + "px";
	}
	return {"index": index, "totalwidth": totalwidth, "totalheight": totalheight, "columnsheight" : columnsheight};
}
function scrollwater(){
	var stopload = 0,
			scrolltimer = null,
			tmpelems = [],
			tmpimgs = [],
			markloaded = [],
			imgsloaded = 0,
			loadready = 0,
			showready = 1;
			
	if(scrolltimer == null) {
	  scrolltimer = setTimeout(function () {
			try {
				loadready = 0;
				showready = 0;

				$.ajax({
					type: 'GET',
					url: auto['nextpage']+'&get=ajax',
					dataType: 'html',
					success: function(s) {
						s = s.replace(/\n|\r/g, "");
						if(auto['curpage']==auto['total']) {
							$('.currentbody #autoload').hide();
							stopload++;
							window.onscroll = null;
						}
						s = s.substring(s.indexOf("<ul id=\"waterfall\""), s.indexOf("<div id=\"tmppic\""));
						s = s.replace("id=\"waterfall\"", "");
						$('.currentbody #tmppic').append(s);
						loadready = 1;
					},
					error: function(data) {
						window.location.href = auto['nextpage'];
					}
				})

				tmpelems = $('.currentbody #tmppic')[0].getElementsByTagName("li");
				var waitingtimer = setInterval(function () {
					stopload >= 2 && clearInterval();
					if(loadready && stopload < 2) {
						if(!tmpelems.length) {
							auto['curpage']++;;
							autobtn.attr('href',auto['nextpage'].replace(/&page=\d+/, '&page=' + (auto['curpage'] + 1)));
							autobtn.attr('curpage',auto['curpage']);
							auto['nextpage'] = auto['nextpage'].replace(/&page=\d+/, '&page=' + (auto['curpage'] + 1));
							autobtn.html('<span class="weui-loadmore__tips">点击加载更多</span>');
							showready = 1;
							clearInterval(waitingtimer);
						}
						for(var i = 0, j = tmpelems.length; i < j; i++) {
							if(tmpelems[i]) {
							  tmpimgs = tmpelems[i].getElementsByTagName("img");
								imgsloaded = 0;
								for(var m = 0, n = tmpimgs.length; m < n; m++) {
									tmpimgs[m].onerror = function () {
										this.style.display = "none";
									};
									markloaded[m] = tmpimgs[m].complete ? 1 : 0;
									imgsloaded += markloaded[m];
								}
								if(imgsloaded == tmpimgs.length) {
									$('.currentbody #waterfall')[0].appendChild(tmpelems[i]);
									wf = waterfall({
										"index": wf.index,
										"totalwidth": wf.totalwidth,
										"totalheight": wf.totalheight,
										"columnsheight": wf.columnsheight
									});
								}
							}
						}
						$('.currentbody .lazyload').picLazyLoad();
					}
				}, 40);
			} catch(e) {}
			scrolltimer = null;
		}, 320);
	}		
}