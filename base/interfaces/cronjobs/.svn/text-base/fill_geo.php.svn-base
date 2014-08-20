<?php
require_once("../../util/inc.php");
ini_set("display_errors", 1);

checkCronjobLogin();

$topics = Topic::fetchBySQL("geo_date is null OR (longitude is null AND geo_date < DATE_SUB(CURDATE(),INTERVAL 30 DAY))", true);
shuffle($topics);
foreach($topics as $topic) {
    $topic->updateCoordinates();
}
?>