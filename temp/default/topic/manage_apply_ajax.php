<?exit?>
<!--{if $_S['page']==1}-->
<div class="memberlist">
  <div id="list">
    <div class="box b_c3 mb10 mt10">
      <h3 class="box_title cl"><span>管理申请</span></h3>
      <div class="users bot o_c3">
        <!--{loop $applys $value}-->
        <!--{if $topic['level']==127  || $_S['usergroup']['power']>5}-->
        <a class="weui-cell weui-cell_access load" href="topic.php?mod=manage&tid=$_GET[tid]&aid=$value['aid']&item=apply" id="apply_$value['uid']">
        <!--{else}-->
        <a class="weui-cell weui-cell_access" href="javascript:">
        <!--{/if}-->
          <div class="weui-cell__hd"><!--{avatar($value,2)}--></div>
          <div class="weui-cell__bd">
            <h4>$value['username']</h4>
            <p class="c4">申请：$topicgroup[$value['level']]['name']</p>
          </div>
          <!--{if $topic['level']==127}-->
          <div class="weui-cell__ft">详情</div>
          <!--{/if}-->
        </a>
        <!--{/loop}-->
      </div>
    </div>
    <div class="box b_c3 mb10 mt10">
      <h3 class="box_title cl"><span>成员申请</span></h3>
      <div class="users autolist bot o_c3">
<!--{/if}-->
        <!--{loop $list $value}-->
        <div class="weui-cell" id="user_$value['uid']">
          <div class="weui-cell__hd"><!--{avatar($value,2)}--></div>
          <div class="weui-cell__bd">
            <h4>$value['username']</h4>
            <p class="c4">$topicgroup[$value['level']]['name']</p>
          </div>
          <div class="weui-cell__ft">
          <a href="topic.php?mod=manage&item=action&ac=1&uid=$value['uid']&tid=$_GET[tid]" class="weui-btn weui-btn_mini weui-btn_default load" loading="tab">拒绝</a>
          <a href="topic.php?mod=manage&item=action&ac=2&uid=$value['uid']&tid=$_GET[tid]" class="weui-btn weui-btn_mini weui-btn_primary load" loading="tab">通过</a>
          </div>
        </div>
        <!--{/loop}-->
<!--{if $_S['page']==1}-->
      </div>
    </div>
  
  </div>
  <div id="page">
  <!--{if $maxpage>1}--><a href="$nexturl" id="autoload" class="weui-loadmore block auto" curpage="$_S['page']" total="$maxpage" area="#apply"><span class="weui-loadmore__tips">下一页</span></a><!--{/if}-->
  </div>
</div>
<!--{/if}-->