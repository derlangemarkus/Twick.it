<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");
$activeTab = "user";

$id = getArrayElement($_GET, "id");
$secret = substr(getArrayElement($_GET, "secret"), 1);

$success = false;
$user = User::fetchById($id);
if ($user) {
	if ($user->getSecretSecret() === $secret) {
		$success = true;
		$user->setApproved(1);
		$user->save();
		
		$_SESSION["userId"] = $user->getId();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('registrationApproved.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('registrationApproved.title') ?>" />
    <meta name="description" content="<?php loc('registrationApproved.title') ?> - <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTwicks') ?>" href="interfaces/rss/latest.php?lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTopics') ?>" href="interfaces/rss/latest_topics.php?lng=<?php echo(getLanguage()) ?>" />
	<?php include("inc/inc_global_header.php"); ?>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1><?php if($success) { loc('registrationApproved.success.headline'); } else { loc('registrationApproved.error.headline'); } ?></h1>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php if($success) { ?>
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><?php loc('registrationApproved.success.subline') ?></h1></div>
					<div class="blog-body">
						<?php loc('registrationApproved.success.text') ?><br />
					<br />
					<a href="<?php if($_SESSION["startpage"]) { echo($_SESSION["startpage"]); } else { ?>index.php<?php } ?>"><?php loc('registrationApproved.success.gotoHomepage') ?></a>
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
				            	<div class="kurzerklaerung"><span><?php loc('registrationApproved.error.subline') ?></span></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link">
									<?php loc('registrationApproved.error.tryAgain') ?><br />
									<br />
									<?php loc('registrationApproved.error.help', '<a href="mailto:' . SUPPORT_MAIL_RECEIVER . '">' . SUPPORT_MAIL_RECEIVER . '</a>') ?>
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
				<?php if($success) { ?>
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('registrationApproved.success.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<p>
			        		<?php loc('registrationApproved.success.info.text', $user->getLogin()) ?>
			            </p>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE --> 	
			    <?php } else { ?>		
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('registrationApproved.error.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<p>
			        		<?php loc('registrationApproved.error.info.text', '<a href="mailto:' . SUPPORT_MAIL_RECEIVER . '">' . SUPPORT_MAIL_RECEIVER . '</a>'); ?> 
			            </p>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE --> 	
			    <?php } ?>                 
			                 
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>  
			
			<br />
		</div>
		<!-- Rechte Haelfte | ENDE -->
		
		<div class="clearbox"></div>
	</div>
	<!-- Content-Bereich | ENDE -->
</div>

<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>