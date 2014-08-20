<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

// Parameter auslesen
$id = getArrayElement($_POST, "id");

$user = User::fetchById($id);
if ($user && !$user->getApproved()) {
	if($user->sendRegistrationMail()) {
		$result = 0;
	} else {
		$result = 1;
	}
} else {
	$result = 2;
}

return $result;
?>


