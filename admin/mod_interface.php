<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('导航设置','admin.php?mod='.$_GET['mod'].'&item=index'),
	'app'=>array('APP适配','admin.php?mod='.$_GET['mod'].'&item=app'),
	'temp'=>array('模板管理','admin.php?mod='.$_GET['mod'].'&item=temp'),
	'color'=>array('配色管理','admin.php?mod='.$_GET['mod'].'&item=color'),
	'smile'=>array('表情管理','admin.php?mod='.$_GET['mod'].'&item=smile'),
	'font'=>array('自定义图标','admin.php?mod='.$_GET['mod'].'&item=font'),
);

if($_GET['item']=='temp'){
	if(in_array($_GET['ac'],array('add','edit'))){
    if($_GET['tempid']){
			$temp=DB::fetch_first("SELECT * FROM ".DB::table('common_temp'." WHERE `tempid`='$_GET[tempid]'"));
			if(!$temp){
				showmessage('模板不存在');
			}
		}
		if(checksubmit('submit')){
			$s['name']=trim($_GET['name']);
			$s['dir']=trim($_GET['dir']);

			if($_GET['ac']=='add'){
				$s['copyright']=trim($_GET['copyright']);
				$s['author']=trim($_GET['author']);
				$s['version']=trim($_GET['version'])?trim($_GET['version']):1;				
			}
			
			if(!$s['name']){
				showmessage('模板名称没有填写');			
			}
			if(!$s['dir']){
				showmessage('模板目录没有填写');			
			}
			if($temp){
				update('common_temp',$s,"tempid='$_GET[tempid]'");
				showmessage('模板修改成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);			
			}else{
				insert('common_temp',$s);
				showmessage('模板添加成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);				
			}
		}
	}elseif($_GET['ac']=='delete'){
		$temp=DB::fetch_first("SELECT * FROM ".DB::table('common_temp'." WHERE `tempid`='$_GET[tempid]'"));
		if(!$temp){
			showmessage('模板不存在');
		}
		if($temp['touch']){
			showmessage('当前模板为默认手机模板不能删除');
		}
		if($temp['pc']){
			showmessage('当前模板为默认PC模板不能删除');
		}
		DB::query("DELETE FROM ".DB::table('common_temp')." WHERE `tempid`='$_GET[tempid]'");
		showmessage('选择模板删除成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);
		
	}else{
		$query = DB::query("SELECT * FROM ".DB::table('common_temp'));
		while($value = DB::fetch($query)) {
			$value['cover']='temp/'.$value['dir'].'/cover.jpg';
			$temps[$value['tempid']]=$value;
		}
		if(checksubmit('submit')){
			DB::query("UPDATE ".DB::table('common_temp')." SET `touch`='0',`pc`='0'");
			update('common_temp',array('touch'=>1),"tempid='$_GET[touch]'");
			update('common_temp',array('pc'=>1),"tempid='$_GET[pc]'");
			C::chche('temp','update');
			showmessage('模板设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);
		}
	}
}elseif($_GET['item']=='font'){
	if($_GET['op']){
		if(in_array($_GET['ac'],array('add','edit'))){
			if($_GET['fid']){
				$icon=DB::fetch_first("SELECT * FROM ".DB::table('common_icon'." WHERE `fid`='$_GET[fid]'"));
				if(!$icon){
					showmessage('自定义图标不存在');
				}
			}
			if(checksubmit('submit')){
				$s['name']=trim($_GET['name']);
				$s['code']=trim($_GET['code']);
				$s['code_on']=trim($_GET['code_on']);

				if(!isappkey($s['name'])){
					showmessage('图标名称不符合要求');
				}
		
				if(!$s['name'] || !$s['code']){
					showmessage('必填项目没有填写');			
				}

				if($icon){
					update('common_icon',$s,"fid='$_GET[fid]'");
					C::chche('icon','update');
					showmessage('自定义图标修改成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&op=icon');			
				}else{
					insert('common_icon',$s);
					C::chche('icon','update');
					showmessage('自定义图标添加成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&op=icon');				
				}
			}
		}else{
			
			$sql['select'] = 'SELECT *';
			$sql['from'] =' FROM '.DB::table('common_icon');
	
			$select=select($sql,$wherearr,30);
	
			if($select[1]) {
				$query = DB::query($select[0]);
				while($value = DB::fetch($query)){
					$icons[$value['fid']]=$value;
				}
			}
			$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&iframe=true';
			$pages=page($select[1],30,$_S['page'],$urlstr);

			if(checksubmit('dosubmit')){
				$fids=implode(',',$_GET['fids']);
				if($fids){
					chechdelete();
					DB::query("DELETE FROM ".DB::table('common_icon')." WHERE `fid` IN($fids)");
				}
				foreach($_GET['name'] as $fid => $name){
					$name=trim($name);
					$code=trim($_GET['code'][$fid]);
					$code_on=trim($_GET['code_on'][$fid]);
					
					update('common_icon',array('name'=>$name,'code'=>$code,'code_on'=>$code_on),"fid='$fid'");
				}		
				C::chche('icon','update');
				showmessage('自定义图标设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&op=icon');	
			}
		}
	}else{
		if(checksubmit('submit')){
			$s['self_font']=trim($_GET['self_font']);

			update('common_setting',array('k'=>'self_font','v'=>$s['self_font']),'',true);
			upsetting();
			showmessage('设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);	

		}
	}
	
}elseif($_GET['item']=='smile'){
	if(in_array($_GET['ac'],array('add','edit'))){
    if($_GET['typeid']){
			$smiletype=DB::fetch_first("SELECT * FROM ".DB::table('common_smile_type'." WHERE `typeid`='$_GET[typeid]'"));
			if(!$smiletype){
				showmessage('表情分类不存在');			
			}
		}
		if(checksubmit('submit')){
			$s['name']=trim($_GET['name']);
			$s['dir']=trim($_GET['dir']);
			$s['list']=intval($_GET['list']);
			$s['canuse']=$_GET['canuse'];

			if(!$s['name'] || !$s['dir']){
				showmessage('表情分类名称和目录没有填写');			
			}
			
			if($smiletype){
				update('common_smile_type',$s,"typeid='$_GET[typeid]'");
				C::chche('smile','update');
				showmessage('表情分类修改成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);			
			}else{
				insert('common_smile_type',$s);
				C::chche('smile','update');
				showmessage('表情分类添加成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);				
			}
		}
	}elseif($_GET['ac']=='manage'){
		$smiletype=DB::fetch_first("SELECT * FROM ".DB::table('common_smile_type'." WHERE `typeid`='$_GET[typeid]'"));
		if(!$smiletype){
			showmessage('表情分类不存在');			
		}
		if($_GET['op']=='add'){
			if(checksubmit('submit')){
				$s['pic']=trim($_GET['pic']);
				$s['str']=trim($_GET['str']);
				$s['list']=intval($_GET['list']);
				$s['type']=$_GET['typeid'];
	
				if(!$s['pic'] || !$s['str']){
					showmessage('表情文件名和文字解析没有填写');			
				}
				insert('common_smile',$s);
				C::chche('smile','update');
				showmessage('表情添加成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&ac='.$_GET['ac'].'&typeid='.$_GET['typeid']);		
			}
		}else{
			$query = DB::query("SELECT * FROM ".DB::table('common_smile')." WHERE type='$_GET[typeid]' ORDER BY list ASC");
			while($value = DB::fetch($query)) {
				$smiles[$value['id']]=$value;
			}

			if(checksubmit('dosubmit')){
				$ids=implode(',',$_GET['id']);
				if($ids){
					chechdelete();
					DB::query("DELETE FROM ".DB::table('common_smile')." WHERE `id` IN($ids)");
				}
				foreach($_GET['ids'] as $key => $id){
					$list=intval($_GET['list'][$id]);
					$pic=trim($_GET['pic'][$id]);
					$str=trim($_GET['str'][$id]);
					if($pic && $str){
						update('common_smile',array('list'=>$list,'pic'=>$pic,'str'=>$str),"id='$id'");
					}
				}
				C::chche('smile','update');
				showmessage('表情设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'].'&ac='.$_GET['ac'].'&typeid='.$_GET['typeid']);			
			}
		}
		
	}else{
		$query = DB::query("SELECT * FROM ".DB::table('common_smile_type').' ORDER BY list ASC');
		while($value = DB::fetch($query)) {
			$smiletypes[$value['typeid']]=$value;
		}
		if(checksubmit('dosubmit')){
			$typeids=implode(',',$_GET['typeid']);
			if($typeids){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('common_smile_type')." WHERE `typeid` IN($typeids)");
				DB::query("DELETE FROM ".DB::table('common_smile')." WHERE `type` IN($typeids)");
			}
			foreach($_GET['typeids'] as $key => $typeid){
				$list=intval($_GET['list'][$typeid]);
				$canuse=$_GET['canuse'][$typeid];
				update('common_smile_type',array('list'=>$list,'canuse'=>$canuse),"typeid='$typeid'");
			}
			C::chche('smile','update');
			showmessage('表情分类设置成功','admin.php?mod='.$_GET['mod'].'&item='.$_GET['item']);		
		}
	}
}
?>