<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkLogin();

$id = getArrayElement($_GET, "id");

$blockedUser = BlockedUser::fetchByUserIds(getUserId(), $id);
$blockedUser->delete();

redirect("../show_blocked_users.php");
?>