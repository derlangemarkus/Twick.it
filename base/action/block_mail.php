<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkAdmin();

$id = getArrayElement($_GET, "id");
$user = User::fetchById($id);
$mail = $user->getMail();


$blockedMail = BlockedMail::fetchByMail($mail);
if (!$blockedMail) {
	$blockedMail = new BlockedMail();
	$blockedMail->setCreationDate(getCurrentDate());
	$blockedMail->setMail($mail);
	$blockedMail->save();
}


redirect($user->getUrl() . "?msg=user.blocked");
?>