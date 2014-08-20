<?php
require_once("../util/inc.php");
header("Content-Type: application/json; charset=utf-8"); 
ini_set("display_errors", 1);
echo("[");

$separator = "";
$favorites = TwickFavorite::fetchByUserId(710);
shuffle ($favorites);
foreach($favorites as $favorite) {
	$twick = $favorite->findTwick();
	$twickUser = $twick->getUser();
	echo($separator);
	?>
	{
		"Id":<?php jecho($twick->getId()) ?>,
		"Avatar":"<?php jecho($twickUser->getAvatarUrl(32)) ?>",
		"User":"<?php jecho($twickUser->getLogin()) ?>",
		"LinkText":"<?php jecho($twick->getTitle()) ?>",
		"Url":"<?php jecho($twick->getUrl()) ?>",
		"Title":"<?php jecho($twick->getText()) ?>"
	}
	<?php 
	$separator = ",";
}
echo("]");
?>