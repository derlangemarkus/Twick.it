<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$secret = getArrayElement($_GET, "secret");
$user = getUser();

if ($user && $user->getId() == $id && $user->getSecret() == $secret) {
	$user->delete();
	
	$_SESSION["userId"] = "";
	unset($_SESSION["userId"]);
	
	redirect(HTTP_ROOT . "/index.php?msg=userdata.delete.success");
} else {
	redirect(HTTP_ROOT . "/index.php");
}
?>
