<?exit?>
<!--{loop $list $value}-->
<!--{eval $value['pics']=count($pics[$value['tid']])}-->
<div id="theme_$value[tid]">
  <div class="b_c3 bob o_c3">
    <div class="theme-ui">
      <span class="r c2 s12">{date($value['dateline'],'Y-m-d H:i:s')}</span><a href="user.php?dzuid=$value['authorid']" class="c8 load"><!--{avatar($value['authorid'],2,'img','dz')}-->$value['author']</a>
    </div>
    <div style="padding-left:42px">
      <div class="sort_sub">{if $value['sortid']}<span class="b_c1 c3 s13">$_S['cache']['discuz_types'][$value['sortid']]</span>{/if}<a href="discuz.php?mod=view&tid=$value['tid']" class="load">$value['subject']</a></div>
      <!--{if $value['sortid']}-->
      <a href="discuz.php?mod=view&tid=$value['tid']" class="sort_opt cl load block">
        <!--{eval $i=0}-->
        <!--{loop $sorts[$value[tid]] $sort}-->
        <!--{eval $option=$_S['cache']['discuz_typeoption'][$sort['optionid']]}-->
        <!--{if in_array($option['type'],array('radio','select'))}-->
        <span class="bo fc{$i}">$option['choices'][$sort['value']]</span>
        <!--{if $i==3}-->
        <!--{eval $i=0}-->
        <!--{else}-->
        <!--{eval $i++}-->
        <!--{/if}-->
        <!--{/if}-->
        <!--{/loop}-->
      </a>
      <ul class="sort_opl c4">
        <!--{loop $sorts[$value[tid]] $sort}-->
        <!--{eval $option=$_S['cache']['discuz_typeoption'][$sort['optionid']]}-->
        <!--{if in_array($option['type'],array('number','text','textarea','calendar','email','url','range'))}-->
        <!--{if stripos('+'.$option['identifier'],"tel") || stripos('+'.$option['identifier'],"dianhua")}-->
        <!--{eval $tel[$value['tid']]='<p class="sort_tel"><a href="tel:'.$sort['value'].'" class="weui-btn weui-btn_mini weui-btn_primary"><span class="icon icon-tel pr5"></span>拨打电话</a></p>';}-->
        <!--{else}-->
        <!--{if $sort['value']}-->
        <li><a href="discuz.php?mod=view&tid=$value['tid']" class="load block">{$option['title']} : {$sort['value']}{$option['unit']}</a></li>
        <!--{/if}-->
        <!--{/if}-->
        <!--{/if}-->
        <!--{/loop}-->
      </ul>
      $tel[$value['tid']]
      <!--{else}-->
      <h3 class="theme-sub"><a href="discuz.php?mod=view&tid=$value['tid']" class="load">$value['subject']</a></h3>
      <!--{/if}-->
      <!--{if $value['pics']==1}-->
      <div class="theme-img-one"><a href="discuz.php?mod=view&tid=$value['tid']" class="load"><!--{eval getdzpic($pics[$value['tid']],640,320)}--></a></div>
      <!--{elseif $value['pics']>1}-->
      <a href="discuz.php?mod=view&tid=$value['tid']" class="load"><ul class="theme-img cl" id="pics_$value[tid]">
        <!--{eval getdzpic($pics[$value['tid']])}-->
      </ul></a>
      <!--{/if}-->
      <p class="theme-foot s13"><a href="discuz.php?mod=forum&fid=$value['fid']" class="c8 r load">$_S['cache']['discuz_forum'][$value['fid']]['name']</a><span class="c4">阅读{$value['views']}</span><em class="c4"></em><span class="c4">评论{$value['replies']}</span></p>  
    </div>
  </div>
</div>
<!--{/loop}-->