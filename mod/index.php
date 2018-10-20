<?php
if(!defined('IN_SMSOT')) {
	exit;
}

if($_S['mobile'] || $_S['setting']['pc']){
	C::chche('portals');
	$pid=$_GET['pid']=$_GET['pid']?$_GET['pid']:1;
	$portal=$_S['cache']['portals'][$pid];
  
	
	loaddiscuz();

	
	$navtitle=$portal['name']?$portal['name']:'频道不存在';
	if(!$portal){
		showmessage('频道不存在');
	}
	if(!$portal['canuse'] && $_S['usergroup']['power']<6){
		showmessage('频道未开放访问');
	}
	$title=$portal['name'].'-'.$_S['setting']['sitename'];
	$metadescription=$portal['description'];
	$keywords=$portal['name'].','.$metakeywords;
	//shar
	$signature=signature();
	$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';

	$_S['shar']['desc']=$metadescription?$metadescription:$_S['setting']['description'];
	
	$portal['header']=dunserialize($portal['header']);
	$portal['footer']=dunserialize($portal['footer']);
	$portal['url']=$portal['url']?$portal['url']:($pid?'index.php?pid='.$pid:'index.php');
	C::chche('portal_skins');
	
	$query = DB::query("SELECT * FROM ".DB::table('portal_settings')."  WHERE `pid`='$pid' ORDER BY list ASC ");
	while($value = DB::fetch($query)){
		$value['setting']=dunserialize($value['setting']);
		$value['ishack']=$_S['cache']['portal_skins'][$value['skinid']]['ishack'];
		$value['formid']=$_S['cache']['portal_skins'][$value['skinid']]['formid'];
		$value['temp']=$_S['cache']['portal_skins'][$value['skinid']]['temp'];

		if($_S['cache']['portal_skins'][$value['skinid']]['js'] && $value['setting']){
			$modjs[]=$_S['cache']['portal_skins'][$value['skinid']]['js'];
		}elseif($value['setting']['js']){
			$modjs[]=$value['setting']['js'];
		}
		if($value['formid']){
			if($value['ishack']){
				$function[$value['formid']]='./hack/'.$value['formid'].'/getmodvar.php';
				$hackcss[$value['formid']]='./hack/'.$value['formid'].'/style.css?t='.$_S['timestamp'];
			}else{
				$function[$value['formid']]='./include/function_'.$value['formid'].'.php';
			}
			
		}
		$mods[$value['sid']]=$value;
	}
	if($portal['header']['use'] && !$portal['footer']['use']){
		$bodyclass='body_t';
	}elseif(!$portal['header']['use'] && $portal['footer']['use']){
		$bodyclass='body_b';
	}elseif($portal['header']['use'] && $portal['footer']['use']){
		$bodyclass='';
	}else{
		$bodyclass='body_0';
	}
	if($modjs){
		$modjs=implode("\n",$modjs);
	}
	foreach($function as $file){
		require_once $file;
	}
	
	function getportalmod($mod){
		global $_S,$portal;
		
		
		if($mod['mid']=='list' || $_S['page']==1){
			if(!$mod['setting']){
				return;
			}
			if($mod['mid']=='topnv'){
				
				if($mod['setting']['content']['navid']){
					$ids=explode(',',$mod['setting']['content']['navid']);
					$topnav=DB::fetch_first("SELECT * FROM ".DB::table('portal_settings')." WHERE pid='$ids[0]' AND sid='$ids[1]'");
					if($topnav){
						$modvar=dunserialize($topnav['setting']);
					}		
				}else{
					$modvar=$mod['setting'];
				}

			}elseif($mod['mid']=='slider'){
				$modvar=$mod['setting'];
			}elseif($mod['mid']=='apps'){
				if($mod['setting']['nids']){
					$width=round(100/$mod['setting']['row'],2).'%';
					$num=$mod['setting']['row']*2;
					$havepage=count($mod['setting']['nids'])>10?true:false;
					$modvar=$mod['setting']['nids'];
				}
			}elseif($mod['mid']=='ann'){
				if($mod['setting']['aids']){
					C::chche('announcement');
					$modvar=$mod['setting']['aids'];
				}
			}elseif($mod['mid']=='search'){
				$modvar=$mod['setting'];
			}elseif($mod['mid']=='ad'){
				if($mod['temp']=='ad_text'){
					$modvar=array('text'=>$mod['setting']['text'],'url'=>$mod['setting']['url']);
				}else{
					$modvar=array('pic'=>$mod['setting']['pic'],'url'=>$mod['setting']['url']);
				}
			}elseif($mod['mid']=='topic'){
				//ids,form,price,(typeid),size,order
				
				if($mod['setting']['form']=='topic'){
					$sql['select'] = 'SELECT t.*';
					$sql['from'] ='FROM '.DB::table('topic').' t';
					$wherearr[] = "t.state >='0'";
					if($mod['setting']['ids']){
						$tids=$mod['setting']['ids'];
						$wherearr[] = "t.tid IN($tids)";
					}
					if($mod['setting']['price']){
						$wherearr[] = "t.price !='0'";
					}
					if($mod['setting']['typeid']){
						$typeid=$mod['setting']['typeid'];
						$wherearr[] = "t.typeid IN($typeid)";
					}

					if($mod['setting']['order']==1){
						$order='t.themes DESC';
					}else{
						$order='t.users DESC';
					}
					$size=$mod['setting']['size']?$mod['setting']['size']:'10';
					$sql['order']='ORDER BY '.$order;
					$select=select($sql,$wherearr,$size);
					if($select[1]) {
						$query = DB::query($select[0]);
						while($value = DB::fetch($query)){
							$value['cover']=$value['cover']?$_S['atc'].'/'.$value['cover']:'ui/nocover.jpg';
							$ids[$value['tid']]=$value;
						}
					}
				}else{
					$sql['select'] = 'SELECT t.*';
					$sql['from'] ='FROM '.DZ::table('forum_forum').' t';
					$sql['select'] .= ',f.*';
					$sql['left'] .=" LEFT JOIN ".DZ::table('forum_forumfield')." f ON f.fid=t.fid";
					$wherearr[] = "t.type !='group'";
					$wherearr[] = "t.displayorder >='0'";
					if($mod['setting']['ids']){
						$tids=$mod['setting']['ids'];
						$wherearr[] = "t.fid IN($tids)";
					}
					if($mod['setting']['price']){
						$wherearr[] = "f.price !='0'";
					}
					if($mod['setting']['typeid']){
						$typeid=$mod['setting']['typeid'];
						$wherearr[] = "f.fup IN($typeid)";
					}

					if($mod['setting']['order']==1){
						$order='t.threads DESC';
					}else{
						$order='t.favtimes DESC';
					}
					$size=$mod['setting']['size']?$mod['setting']['size']:'10';
					$sql['order']='ORDER BY '.$order;
					$select=select($sql,$wherearr,$size,2);
					if($select[1]) {
						$query = DZ::query($select[0]);
						while($value = DZ::fetch($query)){
							$value['icon']=$value['icon']?(strstr($value['icon'],'://')?$value['icon']:$_S['dz']['atc'].'common/'.$value['icon']):$_S['atc'].'/static/nocover.png';
							$ids[$value['fid']]=$value;
						}
					}
				}
				$modvar=array('ids'=>$ids,'form'=>$mod['setting']['form'],'name'=>$mod['setting']['name'],'url'=>$mod['setting']['url']);
			}elseif($mod['mid']=='users'){
				//uids,form,gid,size,order
				$size=$mod['setting']['size']?$mod['setting']['size']:'10';
				$uids=$mod['setting']['uids'];

					
				if($mod['setting']['form']=='discuz'){
					$sql['select'] = 'SELECT u.*';
					$sql['from'] ='FROM '.DZ::table('common_member').' u';
					$wherearr[] = "u.status >='0'";
					if($uids){
						$wherearr[] = "u.uid IN($uids)";
					}
					if($mod['setting']['gid']){
						$gid=$mod['setting']['gid'];
						$wherearr[] = "u.groupid IN($gid)";
					}
					$sql['select'] .= ',c.*';
					$sql['left'] .=" LEFT JOIN ".DZ::table('common_member_count')." c ON c.uid=u.uid";
					$sql['select'] .= ',p.*';
					$sql['left'] .=" LEFT JOIN ".DZ::table('common_member_profile')." p ON p.uid=u.uid";
					if($mod['setting']['order']==1){
						$order='c.follower DESC';
					}elseif($mod['setting']['order']==2){
						$order='u.credits DESC';
					}else{
						$order='u.regdate DESC';
					}
					$sql['order']='ORDER BY '.$order;
					$select=select($sql,$wherearr,$size,2);
					if($select[1]) {
						$query = DZ::query($select[0]);
						while($value = DZ::fetch($query)){
							$value['age']=$value['birthyear']?smsdate($_S['timestamp'],'Y')-$value['birthyear']:'';
							if($value['gender']==1){
								$value['gender']='icon-male';
							}elseif($value['gender']==2){
								$value['gender']='icon-female';
							}
							$users[$value['uid']]=$value;
						}
					}
				}else{
					$sql['select'] = 'SELECT u.*';
					$sql['from'] ='FROM '.DB::table('common_user').' u';
					$wherearr[] = "u.state ='1'";
					if($uids){
						$wherearr[] = "u.uid IN($uids)";
					}
					if($mod['setting']['gid']){
						$gid=$mod['setting']['gid'];
						$wherearr[] = "u.groupid IN($gid)";
					}
					$sql['select'] .= ',c.*';
					$sql['left'] .=" LEFT JOIN ".DB::table('common_user_count')." c ON c.uid=u.uid";
					$sql['select'] .= ',p.*';
					$sql['left'] .=" LEFT JOIN ".DB::table('common_user_profile')." p ON p.uid=u.uid";
					if($mod['setting']['order']==1){
						$order='c.fans DESC';
					}elseif($mod['setting']['order']==2){
						$order='c.experience DESC';
					}else{
						$order='u.regdate DESC';
					}
					$sql['order']='ORDER BY '.$order;
					$select=select($sql,$wherearr,$size);
					if($select[1]) {
						$query = DB::query($select[0]);
						while($value = DB::fetch($query)){
							$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
							$value['age']=$value['birthday']?smsdate($_S['timestamp'],'Y')-smsdate($value['birthday'],'Y'):'';
							if($value['gender']==1){
								$value['gender']='icon-male';
							}elseif($value['gender']==2){
								$value['gender']='icon-female';
							}
							$users[$value['uid']]=$value;
						}
					}
				}
				$modvar=array('users'=>$users,'form'=>$mod['setting']['form'],'name'=>$mod['setting']['name'],'url'=>$mod['setting']['url']);

				
			}elseif($mod['mid']=='html'){
				$modvar=$mod['setting']['html'];
			}else{
				
				$function='getmodvar_'.$mod['formid'];

				$paramarr = array();
				$sarr = explode('/', $mod['setting']['param']);
				if(count($sarr)%2 != 0) $sarr = array_slice($sarr, 0, -1);
				for($i=0; $i<count($sarr); $i=$i+2) {
					if(!empty($sarr[$i+1])) $paramarr[$sarr[$i]] = addslashes(str_replace(array('/', '\\'), '', rawurldecode(stripslashes($sarr[$i+1]))));
				}
				if($paramarr['form']=='discuz' && $mod['mid']=='list' && $paramarr['sortid']){
			    $mod['temp']='list_sorts';
		    }				
		    if($paramarr){
					$modvar=$function($paramarr,$mod['mid']);
				}
				$modvar['name']=$mod['setting']['name'];
				$modvar['url']=$mod['setting']['url'];
				

			}
			$modstyle='';
			if($mod['bot']){
				$modstyle .='margin-bottom:'.$mod['bot'].'px;';
			}
			if($mod['top']){
				$modstyle .='margin-top:'.$mod['top'].'px;';
			}
			$temodir=$mod['ishack']?$mod['formid'].':'.$mod['temp']:'portal/'.$mod['temp'];
			
			include temp($temodir,false);
		}
	}

	function getmodvar_topic($paramarr,$mid){
		global $_S,$portal;

		$sql = array();
		$wherearr = array();
		if($paramarr['form']=='discuz'){
			if($_S['discuz']){
				$sql['select'] = 'SELECT v.*';
				$sql['from'] ='FROM '.DZ::table('forum_thread').' v';
				
				$wherearr[] = "v.displayorder >=0";
				
				/*uid*/
				if($paramarr['uid']){
					$wherearr[] = 'v.authorid IN ('.$paramarr['uid'].')';
				}
				/*fid*/
				if($paramarr['tid']){
					$wherearr[] = 'v.fid IN ('.$paramarr['tid'].')';
				}
				/*tid*/
				if($paramarr['vid']){
					$wherearr[] = 'v.tid IN ('.$paramarr['vid'].')';
				}
				/*pic*/
				if($paramarr['pic']){
					$wherearr[] = "v.attachment ='2'";
				}
				/*best*/
				if($paramarr['best']){
					$wherearr[] = "v.digest IN(1,2,3)";
				}
				/*top*/
				if($paramarr['top']){
					$wherearr[] = "v.displayorder IN(1,2,3)";
				}
				/*typeid*/
				if($paramarr['typeid']){
					$wherearr[] = 'v.typeid IN ('.$paramarr['typeid'].')';
				}
				/*sortid*/
				if($paramarr['sortid']){
					$wherearr[] = 'v.sortid IN ('.$paramarr['sortid'].')';
				}
				/*k*/
				if($paramarr['k']){
					$wherearr[] = 'v.subject LIKE'."'%$paramarr[k]%'";
				}
				/*dateline*/
				if($paramarr['dateline']){
					$dateline=$_S['timestamp']-$paramarr['dateline'];
					$wherearr[] = "v.`dateline` >'$dateline'";
				}
				/*praise*/
				if($paramarr['praise']){
					$wherearr[] = "v.`recommend_add` !='0'";
				}
				if($_S['cache']['discuz']['discuz_common']['webpic']){
					$sql['select'] .= ',p.`pid`,p.`message`';
					$sql['left'] .=" LEFT JOIN ".DZ::table('forum_post')." p ON p.`tid`=v.`tid` AND p.first='1'";					
				}

				if(!empty($paramarr['order'])) {
					$od=explode(" ",$paramarr['order']);
					$sc=$paramarr['sc']?$paramarr['sc']:'DESC';
					$odsc=$od[0].' '.$sc;
					
					if($odsc=='v.replys DESC'){
						$order='v.replies DESC';
					}elseif($odsc=='v.praise DESC'){
						$order='v.recommend_add DESC';
					}elseif($odsc=='v.gratuity_money DESC'){
						$order='v.dateline DESC';
					}elseif($odsc=='v.gratuity_number DESC'){
						$order='v.dateline DESC';
					}else{
						$order=$odsc;
					}
					$sql['order'] = 'ORDER BY '.$order;
				}else{
					$sql['order'] = 'ORDER BY v.dateline DESC';
				}
				$paramarr['size']=$paramarr['size']?$paramarr['size']:'10';

        $select=select($sql,$wherearr,$paramarr['size'],2);

				if($select[1]) {
					$query = DZ::query($select[0]);
					while($value = DZ::fetch($query)){
						if($value['attachment']=='2'){
							$pictab[]='forum_attachment_'.substr($value['tid'], -1);
							$tids[]=$value['tid'];
						}else{
							if(strpos($value['message'], '[/img]') !== FALSE) {
								preg_match_all('/\[img[^\]]*\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is', $value['message'], $matches);
								if(isset($matches[1])){
									$value['imgs']=$matches[1];
								}
							}				
						}
						$value['url']='discuz.php?mod=view&tid='.$value['tid'];
						$value['uid']=$value['authorid'];
						$value['username']=$value['author'];
						$value['name']=$_S['cache']['discuz_forum'][$value['fid']]['name'];
						$value['replys']=$value['replies'];
						$value['topic_url']='discuz.php?mod=forum&fid='.$value['fid'];
						$value['user_url']='user.php?dzuid='.$value['uid'];
						$list[$value['tid']]=$value;
					}
				}
				
				if($tids && $paramarr['sortid']){
					$tidstr=implode(',',$tids);
					$query=DZ::query("SELECT * FROM ".DZ::table('forum_typeoptionvar')." WHERE tid IN($tidstr)");
					while($value = DZ::fetch($query)){
						if($_S['cache']['discuz_typeoption'][$value['optionid']]['type']=='checkbox'){
							$value['value']=explode("\t",$value['value']);
						}
						$sorts[$value['tid']][$value['optionid']]=$value;
					}
				}
				
			}
		}else{
			
			C::chche('topic_groups');
			$tids=implode(',',$_S['cache']['forumids']);	
			$sql['select'] = 'SELECT v.*';
			$sql['from'] ='FROM '.DB::table('topic_themes').' v';
			
			
			/*uid*/
			if($paramarr['uid']){
				$wherearr[] = 'v.uid IN ('.$paramarr['uid'].')';
			}
			/*tid*/
			if($paramarr['tid']){
				$wherearr[] = 'v.tid IN ('.$paramarr['tid'].')';
			}
			/*vid*/
			if($paramarr['vid']){
				$wherearr[] = 'v.vid IN ('.$paramarr['vid'].')';
			}
			/*form*/
			if($paramarr['form']=='forum'){
				$wherearr[] = 'v.tid IN ('.$tids.')';
			}elseif($paramarr['form']=='topic'){
				$wherearr[] = "v.tid != '0'";
				$wherearr[] = 'v.tid NOT IN ('.$tids.')';
			}elseif($paramarr['form']=='group'){
				$wherearr[] = "v.tid = '0'";
			}
			/*pic*/
			if($paramarr['pic']){
				$wherearr[] = "v.`imgs` !=''";
			}
			/*video*/
			if($mid=='video'){
				$wherearr[] = "v.`video` !=''";
			}
			/*best*/
			if($paramarr['best']){
				$wherearr[] = "v.`best` !='0'";
			}
			/*top*/
			if($paramarr['top']){
				$wherearr[] = "v.`top` >'0'";
			}else{
				$wherearr[] = "v.`top` >='0'";
			}
			/*nearby*/
			if($paramarr['nearby']){
				if($_S['uid']){
					$city=$_S['member']['city'];
				}else{
					$_S['cookie']['lbs']=getcookies('lbs');
					
					if($_S['cookie']['lbs']){
						$lbs=dunserialize($_S['cookie']['lbs']);
						$city=$lbs['city'];
					}
				}
				if($city){
					$wherearr[] = 'v.lbs LIKE'."'%$city%'";
				}
			}
			/*lbs*/
			if($paramarr['lbs']){
				$wherearr[] = 'v.lbs LIKE'."'%$city%'";
			}
			/*k*/
			if($paramarr['k']){
				$wherearr[] = 'v.subject LIKE'."'%$paramarr[k]%'";
			}
			/*dateline*/
			if($paramarr['dateline']){
				$dateline=$_S['timestamp']-$paramarr['dateline'];
				$wherearr[] = "v.`dateline` >'$dateline'";
			}
			/*praise*/
			if($paramarr['praise']){
				$wherearr[] = "v.`praise` !='0'";
			}
			/*gratuity*/
			if($paramarr['gratuity']){
				$wherearr[] = "v.`gratuity_number` !='0'";
			}
		
			$sql['select'] .= ',u.`username`,u.`groupid`,u.`dzuid`';
			$sql['left'] .=" LEFT JOIN ".DB::table('common_user')." u ON u.`uid`=v.`uid`";
		
			$sql['select'] .= ',t.`name`';
			$sql['left'] .=" LEFT JOIN ".DB::table('topic')." t ON t.`tid`=v.`tid`";
			
			if(!empty($paramarr['order'])) {
				$od=explode(" ",$paramarr['order']);
				$sc=$paramarr['sc']?$paramarr['sc']:'DESC';
				$odsc=$od[0].' '.$sc;				
				if($odsc=='v.lastpost DESC'){
					$sql['order'] = 'ORDER BY v.dateline DESC';
				}else{
					$sql['order'] = 'ORDER BY '.$odsc;
				}
			}else{
				$sql['order'] = 'ORDER BY v.dateline DESC';
			}

			$paramarr['size']=$paramarr['size']?$paramarr['size']:'10';
			$select=select($sql,$wherearr,$paramarr['size']);

			if($select[1]) {
				
				$query = DB::query($select[0]);
				
				while($value = DB::fetch($query)){
					if($value['username']){
						$value['user']=array('uid'=>$value['uid'],'dzuid'=>$value['dzuid']);
						$value['imgs']=dunserialize($value['imgs']);
						$value['pics']=count($value['imgs']);
						$value['topic']=$value['name'];
						$value['topic_url']='topic.php?tid='.$value['tid'];
						$value['url']='topic.php?vid='.$value['vid'];
						$value['user_url']='user.php?uid='.$value['uid'];
						$list[$value['vid']]=$value;	
					}
				}
				
			}
			
		}
		$maxpage = @ceil($select[1]/10);
		$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
		if($portal['pid']!=1){
			$nexturl = 'index.php?pid='.$portal['pid'].'&page='.$nextpage;
		}else{
			$nexturl = 'index.php?page='.$nextpage;
		}	
		
		return array('list'=>$list,'sorts'=>$sorts,'maxpage'=>$maxpage,'nextpage'=>$nextpage,'nexturl'=>$nexturl,'pictab'=>$pictab,'tids'=>$tids);
		
	}		
	include temp('mod_index',false);	
}else{
	include temp('index');	
}

?>