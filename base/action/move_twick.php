<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 

checkAdmin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$title = getArrayElement($_GET, "title");


// Gibt es das Thema schon?
$topic = array_pop(Topic::fetchByTitle($title));
if(!$topic) {
	$topic = new Topic();
	$topic->setTitle($title);
	$topic->updateStemming();
	$topic->updateCoreTitle();	
	$topic->setLanguageCode(getLanguage());
	$topic->setCreationDate(getCurrentDate());
	$topic->setUrlId($topic->createUrlId());
	$topic->save();
}


// Twick verschieben
$twick = Twick::fetchById($id);
$oldTitle = $twick->getTitle();
$twick->setTopicId($topic->getId());
$twick->setTitle($title);
$twick->save();

$topic->updateTagCloud($topic->getTitle());


// Altes Thema loeschen oder Tagcloud anpassen
$topic = array_pop(Topic::fetchByTitle($oldTitle));
if($topic) {
    if(sizeof($topic->findTwicks())) {
        // Noch andere Twicks übrig -> Tagcloud aktualisieren
        $topic->updateTagCloud($topic->getTitle());
    } else {
        // Keine Twicks mehr übrig -> Thema löschen
        $topic->delete();
    }
}


redirect($twick->getUrl());
?>
