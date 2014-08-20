<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('spam.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('spam.title') ?>" />
    <meta name="description" content="<?php loc('spam.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
	    <!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('spam.headline') ?></h1>
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
				            	<div class="kurzerklaerung"><span><?php loc('spam.subline') ?></span></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link"><?php loc('spam.text', encodeEMailAddress(NOSPAM_MAIL_RECEIVER)) ?></div>
								<div class="twick-link" style="line-height: 33px; padding-left: 15px;">
									<a href="index.php"><?php loc('spam.homepage') ?></a><br />
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
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('spam.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('spam.info.text', encodeEMailAddress(SUPPORT_MAIL_RECEIVER)) ?>
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
