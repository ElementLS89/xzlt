
<div class="footer b_c2 bot o_c1">
  <div class="tabbar">
    <a href="my.php?mod=message" class="load<?php if($_GET['mod']=='message') { ?> c1<?php } else { ?> c4<?php } ?>"><span class="icon icon-talk"></span><p>聊天</p></a>
    <a href="my.php?mod=friend" class="load<?php if($_GET['mod']=='friend') { ?> c1<?php } else { ?> c4<?php } ?>"><span class="icon icon-friend"></span><p>联系人</p></a>
    <a href="user.php" class="load<?php if(PHPSCRIPT=='user') { ?> c1<?php } else { ?> c4<?php } ?>"><span class="icon icon-circle"></span><p>朋友圈</p></a>
  </div>
</div>