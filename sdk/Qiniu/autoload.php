<?php
function classLoader($class){
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	$file = ROOT.'./sdk/' .$path . '.php';
	if (file_exists($file)) {
		require_once $file;
	}
}
spl_autoload_register('classLoader');

require_once  ROOT . './sdk/Qiniu/functions.php';
?>