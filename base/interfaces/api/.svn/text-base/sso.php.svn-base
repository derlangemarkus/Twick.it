<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$token = getArrayElement($_GET, "token");
$type = getArrayElement($_GET, "type");

if (false && !getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(3600);
}

$user = User::fetchById($id);
if (!$user || $user->getLoginToken() != $token) {
    header('HTTP/1.0 401 Unauthorized');
	die("Kein Login");
}

if ($type == "json") {
	header("Content-Type: application/json; charset=utf-8"); 
?>
{
	"query":"<?php jecho($_SERVER["QUERY_STRING"]) ?>",
	"user": 
		{
			"id":"<?php jecho($user->getId()) ?>",
			"display_name":"<?php jecho($user->getDisplayName()) ?>",
			"user_name":"<?php jecho($user->getLogin()) ?>",
			"name":"<?php jecho($user->getName()) ?>",
			"country":"<?php jecho($user->getCountry()) ?>",
			"location":"<?php jecho($user->getLocation()) ?>", 
			"bio":"<?php jecho($user->getBio()) ?>",
			"link":"<?php jecho($user->getLink()) ?>",
			"twitter":"<?php jecho($user->getTwitter()) ?>",
			"url":"<?php jecho($user->getUrl()) ?>",
			"mail":"<?php jecho($user->getMail()) ?>"
		}
}
<?php 
} else {
	header("Content-Type: text/xml; charset=utf-8");
	printXMLHeader(); 
?>
<result>
	<query><?php xecho($_SERVER["QUERY_STRING"]) ?></query>
	<user>
		<id><?php xecho($user->getId()) ?></id>
		<display_name><?php xecho($user->getDisplayName()) ?></display_name>
		<username><?php xecho($user->getLogin()) ?></username>
		<name><?php xecho($user->getName()) ?></name>
		<country><?php xecho($user->getCountry()) ?></country>
		<location><?php xecho($user->getLocation()) ?></location>
		<bio><?php xecho($user->getBio()) ?></bio>
		<link><?php xecho($user->getLink()) ?></link>
		<twitter><?php xecho($user->getTwitter()) ?></twitter>
		<url><?php xecho($user->getUrl()) ?></url>
		<mail><?php xecho($user->getMail()) ?></mail>
	</user>
</result>
<?php
}
?>