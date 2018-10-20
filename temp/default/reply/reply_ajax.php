<?exit?>
<!--{if $_GET['s']=='c'}-->
$value['content']
<!--{else}-->
<!--{if $value['s']=='n'}-->
<p id="comment_{$value['pid']}"><a href="user.php?uid=$value[uid]" class="c8 load">$value['username']</a><em>:</em>$value['content']</p>
<!--{else}-->

<div class="reply flexbox pt10 pb10 bob o_c4" id="reply_$value['pid']">
  <div class="reply_user">
  <a href="user.php?uid=$value[uid]" class="load"><!--{avatar($value['user'],1)}--></a>
  </div>
  <div class="reply_content flex">
    <h3><a href="reply.php?mod=$value[mod]&ac=praise&vid=$_GET[vid]&pid=$value[pid]" class="icon icon-praise r load" loading="tab">{if $value['praise']}<span class="s13 pl5">+$value['praise']</span>{/if}</a><a href="user.php?uid=$value[uid]" class="c8 load">$value['username']</a><!--{if $value['top']}--><span class="b_c8 c3">置顶</span><!--{/if}--><!--{if $value['best']}--><span class="b_c1 c3">推荐</span><!--{/if}--></h3>
    <a href="reply.php?mod=$value[mod]&vid=$_GET[vid]&pid=$value[pid]" class="weui-article load block" id="replycontent_$value['pid']">
    $value['content']
    </a>
    <p class="pt10 s13"><!--{if $canmanage || $value['uid']==$_S['uid']}--><a href="javascript:smsot.replymanage('$value['vid']','$value['pid']','$value['top']','$value['best']','$value['mod']')" class="r c8" id="manage_$value[pid]">管理</a>{else}<a href="index.php?mod=feed&type=3&ref=reply.php?vid=$theme[vid]&pid=$value[pid]" class="r c8 load">举报</a><!--{/if}--><span class="c4">{date($value['dateline'],'m-d H:i:s')}</span><a href="reply.php?mod={$value['mod']}&ac=rp&s=n&vid=$_GET['vid']&pid=$value['pid']" class="b_c2 load" loading="tab"><span id="commentscount_$value['pid']">$value['replys']</span>回复</a></p>
    <!--{if $replys[$value[pid]]}-->
    <div class="comments b_c7 mt10 s13" id="comments_{$value['pid']}">
      <!--{loop $replys[$value[pid]] $comment}-->
      <p id="comment_{$comment['pid']}"><a href="user.php?uid=$comment[uid]" class="c8 load">$comment['username']</a><em>:</em>$comment['content']</p>
      <!--{/loop}-->
      <!--{if $value['replys']>count($replys[$value[pid]])}-->
      <p><a href="reply.php?mod={$value['mod']}&vid=$_GET[vid]&pid=$value[pid]" class="load c8">查看全部$value['replys']条评论&gt;</a></p>
      <!--{/if}-->
    </div>
    <!--{/if}-->
  </div>
</div>
<!--{/if}-->
<!--{/if}-->
