<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");

$id = getArrayElement($_POST, "twick");

$twick = Twick::fetchById($id);
$user = $twick->findUser();
$user->updateTagCloud();
?>