<?php 
require_once("../../util/inc.php");
checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$secret = getArrayElement($_GET, "secret");
$twick = TwickInfo::fetchById($id);
$user = getUser();

// Sicher ist sicher
if(
	!isAdmin() && ($user->getId() != $twick->getUserId() || $secret != $user->getSecret()) || 
	!$twick
) {
	redirect(HTTP_ROOT . "/index.php");
	exit;
}

$twick->delete();
redirect("../topic.php?search=" . urlencode($twick->getTitle()) . "&msg=mobile.twick.deleted");
?>