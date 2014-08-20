<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

$username = getArrayElement($_POST, "username");

$user = User::fetchByMail($username);
if (!$user) {
	$user = User::fetchByLogin($username);
}

$ok = true;
if ($user) {
	if($user->sendPasswortResetMail()) {
		$sendMessage = _loc('forgotPassword.sent');
	} else {
		$sendMessage = _loc('forgotPassword.error.technicalError');
		$ok = false;
	}
} else {
	$sendMessage = _loc('forgotPassword.error.noMatch');
	$ok = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('forgotPassword.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('forgotPassword.title') ?>" />
    <meta name="description" content="<?php loc('forgotPassword.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('forgotPassword.title') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		
		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><span><?php loc('forgotPassword.title') ?></span></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php if ($ok) { ?>
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><?php loc('forgotPassword.sent.ok') ?></h1></div>
					<div class="blog-body">
						<br /><?php echo($sendMessage) ?>
					</div>
					<div class="blog-footer"></div>
				</div>
				<!-- Kasten | ENDE -->
				<?php } else { ?>
				<!-- Sprechblase | START -->
				<div class="sprechblase">
					<h2>&nbsp;<span>&nbsp;</span></h2>
					<div class="sprechblase-main">
				    	<div class="sprechblase-achtung">&nbsp;</div>
				        <div class="sprechblase-rechts">
				        	<div class="blase-header" id="eingabeblase-head">
				            	<div class="kurzerklaerung"><span><?php loc('forgotPassword.error')?> </span></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link">
									<?php echo($sendMessage) ?>
									<br /><br />
									<a href="forgot_password_form.php" id="createLink"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('core.back')?></a>
								</div>
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- Sprechblase | ENDE -->
				<?php }  ?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser" >
			    	<div class="teaser-head"><h2><?php loc('forgotPassword.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('forgotPassword.info.text') ?><br />
			        		<br />
			        		<?php loc('forgotPassword.info.howto') ?><br />
							<ol>
								<li><?php loc('forgotPassword.info.howto.1') ?></li>
								<li><?php loc('forgotPassword.info.howto.2') ?></li>
								<li><?php loc('forgotPassword.info.howto.3') ?></li>
								<li><?php loc('forgotPassword.info.howto.4') ?></li>
							</ol>
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
		
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