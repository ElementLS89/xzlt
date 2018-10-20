<div class="box b_c3 mb10 mt10">
  <h3 class="box_title bob o_c3 cl"><span class="c4">小组介绍</span></h3>
  <div class="topic_buy_info s15">
    <p class="c4">$topic['about']</p>
    <p class="bob o_c3 pb5"><span class="r">({$topic['users']}+)</span>他们都在</p> 
    <ul class="cl pt10">
      <!--{loop $users $value}-->
      <li><!--{avatar($value],1)}--></li>
      <!--{/loop}-->
    </ul>     
  </div>


</div>
<div class="box b_c3 mb10">
  <h3 class="box_title bob o_c3 cl"><span class="r c9">$topic['price']元</span><span class="c4">付费说明</span></h3>
  <ul class="infolist c4">
    <li>付费后您可以使用当前账号阅读并参与[{$topic['name']}]的互动</li>
    <li>虚拟商品原则上不予退款，如有争议请联系管理人员</li>
    <li>发现违反规定的小组，请勿加入并请及时举报</li>
  </ul>
</div>
<div class="box b_c3 mb10">
  <h3 class="box_title bob o_c3 cl"><span class="c4">部分主题预览</span></h3>
  <div class="themeslist">
    <!--{loop $list $value}-->
    <div id="theme_$value[vid]">
      <div class="b_c3 bob o_c3">
        <div class="theme-ui">
          <span class="r c2 s12">{date($value['dateline'],'Y-m-d H:i:s')}</span><a href="user.php?uid=$value['uid']" class="c8 load"><!--{avatar($value['user'],2)}-->$value['username']</a>
        </div>
        <div style="padding-left:42px">
          <!--{if $value['subject']}-->
          <h3 class="theme-sub">$value['subject']</h3>
          <!--{/if}-->
          <!--{if $value['video']}-->
          <div class="theme-video video_hode"><img src="{$value['video']}?vframe/jpg/offset/{$_S['setting']['qiniu_frame']}" onerror="this.onerror=null;this.src='./ui/novideocover.png'"/><span class="icon icon-play"></span></div>
          <!--{else}-->
          <!--{if $value['pics']==1}-->
          <div class="theme-img-one"><!--{eval piclist($value,640,320)}--></div>
          <!--{elseif $value['pics']>1}-->
          <ul class="theme-img cl" id="pics_$value[vid]">
            <!--{eval piclist($value)}-->
          </ul>
          <!--{/if}-->
          <!--{/if}-->
          <p class="theme-foot s13">{if $value['lbs']}<span class="r b_c7 c8 ellipsis icon icon-lbs">$value['lbs']</span>{else}<a href="$value['topic_url']" class="c8 r load">$value['topic']</a>{/if}<span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replys']}</span><em class="c4"></em><span class="c4">点赞{$value['praise']}</span></p>  
        </div>
      </div>
    </div>
    <!--{/loop}-->
  </div>
</div>