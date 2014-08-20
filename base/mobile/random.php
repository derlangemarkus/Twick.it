<?php
require_once("util/inc.php"); 

$topic = array_pop(Topic::fetchRandom(1));

header("Location: " . $topic->getUrl());
exit;
?>