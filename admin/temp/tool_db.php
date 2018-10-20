<?exit?>
<ul class="catalog cl">
  <li{if !$_GET['ac']} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&iframe=yes">备份</a></li>
  <li{if $_GET['ac']=='import'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=import&iframe=yes">恢复</a></li>
  <li{if $_GET['ac']=='run'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=run&iframe=yes">升级</a></li>
  <li{if $_GET['ac']=='optimize'} class="a"{/if}><a href="admin.php?mod=$_GET['mod']&item=$_GET['item']&ac=optimize&iframe=yes">优化</a></li>
</ul>

<p class="empty">请下载安装<a href="https://www.phpmyadmin.net/" target="_blank">phpmyadmin</a>进行数据库的相关操作</p>