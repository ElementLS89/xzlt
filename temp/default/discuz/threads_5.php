<?exit?>
<div class="waterfallist">
  <ul id="waterfall" class="waterfall cl">
    <!--{loop $list $value}-->
    <!--{eval $cover=dzwatercover($pics[$value['tid']]);}-->
    <li id="{$value['tid']}/{$cover['width']}/{$cover['height']}">
      <div class="c">
        <div class="b_c3">
          <a href="discuz.php?mod=view&tid=$value['tid']" class="load block">
          <img src="ui/sl.png" class="cover lazyload" id="cover{$value[tid]}" data-original="$cover['pic']" />
          <p class="sub">$value[subject]</p></a>
        </div>
      </div>
    </li>
    <!--{/loop}-->
  </ul>
  <div id="tmppic" style="display: none;"></div>
</div>



