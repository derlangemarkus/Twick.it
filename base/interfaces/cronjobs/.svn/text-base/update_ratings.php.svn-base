<?php
require_once("../../util/inc.php"); 

checkCronjobLogin();

foreach(UserInfo::fetchAll(true, true) as $info) {
	$id = $info->getId();
	$languageCode = $info->getLanguageCode();	
	$user = User::fetchById($id);
	$user->setRatingSumCached($info->getRatingSum(), $languageCode);
	$user->setRatingCountCached($info->getRatingCount(), $languageCode);
	$user->save();
}

?>