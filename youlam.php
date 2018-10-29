<?php

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './admin/function.php';

$S = new S();
$S -> star();
if($_GET['mod']=='youlam'){
	if($_GET['item']=='tips'){
		if($_GET['ac']=='select'){
			if($_GET['selectFirstClass']){
				$query = DB::query("SELECT * FROM ".DB::table('topic')." WHERE typeid=".$_GET['selectFirstClass']);
				while($value = DB::fetch($query)) {
					$secondTypes[$value['tid']]=$value;
				}
				if(!empty($secondTypes)){
					echo json_encode($secondTypes);
				}else{}
			}elseif($_GET['selectSecondClass']!='请选择'){
				$query = DB::query("SELECT * FROM ".DB::table('topic_tips')." WHERE tid=".$_GET['selectSecondClass']);
				while($value = DB::fetch($query)) {
					$tipsList[$value['vid']]=$value;
				}
				if(!empty($tipsList)){
					echo json_encode($tipsList);
				}else{}
			}
		}elseif($_GET['ac']=='add'){
			if($_GET['selectSecondClass']){
				$s['tid']=$_GET['selectSecondClass'];
				$s['subject']=$_GET['name'];
				$s['link']=$_GET['url'];
			//	$s['imgs']=$_GET['pic'];
				
				insert('topic_tips',$s);
				echo $s['subject'];
			}
		}
	}
}
?>