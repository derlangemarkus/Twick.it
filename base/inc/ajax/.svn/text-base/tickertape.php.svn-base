<?php
require_once("../../util/inc.php");
header("Content-Type: application/json; charset=utf-8"); 

$output = array();
foreach(TwickInfo::fetchRandom(9) as $twick) {
	$twickUser = $twick->getUser();
	$data = array();
	$data["Id"] = $twick->getId();
	$data["Avatar"] = $twickUser->getAvatarUrl(32);
	$data["User"] = $twickUser->getLogin();
	$data["LinkText"] = $twick->getTitle();
	$data["Url"] = $twick->getUrl();
	$data["Title"] = $twick->getText();
	$output[] = $data;
}

echo(json_encode($output));
?>