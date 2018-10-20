<?exit?>
<!--{loop $list $value}-->
<div class="reply flexbox pt10 pb10 bob o_c4" id="reply_$value['pid']">
  <div class="reply_user">
  <!--{if $value['anonymous']}-->
  <!--{avatar('anonymous',1)}-->
  <!--{else}-->
  <a href="user.php?dzuid=$value[authorid]" class="load"><!--{avatar($value['authorid'],1,'img','dz')}--></a>
  <!--{/if}-->
  </div>
  <div class="reply_content flex">
    <!--{if !$value['groupid'] || in_array($value['groupid'],array(4,5,6,8,9))}-->
    <p class="s13 c4 pt15 pb15">用户已被删除或禁言</p>
    <!--{else}-->
    <h3><a href="discuz.php?mod=action&ac=praise&pid=$value[pid]" class="icon icon-praise r load" loading="tab"><!--{if $value['praise']}--><span class="s13 pl5">+$value['praise']</span><!--{/if}--></a><!--{if !$value['anonymous']}--><a href="user.php?dzuid=$value[authorid]" class="c8 load">$value['author']</a><!--{else}-->匿名<!--{/if}--><!--{if $value['top']}--><span class="b_c8 c3">置顶</span><!--{/if}--></h3>
    <div id="replycontent_{$value[pid]}">
      <!--{eval $content=$value}-->
      <!--{eval $attachment=$atcs[$value['pid']]}-->
      <!--{eval include temp('discuz/content',false)}-->
    </div>
    <p class="pt10 s13"><!--{if $canmanage || $thread['authorid']==$_S[myid]}--><a href="javascript:postmanage('$value['tid']','$value['pid']','$value['top']','$value['best']')" class="r c8">管理</a>{else}<a href="index.php?mod=feed&type=3&ref=discuz.php?mod=view&tid=$value[tid]&pid=$value[pid]" class="r c8 load">举报</a><!--{/if}--><span class="c4">{date($value['dateline'],'m-d H:i:s')}</span><a href="discuz.php?mod=post&ac=replypost&pid=$value['pid']" class="b_c2 load" loading="tab">回复</a></p>    
    <!--{/if}-->

  </div>
</div>
<!--{/loop}-->