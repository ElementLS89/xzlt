<?php
if(!defined('IN_SMSOT')) {
	exit;
}
class C{
	
	public static function chche($cacheid,$action='get',$time='',$type='system') {
    global $_S,$_GET;
		if($type=='system'){
			$cachefile=ROOT.'./data/cache/sys_'.$cacheid.'.php';
			if(!is_file($cachefile) || $action=='update' || ($time && @filemtime($cachefile)+$time<$_S['timestamp'])) {
				$function='get_syscache_'.$cacheid;
				return $function();
			}else{
				include_once $cachefile;
			}
		}else{
			if($_S['uid'] && is_array($cacheid)){
				foreach($cacheid as $k){
					$keyarr[]='\''.$k.'\'';
				}
				$keystr=implode(',',$keyarr);
				$query = DB::query('SELECT * FROM '.DB::table('common_user_cache')." WHERE `uid` ='$_S[uid]' AND `k` IN ($keystr)");
				while($value = DB::fetch($query)) {
					if(!$value['v']){
						$function='get_usercache_'.$value['k'];
						$caches[$value['k']]=self::$function();
					}else{
						$caches[$value['k']]=dunserialize($value['v']);
					}
				}
				return $caches;
			}else{
				return false;
			}			
		}
	}
}

function get_syscache_common(){
	global $_S;
	unset($_S['cache']['common']);
	$query = DB::query("SELECT * FROM ".DB::table('common_cache'));
	while($value = DB::fetch($query)) {
		$_S['cache']['common'][$value['name']]=$value;
	}
	$cache='$_S[\'cache\'][\'common\']='.var_export($_S['cache']['common'],true);
	writefile(ROOT.'./data/cache/sys_common.php', $cache, 'php', 'w', 0);	
}

function get_syscache_smile(){
	global $_S;
	unset($_S['cache']['smiletype']);
	unset($_S['cache']['smiles']);
	$query = DB::query("SELECT * FROM ".DB::table('common_smile_type')." WHERE `canuse` ='1' ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		$_S['cache']['smiletype'][$value['typeid']]=$value;
		$typeids[]=$value['typeid'];
	}
	if($typeids){
		$typestrs=implode(',',$typeids);
		$query = DB::query("SELECT * FROM ".DB::table('common_smile')." WHERE `type` IN($typestrs) ORDER BY list ASC");
		while($value = DB::fetch($query)) {
			$value['pic']=$_S['cache']['smiletype'][$value['type']]['dir'].'/'.$value['pic'];
			$_S['cache']['smiles'][$value['type']][$value['id']]=$value;
		}
	}
	$cache='$_S[\'cache\'][\'smiletype\']='.var_export($_S['cache']['smiletype'],true).';'."\r\n";
	$cache.='$_S[\'cache\'][\'smiles\']='.var_export($_S['cache']['smiles'],true);
	writefile(ROOT.'./data/cache/sys_smile.php', $cache, 'php', 'w', 0);		
}

function get_syscache_hacks(){
	global $_S;
	unset($_S['cache']['hacks']);
	$query = DB::query("SELECT * FROM ".DB::table('common_hack')." WHERE `open` ='1'");
	while($value = DB::fetch($query)) {
		$value['setting']=dunserialize($value['setting']);
		$_S['cache']['hacks'][$value['id']]=$value;
	}
	$cache='$_S[\'cache\'][\'hacks\']='.var_export($_S['cache']['hacks'],true);
	writefile(ROOT.'./data/cache/sys_hacks.php', $cache, 'php', 'w', 0);	

}

function get_syscache_discuz(){
	global $_S;
	unset($_S['cache']['discuz']);
	$caches=array('discuz_common','discuz_wechat','discuz_aliyun','discuz_getrule','discuz_forum');
	$query = DB::query("SELECT * FROM ".DB::table('common_open')." WHERE `cacheid` IN('discuz_common','discuz_wechat','discuz_aliyun','discuz_getrule','discuz_forum')");
	while($value = DB::fetch($query)) {
		$value['content']=$value['content']?dunserialize($value['content']):array();
		$_S['cache']['discuz'][$value['cacheid']]=$value['content'];
	}
  foreach($caches as $id){
		if(!$_S['cache']['discuz'][$id]){
			$_S['cache']['discuz'][$id]=array();
		}
	}
	$cache='$_S[\'cache\'][\'discuz\']='.var_export($_S['cache']['discuz'],true);
	writefile(ROOT.'./data/cache/sys_discuz.php', $cache, 'php', 'w', 0);	

}

function get_syscache_icon(){
	global $_S;
	unset($_S['cache']['icon']);
	
	$query = DB::query("SELECT * FROM ".DB::table('common_icon'));
	while($value = DB::fetch($query)) {
		if($value){
			$_S['cache']['icon'][$value['fid']]=$value;
		}
	}
	
	if($_S['cache']['icon']){
		$cache='$_S[\'cache\'][\'icon\']='.var_export($_S['cache']['icon'],true);
		writefile(ROOT.'./data/cache/sys_icon.php', $cache, 'php', 'w', 0);			
	}


}

function get_syscache_styles(){
	global $_S;
	unset($_S['cache']['styles']);
	$query = DB::query("SELECT * FROM ".DB::table('common_styles')." WHERE `canuse` ='1'");
	while($value = DB::fetch($query)) {
		$value['content']=dunserialize($value['content']);
		$_S['cache']['styles'][$value['styleid']]=$value;
	}
	$cache='$_S[\'cache\'][\'styles\']='.var_export($_S['cache']['styles'],true);
	writefile(ROOT.'./data/cache/sys_styles.php', $cache, 'php', 'w', 0);	

}

function get_syscache_colors(){
	global $_S;
	unset($_S['cache']['colors']);
	$data=DB::fetch_first("SELECT * FROM ".DB::table('common_open')." WHERE `cacheid`='colors'");
	$_S['cache']['colors']=dunserialize($data['content']);
	$cache='$_S[\'cache\'][\'colors\']='.var_export($_S['cache']['colors'],true);
	writefile(ROOT.'./data/cache/sys_colors.php', $cache, 'php', 'w', 0);	
	upcss();

}

function get_syscache_userfield(){
	global $_S;
	unset($_S['cache']['userfield']);
	$data=DB::fetch_first("SELECT * FROM ".DB::table('common_open')." WHERE `cacheid`='userfield'");
	$_S['cache']['userfield']=dunserialize($data['content']);
	foreach($_S['cache']['userfield'] as $field=>$fieldvalue){
		if($fieldvalue['content']){
			foreach(explode("\n", $fieldvalue['content']) as $item) {
				list($id, $value) = explode('=', $item);
				$_S['cache']['userfield'][$field]['choises'][trim($id)] = trim($value);
			}
			unset($_S['cache']['userfield'][$field]['content']);
		}
	}
	
	$cache='$_S[\'cache\'][\'userfield\']='.var_export($_S['cache']['userfield'],true);
	writefile(ROOT.'./data/cache/sys_userfield.php', $cache, 'php', 'w', 0);
}
function get_syscache_usergroup(){
	global $_S;
	unset($_S['cache']['usergroup']);
	$data=DB::fetch_first("SELECT * FROM ".DB::table('common_open')." WHERE `cacheid`='usergroup'");
	$_S['cache']['usergroup']=dunserialize($data['content']);
	$cache='$_S[\'cache\'][\'usergroup\']='.var_export($_S['cache']['usergroup'],true);
	writefile(ROOT.'./data/cache/sys_usergroup.php', $cache, 'php', 'w', 0);
}

function get_syscache_credits(){
	global $_S;
	unset($_S['cache']['credits']);
	$query = DB::query("SELECT * FROM ".DB::table('common_credits'));
	while($value = DB::fetch($query)) {
		$_S['cache']['credits'][$value['cid']]=$value;
	}
	$cache='$_S[\'cache\'][\'credits\']='.var_export($_S['cache']['credits'],true);
	writefile(ROOT.'./data/cache/sys_credits.php', $cache, 'php', 'w', 0);	
}

function get_syscache_spacecover(){
	global $_S;
	unset($_S['cache']['spacecover_type']);
	unset($_S['cache']['spacecover']);
	$query = DB::query("SELECT * FROM ".DB::table('common_spacecover_type')." WHERE `canuse` ='1' ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		$_S['cache']['spacecover_type'][$value['tid']]=$value;
		$typeids[]=$value['tid'];
	}
	if($typeids){
		$typestrs=implode(',',$typeids);
		$query = DB::query("SELECT * FROM ".DB::table('common_spacecover')." WHERE `tid` IN($typestrs) ORDER BY list ASC");
		while($value = DB::fetch($query)) {
			$value['path']=$_S['cache']['spacecover_type'][$value['tid']]['folder'].'/'.$value['path'];
			$_S['cache']['spacecover'][$value['tid']][$value['cid']]=$value;
		}
	}
	$cache='$_S[\'cache\'][\'spacecover_type\']='.var_export($_S['cache']['spacecover_type'],true).';'."\r\n";
	$cache.='$_S[\'cache\'][\'spacecover\']='.var_export($_S['cache']['spacecover'],true);
	writefile(ROOT.'./data/cache/sys_spacecover.php', $cache, 'php', 'w', 0);		
}
function get_syscache_topic_groups(){
	global $_S;
	unset($_S['cache']['topic_groups']);
	unset($_S['cache']['forums']);
	unset($_S['cache']['forumids']);
	$query = DB::query("SELECT * FROM ".DB::table('topic_group')." WHERE `hidden` !='1' ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		$_S['cache']['topic_groups'][$value['gid']]=$value;
		$gids[]=$value['gid'];
	}
	if($gids){
		$gidstrs=implode(',',$gids);
		$query = DB::query("SELECT * FROM ".DB::table('topic')." WHERE `gid` IN($gidstrs) ORDER BY list ASC");
		while($value = DB::fetch($query)) {
			$value['cover']=$value['cover']?$_S['atc'].'/'.$value['cover']:'ui/nocover.jpg';
			$_S['cache']['forums'][$value['tid']]=$value;
			$_S['cache']['forumids'][]=$value['tid'];
		}
	}
	
	$cache='$_S[\'cache\'][\'topic_groups\']='.var_export($_S['cache']['topic_groups'],true).';'."\r\n";
	$cache.='$_S[\'cache\'][\'forums\']='.var_export($_S['cache']['forums'],true).';'."\r\n";
	$cache.='$_S[\'cache\'][\'forumids\']='.var_export($_S['cache']['forumids'],true);
	
	writefile(ROOT.'./data/cache/sys_topic_groups.php', $cache, 'php', 'w', 0);	

}

function get_syscache_topic_types(){
	global $_S;
	unset($_S['cache']['topic_types']);
	$query = DB::query("SELECT * FROM ".DB::table('topic_type')." ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		$_S['cache']['topic_types'][$value['typeid']]=$value;
	}
	$cache='$_S[\'cache\'][\'topic_types\']='.var_export($_S['cache']['topic_types'],true);
	writefile(ROOT.'./data/cache/sys_topic_types.php', $cache, 'php', 'w', 0);	

}


function get_syscache_temp(){
	global $_S;
	unset($_S['cache']['temp']);
	$query = DB::query("SELECT * FROM ".DB::table('common_temp')." WHERE `touch`='1' OR `pc`='1'");
	while($value = DB::fetch($query)) {
		if($value['touch']){
			$_S['cache']['temp']['touch']=$value;
		}
		if($value['pc']){
			$_S['cache']['temp']['pc']=$value;
		}
	}
	$cache='$_S[\'cache\'][\'temp\']='.var_export($_S['cache']['temp'],true);
	writefile(ROOT.'./data/cache/sys_temp.php', $cache, 'php', 'w', 0);	
}

function get_syscache_apps(){
	global $_S;
	unset($_S['cache']['apps']);
	$data=DB::fetch_first("SELECT * FROM ".DB::table('common_open')." WHERE `cacheid`='apps'");
	$_S['cache']['apps']=dunserialize($data['content']);
	$cache='$_S[\'cache\'][\'apps\']='.var_export($_S['cache']['apps'],true);
	writefile(ROOT.'./data/cache/sys_apps.php', $cache, 'php', 'w', 0);	
}

function get_syscache_portals(){
	global $_S;
	unset($_S['cache']['portals']);
	$query = DB::query("SELECT * FROM ".DB::table('portal')." ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		$_S['cache']['portals'][$value['pid']]=$value;
	}
	$cache='$_S[\'cache\'][\'portals\']='.var_export($_S['cache']['portals'],true);
	writefile(ROOT.'./data/cache/sys_portals.php', $cache, 'php', 'w', 0);	
}

function get_syscache_portal_skins(){
	global $_S;
	unset($_S['cache']['portal_skins']);
	$query = DB::query("SELECT * FROM ".DB::table('portal_mods_skin'));
	while($value = DB::fetch($query)) {
		$_S['cache']['portal_skins'][$value['skinid']]=$value;
	}
	$cache='$_S[\'cache\'][\'portal_skins\']='.var_export($_S['cache']['portal_skins'],true);
	writefile(ROOT.'./data/cache/sys_portal_skins.php', $cache, 'php', 'w', 0);	
}

function get_syscache_navs(){
	global $_S;
	unset($_S['cache']['navs']);
	$query = DB::query("SELECT * FROM ".DB::table('common_open')." WHERE cacheid IN('nav_bot','nav_side','nav_find','nav_write')");
	while($value = DB::fetch($query)) {
		$value['content']=dunserialize($value['content']);
		if($value['cacheid']!='nav_find' && $value['cacheid']!='nav_write'){
			foreach($value['content'] as $k=>$nv){
				if(strpos($nv['icon'],'+')==false){
					$value['content'][$k]['icon']='icon '.$nv['icon'];
				}else{
					$v2=explode('+',$nv['icon']);
					$value['content'][$k]['icon']=$v2[0].' '.$v2[1];
				}
			}			
		}

		$_S['cache']['navs'][$value['cacheid']]=$value['content'];
	}
	$cache='$_S[\'cache\'][\'navs\']='.var_export($_S['cache']['navs'],true);
	writefile(ROOT.'./data/cache/sys_navs.php', $cache, 'php', 'w', 0);	

}

function get_syscache_slider(){
	global $_S;
	unset($_S['cache']['slider']);
	$query = DB::query("SELECT * FROM ".DB::table('common_slider')." ORDER BY list ASC");
	while($value = DB::fetch($query)) {
		$_S['cache']['slider'][$value['type']][$value['sid']]=$value;
	}
	$cache='$_S[\'cache\'][\'slider\']='.var_export($_S['cache']['slider'],true);
	writefile(ROOT.'./data/cache/sys_slider.php', $cache, 'php', 'w', 0);	

}

function get_syscache_announcement(){
	global $_S;
	unset($_S['cache']['announcement']);
	$query = DB::query("SELECT * FROM ".DB::table('common_announcement')." ORDER BY aid DESC");
	while($value = DB::fetch($query)) {
		$_S['cache']['announcement'][$value['aid']]=$value;
	}
	$cache='$_S[\'cache\'][\'announcement\']='.var_export($_S['cache']['announcement'],true);
	writefile(ROOT.'./data/cache/sys_announcement.php', $cache, 'php', 'w', 0);	
}

?>