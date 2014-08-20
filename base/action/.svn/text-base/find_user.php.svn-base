<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 

$login = getArrayElement($_GET, "username");

$user = User::fetchByLogin($login);
if ($user && !$user->getDeleted()) {
	redirect($user->getUrl());
} else {
	redirect("../show_users.php?notFound=$login");
}
?>