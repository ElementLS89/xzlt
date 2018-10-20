<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

C::chche('hacks');


$menus=array(
  'index'=>array('应用管理','admin.php?mod='.$_GET['mod'].'&item=index'),
	'add'=>array('创建应用','admin.php?mod='.$_GET['mod'].'&item=add'),
	'appstore'=>array('应用商店','admin.php?mod='.$_GET['mod'].'&item=appstore'),
);
function uphackseting($id){
	$query = DB::query("SELECT * FROM ".DB::table('common_hack_setting')." WHERE `id`='$id' ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		if(in_array($value['type'],array('radio','select','checkbox'))){
			foreach(explode("\n", $value['content']) as $item) {
				list($key, $name) = explode('=', $item);
				$value['choose'][$key]=array('key'=>$key,'name'=>$name);
			}
		}
		$setting[$value['valueid']]=$value;
	}
	if($setting){
		$setting=dserialize($setting);
		update('common_hack',array('setting'=>$setting),"id='$id'");
	}
}
if($_GET['item']=='index'){
	$hacks=DB::fetch_all("SELECT * FROM ".DB::table('common_hack'));
	foreach($hacks as $value){
		$value['icon']='hack/'.$value['id'].'/icon.png';
		$value['set']='admin.php?mod=hacks&ac=set&id='.$value['id'].'&iframe=yes';
		if($value['open']){
			$hacklist['open'][]=$value;
		}else{
			$hacklist['close'][]=$value;
		}
		$hackids[]=$value['id'];
		$hacks[$value['id']]=$value;
	}
	$hackdir = dir(ROOT.'./hack');
	while($entry = $hackdir->read()) {
		if(!in_array($entry, array('.', '..','index.html')) && is_dir(ROOT.'./hack/'.$entry) && !in_array($entry, $hackids)) {
			$entryfile ='./hack/'.$entry.'/var.php';
			if(is_file(ROOT.$entryfile)) {
				require_once $entryfile;
				if($thishack[$entry]){
					$thishack[$entry]['icon']='hack/'.$entry.'/icon.png';
					$hacklist['notinstall'][$entry]=$thishack[$entry];
				}
			}
		}
	}
	if($_GET['ac']){
		$hack=$hacks[$_GET['id']];
		if(!$hack){
			$hack=$hacklist['notinstall'][$_GET['id']];
			if(!$hack){
				showmessage('应用不存在');
			}
		}
		$hack['setting']=dunserialize($hack['setting']);
	}
	$valuetype=array(
	  'usergroup'=>'用户组',
		'forum'=>'板块',
		'number'=>'数字',
		'text'=>'字符串',
		'textarea'=>'文本',
		'radio'=>'单选',
		'select'=>'下拉菜单',
		'checkbox'=>'多选',
		'date'=>'日期',
		'time'=>'时间',
	);
	if($_GET['ac']=='close'){
		if(!$hack['open']){
			showmessage('应用还未开启 ');
		}
		update('common_hack',array('open'=>0),"id='$_GET[id]'");
		C::chche('hacks','update');
		showmessage('应用关闭成功','admin.php?mod=hacks');
		
	}elseif($_GET['ac']=='open'){
		if($hack['open']){
			showmessage('应用已经开启 ');
		}
		update('common_hack',array('open'=>1),"id='$_GET[id]'");
		C::chche('hacks','update');
		showmessage('应用开启成功','admin.php?mod=hacks');
	}elseif($_GET['ac']=='set'){
		require_once ROOT.'./hack/'.$_GET['id'].'/set.php';

    if(!$_GET['t']){
		  if(checksubmit('submit')){
			  foreach($hack['setting'] as $v){
					if($v['type']=='usergroup' || $s['type']=='checkbox' ){
						$s=@implode(',',$_GET['set'][$v['valueid']]);
					}elseif(in_array($v['type'],array('number','text','date','time','textarea'))){
						$s=trim($_GET['set'][$v['valueid']]);
					}else{
						$s=$_GET['set'][$v['valueid']];
					}
					update('common_hack_setting',array('value'=>$s),"`valueid`='$v[valueid]'");
				}
        uphackseting($hack['id']);
				C::chche('hacks','update');
			  showmessage('应用设置成功','admin.php?mod=hacks&ac=set&id='.$hack['id']);
			}
		}
	}elseif($_GET['ac']=='install'){
		if(is_file(ROOT.'./hack/'.$_GET['id'].'/install.php')) {
			require_once ROOT.'./hack/'.$_GET['id'].'/install.php';
		}
		showmessage('应用安装成功','admin.php?mod=hacks');
	}elseif($_GET['ac']=='uninstall'){
		if($_GET['confirm']){
			
			DB::query("DELETE FROM ".DB::table('common_hack')." WHERE `id`='$_GET[id]'");
			DB::query("DELETE FROM ".DB::table('common_hack_setting')." WHERE `id`='$_GET[id]'");
			C::chche('hacks','update');
			if(is_file(ROOT.'./hack/'.$_GET['id'].'/uninstall.php')) {
				require_once ROOT.'./hack/'.$_GET['id'].'/uninstall.php';
			}
			showmessage('所选应用已卸载','admin.php?mod=hacks&iframe=true');			
		}else{
			showmessage('您确定要卸载本应用吗','admin.php?mod=hacks&ac=uninstall&id='.$hack['id'].'&confirm=true&iframe=true',array('confirm'=>'1'));
		}

	}elseif($_GET['ac']=='develop'){
		if(!$_GET['op']){
			if(checksubmit('submit')){
				$s['id']=trim($_GET['hackid']);
				$s['name']=$_GET['name']?cutstr(trim($_GET['name']),20):'';
				$s['version']=trim($_GET['version'])?trim($_GET['version']):'1';
				$s['type']=$_GET['type'];
				$s['about']=$_GET['about'];
				
				if(!$s['id']){
					showmessage('没有填写应用ID');
				}
				if(!isappkey($s['id'])){
					showmessage('应用ID不符合要求');
				}
				if($s['id']!=$hack['id']){
					if(DB::fetch_first("SELECT * FROM ".DB::table('common_hack')." WHERE `id`='$s[id]'")){
						showmessage('应用ID不能与现有ID重复');
					}					
				}
				if(!$s['name']){
					showmessage('没有填写应用名称');
				}
				update('common_hack',$s,"id='$_GET[id]'");
				showmessage('应用设置成功','admin.php?mod=hacks&ac=develop&id='.$s['id']);
			}
		}elseif(in_array($_GET['op'],array('add','edit'))){
			if($_GET['op']=='edit'){
				$set=DB::fetch_first("SELECT * FROM ".DB::table('common_hack_setting'." WHERE `valueid`='$_GET[valueid]'"));
				if(!$set){
					showmessage('变量不不存在');
				}
			}
			if(checksubmit('submit')){
				$s['valueid']=$_GET['op']=='edit'?trim($_GET['newvalueid']):trim($_GET['valueid']);
				$s['name']=trim($_GET['name']);
				$s['type']=$_GET['type'];
				$s['about']=trim($_GET['about']);
				$s['content']=trim($_GET['content']);
				
				if(!$s['name']){
					showmessage('变量名称没有填写');			
				}
				if(!$s['valueid']){
					showmessage('变量ID没有填写');			
				}
				if($_GET['op']=='add' || ($_GET['op']=='edit' && $s['valueid']!=$set['valueid'])){
					if(DB::fetch_first("SELECT * FROM ".DB::table('common_hack_setting')." WHERE `id`='$hack[id]' AND `valueid`='$s[valueid]'")){
						showmessage('同一应用下不能有重复的变量名称');
					}	
				}
				if($set){
					update('common_hack_setting',$s,"`valueid`='$_GET[valueid]'");
					uphackseting($hack['id']);
					if($hack['open']){
						C::chche('hacks','update');
					}
					showmessage('应用变量配置修改成功','admin.php?mod='.$_GET['mod'].'&ac='.$_GET['ac'].'&id='.$hack['id'].'&op=set');			
				}else{
					$s['id']=$hack['id'];
					insert('common_hack_setting',$s);
					uphackseting($hack['id']);
					if($hack['open']){
						C::chche('hacks','update');
					}
					showmessage('应用变量添加成功','admin.php?mod='.$_GET['mod'].'&ac='.$_GET['ac'].'&id='.$hack['id'].'&op=set');				
				}
			}
		}else{
			$query = DB::query("SELECT * FROM ".DB::table('common_hack_setting')." WHERE `id`='$hack[id]' ORDER BY list ASC");
			while($value = DB::fetch($query)) {
				$values[$value['valueid']]=$value;
			}
			if(checksubmit('submit')){
				if($_GET['valueid']){
					foreach($_GET['valueid'] as $id){
						$ids[]='\''.$id.'\'';
					}
					$valueids=implode(',',$ids);					
				}
				if($valueids){
					DB::query("DELETE FROM ".DB::table('common_hack_setting')." WHERE `valueid` IN($valueids)");
				}
				foreach($_GET['valueids'] as $key => $valueid){
					$list=intval($_GET['list'][$valueid]);
					update('common_hack_setting',array('list'=>$list),"valueid='$valueid'");
				}
				uphackseting($hack['id']);
				if($hack['open']){
					C::chche('hacks','update');
				}
				showmessage('变量设置成功','admin.php?mod='.$_GET['mod'].'&ac='.$_GET['ac'].'&id='.$hack['id'].'&op=set');	
			}
		}
	}
}elseif($_GET['item']=='appstore'){
	require_once './include/json.php';
	$apps=get_urlcontent('https://www.smsot.com/apps.php');
  $apps=JSON::decode($apps);
}elseif($_GET['item']=='add'){

  if(checksubmit('submit')){
	  $s['id']=trim($_GET['id']);
		$s['name']=$_GET['name']?cutstr(trim($_GET['name']),20):'';
		$s['version']=trim($_GET['version'])?trim($_GET['version']):'1';
		$s['type']=$_GET['type'];
		$s['about']=$_GET['about'];
		
		if(!$s['id']){
		  showmessage('没有填写应用ID');
		}
		if(!isappkey($s['id'])){
			showmessage('应用ID不符合要求');
		}
		if(DB::fetch_first("SELECT * FROM ".DB::table('common_hack')." WHERE `id`='$s[id]'")){
			showmessage('应用ID不能与现有ID重复');
		}
		if(!$s['name']){
			showmessage('没有填写应用名称');
		}
		insert('common_hack',$s);
		showmessage('应用创建成功','admin.php?mod=hacks');
	}
}

?>