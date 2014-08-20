<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Twick.it - Geblockte User</title>
	<script type="text/javascript" src="<?php echo(HTTP_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src="<?php echo(HTTP_ROOT) ?>/html/js/scriptaculous/src/scriptaculous.js?load=effects"></script>
</head>
<body>
<?php include("inc/inc_login_status.php"); ?>
<?php include("inc/inc_language_switch.php"); ?>
<?php include("inc/inc_menu.php"); ?>
<?php include("inc/inc_search_form.php"); ?>


<hr />
<h1>Geblockte User</h1>
<?php 
foreach(BlockedUser::fetchByMyUserId(getUSerId()) as $blockedUser) {
	$aUser = $blockedUser->getUser(); 
?>
<a href="<?php echo($aUser->getUrl()) ?>"><?php echo($aUser->getAvatar()) ?> <?php echo htmlspecialchars($aUser->getDisplayName()) ?></a> <a href="action/unblock_user.php?id=<?php echo($aUser->getId()) ?>">Nicht mehr blocken</a><br />
<?php } ?>
</body>
</html>
