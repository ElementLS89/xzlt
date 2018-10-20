<?php
define('PHPSCRIPT', 'search');

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';


$S = new S();
$S -> star();


$_GET['mod']=$_GET['mod']?$_GET['mod']:'topic';
$_S['setting']['mods']=dunserialize($_S['setting']['mods']);

if($_GET['mod']=='user'){
	$navtitle='找人';
	$backurl='my.php?mod=friend';
	require_once './include/function_user.php';
	C::chche('userfield');	
  if($_GET['k']){
		C::chche('usergroup');
		$backurl='search.php?mod=user';
		$sql['select'] = 'SELECT u.*';
		$sql['from'] =' FROM '.DB::table('common_user').' u';
    
		$wherearr[] = 'u.username LIKE'."'%$_GET[k]%'";

		$sql['select'] .= ',p.*';
		$sql['left'] .=" LEFT JOIN ".DB::table('common_user_profile')." p ON p.uid=u.uid";
		foreach($_GET['search'] as $field=>$v){
			if($v){
				$s.='&search['.$field.']='.$v;
				if($_S['cache']['userfield'][$field]['type']=='date'){
					$k=explode(',',$v);
					$age1=$_S['timestamp']-$k[1]*31536000;
					$age2=$_S['timestamp']-$k[0]*31536000;
			
					$wherearr[] = "p.$field > '$age1'";
					$wherearr[] = "p.$field < '$age2'";
			
				}elseif($_S['cache']['userfield'][$field]['type']=='checkbox'){
					$wherearr[] = "p.$field LIKE"."'%$v%'";
				}else{
					$wherearr[] = "p.$field ='$v'";
				}				
			}
		}

		$sql['order']='ORDER BY u.lastactivity DESC';	
		$select=select($sql,$wherearr,10);

		if($select[1]) {
			$query = DB::query($select[0]);
			while($value = DB::fetch($query)){
				$value['age']=$value['birthday']?smsdate($_S['timestamp'],'Y')-smsdate($value['birthday'],'Y'):'';
				if($value['gender']==1){
					$value['gender']='icon-male';
				}elseif($value['gender']==2){
					$value['gender']='icon-female';
				}
				if($value['lat'] && $value['lng'] && $_S['member']['lat'] && $_S['member']['lng']){
					$value['dis']=distance($value['lat'],$value['lng'],$_S['member']['lat'],$_S['member']['lng']);
					if($value['dis']=='0m'){
						$value['dis']='在你身边';
					}
				}
				$value['group']=$_S['cache']['usergroup'][$value['groupid']]['name'];
				$list[$value['uid']]=$value;
			}
		}
		
		$maxpage = @ceil($select[1]/10);
		$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
		$nexturl = 'search.php?mod=user&k='.$_GET['k'].$s.'&page='.$nextpage;
	}else{
		$backurl='my.php?mod=friend';
	}
	$temp=PHPSCRIPT.'/'.$_GET['mod'];
}else{
	$navtitle='搜索';
	$themetable=$_S['setting']['mods'][$_GET['mod']]['table'];
	
	
	if($_S['setting']['mods'][$_GET['mod']]['ishack']){
		require_once ROOT.'./hack/'.$_GET['mod'].'/search.php';
	}else{
		require_once ROOT.'./mod/'.$_GET['mod'].'_search.php';
		$temp=PHPSCRIPT.'/'.$_GET['mod'];
	}
}

$title=$navtitle.'-'.$_S['setting']['sitename'];
//shar
$signature=signature();
$apilist='onMenuShareTimeline,onMenuShareAppMessage,onMenuShareQQ,onMenuShareWeibo,onMenuShareQZone';

include temp($temp);
?>