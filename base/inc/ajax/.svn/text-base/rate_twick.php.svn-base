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
$plusMinus = $rating > 0 ? 1 : -1;

$twick = Twick::fetchById($id);
$user = getUser();
 
if ($user && $twick && $twick->getUserId() != $user->getId() && $user->getSecret() == $secret) {	
	$twick->rate($plusMinus, $user);
}

echo(
    json_encode(
        array(
            "id" => $id,
            "rating" => $plusMinus,
            "badge" => Badge::getLevelName($badge)
        )
    )
);
?>