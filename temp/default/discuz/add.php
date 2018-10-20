<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
  </div>
  <div id="main">
    <div class="smsbody body_b $outback">
        <!--{loop $groups $group}-->
        <div class="catslist mb10 b_c3">
          <h3 class="tc"><em class="bob o_c3"></em><span>$group['name']</span><em class="bob o_c3"></em></h3>
          <ul class="cl">
            <!--{loop $forums[$group[fid]] $forum}-->
            <li><a href="discuz.php?mod=post&ac=addthread&fid=$forum['fid']" class="load"><img src="$forum['icon']"><p class="ellipsis">$forum['name']</p></a></li>
            <!--{/loop}-->
          </ul>
        </div>
        <!--{/loop}-->
      
    </div>
  </div>
  <div id="footer">
    <a href="javascript:" class="closepage b_c3 bot o_c3 icon icon-close c1"></a>
  </div>
</div>
<div id="smsscript">
  <!--{template wechat_shar}-->
  <!--{template wechat_lbs}-->
</div>

<!--{template footer}-->