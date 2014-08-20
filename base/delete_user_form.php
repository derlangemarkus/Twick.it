<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 
checkLogin();

$user = getUser();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('deleteAccount.title', $user->getLogin()) ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('deleteAccount.title', $user->getLogin()) ?>" />
    <meta name="description" content="<?php loc('deleteAccount.title', $user->getLogin()) ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript" src="html/js/twickit/twickit_userdata_js.php"></script>
</head>
<body>
<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
	    <!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('deleteAccount.headline', "<span id='topicTitle'>" . $user->getLogin() . "</span>") ?></h1>
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
				            	<div class="kurzerklaerung"><span><?php loc('deleteAccount.subline', $user->getLogin()) ?></span></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link">
									<?php loc('deleteAccount.text', $user->getLogin()) ?><br />
									<br />
									<a href="action/delete_user.php?id=<?php echo($user->getId()) ?>&secret=<?php echo($user->getSecret()) ?>"><?php loc('deleteAccount.yes') ?></a><br />
									<br />
									<br />
									<a href="user_data.php"><?php loc('deleteAccount.no') ?></a><br />
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
			
				<!-- Loeschen | START -->
			    <div class="teaser" id="wikipedia-teaser">
			    	<div class="teaser-head"><h2><?php loc('deleteAccount.areYouSure.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div><?php loc('deleteAccount.areYouSure.text') ?></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Loeschen | ENDE -->  
			    
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