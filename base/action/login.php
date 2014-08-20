<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 

$login = getArrayElement($_POST, "login");
$password = getArrayElement($_POST, "password");
$msg = "";

$user = User::fetchByMail($login);
if (!$user) {
	$user = User::fetchByLogin($login);
}

redirect(login($user, $password));
?>
