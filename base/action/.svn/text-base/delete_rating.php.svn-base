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
$ratingId = getArrayElement($_GET, "rating");


$rating = TwickRating::fetchById($ratingId);

if ($rating && $rating->getUserId() == getUserId()) {	
	$rating->delete();
	
	$topic = Topic::fetchById($id);
	$topic->updateTagCloud($topic->getTitle());
	redirect($topic->getUrl());	
}


redirect("../index.php");
?>
