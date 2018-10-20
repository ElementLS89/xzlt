<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <!--{if $_GET['action']!='qrcode'}-->
    <div class="header flexbox b_c1 c3">
      <div class="header-l"><a href="javascript:SMS.closepage()" class="icon icon-close"></a></div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
    <!--{/if}-->
  </div>
  <div id="main">
    <div class="smsbody{if $_GET['action']=='qrcode'} body_b{/if} $outback" nocache="true">

      <!--{if $_GET['action']=='adopt'}-->
      <div class="usercenter flexbox b_c3 bob bot o_c3 p10">
        <a href="user.php?uid=$apply['uid']" class="flex load close">
          <!--{avatar($apply,2)}-->
          <h3 class="c6">$apply['username']</h3>
          <p class="c4">$apply['message']</p>
        </a>
      </div>
      <form action="user.php?mod=action&action=adopt&aid=$_GET['aid']" method="post" id="user_action_adopt">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <div class="weui-cells__title">设置分组</div>
        <div class="weui-cells">
          <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
              <label for="" class="weui-label">选择分组</label>
            </div>
            <div class="weui-cell__bd">
              <select class="weui-select" name="friendtype">
                <option value="0">我的好友</option>
                <!--{loop $friendtypes $value}-->
                <option value="$value['typeid']">$value['name']</option>
                <!--{/loop}-->
              </select>
            </div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="newfriendtype" maxlength="20" placeholder="新建分组">
            </div>
          </div>
        </div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd">不让Ta看我的朋友圈</div>
            <div class="weui-cell__ft">
              <label for="switchlbs" class="weui-switch-cp">
              <input id="switchlbs" class="weui-switch-cp__input" type="checkbox" value="1" name="shield">
              <div class="weui-switch-cp__box"></div>
              </label>
            </div>
          </div>
        </div>

        <div class="p15 flexbox flexbtn">
          <button type="button" class="weui-btn weui-btn_primary formpost flex">同意</button>
          <a href="user.php?mod=action&action=ignore&aid=$apply['aid']" class="weui-btn weui-btn_default load flex">拒绝</a>
        </div>
        
      </form>
      <!--{elseif $_GET['action']=='friendtype'}-->
      <form action="user.php?mod=action&action=friendtype&uid=$_GET['uid']" method="post" id="user_action_friendtype">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />

        <div class="weui-cells__title">设置分组</div>
        <div class="weui-cells weui-cells_radio">
          <label class="weui-cell weui-check__label" for="friendtype0">
          <div class="weui-cell__bd">
            <p>我的好友</p>
          </div>
          <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="friendtype" value="0"  {if !$friend['friendtype']}checked="checked"{/if} id="friendtype0">
            <span class="weui-icon-checked"></span>
          </div>
          </label>
          <!--{loop $friendtypes $value}-->
          <label class="weui-cell weui-check__label" for="friendtype{$value['typeid']}">
          <div class="weui-cell__bd">
            <p>$value['name']</p>
          </div>
          <div class="weui-cell__ft">
            <input type="radio" class="weui-check" name="friendtype" value="$value['typeid']" {if $friend['friendtype']==$value['typeid']}checked="checked"{/if} id="friendtype{$value['typeid']}">
            <span class="weui-icon-checked"></span>
          </div>
          </label>
          <!--{/loop}-->
        </div>

        <div class="weui-cells__title">新建分组</div>
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="newfriendtype" maxlength="20" placeholder="新建分组">
            </div>
          </div>
        </div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd">不让Ta看我的朋友圈</div>
            <div class="weui-cell__ft">
              <label for="switchlbs" class="weui-switch-cp">
              <input id="switchlbs" class="weui-switch-cp__input" type="checkbox" value="1" name="shield" {if $friend['shield']}checked="checked"{/if}>
              <div class="weui-switch-cp__box"></div>
              </label>
            </div>
          </div>
        </div>
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">设置分组</button></div>
      </form>  
      <!--{elseif $_GET['action']=='managefriendtype'}-->
      <form action="user.php?mod=action&action=managefriendtype" method="post" id="user_action_add">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        
        <div class="weui-cells">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="newfriendtype" maxlength="20" placeholder="新建分组">
            </div>
          </div>
        </div>
        <div class="weui-cells__title">修改分组名称</div>
        <div class="weui-cells">
          <!--{loop $friendtypes $value}-->
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input type="hidden" name="typeid[]" value="$value['typeid']" />
              <input class="weui-input" type="text" name="typename[]" value="$value[name]" maxlength="20" placeholder="新建分组">
            </div>
            <div class="weui-cell__ft s0">
              <a href="user.php?mod=action&action=deletefriendtype&typeid=$value['typeid']" class="weui-icon-warn load"></a>
            </div>
          </div>
          <!--{/loop}-->
        </div>
        
        
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">提交</button></div>
      </form>  
      <!--{elseif $_GET['action']=='add'}-->
      <form action="user.php?mod=action&action=add&uid=$_GET['uid']" method="post" id="user_action_add">
        <input name="submit" type="hidden" value="true" />
        <input name="hash" type="hidden" value="$_S['hash']" />
        <div class="weui-cells__title">打招呼信息</div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <textarea class="weui-textarea" name="message" maxlength="200" rows="3">我是$_S['member']['username']</textarea>
            </div>
          </div>
        </div>
        <div class="weui-cells__title">设置分组</div>
        <div class="weui-cells">
          <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
              <label for="" class="weui-label">选择分组</label>
            </div>
            <div class="weui-cell__bd">
              <select class="weui-select" name="friendtype">
                <option value="0">我的好友</option>
                <!--{loop $friendtypes $value}-->
                <option value="$value['typeid']">$value['name']</option>
                <!--{/loop}-->
              </select>
            </div>
          </div>
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <input class="weui-input" type="text" name="newfriendtype" maxlength="20" placeholder="新建分组">
            </div>
          </div>
        </div>
        <div class="weui-cells weui-cells_form">
          <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd">不让Ta看我的朋友圈</div>
            <div class="weui-cell__ft">
              <label for="switchlbs" class="weui-switch-cp">
              <input id="switchlbs" class="weui-switch-cp__input" type="checkbox" value="1" name="shield">
              <div class="weui-switch-cp__box"></div>
              </label>
            </div>
          </div>
        </div>
        
        <div class="p15"><button type="button" class="weui-btn weui-btn_primary formpost">添加好友</button></div>
      </form>
      <!--{elseif $_GET['action']=='qrcode'}-->
      <div class="qrcode-body closepage">
        <div class="qrcode-content">
          <div class="qrcode-area">
            <img src="qrcode.php?url=$url&size=8" class="qcode" />          
          </div>
          <p class="c3"><!--{avatar($user,2)}-->$user['username']</p>
          
        </div>
      </div>
      <!--{/if}-->
    </div>
  </div>
  <div id="footer">
  <!--{if $_GET['action']=='qrcode'}-->
  <a href="javascript:" class="closepage b_c6 icon icon-close c3"></a>
  <!--{/if}-->
  </div>
</div>
<div id="smsscript">
  <!--{if $_GET['action']=='qrcode'}-->
  <script language="javascript" reload="1">
	  $(document).ready(function() {
      
		});
  </script>
  <!--{/if}-->
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->