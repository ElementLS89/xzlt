<?exit?>
<!--{if $value['type']=='text'}-->
<div class="weui-cell">
  <div class="weui-cell__hd">
    <label class="weui-label"><!--{if $value['need']}--><span class="c9">*</span><!--{/if}-->{$value['name']}</label>
  </div>
  <div class="weui-cell__bd">
    <input class="weui-input" type="text" name="$field" maxlength="20" value="{if $my[$field]}$my[$field]{/if}" placeholder="请输入您的{$value['name']}">
  </div>
</div>
<!--{elseif $value['type']=='textarea'}-->
<div class="weui-cells weui-cells_form">
  <div class="weui-cell">
    <div class="weui-cell__bd">
      <textarea class="weui-textarea" name="$field" placeholder="请输入{$value['name']}" maxlength="200" rows="3">$my[$field]</textarea>
    </div>
  </div>
</div>
<!--{elseif $value['type']=='number'}-->
<div class="weui-cell">
  <div class="weui-cell__hd">
    <label class="weui-label"><!--{if $value['need']}--><span class="c9">*</span><!--{/if}-->$value['name']</label>
  </div>
  <div class="weui-cell__bd">
    <input class="weui-input" type="number" name="$field" pattern="[0-9]*" value="{if $my[$field]}$my[$field]{/if}" placeholder="请输入您的{$value['name']}">
  </div>
  <div class="weui-cell_ft">
    $value['unit']
  </div>
</div>
<!--{elseif in_array($value['type'],array('radio','select'))}-->
<div class="weui-cell weui-cell_select weui-cell_select-after">
  <div class="weui-cell__hd">
    <label for="$field" class="weui-label"><!--{if $value['need']}--><span class="c9">*</span><!--{/if}-->$value['name']</label>
  </div>
  <div class="weui-cell__bd">
    <select class="weui-select" name="$field" id="$field">
      <!--{loop $value['choises'] $id $value}-->
      <option value="$id" {if $my[$field]==$id}selected="selected"{/if}>$value</option>
      <!--{/loop}-->
    </select>
  </div>
</div>
<!--{elseif $value['type']=='checkbox'}-->
<!--{eval $my[$field]=explode(',',$my[$field]);}-->
<div class="weui-cells weui-cells_checkbox">
  <!--{loop $value['choises'] $id $value}-->
  <label class="weui-cell weui-check__label" for="$field{$id}">
    <div class="weui-cell__hd">
      <input type="checkbox" class="weui-check" value="$id" name="$field[]" id="$field{$id}" {if in_array($id,$my[$field])}checked="checked"{/if}>
      <i class="weui-icon-checked"></i>
    </div>
    <div class="weui-cell__bd">
      <p>$value</p>
    </div>
  </label>
  <!--{/loop}-->
</div>
<!--{elseif $value['type']=='date'}-->
<!--{eval $my[$field]=$my[$field]?smsdate($my[$field],$value['datetype']):'';}-->
<div class="weui-cell">
  <div class="weui-cell__hd">
    <label for="" class="weui-label"><!--{if $value['need']}--><span class="c9">*</span><!--{/if}-->$value['name']</label>
  </div>
  <div class="weui-cell__bd">
    <input class="weui-input" name="$field" type="date" value="$my[$field]">
  </div>
</div>
<!--{elseif $value['type']=='file'}-->
<div class="uploadcover" id="{$field}"><a href="javascript:" class="bo o_c1 b_c3" id="{$field}_area">{if $my[$field]}<img src="$_S['atc']/$my[$field]">{else}<span></span>{/if}</a>上传$value['name']（{$value['width']}*{$value['height']}）</div>
<input type="file" id="{$field}-file" name="{$field}" accept="image/gif,image/jpeg,image/jpg,image/png" style="display:none">
<!--{/if}-->