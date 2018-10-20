<!--{if $_GET['fid']}-->
<!--{eval $box='vf_s'.$_GET['fid'].'_new'.$_GET['sortid'];}-->
<!--{else}-->
<!--{eval $box='vsort_'.$_GET['sortid'];}-->
<!--{/if}-->
<div id="showsortopt" style="display:none"><a href="javascript:SMS.toggle('#sortopt','#showsortopt')" class="cl p10 b_c3 bob o_c3 block mb10"><span class="r icon icon-expanding pl5 s18 c2"></span><span class="r c2 s13">点击展开高级搜索</span><span class="icon icon-search pr10 s18 c9"></span><span class="c9 s15">$_S['cache']['discuz_types'][$_GET['sortid']]</span></a></div>
<div id="sortopt">
  <form action="discuz.php" method="get" id="search-sort" type="search" onsubmit="getform(this.id);return false" id="">
    <!--{loop $_GET $key $val}-->
    <!--{if !in_array($key,array('load','get','page'))}-->
    <input type="hidden" name="$key" value="$val" />
    <!--{/if}-->
    <!--{/loop}-->
    <table cellpadding="0" cellspacing="0" class="sort_table b_c3 ">
      <tbody>
        <!--{loop $thissort $value}-->
        <!--{if $value['search'] && in_array($value['type'], array('radio', 'checkbox', 'select', 'range', 'text', 'number'))}-->
        <!--{eval $op='op'.$value['optionid'];}-->
        <tr>
          <th class="c4">$value['title']</th>
          <td class="bob o_c3">
          <!--{if in_array($value['type'], array('radio', 'checkbox', 'select', 'range'))}-->
          <a href="{eval sorturl('op'.$value['optionid'])}" class="{if !$_GET[$op]}c9{else}c8{/if} get" box="$box" type="get">不限</a>
          <!--{loop $value['choices'] $id $name}-->
          <a href="{eval sorturl('op'.$value['optionid'],$id)}" class="{if $_GET[$op]==$id}c9{else}c8{/if} get" box="$box" type="get">$name</a>
          <!--{/loop}-->
          <!--{else}-->
          <input class="weui-input" type="text" name="$op" value="" placeholder="请输入搜索内容">
          <!--{/if}-->
          </td>
        </tr>
        <!--{/if}-->
        <!--{/loop}-->
      </tbody>
    </table>
  </form>
  <a href="javascript:SMS.toggle('#showsortopt','#sortopt')" class="icon icon-collapsing bot o_c3 b_c2 mb10" id="unfoldsortopt"></a>
</div>

