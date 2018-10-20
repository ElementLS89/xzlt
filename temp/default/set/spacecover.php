<?exit?>
<!--{template header}-->
<div id="view">
  <div id="header">
    <div class="header b_c1 flexbox c3">
      <div class="header-l">{eval back('close')}</div>
      <div class="header-m flex">$navtitle</div>
      <div class="header-r"><a href="javascript:SMS.openside()" class="icon icon-openside"></a></div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody $outback">
      <div class="topnv swipernv b_c3 bob o_c3">
        <ul class="flexbox">
          <li class="c1 flex"><a href="javascript:"><span>推荐</span></a></li>     
          <li class="c7 flex"><a href="javascript:uploadspacecover()"><span>上传</span></a></li>
          <span class="swipernv-on b_c1"></span>
        </ul>
      </div>
      <!--{loop $_S['cache']['spacecover_type'] $type}-->
      <div class="spacecover bob o_c3 b_c3 mt10">
        <h3><span class="r s13 c4">{echo count($_S['cache']['spacecover'][$type['tid']])}张</span>$type['name']</h3>
        <ul class="cl">
          <!--{eval $i=1}-->
          <!--{loop $_S['cache']['spacecover'][$type['tid']] $value}-->
          <!--{if $i<7}-->
          <li onClick="javascript:SMS.openlayer('setspacecover');select_spacecover('{$type['tid']}','{$value['cid']}')"><div class="c"><div><img src="ui/spacecover/$value['path']"></div><p class="s13 c4">$value['name']</p></div></li>
          <!--{/if}-->
          <!--{eval $i++}-->
          <!--{/loop}-->
        </ul>
      </div>
      <!--{/loop}-->
      <div id="layer">
      <!--{template set/setspacecover}-->
      </div>


      
    </div>
  </div>
  <div id="footer"> 
    
  </div>
</div>
<div id="smsscript">
  <script language="javascript" reload="1">
	  $(document).ready(function() {
      SMS.translate_int();
		});
  </script>
  <script language="javascript">
    var spacecover=$spacecover;
		
		function select_spacecover(tid,cid,preview){
			var coverpath='ui/spacecover/'+spacecover[tid][cid]['path'],keys = [],covers='';
			if(SMS.empty(preview)){
				for (key in spacecover[tid]) {
					keys.push(key);
				}
				for(i = 0; i < keys.length; i++){
					if(spacecover[tid][keys[i]]['cid'] == cid){
						var checked=" checked ";
					}else{
						var checked="";
					}
					covers +='<li onClick="javascript:select_spacecover(\''+tid+'\',\''+spacecover[tid][keys[i]]['cid']+'\',true);"><label><div><img src="ui/spacecover/'+spacecover[tid][keys[i]]['path']+'"><input type="radio" name="coverid" value="'+spacecover[tid][keys[i]]['cid']+'"'+checked+'><span class="icon c1"></span></div></label></li>';
				}
				$('.layer .selectcover ul').html(covers);
				$('.layer #spacecover_tid').val(tid);	
			}
      $('.layer #spacecover_cid').val(cid);	
			$('.layer .usertop-bg').css({'background-image':'url('+coverpath+')'});
		}
    function uploadspacecover(){
			SMS.openlayer('setspacecover');
			var obj = $(this);
			
      $('#spacecover-file').click();
			$('#spacecover-file').on("change", function(e){
				
				var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
				if(url) {
					src = url.createObjectURL(files[0]);
				}else {
					src = e.target.result;
				}
				$('.layer #spacecover_tid').val("");	
				$('.layer #spacecover_cid').val("");	
				$('.layer .selectcover ul').html("");
				
				$('.layer .usertop-bg').css({'background-image':'url('+src+')'});

			});
			
		}
  </script>
  <!--{template wechat_shar}-->
</div>
<!--{template footer}-->