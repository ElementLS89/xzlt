<?exit?>
<!--{loop $list $value}-->
<div class="reply flexbox pt10 pb10 bob o_c4" id="comment_$value[cid]">
  <div class="reply_user">
  <!--{if !$value['uid']}-->
  <span class="icon icon-anonymous"></span>
  <!--{else}-->
  <a href="user.php?dzuid=$value[uid]" class="load"><!--{avatar($value['uid'],1,'img','dz')}--></a>
  <!--{/if}-->
  </div>
  <div class="reply_content flex">
    <h3><!--{if $value['uid']}--><a href="user.php?dzuid=$value[uid]" class="c8 load">$value['username']</a><!--{else}-->匿名<!--{/if}--></h3>
    <div id="commentcontent_{$value[cid]}">
      $value['message']
    </div>
    <p class="pt10 s13"><!--{if $_S['usergroup']['power']>5}--><a href="discuz.php?mod=portal&ac=del&cid=$value['cid']" class="r c8 load" loading="tab">删除</a><!--{else}--><a href="index.php?mod=feed&type=3&ref=discuz.php?mod=news&aid=$_GET[aid]&cid=$value[cid]" class="r c8 load">举报</a><!--{/if}--><!--{if $_S['usergroup']['power']>5 || $_S['myid']==$value['uid']}--><a href="discuz.php?mod=portal&ac=edit&cid=$value['cid']" class="r c8 load pr10">编辑</a><!--{/if}--><span class="c4">{date($value['dateline'],'m-d H:i:s')}</span><a href="discuz.php?mod=portal&ac=replycomment&cid=$value['cid']" class="b_c2 load" loading="tab">回复</a></p>
  </div>
</div>
<!--{/loop}-->