<?exit?>
<div class="layer_header b_c1 c3"><a href="javascript:SMS.openlayer('setstyle')" class="icon icon-close"></a><span>选择风格配色</span></div>

<form action="set.php?type=preference" method="post" id="set_preference">
  <input name="submit" type="hidden" value="true" />
  <input name="hash" type="hidden" value="$_S['hash']" />
  <ul class="styles cl">
    <!--{loop $_S['cache']['colors'] $style}-->
    <!--{if $style['canuse']}-->
    <li>
      <label for="s{$style['cid']}" onclick="selectstyle('$style['color']')">
      <div style="background:{$style['color']}">
        <p class="b_c3">$style['name']</p>
        <input type="radio" name="style" value="$style['cid']" {if $_S['member']['style']==$style['cid']}checked="checked"{/if} id="s{$style['cid']}">
        <span class="icon icon-yes"></span> </div>
      </label>
    </li>
    <!--{/if}-->
    <!--{/loop}-->
  </ul>

  <div class="footer_btn b_c7"><div class="p10"><button type="button" class="weui-btn weui-btn_primary formpost">选择使用</button></div></div>
</form>
    
    