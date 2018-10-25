<?php

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';
require_once './admin/function.php';

$S = new S();
$S -> star();
if($_GET['mod']=='youlam'){
	if($_GET['item']=='tips'){
		if($_GET['firstClass']!=''){
	/*		$query = DB::query("SELECT * FROM ".DB::table('topic_type')." ORDER BY list ASC");
			while($value = DB::fetch($query)) {
				$firstTypes[$value['typeid']]=$value;
			}*/
	//		echo $firstTypes[2]['name'];
	//		$secondTypes=0;
			$query = DB::query("SELECT * FROM ".DB::table('topic')." WHERE typeid=".$_GET['firstClass']);
			while($value = DB::fetch($query)) {
				$secondTypes[$value['tid']]=$value;
			}
			echo json_encode($secondTypes);
		}
	}
}
?>