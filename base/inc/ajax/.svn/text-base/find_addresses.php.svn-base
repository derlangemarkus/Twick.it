<?php
require_once("../../util/inc.php");
require_once("../../entity/Topic.php");
header("Content-Type: application/json; charset=utf-8"); 

$north = getArrayElement($_GET, "north");
$west = getArrayElement($_GET, "west");
$south = getArrayElement($_GET, "south");
$east = getArrayElement($_GET, "east");

$result = array();
foreach(Topic::findInArea($north, $west, $south, $east) as $topic) {
    $result[] = array("id"=>$topic->getId() , "title"=>$topic->getTitle(), "latitude"=>$topic->getLatitude(), "longitude"=>$topic->getLongitude());
}
echo(json_encode($result));
?>