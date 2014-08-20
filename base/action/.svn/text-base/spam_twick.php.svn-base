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
$refferer = getArrayElement($_GET, "r");
$secret = getArrayElement($_GET, "secret");
$type = getArrayElement($_POST, "type", 1024);

$twick = Twick::fetchById($id);
$user = getUser();

if ($twick && $user && $user->getSecret() == $secret) {
    $twick->spam($user, $type);
	
	// Zurueck zum Twick
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
			$theUser = User::fetchById($userId);
			if ($theUser) {
				$url = $theUser->getUrl() . "#" . $twick->getId(); 
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
