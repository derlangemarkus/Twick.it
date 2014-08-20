<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkLogin();

// Parameter auslesen
$user = getUser();

copyArrayInClass($user, $_POST);
$user->save();
$user->resetCache();

redirect("../user_data.php?msg=Deine+Daten+wurden+gespeichert.");
?>