<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");

$id = getArrayElement($_GET, "id");
$secret = substr(getArrayElement($_GET, "secret"), 1);

$success = false;
$user = User::fetchById($id);
if ($user) {
	if ($user->getSecretSecret() === $secret) {
		$success = $user->sendNewPasswordMail();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('resetPassword.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('resetPassword.title') ?>" />
    <meta name="description" content="<?php loc('resetPassword.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('resetPassword.title') ?>" />
	<script type="text/javascript" src="html/js/swfobject.js"></script>
	<?php include("inc/inc_global_header.php"); ?>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		
		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><span><?php loc('resetPassword.headline') ?></span></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php if($success) { ?>
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><?php loc('resetPassword.success.headline') ?></h1></div>
					<div class="blog-body">
						<br /><?php loc('resetPassword.success.text'); ?>
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
				            	<div class="kurzerklaerung"></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link">
									<?php loc('resetPassword.error'); ?>
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