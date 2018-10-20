<?exit?>
<!--{if $_S['page']==1}-->
<div class="memberlist">
  <div id="list">
    <div class="box b_c3 mb10 mt10">
      <h3 class="box_title cl"><span>管理团队</span></h3>
      <div class="users bot o_c3">
        <!--{loop $manager $value}-->
        <div class="weui-cell" id="manager_$value['uid']">
          <div class="weui-cell__hd"><!--{avatar($value,2)}--></div>
          <div class="weui-cell__bd">
            <h4>$value['username']</h4>
            <p class="c4">$topicgroup[$value['level']]['name']</p>
          </div>
          <div class="weui-cell__ft">
          <!--{if $topic['level']>$value['level']}-->
          <a href="topic.php?mod=manage&item=action&ac=6&uid=$value['uid']&tid=$_GET[tid]" class="weui-btn weui-btn_mini weui-btn_default load" loading="tab">撤销</a>
          <!--{/if}-->
          </div>
        </div>
        <!--{/loop}-->
      </div>
    </div>
    <div class="box b_c3 mb10 mt10">
      <h3 class="box_title cl"><span>成员管理</span></h3>
      <div class="users autolist bot o_c3">
<!--{/if}-->
        <!--{loop $list $value}-->
        <div class="weui-cell" id="member_$value['uid']">
          <div class="weui-cell__hd"><!--{avatar($value,2)}--></div>
          <div class="weui-cell__bd">
            <h4>$value['username']</h4>
            <p class="c4">$topicgroup[$value['level']]['name']</p>
          </div>
          <div class="weui-cell__ft">
          <a href="topic.php?mod=manage&item=action&ac=5&uid=$value['uid']&tid=$_GET[tid]" class="weui-btn weui-btn_mini weui-btn_default load" loading="tab">删除</a>
          </div>
        </div>
        <!--{/loop}-->
<!--{if $_S['page']==1}-->
      </div>
    </div>
  
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#member"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
</div>
<!--{/if}-->