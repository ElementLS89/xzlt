<?php
if(!defined('IN_SMSOT')) {
	exit;
}
function getthemecontent($vid,$ac='view'){
	global $_S;
	$theme=DB::fetch_first("SELECT v.*,c.*,u.username,u.groupid,u.dzuid,f.fuid FROM ".DB::table('topic_themes')." v LEFT JOIN ".DB::table('topic_theme_content')." c ON c.vid=v.vid LEFT JOIN ".DB::table('common_user')." u ON u.uid=v.uid LEFT JOIN ".DB::table('common_follow')." f ON f.fuid=v.uid AND f.uid='$_S[uid]' WHERE v.`vid`='$vid'");
	
	if($theme){
		$theme['content'] = preg_replace(array("#\n\r+#","#\r\n+#","#\n+#"), "\n", $theme['content']);
		$theme['content']=str_replace(array("\n"),array("<br>"),$theme['content']);
		$theme['content'] = preg_replace_callback("/\[h\=(.+?)]/s", 'puttitle', $theme['content']);
		$theme['content'] = preg_replace_callback("/\[img\=(.+?)](.+?)\[\/img]/s", 'putimgs', $theme['content']);
		$theme['content'] = preg_replace_callback("/\[pic\=(.+?)]/s", 'putpics', $theme['content']);
		if($ac=='post'){
			$theme['content'] = preg_replace_callback("/\[video\=(.+?)]/s", 'putvideos_post', $theme['content']);
		}else{
			$theme['content'] = preg_replace_callback("/\[video\=(.+?)]/s", 'putvideos', $theme['content']);
		}
		
		$theme['user']=array('uid'=>$theme['uid'],'dzuid'=>$theme['dzuid']);
		
    $theme['gratuity_money']=$theme['gratuity_money']/100;
		$theme['imgs']=dunserialize($theme['imgs']);
		
		$table='topic_atc_'.substr($vid,-1);

		$query = DB::query("SELECT * FROM ".DB::table($table)." WHERE `vid` ='$vid'");
		while($value = DB::fetch($query)) {
			$value['scaling']=round($value['height']/$value['width'],2);
			if($value['thumb']){
				$value['atc']=$value['atc'].'_thumb.jpg';
			}
			$theme['images'][$value['aid']]=$value;
		}
		return $theme;		
	}else{
		return ;
	}
}

function getmanager($tid){
	$manager=DB::fetch_first("SELECT * FROM ".DB::table('topic_users')." WHERE `tid`='$tid' AND `level`='127' ORDER BY `dateline` ASC");
	if($manager){
		return $manager['uid'];
	}
}

function getpower($topic){
	global $_S;
	
	if($topic['gid']){
		C::chche('topic_groups');
		$group=$_S['cache']['topic_groups'][$topic['gid']];
		if($group['manager']){
			$managers=explode(' ',$group['manager']);
		}
	}
	$canmanage=$_S['usergroup']['power']>5||$topic['level']>125||in_array($_S['member']['username'],$managers)?true:false;
	return $canmanage;
}
function upuserlevel($user,$experience){
	global $_S;

	if($user['level']!=''){
		if($user['level']<12){
			$level=$user['level']+1;
			if($user['experience']+$experience>=$_S['setting']['topicgroup'][$level]['experience']){
				$s['level']=$level;
			}elseif($user['experience']+$experience<$_S['setting']['topicgroup'][$user['level']]['experience']){
				$s['level']=$user['level']-1;
			}
		}
		$s['experience']=$user['experience']+$experience;
		update('topic_users',$s,"uid='$user[uid]' AND tid='$user[tid]'");		
	}

}

function piclist($theme,$w='200',$h='150',$max='9'){
	global $_S,$pics;
	$return='';$i=0;
	foreach($theme['imgs'] as $img){
		if($i<$max){
			if($theme['pics']==1 || $max==1){
				if(PHPSCRIPT=='get'){
					$return='<img src="'.getimg($img['atc'],$w,$h,false,'return').'" class="pic" />';
				}else{
					$return='<img src="ui/sl.png" data-original="'.getimg($img['atc'],$w,$h,false,'return').'" class="pic lazyload" scaling="'.round($h/$w,2).'" />';
				}
				
			}else{
				if(PHPSCRIPT=='get'){
					$return .='<li><div><img src="'.getimg($img['atc'],$w,$h,false,'return').'"/></div></li>';
				}else{
					$return .='<li><div><img src="ui/sl.png" data-original="'.getimg($img['atc'],$w,$h,false,'return').'" class="lazyload" scaling="'.round($h/$w,2).'"/></div></li>';
				}
				
			}
			$i++;				
		}
	}
	echo $return;
}

function watercover($theme){
	global $_S,$pics;
	if($theme['imgs']){
	  $cover=current($theme['imgs']);
		
		$cover['pic']=getimg($cover['atc'],285,9999,true,'return');
		
	}else{
		$cover['pic']='ui/nopic.gif';
		$cover['width']='285';
		$cover['height']='285';
	}
  return $cover;
}
?>