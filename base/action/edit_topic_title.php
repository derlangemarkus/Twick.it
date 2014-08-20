<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkAdmin();

// Parameter auslesen
$id = getArrayElement($_POST, "id");
$title = getArrayElement($_POST, "title");

$topic = Topic::fetchById($id);

if ($topic->getTitle() != $title) {
	if ($other = array_pop(Topic::fetchByTitle($title))) {
		if ($other->getId() != $id) {
			die("Doppeltes Thema!");
		}
	}
	
	foreach($topic->findTwicks() as $twick) {
		$twick->setTitle($title);
		$twick->save();
	}
	
	$topic->setTitle($title);
	$topic->updateCoreTitle();
	$topic->updateStemming();
	
	$urlId = createSeoUrl($topic->getTitle(), $topic->getLanguageCode());
	$counter = 2;
	
	$newUrlId = $urlId;
	while($other = Topic::fetchByUrlId($newUrlId)) {
		if ($other->getId() != $id) {
			$newUrlId = $urlId . "_" . $counter;
			$counter++;
		} else {
			break;
		}
	}
	$topic->setUrlId($newUrlId);
	
	
	$topic->save();
	
	echo($topic->getTitle());
} else {
	echo($title);
}
?>
