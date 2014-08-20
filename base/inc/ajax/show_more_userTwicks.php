<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

$login = getArrayElement($_GET, "username");
if (startsWith($login, "Twitter-User-")) {
	$login = "Twitter-User: " . substringAfter($login, "Twitter-User-");
}

$offset = getArrayElement($_GET, "offset");
$limit = getArrayElement($_GET, "limit");
$sort = getArrayElement($_GET, "sort", "rating_sum");
$direction = getArrayElement($_GET, "direction", "DESC");

$user = User::fetchByLogin($login);
if ($user) {
	$id = $user->getId();
		
	$twicks = Twick::fetchByUserId($id, false, array("ORDER BY"=>"$sort $direction", "LIMIT"=>$limit+1, "OFFSET"=>$offset));
	
	if (sizeof($twicks) <= $limit) {
		echo(0);   // Es kommen keine Twicks mehr
	} else {
		echo(1);   // Es gibt noch mehr Twicks
	}
	
	foreach(array_slice($twicks, 0, $limit) as $twick) {
		$twick->display(false, 4, false, false, "&userId=" . $user->getId());
	}
}
?>