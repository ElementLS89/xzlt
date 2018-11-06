<?exit?>
<div id="view">
    <div class="smsbody body_b $outback">
	  <div class="find-items b_c3">
        <ul class="cl c6">
          <!--{loop $tipsList $value}-->
          <!--{if $value['subject']}-->
          <li><a href="$value['link']" {if $value['link']}class="load"{/if}><img src="$_S[atc]/$value[pic]" /><p{if !$value['link']} class="c4"{/if}>$value[subject]</p></a></li>
          <!--{/if}-->
          <!--{/loop}-->
        </ul>
      </div>
    </div>
</div>