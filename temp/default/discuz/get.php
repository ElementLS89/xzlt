<!--{if $_GET['tid']}-->
<!--{if $_GET['show']=='c'}-->
<!--{eval $content=$thread}-->
<!--{eval $attachment=$atcs[$pid]}-->
<!--{template discuz/content}-->
<!--{else}-->
<!--{eval $list[$thread['tid']]=$thread}-->
<!--{eval $pics[$thread['tid']]=$atcs[$pid]['img']}-->
<!--{eval include temp('discuz/threads_1')}-->
<!--{/if}-->
<!--{elseif $_GET['pid']}-->
<!--{if $_GET['show']!='c'}-->
<div class="reply flexbox pt10 pb10 bob o_c4" id="reply_$post['pid']">
  <div class="reply_user">
  <!--{if !$post['author']}-->
  <span class="icon icon-anonymous"></span>
  <!--{else}-->
  <a href="user.php?dzuid=$post[authorid]" class="load"><!--{avatar($post['authorid'],1,'img','dz')}--></a>
  <!--{/if}-->
  </div>
  <div class="reply_content flex">
    <h3><a href="discuz.php?mod=action&ac=praise&pid=$post[pid]" class="icon icon-praise r load" loading="tab"><!--{if $post['praise']}--><span class="s13 pl5">+$post['praise']</span><!--{/if}--></a><!--{if $post['author']}--><a href="user.php?dzuid=$post[authorid]" class="c8 load">$post['author']</a><!--{else}-->匿名<!--{/if}--><!--{if $post['top']}--><span class="b_c8 c3">置顶</span><!--{/if}--></h3>
    <div id="replycontent_{$value[pid]}">
<!--{/if}-->
      <!--{eval $content=$post}-->
      <!--{eval $attachment=$atcs}-->
      <!--{template discuz/content}-->
<!--{if $_GET['show']!='c'}-->
    </div>
    <p class="pt10 s13"><a href="javascript:postmanage('$post['tid']','$post['pid']','$post['top']','$post['best']')" class="r c8">管理</a><span class="c4">{date($post['dateline'],'m-d H:i:s')}</span><a href="discuz.php?mod=post&ac=replypost&pid=$post['pid']" class="b_c2 load" loading="tab">回复</a></p>
  </div>
</div>
<!--{/if}-->
<!--{else}-->
<!--{if $_GET['ac']=='edit'}-->
$comment['message']
<!--{else}-->
<div class="reply flexbox pt10 pb10 bob o_c4" id="comment_{$comment[cid]}">
  <div class="reply_user">
  <!--{if !$comment['uid']}-->
  <span class="icon icon-anonymous"></span>
  <!--{else}-->
  <a href="user.php?dzuid={$comment[uid]}" class="load"><!--{avatar($comment['uid'],1,'img','dz')}--></a>
  <!--{/if}-->
  </div>
  <div class="reply_content flex">
    <h3><!--{if $comment['uid']}--><a href="user.php?dzuid=$comment[uid]" class="c8 load">$comment['username']</a><!--{else}-->匿名<!--{/if}--></h3>
    <div id="commentcontent_{$comment[cid]}">
      $comment['message']
    </div>
    <p class="pt10 s13"><!--{if $_S['usergroup']['power']>5}--><a href="discuz.php?mod=portal&ac=del&cid=$comment['cid']" class="r c8 load">删除</a><!--{/if}--><a href="discuz.php?mod=portal&ac=edit&cid=$comment['cid']" class="r c8 load pr10">编辑</a><span class="c4">{date($comment['dateline'],'m-d H:i:s')}</span><a href="discuz.php?mod=portal&ac=replycomment&cid=$comment['cid']" class="b_c2 load" loading="tab">回复</a></p>
  </div>
</div>
<!--{/if}-->
<!--{/if}-->