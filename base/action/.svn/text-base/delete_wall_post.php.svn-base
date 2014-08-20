<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
checkLogin();

// Parameter auslesen
$postId = getArrayElement($_POST, "id");
$secret = getArrayElement($_POST, "secret");

$user = getUser();
$post = WallPost::fetchById($postId);

if($secret && $user->getSecret() == $secret && $post->isDeletable()) {
	$post->delete();
} 
	
?>
