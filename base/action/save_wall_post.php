<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
require_once("../util/notifications/Notificator.class.php");
checkLogin();

// Parameter auslesen
$userId = getArrayElement($_POST, "user");
$post = trim(getArrayElement($_POST, "post"));
$secret = getArrayElement($_POST, "secret");
$parentId = getArrayElement($_POST, "parent", null);

$user = getUser();

if($userId && $post && $secret && $user->getSecret() == $secret) {
	$wallPost = new WallPost();
	$wallPost->setUserId($userId);
	$wallPost->setParentId($parentId);
	$wallPost->setAuthorId($user->getId());
	$wallPost->setMessage($post);
	$wallPost->setCreationDate(getCurrentDate());
	$wallPost->save();
	
	$wallOwner = User::fetchById($userId);
	Notificator::writeWallPost($wallOwner, $user, $wallPost);
	
	echo($wallPost->getId());
} else {
	echo(0);
}
?>
