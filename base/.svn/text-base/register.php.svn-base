<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");
require_once("util/notifications/Notificator.class.php");

// Parameter auslesen
$login = getArrayElement($_POST, "login");
$mail = strtolower(trim(getArrayElement($_POST, "mail")));
$password = getArrayElement($_POST, "password");
$password2 = getArrayElement($_POST, "password2");


if (startsWith($login, "-") || !preg_match('/^[a-zA-Z_\d]+$/', $login)) {
	redirect("register_form.php?error=userdata.error.login.invalidChars");
}
if (!getArrayElement($_POST, "agb")) {
	redirect("register_form.php?error=userdata.error.terms.accept");
}
if (trim($password) == "") {
	redirect("register_form.php?error=userdata.error.email.invalidOrEmpty");
}
if(User::fetchByMail($mail)) {
	redirect("register_form.php?error=userdata.error.login.duplicateMail");
}
if(User::fetchByLogin($login)) {
	redirect("register_form.php?error=userdata.error.login.taken");
}
if($password != $password2) {
	redirect("register_form.php?error=userdata.error.password.repeat");
}

if (BlockedMail::isBlocked($mail)) {
	redirect("register_form.php?error=userdata.error.login.blocked");
}

if (SpamBlocker::check($_POST)) {
	$user = new User();
	copyArrayInClass($user, $_POST);
	$user->setRegisterMail($_POST["mail"]);
	$user->setPassword(md5($password));
	$user->setEnableMessages(true);
	$user->setCreationDate(getCurrentDate());
	$user->setRegisterLanguageCode(getLanguage());
    $user->setAlerts(Notificator::NOTIFICATION_DEFAULT);
	$user->save();

	
	if (!$user->sendRegistrationMail()) {
		popup(_loc('userdata.error.couldNotSend'));
	}
} else {
	redirect("spam.php");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('userdata.registration.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('userdata.registration.title') ?>" />
    <meta name="description" content="<?php loc('userdata.registration.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript" src="html/js/twickit/twickit_userdata_js.php"></script>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
	    <!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('userdata.success.headline') ?></h1>
		</div>
    
	   	<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<!-- Sprechblase | START -->
				<div class="sprechblase">
					<h2>&nbsp;<span>&nbsp;</span></h2>
					<div class="sprechblase-main">
				    	<div class="sprechblase-achtung">&nbsp;</div>
				        <div class="sprechblase-rechts">
				        	<div class="blase-header" id="eingabeblase-head">
				            	<div class="kurzerklaerung"><span><?php loc('userdata.success.hello', $login) ?></span></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link">
									<?php loc('userdata.success.text.1') ?><br /> 
									<br />
									<?php loc('userdata.success.text.2') ?><br />
								</div>
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- Sprechblase | ENDE -->
				
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
				
				<!-- Willkommen | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('userdata.success.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			                <?php loc('userdata.success.info.text') ?>
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Willkommen | ENDE -->  
			    
			<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>      
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>
