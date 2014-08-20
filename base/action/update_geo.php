<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");

$id = getArrayElement($_POST, "topic");

$topic = Topic::fetchById($id);
$topic->updateCoordinates();
?>