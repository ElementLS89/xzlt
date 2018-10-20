
<div class="block">
  <h3>基本信息</h3>
  <ul class="block_info">
    <li><cite>版权所有</cite><a href="https://www.smsot.com/" target="_blank">山东魔缇网络科技有限公司</a></li>
    <li><cite>程序版本</cite>Smsot<?php echo $_S['setting']['version'];?></li>
    <li><cite>服务器系统</cite><?php echo $serverinfo;?></li>
    <li><cite>服务器软件</cite><?php echo $_SERVER['SERVER_SOFTWARE'];?></li>
    <li><cite>PHP版本</cite><?php echo $phpinfo;?></li>
    <li><cite>magic_quote_gpc</cite><?php echo $magic_quote_gpc;?></li>
    <li><cite>allow_url_fopen</cite><?php echo $allow_url_fopen;?></li>
    <li><cite>上传许可</cite><?php echo $fileupload;?></li>
  </ul>
</div>
<?php if($notice) { ?>
<div id="notice" style="display:none">
  <h3><em class="icon icon-close" onclick="closenotice();"></em>Smsot通知</h3>
  <ul>
    <?php if(is_array($notice)) foreach($notice as $value) { ?>    <li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['subject'];?></a></li>
    <?php } ?>
  </ul>
</div>

<script language="javascript">
  $('#notice').fadeIn();
  function closenotice(){
$('#notice').hide();
}

</script>
<?php } ?>