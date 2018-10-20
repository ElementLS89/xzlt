<?exit?>
<div class="footer b_c2 bot o_c1 mainfooter">
  <div class="tabbar">
    <!--{loop $_S['tabbar'] $id $value}-->
    <a href="$value['url']" class="load {if $_S['currentkey']==$id}c1{else}c4{/if}"><span class="$value['icon']"></span><p>$value['name']</p></a>
    <!--{/loop}-->
  </div>
</div>