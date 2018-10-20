<?exit?>
<!--{if $modvar['name']}-->
<div class="box b_c3 mb10" style="$modstyle">
  <h3 class="box_title bob o_c3 cl"><!--{if $modvar['url']}--><a href="$modvar['url']" class="icon icon-more r c4"></a><!--{/if}--><span class="c4">$modvar['name']</span></h3>
<!--{else}-->
<div class="b_c3" style="$modstyle">
<!--{/if}-->
  <div class="users">
    <!--{if $modvar['form']=='discuz'}-->
    <!--{loop $modvar['users'] $value}-->
    <a href="user.php?dzuid=$value['uid']" class="weui-cell weui-cell_access load">
      <div class="weui-cell__hd"><!--{avatar($value['uid'],2,'img','dz')}--></div>
      <div class="weui-cell__bd">
        <h4>$value['username']</h4>
        <p class="c4">$value['bio']</p>
      </div>
    </a>
    <!--{/loop}-->      
    <!--{else}-->
    <!--{loop $modvar['users'] $value}-->
    <a href="user.php?uid=$value['uid']" class="weui-cell weui-cell_access load">
      <div class="weui-cell__hd"><!--{avatar($value['user'],2)}--></div>
      <div class="weui-cell__bd">
        <h4>$value['username']</h4>
        <p class="c4">$value['bio']</p>
      </div>
    </a>
    <!--{/loop}-->  
    <!--{/if}--> 
  </div>
</div>