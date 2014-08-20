<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkAdmin();

$id = getArrayElement($_GET, "id");
if (isAdmin()) {
	foreach(TwickSpamRating::fetchByTwickId($id) as $rating) {
		$rating->delete();
	}
}

redirect(HTTP_ROOT . "/admin/bullshit.php");
?>