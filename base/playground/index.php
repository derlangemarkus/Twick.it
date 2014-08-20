<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo(HTTP_ROOT) ?>/" />
    <title><?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
    <meta name="robots" content="index,follow" />
    <meta name="revisit-after" content="1 days" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="../interfaces/browser_plugins/twickit-search.xml" />
	
    <link href="../html/css/twick-styles.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/scriptaculous/src/scriptaculous.js?load=effects"></script>
    <script type="text/javascript" src="../html/js/twickit/twickit_twick_js.php"></script>
	<!--[if IE]>
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/png.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/interfaces/js/popup/twickit.js"></script>
</head>
<body>
	<?php include("../inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1>Spielereien rund um die Erklärmaschine</h1>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links" style="width:920px;background-color:#EFEFEF;">
				<div class="homepage-teaser">
					<div class="text">
                        <b>Twick.it-Map</b><br />
                        Alle Erklärungen werden auf einer Karte dargestellt. 
                    </div>
                </div>
                <div class="homepage-teaser">
                    <div class="text">
                        <b>Google Maps</b><br />
                        Alle Erklärungen werden in Google Maps dargestellt.
                    </div>
                </div>
                <div class="homepage-teaser">
                    <div class="text">
                        <b>Augmented Reality</b><br />
                        Blendet Erklärungen in die Live-Aufnahmen der Handy-Kamera ein.
                    </div>
				</div>

                <div class="homepage-teaser">
                    <div class="text">
                        <b>Find-the-topic</b><br />
                        Wir zeigen die Tag-Cloud. Du rätst das Thema.
                    </div>
				</div>

                <div class="homepage-teaser">
                    <div class="text">
                        <b>Google Chrome-Plugin</b><br />
                        Erklärungen auf jeder Webseite
                    </div>
				</div>

                <div class="homepage-teaser">
                    <div class="text">
                        <b>Twick.it-Android-App</b><br />
                        Jooce machts möglich: Twicks auf deinem Smartphone
                    </div>
				</div>
				<br style="clear:both;"/>
			</div>
			<!-- Linke Haelfte | ENDE -->
		
		
		<div class="clearbox"></div>
	</div>
	<!-- Content-Bereich | ENDE -->
</div>

<?php
include(DOCUMENT_ROOT . "/inc/inc_footer.php"); 
?>

</body>
</html>