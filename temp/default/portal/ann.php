<?exit?>
<div class="announcement b_c3 bob o_c3 flexbox" style="$modstyle">
  <span class="c9">公告</span>
  <div>
    <ul class="flex s15">
      <!--{loop $modvar $aid}-->
      <li><a href="index.php?mod=announcement&aid=$aid" class="load">$_S['cache']['announcement'][$aid]['subject']</a></li>
      <!--{/loop}-->
    </ul>            
  </div>
</div>