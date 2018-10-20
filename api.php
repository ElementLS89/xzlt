<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
define('PHPSCRIPT', 'api');

require_once './config.php';
require_once './include/core.php';
require_once './include/json.php';
require_once './include/function.php';

$S = new S();
$S -> star(1,true);

if(function_exists('file_get_contents')){
	$data=file_get_contents("php://input");
}else{
	$data=$GLOBALS["HTTP_RAW_POST_DATA"];
}

if($data){
	$data=JSON::decode($data);
	if($_S['setting']['authkey']!=$data['apikey']){
		exit;
	}
	if($data['hack']){
		require_once './hack/'.$data['hack'].'/api.php';
	}else{
		/*发现图标*/
		if($data['cacheid']=='nav_find' || $data['cacheid']=='nav_write'){
			require_once './include/image.php';
			foreach($data['content'] as $nv){
				if(strstr($nv['icon'],'://')){
					$data['content'][$nv['nid']]['icon']=makelocal($nv['icon'],'open');
				}
			}
		}
		/*广告图片&&幻灯图片*/
		if($data['param']['type']!='mods'){
			if($data['param']['skinid']==1 || $data['param']['skinid']==3){
				require_once './include/image.php';
				$data['content']['setting']=dunserialize($data['content']['setting']);
				if($data['param']['skinid']==1){
					if(strstr($data['content']['setting']['pic'],'://')){
						$data['content']['setting']['pic']=makelocal($data['content']['setting']['pic'],'open');
					}
				}else{
					foreach($data['content']['setting']['content'] as $id=> $value){
						if(strstr($value['pic'],'://')){
							$data['content']['setting']['content'][$id]['pic']=makelocal($value['pic'],'open');
						}
					}				
				}
				$data['content']['setting']=dserialize($data['content']['setting']);
			}			
		}

		if(in_array($data['api'],array('navs','apps','colors','usergroup','userfield','discuz'))){
			$content=dserialize($data['content']);
			$cacheid=$data['cacheid'];
			DB::query("REPLACE INTO ".DB::table('common_open')." (`cacheid`,`content`) VALUES ('$cacheid','$content')");
			C::chche($data['api'],'update');
			
		}elseif($data['api']=='portal'){

			if($data['param']['type']=='portal'){
				if($data['param']['ac']=='add'){
					insert('portal',$data['content']);
					C::chche('portals','update');
				}elseif($data['param']['ac']=='manage'){
					if($data['param']['del']){
						$pids=implode(',',$data['param']['del']);
						DB::query("DELETE FROM ".DB::table('portal')." WHERE `pid` IN($pids)");
						DB::query("DELETE FROM ".DB::table('portal_settings')." WHERE `pid` IN($pids)");
					}
					foreach($data['content'] as $pid => $post){
						update('portal',$post,"pid='$pid'");
					}
					C::chche('portals','update');
				}else{
					$pid=$data['content']['pid'];
					unset($data['content']['pid']);
					update('portal',$data['content'],"pid='$pid'");
				}
				C::chche('portals','update');
			}elseif($data['param']['type']=='set'){
				
				if($data['param']['ac']=='add'){
					insert('portal_settings',$data['content']);
				}elseif($data['param']['ac']=='del'){
					$pid=$data['param']['pid'];
					$sid=$data['param']['sid'];
					
          DB::query("DELETE FROM ".DB::table('portal_settings')." WHERE `pid` ='$pid' AND sid='$sid'");
				}elseif($data['param']['ac']=='style'){
					$pid=$data['param']['pid'];
					$sid=$data['param']['sid'];
					update('portal_settings',$data['content'],"pid='$pid' AND sid='$sid'");					
				}elseif($data['param']['ac']=='set'){
					$pid=$data['param']['pid'];
					$sid=$data['param']['sid'];
					update('portal_settings',$data['content'],"pid='$pid' AND sid='$sid'");		
				}else{
					$pid=$data['param']['pid'];
					foreach($data['content'] as $list=>$sid){
						update('portal_settings',array('list'=>$list),"pid='$pid' AND sid='$sid'");
					}
				}
			}elseif($data['param']['type']=='clear'){
				$pid=$data['content']['pid'];
				DB::query("DELETE FROM ".DB::table('portal_settings')." WHERE `pid` ='$pid'");
			}elseif($data['param']['type']=='mods'){
				if($data['param']['ac']=='add'){
					insert('portal_mods_skin',$data['content']);
				}elseif($data['param']['ac']=='edit'){
					$skinid=$data['param']['skinid'];

					
					update('portal_mods_skin',$data['content'],"skinid='$skinid'");
				}elseif($data['param']['ac']=='del'){
					if($data['content']){
						$skinid=implode(',',$data['content']);
						DB::query("DELETE FROM ".DB::table('portal_mods_skin')." WHERE `skinid` IN($skinid)");
					}
				}
				C::chche('portal_skins','update');
			}
		}elseif($data['api']=='websocket'){
			foreach($data['content'] as $fild=>$value){
				DB::query("REPLACE INTO ".DB::table('common_setting')."(k, v) VALUES ('$fild', '$value')");
			}
			upsetting();
		}elseif($data['api']=='topic'){
			foreach($data['content'] as $fild=>$value){
				if($fild=='topicgroup'){
					$value=dserialize($value);
				}
				DB::query("REPLACE INTO ".DB::table('common_setting')."(k, v) VALUES ('$fild', '$value')");
			}
			upsetting();
		}elseif($data['api']=='regsite'){
			DB::query("REPLACE INTO ".DB::table('common_setting')."(k, v) VALUES ('openid', '$data[openid]')");
			upsetting();
		}
	}
}else{
	header('Content-type: application/json');		
	if($_GET['ac']=='verification'){
		if($_GET['admin'] && $_GET['pass']){
			$user=DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$_GET[admin]'");
			if(!$user){
				$setting=JSON::encode(array('error'=>'管理员账号不存在'));
			}elseif($user['password']!=md5(md5($_GET['pass']).$user['salt'])){
				$setting=JSON::encode(array('error'=>'管理员密码错误'));
			}else{
				$setting=JSON::encode($_S['setting']);			
			}
		}
		echo $setting;
	}else{
		if($_S['setting']['authkey']!=$_GET['apikey']){
			$error=JSON::encode(array('error'=>'通信失败'));
			echo $error;
		}else{
			if($_GET['hack']){
				require_once './hack/'.$_GET['hack'].'/api.php';
			}else{
				if($_GET['ac']=='ann'){
					$query = DB::query("SELECT aid,subject FROM ".DB::table('common_announcement')." ORDER BY aid DESC");
					while($value = DB::fetch($query)) {
						$anns[$value['aid']]=$value;
					}
					$anns=JSON::encode($anns);
					echo $anns;
				}elseif($_GET['ac']=='mods'){
					$mods=dunserialize($_S['setting']['mods']);
					$mods=JSON::encode($mods);
					echo $mods;
				}elseif($_GET['ac']=='synchronization'){
					if(in_array($_GET['data'],array('navs','apps','colors','usergroup','userfield','discuz'))){
						C::chche($_GET['data']);
						$data=JSON::encode($_S['cache'][$_GET['data']]);
					}elseif($_GET['data']=='portal_set'){
						/*sets*/
						$query = DB::query("SELECT * FROM ".DB::table('portal_settings')." WHERE pid='$_GET[pid]' ORDER BY list ASC");
						while($value = DB::fetch($query)) {
							$portalsets[$value['sid']]=$value;
						}
						$data=JSON::encode($portalsets);
					}elseif($_GET['data']=='portal'){
						/*mods*/
						$query = DB::query("SELECT * FROM ".DB::table('portal_mods'));
						while($value = DB::fetch($query)) {
							$portalmods[$value['mid']]=$value;
						}
						
						C::chche('portals');
						C::chche('portal_skins');
						$data=JSON::encode(array('portal'=>$_S['cache']['portals'],'portal_mods'=>$portalmods,'portal_mods_skin'=>$_S['cache']['portal_skins']));
					}elseif($_GET['data']=='portal_mod'){
						/*mods*/
						$query = DB::query("SELECT * FROM ".DB::table('portal_mods'));
						while($value = DB::fetch($query)) {
							$portalmods[$value['mid']]=$value;
						}
						C::chche('portal_skins');
						$data=JSON::encode(array('portal_mods'=>$portalmods,'portal_mods_skin'=>$_S['cache']['portal_skins']));
					}elseif($_GET['data']=='topic'){
						$topic=array(
							'topicgroup'=>dunserialize($_S['setting']['topicgroup']),
							'topiccreat'=>$_S['setting']['topiccreat'],
							'replyshow'=>$_S['setting']['replyshow'],
						);
						$data=JSON::encode($topic);
					}elseif($_GET['data']=='websocket'){
						$websocket=array(
							'protocol'=>$_S['setting']['protocol'],
							'wsip'=>$_S['setting']['wsip'],
							'wsport'=>$_S['setting']['wsport'],
							'wscount'=>$_S['setting']['wscount'],
							'wslanip'=>$_S['setting']['wslanip'],
							'wsstartport'=>$_S['setting']['wsstartport'],
							'wsregister'=>$_S['setting']['wsregister'],
						);
						$data=JSON::encode($websocket);
					}
				}				
			}
			echo $data;
		}
	}
}
?>