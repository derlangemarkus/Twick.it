<?php
require_once("../util/inc.php");

$id = getArrayElement($_GET, "id");
$size = getArrayElement($_GET, "size");


$url = Cache::getCachedValue("avatar$id");
if (!$url) {
	$user = User::fetchById($id);
	$url = $user->getAvatarUrl($size);
	
	$cache= new Cache();
	$cache->saveInCache("avatar$id", $url);
}

$info = getimagesize($url);
$mime = $info["mime"];
header("Content-Type: $mime");
readfile($url);
?>