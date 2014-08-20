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
$add = getArrayElement($_GET, "add", false);
$user = getUser();
$userId = getUserId();

if ($user->getSecret() == $secret) {
	$favorite = TwickFavorite::fetchByUserAndTwickId($userId, $id);
	if ($favorite) {
		if (!$add) {
			$favorite->delete();
			echo("OK");
		}
	} else {
		if ($add) {
			$favorite = new TwickFavorite();
			$favorite->setUserId($userId);
			$favorite->setTwickId($id);
			$favorite->setCreationDate(getCurrentDate());
			$favorite->save();
			echo("OK");
		}
	}
}
?>
