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
	if ($user->getApproved()) {
		$sendMessage = _loc('resend.error.alreadyApproved');
		$ok = false;
	} else {
		if($user->sendRegistrationMail()) {
			$sendMessage = _loc('resend.ok.text');
		} else {
			$sendMessage = _loc('resend.error.technical');
			$ok = false;
		}
	}
} else {
	$sendMessage = _loc('resend.error.noMatch');
	$ok = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('resend.title')?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('resend.title') ?>" />
    <meta name="description" content="<?php loc('resend.title')?> | <?php loc('core.titleClaim')?>" />   
    <meta name="keywords" content="<?php loc('resend.title')?>" />
	<?php include("inc/inc_global_header.php"); ?>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('resend.headline') ?></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php if ($ok) { ?>
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><?php loc('resend.ok.headline') ?></h1></div>
					<div class="blog-body">
						<?php echo($sendMessage) ?>
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
				            	<div class="kurzerklaerung"><span><?php loc('resend.error.headline') ?></span></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link">
									<?php echo($sendMessage) ?>
									<br /><br />
									<a href="resend_registration_mail_form.php" id="createLink"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('core.back') ?></a>
								</div>
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- Sprechblase | ENDE -->
				<?php } ?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('resend.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('resend.info.text') ?><br />
			        		<br />
			        		<?php loc('resend.info.howto') ?><br />
							<ol>
								<li><?php loc('resend.info.howto.1') ?></li>
								<li><?php loc('resend.info.howto.2') ?></li>
								<li><?php loc('resend.info.howto.3') ?></li>
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

