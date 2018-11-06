<?php

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './admin/function.php';

$S = new S();
$S -> star();
if($_GET['mod']=='youlam'){
	if($_GET['item']=='topic'){
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
				$typesList = DB::fetch_first("SELECT * FROM ".DB::table('topic')." WHERE tid=".$_GET['selectSecondClass']);
				$typesList['types']=dunserialize($typesList['types']);
				
				if(!empty($typesList)){
					echo json_encode($typesList);
				}else{}
			}
		}else{}
	}
}
?>