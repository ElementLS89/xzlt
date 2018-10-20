<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l"><a href="javascript:SMS.closepage()" class="icon icon-close"></a></div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback" nocache="true">
      <div class="weui-cells">
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <p>申请:</p>
          </div>
          <div class="weui-cell__bd">$topicgroup[$apply['level']]['name']</div>
        </div>
        <a href="user.php?uid=$apply['uid']" class="weui-cell weui-cell_access load">
          <div class="weui-cell__hd">
            <p>账号:</p>
          </div>
          <div class="weui-cell__bd">$apply['username']</div>
          <div class="weui-cell__ft"></div>
        </a>
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <p>等级:</p>
          </div>
          <div class="weui-cell__bd">$topicgroup[$apply['lv']]['name']</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <p>经验:</p>
          </div>
          <div class="weui-cell__bd">$apply['experience']</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <p>姓名:</p>
          </div>
          <div class="weui-cell__bd">$apply['name']</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <p>电话:</p>
          </div>
          <div class="weui-cell__bd">$apply['tel']</div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <p>QQ号:</p>
          </div>
          <div class="weui-cell__bd">$apply['qq']</div>
        </div>
  
      </div>
      <div class="weui-cells__title">介绍和申请理由</div>
      <div class="weui-cells s14">
        <div class="weui-cell">
        $apply['about']
        </div>
      </div>
      <div class="p15 flexbox flexbtn">
        <a href="topic.php?mod=manage&item=action&ac=4&uid=$apply['uid']&tid=$_GET[tid]" class="weui-btn weui-btn_primary load flex" loading="tab">同意</a>
        <a href="topic.php?mod=manage&item=action&ac=3&uid=$apply['uid']&tid=$_GET[tid]" class="weui-btn weui-btn_default load flex" loading="tab">拒绝</a>
      </div>
      
    </div>
  </div>
  <div id="footer"> 
  </div>
</div>
<div id="smsscript">
<!--{template wechat_shar}-->
</div>
<!--{template footer}-->