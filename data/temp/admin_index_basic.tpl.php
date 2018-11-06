
<div class="block">
  <h3>站点信息</h3>
  <ul class="block_info">
    <li>可以在这里设置站点的基本信息</li>
    <li>网站URL地址这里请一定要设置真实的URL地址否则很多接口会无效</li>
  </ul>

</div>
<div class="block">
  <h3>设置站点信息</h3>
  <form action="admin.php?mod=<?php echo $_GET['mod'];?>&item=<?php echo $_GET['item'];?>" method="post" enctype="multipart/form-data">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="<?php echo $_S['hash'];?>" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>站点名称</th>
        <td><input type="text" class="input w300" name="sitename" value="<?php echo $_S['setting']['sitename'];?>"><em>站点名称，将显示在浏览器窗口标题等位置</em></td>
      </tr>
      <tr>
        <th>网站URL</th>
        <td><input type="text" class="input w300" name="siteurl" value="<?php echo $_S['setting']['siteurl'];?>"><em>你的网站地址，注意后面要包含"/"，错误的设置会导致微信相关功能失效</em></td>
      </tr>
      <tr>
        <th>自定义二维码</th>
        <td><?php if($_S['setting']['qrcode']) { ?><img src="<?php echo $_S['atc'];?>/<?php echo $_S['setting']['qrcode'];?>"><?php } ?><input type="file" name="qrcode"><em>将显示再PC版的首页，如果无自定义二维码系统会生成一个默认的二维码</em></td>
      </tr>
      <tr>
        <th>开启PC访问</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="pc" value="1" <?php if($_S['setting']['pc']) { ?>checked<?php } ?>/><span class="icon"></span>是</label>
        <label class="radio"><input type="radio" class="check" name="pc" value="0" <?php if(!$_S['setting']['pc']) { ?>checked<?php } ?>/><span class="icon"></span>否</label>
        <em>是否开启PC版访问</em>
        </td>
      </tr>
      <tr>
        <th>关闭站点</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="close" value="1" <?php if($_S['setting']['close']) { ?>checked<?php } ?>/><span class="icon"></span>是</label>
        <label class="radio"><input type="radio" class="check" name="close" value="0" <?php if(!$_S['setting']['close']) { ?>checked<?php } ?>/><span class="icon"></span>否</label>
        <em>暂时将站点关闭，其他人无法访问，但不影响管理员访问</em>
        </td>
      </tr>
      <tr>
        <th>关闭论坛功能</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="closebbs" value="1" <?php if($_S['setting']['closebbs']) { ?>checked<?php } ?>/><span class="icon"></span>是</label>
        <label class="radio"><input type="radio" class="check" name="closebbs" value="0" <?php if(!$_S['setting']['closebbs']) { ?>checked<?php } ?>/><span class="icon"></span>否</label>
        <em>论坛功能关闭之后，普通用户将关闭发帖功能，帖子展示也将以资讯风格进行展示，小组功能也将关闭</em>
        </td>
      </tr>      
      <tr>
        <th>敏感词过滤</th>
        <td><textarea class="textarea" name="sensitive"><?php echo $_S['setting']['sensitive'];?></textarea><em>设置敏感词过滤,多个用逗号隔开</em></td>
      </tr>

      <tfoot>
        <tr>
          <td colspan="2">
            <button type="submit" class="button" name="submit" value="true">提交</button>
          </td>
        </tr>  
      </tfoot>
    </table>
  </form>  
</div>