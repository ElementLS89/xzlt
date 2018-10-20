<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$navtitle='Smsot管理后台';

$menus=array(
  'index'=>array('用户管理','admin.php?mod='.$_GET['mod'].'&item=index'),
	'add'=>array('添加用户','admin.php?mod='.$_GET['mod'].'&item=add'),
	'member'=>array('用户组','admin.php?mod='.$_GET['mod'].'&item=member'),
	'field'=>array('用户字段','admin.php?mod='.$_GET['mod'].'&item=field'),
	'review'=>array('审核用户','admin.php?mod='.$_GET['mod'].'&item=review'),
);
if(in_array($_GET['item'],array('add','edit'))){
	if($_GET['uid']){
		require_once './include/function_user.php';
		C::chche('userfield');;
		$user=getuser(array('common_user','common_user_count','common_user_profile','common_user_setting'),trim($_GET['uid']));
		if(!$user){
			showmessage('用户不存在');
		}
	}	
	if(checksubmit('submit')){
		if($_FILES['avatar']['name']){
			require_once './include/upimg.php';
			$file=$_FILES['avatar'];
			$upload = new upload();
			$file['ext'] = $upload->fileext($file['name']);
			!$upload->is_image_ext($file['ext']) && showmessage('上传的不是图片');
			$upload->type = 'avatar';
			$upload->extid = $user['uid'];
			$upload->init($file,$upload->type, $upload->extid);
			if(!$upload->save()) {
				showmessage($upload->errormessage());
			}
			$img = new image;
			$folder=array();
			$folder[0]=ceil($user['uid']/1000000);
			$folder[1]=ceil($user['uid']/10000);
			$folder[2]=ceil($user['uid']/100);
			$avatar='avatar/'.$folder[0].'/'.$folder[1].'/'.$folder[2].'/'.$user['uid'];
			$img->Thumb($upload->attach['target'],$avatar.'_1.jpg',64, 64, 'fixwr');
			$img->Thumb($upload->attach['target'],$avatar.'_2.jpg',96, 96, 'fixwr');
			$img->Thumb($upload->attach['target'],$avatar.'_3.jpg',200, 200, 'fixwr');
		}
		$s['groupid']=$_GET['groupid'];
		$s['username']=stringvar($_GET['username'],'16');
		
					
		if($_GET['password']!=''){
			if($user){
				$s['password']=md5(md5($_GET['password']).$user['salt']);
			}else{
				$s['salt']=substr(uniqid(rand()), -6);
				$s['regip']=$s['lastip']=get_client_ip();
				$s['regdate']=$s['lastactivity']=$_S['timestamp'];
				$s['password']=md5(md5($_GET['password']).$s['salt']);
			}
		}
		if($user){
			$s['email']=trim($_GET['email']);
			$s['tel']=trim($_GET['tel']);
			$s['dzuid']=trim($_GET['dzuid']);
			$s['openid']=trim($_GET['openid']);
			$s['mini']=trim($_GET['mini']);
			
			$count['follow']=abs(intval($_GET['follow']));
			$count['fans']=abs(intval($_GET['fans']));
			$count['balance']=abs(intval($_GET['balance']))*100;
			$count['gold']=abs(intval($_GET['gold']));
			$count['experience']=abs(intval($_GET['experience']));
			foreach($_S['cache']['userfield'] as $field=>$value){
				if($value['canuse']){
					if($value['type']=='text' || $value['type']=='textarea'){
						if($value['max']){
							$profile[$field]=stringvar($_GET[$field],$value['max']);
						}else{
							$profile[$field]=trim($_GET[$field]);
						}
					}elseif($value['type']=='number'){
						$profile[$field]=abs(intval($_GET[$field]));
					}elseif(in_array($value['type'],array('radio','select'))){
						$profile[$field]=$_GET[$field];
					}elseif($value['type']=='checkbox'){
						$profile[$field]=$_GET[$field]?implode(',',$_GET[$field]):'';
					}elseif($value['type']=='date'){
						$profile[$field]=$_GET[$field]?strtotime($_GET[$field]):'';
					}elseif($value['type']=='file'){
						if($_FILES[$field]['name']){
							$file = upload_img($_FILES[$field],'common',$value['width'],$value['height']);
							$profile[$field]=$file['attachment'].($file['thumb']?'_'.$value['width'].'_'.$value['height'].'.jpg':'');
						}
					}
				}
			}
			
			$profile['lat']=trim($_GET['lat']);
			$profile['lng']=trim($_GET['lng']);
			$profile['geohash']=trim($_GET['geohash']);
			$profile['nation']=trim($_GET['nation']);
			$profile['province']=trim($_GET['province']);
			$profile['city']=trim($_GET['city']);
			$profile['district']=trim($_GET['district']);
			$profile['addr']=trim($_GET['addr']);
			
			$setting['lbs']=$_GET['lbs'];
			$setting['profile']=$_GET['profile'];
			$setting['pm']=$_GET['pm'];
			$setting['friend']=$_GET['friend'];
			$setting['circle']=$_GET['circle'];
				
		}
		if(!$s['username']){
			showmessage('用户名没有填写');
		}
		if($user){
			if($s['username']!=$user['username'] && DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$s[username]'")){
				showmessage('用户名已存在');
			}
			if($count['balance']/100!=$user['balance']){
        $arose['balance']=($count['balance']/100-$user['balance'])*100;
				$relation=serialize(array());
				$lid=makeid();
				insert('common_user_count_log',array('lid'=>$lid,'uid'=>$_GET['uid'],'fild'=>'balance','arose'=>$arose['balance'],'title'=>'管理员修改','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
			}
			if($count['gold']!=$user['gold']){
        $arose['gold']=$count['gold']-$user['gold'];
				$relation=serialize(array());
				$lid=makeid();
				insert('common_user_count_log',array('lid'=>$lid,'uid'=>$_GET['uid'],'fild'=>'gold','arose'=>$arose['gold'],'title'=>'管理员修改','relation'=>$relation,'state'=>'1','logtime'=>$_S['timestamp']),true);
			}
			update('common_user',$s,"uid='$_GET[uid]'");
			update('common_user_count',$count,"uid='$_GET[uid]'");
			update('common_user_profile',$profile,"uid='$_GET[uid]'");
			update('common_user_setting',$setting,"uid='$_GET[uid]'");

			$ref=$_GET['ref']?$_GET['ref']:'admin.php?mod='.$_GET['mod'].'&item=index';
			showmessage('用户编辑成功',$_GET['ref']);		
		}else{
			if(DB::fetch_first("SELECT * FROM ".DB::table('common_user')." WHERE username='$s[username]'")){
				showmessage('用户名已存在');
			}			
			if(!$_GET['password']){
				showmessage('没有设置密码');
			}
			$uid=insert('common_user',$s);
			insert('common_user_count',array('uid'=>$uid));
			insert('common_user_profile',array('uid'=>$uid));
			insert('common_user_setting',array('uid'=>$uid));
			showmessage('用户添加成功','admin.php?mod='.$_GET['mod'].'&item=index');		
		}
	}
	
}else{
	require_once './include/function_user.php';
	C::chche('userfield');
  
	$urlstr='admin.php?mod='.$_GET['mod'].'&item='.$_GET['item'];
	foreach($_GET as $key => $value){
		if(!in_array($key,array('mod','item','search','field'))){
			$urlstr.='&'.$key.'='.$value;
		}
		if(in_array($key,array('search','field'))){
			foreach($value as $k=>$v){
				if(is_array($v)){
					foreach($v as $vv){
						$urlstr.='&'.$key.'['.$k.']'.'[]='.$vv;
					}
				}else{
					$urlstr.='&'.$key.'['.$k.']'.'='.$v;
				}
			}
		}
	}
	
	if($_GET['searchsubmit'] || $_GET['item']=='review'){
		$sql['select'] = 'SELECT u.*';
		$sql['from'] =' FROM '.DB::table('common_user').' u';
		foreach($_GET['search'] as $k=>$get){
			$g[$k]=trim($get);
		}
		
		if($g['username']!=''){
			$wherearr[] = 'u.username LIKE'."'%$g[username]%'";		
		}
		if($g['groupid']!=''){
			$wherearr[] = "u.groupid ='$g[groupid]'";
		}
		if($g['state']!='-1'){
			$wherearr[] = "u.state ='$g[state]'";
		}
		if($_GET['item']=='review'){
			$wherearr[] = "u.state ='0'";
		}
		if($g['openid']!='-1'){
			if($g['openid']=='0'){
				$wherearr[] = "u.openid =''";
			}else{
				$wherearr[] = "u.openid !=''";
			}
		}
		if($g['telnum']){
			$wherearr[] = 'u.tel LIKE'."'%$g[telnum]%'";		
		}else{
			if($g['tel']!='-1'){
				if($g['tel']=='0'){
					$wherearr[] = "u.tel =''";
				}else{
					$wherearr[] = "u.tel !=''";
				}
			}			
		}

	
		foreach($_GET['field'] as $k=>$get){
			if(is_array($get)){
				foreach($get as $i=>$v){
					$f[$k][$i]=trim($v);
				}
			}else{
				$f[$k]=trim($get);
			}
		}
		$sql['select'] .= ',p.*';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user_profile')." p ON p.uid=u.uid";
		foreach($_S['cache']['userfield'] as $field=>$value){
			if($value['canuse']){
				if($value['type']=='date'){
					if($f[$field][0]!=''){
						$d1=strtotime($f[$field][0]);
						$wherearr[] = "p.$field >'$d1'";
					}
					if($f[$field][1]!=''){
						$d2=strtotime($f[$field][1]);
						$wherearr[] = "p.$field >'$d2'";
					}
				}elseif($value['type']=='number'){
					if($f[$field][0]!=''){
						$n1=$f[$field][0];
						$wherearr[] = "p.$field >'$n1'";
					}
					if($f[$field][1]!=''){
						$n2=$f[$field][1];
						$wherearr[] = "p.$field >'$n2'";
					}
				}elseif(in_array($value['type'],array('text','textarea','file'))){
					if($f[$field]!=''){
						if($f[$field]=='0'){
							$wherearr[] = "p.$field =''";
						}else{
							$wherearr[] = "p.$field !=''";
						}
					}
				}elseif($value['type']=='checkbox'){
					if($f[$field]!=''){
						$wherearr[] = "p.$field LIKE"."'%$f[$field]%'";
					}
				}else{
					if($f[$field]!=''){
						$wherearr[] = "p.$field ='$f[$field]'";
					}
				}
			}
		}
		$sql['select'] .= ',c.*';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user_count')." c ON c.uid=u.uid";
		
		$sql['order']='ORDER BY u.lastactivity DESC';	
		$select=select($sql,$wherearr,30);

		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				if($value['balance']){
					$value['balance']=$value['balance']/100;
				}
				if($value['interest']){
					$value['interest']=explode(',',$value['interest']);
				}
				$list[$value['uid']]=$value;
			}
		}
    $ref=urlencode($urlstr);
		$pages=page($select[1],30,$_S['page'],$urlstr);

		if($_POST['deletesubmit'] || $_POST['examinesubmit']){
			$uids=implode(',',$_GET['uid']);
			if($_POST['deletesubmit']){
				chechdelete();
				DB::query("DELETE FROM ".DB::table('common_user')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('common_user_count')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('common_user_count_log')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('common_user_profile')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('common_user_setting')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('common_mini')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('topic_users')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('topic_themes')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('topic_illustration')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('topic_video')." WHERE `uid` IN($uids)");
				DB::query("DELETE FROM ".DB::table('common_record')." WHERE `uid` IN($uids)");
			}elseif($_POST['examinesubmit']){
				update('common_user',array('state'=>'1'),"uid IN($uids)");
			}
			showmessage('用户管理操作成功',$urlstr);		
		}		
	}

}
?>