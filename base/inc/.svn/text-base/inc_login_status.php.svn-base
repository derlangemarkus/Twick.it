<?php
$loggedInUser = getUser();
$id = getArrayElement($_GET, "id");

if ($loggedInUser) {
	?>
	Du bist angemeldet als <?php echo($loggedInUser->getAvatar()) ?> <?php echo($loggedInUser->getDisplayName()) ?>. <a href="<?php echo(HTTP_ROOT) ?>/action/logout.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>">Logout</a> | <a href="<?php echo(HTTP_ROOT) ?>/user_data.php">Daten ansehen/ändern</a> | <a href="<?php echo(HTTP_ROOT) ?>/delete_user_form.php">Account löschen</a>
	<?php
} else {
	?>
	Du bist nicht angemeldet. Melde dich hier an 
	<form id="loginForm" action="<?php echo(HTTP_ROOT) ?>/action/login.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>" method="post" style="display:inline;">
		<input type="text" name="login" value="E-Mail-Adresse" onfocus="this.select()"/>
		<input type="password" name="password" value="" onfocus="this.select()" />
		<input type="submit" value="GO" />
	</form> oder per <a href="<?php echo(HTTP_ROOT . "/twitter_login.php") ?>">Twitter-Account</a> (<a href="<?php echo(HTTP_ROOT) ?>/forgot_password_form.php">Passwort vergessen</a>, <a href="<?php echo(HTTP_ROOT) ?>/resend_registration_mail_form.php">Registrierungsmail erneut senden</a>) oder <a href="<?php echo(HTTP_ROOT) ?>/register_form.php">erstelle einen neuen Account</a>.
	<?php
}


if ($msg = getArrayElement($_GET, "msg")) {
	echo("<br />$msg<br />");
}
?><br /><hr />