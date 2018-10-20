<?exit?>
<ul class="catalog cl">
  <li{if !$_GET['op']} class="a"{/if}><a href="admin.php?mod=index&item=$_GET['item']&iframe=yes">上传设置</a></li>
  <li{if $_GET['op']=='qiniu'} class="a"{/if}><a href="admin.php?mod=index&item=$_GET['item']&op=qiniu&iframe=yes">七牛云存储</a></li>
</ul>
{if $_GET['op']=='qiniu'}
<div class="block">
  <h3>上传设置</h3>
  <ul class="block_info">
    <li>本功能需要开通七牛云存储服务,申请开通地址为“https://www.qiniu.com/”</li>
    <li>开通本功能后可以进行视频的处理和上传</li>
  </ul>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']&op=qiniu" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>AK</th>
        <td><input type="text" class="input w300" name="qiniu_ak" value="$_S['setting']['qiniu_ak']"><em>进入七牛管理面板获取AK和SK</em></td>
      </tr>
      <tr>
        <th>SK</th>
        <td>
        <input type="text" class="input w300" name="qiniu_sk" value="$_S['setting']['qiniu_sk']">
        </td>
      </tr>
      <tr>
        <th>存储区域</th>
        <td>
        <div class="select">
          <select name="qiniu_endpoint">
            <option value="0">下拉选择</option>
            <option value="up.qiniup.com" {if $_S['setting']['qiniu_endpoint']=='up.qiniup.com'}selected="selected"{/if}>华东</option>
            <option value="up-z1.qiniup.com" {if $_S['setting']['qiniu_endpoint']=='up-z1.qiniup.com'}selected="selected"{/if}>华北</option>
            <option value="up-z2.qiniup.com" {if $_S['setting']['qiniu_endpoint']=='up-z2.qiniup.com'}selected="selected"{/if}>华南</option>
            <option value="up-na0.qiniup.com" {if $_S['setting']['qiniu_endpoint']=='up-na0.qiniup.com'}selected="selected"{/if}>北美</option>
          </select>
        </div><em>请根据您存储空间的存储区域进行选择，错误的选择将导致无法上传</em> 
        </td>
      </tr>
      
      <tr>
        <th>存储空间</th>
        <td><input type="text" class="input" name="qiniu_bucket" value="$_S['setting']['qiniu_bucket']"><em>填写存储空间名称</em></td>
      </tr>
      <tr>
        <th>外链域名</th>
        <td><input type="text" class="input w300" name="qiniu_domain" value="$_S['setting']['qiniu_domain']"><em>填写存储空间的外链域名以http或https开头，结尾需包含"/"，请勿使用七牛的临时域名，临时域名有流量限制将导致上传不稳定</em></td>
      </tr>
      <tr>
        <th>视频压缩分辨率</th>
        <td><input type="text" class="input" name="qiniu_resolution" value="$_S['setting']['qiniu_resolution']"><em>填写视频压缩处理的分辨率大小如640x480</em></td>
      </tr>
      <tr>
        <th>视频截图</th>
        <td><input type="text" class="input" name="qiniu_frame" value="$_S['setting']['qiniu_frame']"><em>填写取第几帧为视频截图,5以内最佳，否则过短的视频无法获取截图</em></td>
      </tr>
      <tr>
        <th>多媒体处理私有列队</th>
        <td><input type="text" class="input" name="qiniu_pipeline" value="$_S['setting']['qiniu_pipeline']"><em>添加多媒体处理服务，并把建立的列队名称添加到此处</em></td>
      </tr>
      <tr>
        <th>列表播放</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="qiniu_play" value="1" {if $_S['setting']['qiniu_play']}checked{/if}/><span class="icon"></span>是</label>
        <label class="radio"><input type="radio" class="check" name="qiniu_play" value="0" {if !$_S['setting']['qiniu_play']}checked{/if}/><span class="icon"></span>否</label>
        <em>在列表页点击视频缩略图是否直接播放视频</em>
        </td>
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
{else}
<div class="block">
  <h3>上传设置</h3>
  <form action="admin.php?mod=$_GET['mod']&item=$_GET['item']" method="post">
    <input name="iframe" type="hidden" value="true" />
    <input name="hash" type="hidden" value="$_S['hash']" />
    <table class="table" cellpadding="0" cellspacing="0">
      <tr>
        <th>本地附件保存位置</th>
        <td><input type="text" class="input" name="attach" value="$_S['setting']['attach']"><em>服务器路径，属性 777，必须为 web 可访问到的目录，结尾不加 "/"</em></td>
      </tr>
      <tr>
        <th>图片处理库类型</th>
        <td>
        <label class="radio"><input type="radio" class="check" name="imagelib" value="0" {if !$_S['setting']['imagelib']}checked{/if}/><span class="icon"></span>GD</label>
        <label class="radio"><input type="radio" class="check" name="imagelib" value="1" {if $_S['setting']['imagelib']}checked{/if}/><span class="icon"></span>ImageMagick</label>
        <em>GD 是最广泛的处理库但是使用的系统资源较多。ImageMagick 速度快系统资源占用少，但需要服务器安装 ImageMagick 扩展。如果您的服务器有条件安装此程序，请到 http://www.imagemagick.org 下载</em>
        </td>
      </tr>
      <tr>
        <th>缩略图质量</th>
        <td><input type="text" class="input" name="thumbquality" value="$_S['setting']['thumbquality']"><em>设置图片附件缩略图的质量参数，范围为 0～100 的整数，数值越大结果图片效果越好，但尺寸也越大</em></td>
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
{/if}

