<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkLogin();

$secret = getArrayElement($_GET, "secret");
$id = getArrayElement($_GET, "id");
$twick = Twick::fetchById($id);
$url = HTTP_ROOT;

if ($twick) {
	$url = $twick->getUrl();
	if($twick->isDeletable()) {
		$user = getUser();
		if ($user->getSecret() == $secret) {
			$twick->delete();
		}
	}
}

if(getArrayElement($_GET, "bullshit")) {
	redirect(HTTP_ROOT . "/admin/bullshit.php");
} else {
	redirect($url);
}
?>