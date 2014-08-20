<?php
require_once("../../util/inc.php"); 

checkCronjobLogin();

define("CACHE_DIR", DOCUMENT_ROOT . "/writable/cache/");

// Alte Cache-Dateien loeschen
clearCacheData(CACHE_DIR);

function clearCacheData($inDir) {
	$handle = opendir($inDir);
	while (($file = readdir($handle)) !== false) {
		if ($file !== ".." && $file !== ".") {
			$fileName = $inDir . $file;
			if(is_file($fileName)) {
				$stat = stat($fileName);
				if($stat["mtime"] < time()-31*24*60*60) {
					unlink($fileName);
				}
			} else {
				if($file != "supertrumpf") {
					clearCacheData($fileName . "/");
				}
			}
		}
	}
	closedir($handle);
}
?>