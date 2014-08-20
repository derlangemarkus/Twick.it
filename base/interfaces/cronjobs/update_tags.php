<?php
require_once("../../util/inc.php"); 

checkCronjobLogin();

set_time_limit(60000);

foreach(Topic::fetchAll(true) as $topic) {
	$topic->updateTagCloud($topic->getTitle());
}


foreach(User::fetchAll(true, true) as $user) {
	$user->updateTagCloud();
}
?>
FERTIG
