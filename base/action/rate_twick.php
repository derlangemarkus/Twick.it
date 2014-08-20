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
$rating = getArrayElement($_GET, "rating");
$secret = getArrayElement($_GET, "secret");
$refferer = getArrayElement($_GET, "r");
$plusMinus = $rating > 0 ? 1 : -1;

$twick = TwickInfo::fetchById($id);
$user = getUser();
 
if ($user && $twick && $twick->getUserId() != $user->getId() && $user->getSecret() == $secret) {	
    $twick->rate($plusMinus, getUserId());

	switch($refferer) {
		// Ueber Admin-Bullshit-Uebersicht
		case 1: 
			$url = HTTP_ROOT . "/admin/bullshit.php";
			break;
			
		// Ueber Einzelansicht			
		case 2: 
			$url = $twick->getStandaloneUrl(); 
			break;
			
		// Ueber Favoriten			
		case 3: 
			$userId = getArrayElement($_GET, "userId", -1);
			$theUser = User::fetchById($userId);
			if ($theUser) {
				$url = HTTP_ROOT . "/show_favorites.php?id=" . $theUser->getId() . "#" . $twick->getId(); 
				break;
			}
			
		// Ueber User-Seite
		case 4: 
			$userId = getArrayElement($_GET, "userId", -1);
			$direction = getArrayElement($_GET, "direction");
			$sort = getArrayElement($_GET, "sort");
			$offset = getArrayElement($_GET, "offset");
			$theUser = User::fetchById($userId);
			if ($theUser) {
				$url = $theUser->getUrl() . "?direction=$direction&sort=$sort&offset=$offset" . "#" . $twick->getId(); 
				break;
			}
			
		// Letzte Twicks
		case 5: 
			$url = HTTP_ROOT . "/latest_twicks.php"; 
			
			
		default: 
			$url = $twick->getUrl(); 
	}
	
	redirect($url);	
}

redirect("../index.php");
?>
