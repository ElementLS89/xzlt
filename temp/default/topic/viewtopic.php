<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header $topicskin['topbg'] flexbox c3">
      <div class="header-l">{eval back('back')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r">
      <!--{if $ismember}-->
      <a href="javascript:SMS.opensheet('#topicsheet')" class="icon icon-more" id="topicbtn_$topic['tid']"></a>
      <!--{else}-->
      <!--{if $canmanage}-->
      <a href="topic.php?mod=manage&tid=$topic['tid']" class="icon icon-set load"></a>
      <!--{else}-->
      <a href="topic.php?mod=action&ac=join&tid=$topic['tid']" class="weui-btn weui-btn_mini load" id="topicbtn_$topic['tid']" loading="tab">加入</a>
      <!--{/if}-->
      
      <!--{/if}-->
      </div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $topicskin['body'] $outback">

      <!--{if $topic['banner']}-->
      <div class="topic_banner" style="background-image:url($_S['atc']/$topic['banner'])">
      <!--{/if}-->
        <div class="topicinfo $topicskin['info']">
          <div class="flexbox p15">
            
            <img src="$topic['cover']">
            <div class="flex">
              <h3 class="s18 ellipsis">$topic['name']</h3>
              <!--{if $topic['price'] && !$topic['level'] && !$canmanage}-->
              <p class="s13 $topicskin['info_p']">话题数<em>$topic['themes']</em></p> 
              <p class="s13 $topicskin['info_p']">成员数<em>$topic['users']</em></p> 
              <!--{else}-->
              <p class="s13 $topicskin['info_p'] ellipsis">话题数<em id="themes_$topic['tid']">$topic['themes']</em>成员数<a href="topic.php?tid=$_GET['tid']&show=member" id="users_$topic['tid']" class="load pl5">$topic['users']</a></p>
              <p class="s13 $topicskin['info_p']">$topic['about']</p>                 
              <!--{/if}-->
         
            </div>
            <!--{if $_S['app']['hideheader']}-->
            <!--{if $ismember}-->
              <a href="javascript:SMS.opensheet('#topicsheet')" class="icon icon-more" id="topicbot_$topic['tid']"></a>
            <!--{else}-->
              <!--{if $canmanage}-->
              <a href="topic.php?mod=manage&tid=$topic['tid']" class="icon icon-set load"></a>
              <!--{else}-->
              <a href="topic.php?mod=action&ac=join&tid=$topic['tid']" class="weui-btn weui-btn_mini {if $topic['banner']}weui-btn_warn{else}weui-btn_default{/if} load" id="topicbot_$topic['tid']" loading="tab">加入</a>
              <!--{/if}-->
            <!--{/if}-->
            <!--{/if}-->
          </div>
        </div>
      <!--{if $topic['banner']}-->
      </div>
      <!--{/if}-->
      <!--{if $topic['price'] && !$topic['level'] && !$canmanage}-->
      <!--{template topic/buytopic}-->
      <!--{else}-->      
      <!--{if $_GET['show']=='member'}-->
      <div class="box b_c3 mb10 mt10">
        <h3 class="box_title cl"><span>管理团队</span></h3>
        <!--{if $manager}-->
        <div class="users">
          <!--{loop $manager $value}-->
          <a href="user.php?uid=$value['uid']" class="weui-cell weui-cell_link load">
            <div class="weui-cell__hd"><!--{avatar($value,2)}--></div>
            <div class="weui-cell__bd">
              <h4>$value['username']</h4>
              <p class="c4">$value['bio']</p>
            </div>
            <div class="weui-cell__ft">
            <!--{if $value['level']=='127'}-->$topicgroup[127]['name']<!--{else}-->$topicgroup[126]['name']<!--{/if}-->
            </div>
          </a>
          <!--{/loop}-->
        </div>
        <!--{/if}-->
        <!--{if $topic['maxleaders']}-->
        <a class="weui-cell weui-cell_access load" href="topic.php?mod=action&ac=apply&tid=$_GET[tid]&level=127">
          <div class="weui-cell__bd"><p>申请$topicgroup[127]['name']</p></div>
          <div class="weui-cell__ft s12">还有$topic['maxleaders']个名额</div>
        </a>
        <!--{/if}-->
        <!--{if $topic['maxmanagers']}-->
        <a class="weui-cell weui-cell_access load" href="topic.php?mod=action&ac=apply&tid=$_GET[tid]&level=126">
          <div class="weui-cell__bd"><p>申请$topicgroup[126]['name']</p></div>
          <div class="weui-cell__ft s12">还有$topic['maxmanagers']个名额</div>
        </a>
        <!--{/if}-->
      </div>
      <div class="box b_c3 mb10 mt10">
        <h3 class="box_title cl"><span>成员列表</span></h3>
        <div class="users">
          <div class="autolist">
          <!--{template topic/viewtopic_ajax}-->
          </div>

        </div>
      </div> 
      <!--{if $maxpage>1}-->
      <div id="page">
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <!--{/if}-->
      
      
      <!--{else}-->
      <div class="scrollx topnv navs b_c3 bob o_c3 mb10">
        <div class="scrollx_area">
          <ul class="c">
            <li{if $_GET['order']=='new'} class="c1 o_c1"{/if} id="type_{$_GET['tid']}_new">
              <a href="topic.php?tid=$_GET['tid']&order=new" class="get" box="vt_{$_GET['tid']}_new" btn="type_{$_GET['tid']}_new">最新</a>
            </li>
            <li{if $_GET['order']=='hot' && !$_GET['typeid']} class="c1 o_c1"{/if} id="type_{$_GET['tid']}">
              <a href="topic.php?tid=$_GET['tid']&order=hot" class="get" box="vt_{$_GET['tid']}_hot" btn="type_{$_GET['tid']}">最热</a>
            </li>
            <li{if $_GET['order']=='searchcall'} class="c1 o_c1"{/if} id="type_searchcall">
              <a href="topic.php?show=searchcall" class="get" box="vt_searchcall" btn="type_searchcall">小号</a>
            </li>
			  
			<li{if $_GET['order']=='tips' && !$_GET['typeid']} class="c1 o_c1"{/if} id="type_tips">
              <a href="topic.php?&show=tips" class="get" box="vt_tips" btn="type_tips">攻略</a>
            </li>
			
            <!--{loop $topic['types'] $id $name}-->
            <li{if $_GET['typeid']==$id} class="c1 o_c1"{/if} id="type_{$_GET['tid']}_{$id}">
              <a href="topic.php?tid=$_GET['tid']&typeid=$id" class="get" box="vt_{$_GET['tid']}_new{$id}" btn="type_{$_GET['tid']}_{$id}">$name</a>
            </li>
            <!--{/loop}-->          
          </ul>  
        
        </div>
      </div>
       
      <!--{if $tops}-->
      <ul class="toplist b_c3 o_c3{if count($tops)<4} mb10{/if}" {if count($tops)>3}style="height:122px;"{/if}>
        <!--{loop $tops $value}-->
        <li class="bob o_c3 ellipsis"><a href="topic.php?vid=$value['vid']" class="load"><span class="b_c8 c3">顶</span>$value['subject']</a></li>
        <!--{/loop}-->
      </ul>
      <!--{if count($tops)>3}-->
      <a href="javascript:SMS.unfold('unfoldtoplist','.toplist',122)" class="icon icon-expanding bot o_c3 b_c3" id="unfoldtoplist"></a><!--{/if}-->
      <!--{/if}-->
      
      <div class="ready current themeslist" id="vt_{$_GET['tid']}_new"><!--{template topic/viewtopic_ajax}--></div>
      <div class="themeslist" id="vt_{$_GET['tid']}_hot" style="display:none"></div>
      <div class="themeslist" id="vt_searchcall" style="display:none">
        <div class="weui-search-bar" id="liveSearchBar">
          <form class="weui-search-bar__form">
            <div class="weui-search-bar__box"> <i class="weui-icon-search"></i>
              <input type="search" class="weui-search-bar__input" id="liveSearchInput" onkeyup="showLiveSearchResult(this.value)" name="k" placeholder="搜索" required>
              <a href="javascript:" class="weui-icon-clear" id="liveSearchClear"></a>
            </div>
            <label class="weui-search-bar__label" id="liveSearchText"> <i class="weui-icon-search"></i> <span>搜索</span> </label>
          </form>
          <a href="javascript:" class="weui-search-bar__cancel-btn" id="liveSearchCancel">取消</a>
        </div>
        <div id="liveSearch" class="weui-cells searchbar-result"></div>
      </div>
      <div class="themeslist" id="vt_tips" style="display:none"></div>

      <!--{loop $topic['types'] $id $name}-->
      <div class="themeslist" id="vt_{$_GET['tid']}_new{$id}" style="display:none"></div>
      <!--{/loop}-->      
      
      <div id="page">
      <!--{if $maxpage>1}-->
      <a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#vt_{$_GET['tid']}_new" {if $topic['liststype']=='5'}type="water"{/if}><span class="weui-loadmore__tips">下一页</span></a>
      <!--{/if}-->   
      </div>
      <!--{/if}-->
      <!--{/if}-->
      <div class="weui-actionsheet" id="topicsheet">
        <div class="weui-actionsheet__menu">
          <a href="topic.php?mod=action&ac=out&tid=$topic['tid']" class="weui-actionsheet__cell c6 load" loading="tab">退出</a>
          <!--{if $canmanage}-->
          <a href="topic.php?mod=manage&tid=$topic['tid']" class="weui-actionsheet__cell c6 load">管理</a>
          <!--{/if}-->
          <!--{if $_S['uid']}-->
          <a href="index.php?mod=feed&type=3&ref=topic.php?tid=$_GET[tid]" class="weui-actionsheet__cell c6 load">举报</a>
          <!--{/if}-->
        </div>
        <div class="weui-actionsheet__action">
          <a href="javascript:" class="weui-actionsheet__cell c1">取消</a>
        </div>
      </div>      
    </div>
  </div>
  <div id="footer"> 
    <!--{if $topic['price'] && !$topic['level'] && !$canmanage}-->
    <a href="topic.php?mod=action&ac=join&tid=$topic['tid']" class="load buytopic c3 b_c1" loading="tab">加入小组</a>
    <!--{else}-->
    <!--{if !$_S['setting']['closebbs']}-->
    <a href="topic.php?mod=post&tid=$topic['tid']" class="icon icon-write addtopic b_c8 load" loading="tab"></a>
    <!--{/if}-->
    <!--{/if}-->
  </div>
</div>
<div id="smsscript">
  <!--{if $topic['liststype']=='5'}-->
  <script language="javascript" reload="1">
    var wf = {};
		$('.currentbody').ready(function(){
			if($('.currentbody #waterfall').length >0) {
				wf = waterfall();
			}
		});
  </script>
  <!--{/if}-->
  <!--{template wechat}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->