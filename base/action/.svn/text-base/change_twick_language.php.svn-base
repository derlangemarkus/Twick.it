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

$oldTwick = TwickInfo::fetchById($id);

$topic = array_pop(Topic::fetchByTitle($oldTwick->getTitle()));
if (!$topic) {
	$topic = new Topic();
	$topic->setTitle($oldTwick->getTitle());
	$topic->updateStemming();
	$topic->updateCoreTitle();	
	$topic->setLanguageCode(getLanguage());
	$topic->setCreationDate($oldTwick->getCreationDate());
	$topic->setUrlId($topic->createUrlId());
	$topic->save();
}

$twick = new Twick();
$twick->setTopicId($topic->getId());
$twick->setAcronym($oldTwick->getAcronym());
$twick->setText($oldTwick->getText());
$twick->setLink($oldTwick->getLink());
$twick->setCreationDate($oldTwick->getCreationDate());
$twick->setUserId($oldTwick->getUserId());
$twick->setInputSource($oldTwick->getInputSource());
$twick->setTitle($oldTwick->getTitle());
$twick->setLanguageCode(getLanguage());
$twick->save();


$oldTwick->delete();

redirect($twick->getUrl());
	

?>
