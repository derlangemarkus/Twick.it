<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 
checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$rating = getArrayElement($_GET, "rating");
$secret = getArrayElement($_GET, "secret");
$refferer = getArrayElement($_GET, "r");
$plusMinus = $rating > 0 ? 1 : -1;

$twick = Twick::fetchById($id);
$user = getUser();
 

if ($user && $twick && $user->getSecret() == $secret) {	
	if($twick->getUserId() == $user->getId()) {
		$msg = "msg=twick.rating.ownTwick";
	} else {
		$twick->rate($plusMinus, $user);
		$msg = "msg=mobile.rate.thanks";
	}
	
	switch($refferer) {
		// Ueber Themen-Seite
		case 1: 
			$url = "../topic.php?search=" . urlencode(getArrayElement($_GET, "x", -1)) . "&$msg";
			break;
			
		// Ueber User-Seite			
		case 2: 
			$url = "../user.php?name=" . getArrayElement($_GET, "x", -1). "&$msg";
			break;
			
		// Ueber Liste der neuesten Twicks 	
		case 3: 
			$url = "../latest.php?$msg";
			break;
			
		default: 
			$url = "../index.php?$msg"; 
	}
	
	redirect($url . "#" . $twick->getId());
}

redirect("../index.php");
?>
