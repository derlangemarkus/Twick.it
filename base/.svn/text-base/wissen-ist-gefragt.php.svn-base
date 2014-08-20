<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

$activeTab = "start";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
	<meta name="google-site-verification" content="J0wbPBp478hZfTYDXu67X2sBh6A7qgEE1n6osQWWul4" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo(HTTP_ROOT) ?>/" />
    <title><?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
    <meta name="robots" content="index,follow" />
	<meta name="revisit-after" content="1 days" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="interfaces/browser_plugins/twickit-search.xml" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTwicks') ?>" href="interfaces/rss/latest.php?lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTopics') ?>" href="interfaces/rss/latest_topics.php?lng=<?php echo(getLanguage()) ?>" />
	
    <link href="html/css/twick-styles.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="html/js/scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src="html/js/scriptaculous/src/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="html/js/swfobject.js"></script>
	<script type="text/javascript" src="html/js/twickit/twickit_twick_js.php"></script>
	<!--[if IE]>
	<script type="text/javascript" src="html/js/png.js"></script>
	<![endif]-->
	<script type="text/javascript" src="interfaces/js/popup/twickit.js"></script>
	<script type="text/javascript" src="html/js/TickerTape/TickerTape_js.php?v101"></script>
	
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1><?php loc('homepage.welcome') ?></h1>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links" style="width:920px;background-color:#EFEFEF;">
				<div id="step1" class="homepage-teaser" style="display:none;">
					<div class="zahl">1</div>
					<div class="text"><?php loc('homepage.step.1') ?></div>
				</div>
			
				<div id="step2" class="homepage-teaser" style="display:none;">
					<div class="zahl">2</div>
					<div class="text"><?php loc('homepage.step.2') ?></div>
				</div>
				
				<div id="step3" class="homepage-teaser" style="display:none;">
					<div class="zahl">3</div>
					<div class="text"><?php loc('homepage.step.3') ?></div>
				</div>
			
				<br style="clear:both;"/>
			
				<!-- Laufschrift | START  -->
				<script type="text/javascript">new TickerTape('inc/ajax/tickertape.php', 'horizontalTickerTape', 200, true);</script>
				<!-- Laufschrift | ENDE -->
				
				<div style="width:68px;height:55px;display:block;position:absolute;margin-top:-60px;background-image:url(html/img/fade_l.png); background-repeat:repeat-y;"></div>
				<div style="width:68px;height:55px;display:block;position:absolute;margin-left:852px;margin-top:-60px;background-image:url(html/img/fade_r.png); background-repeat:repeat-y;"></div>
				
				<script type="text/javascript">
				Effect.Appear("step1", { delay: 0 });
				Effect.Appear("step2", { delay: 0.5 });
				Effect.Appear("step3", { delay: 1 });
				</script>
			</div>
			<!-- Linke Haelfte | ENDE -->
		
		
		<div class="clearbox"></div>
	</div>
	<!-- Content-Bereich | ENDE -->
</div>



<?php
$footerMessage = "<a href='all_topics.php'>". _loc('homepage.summary', number_format(TwickInfo::findNumberOfTwicks(true), 0, _loc('format.number.decimal'), _loc('format.number.thousand'))) . "</a>";
include(DOCUMENT_ROOT . "/inc/inc_footer.php"); 
?>

<div id="curtain"></div><div style="top: 150px; left: 400px;" class="popup-kasten" id="welcomePopup"><div class="popup-head" style="width:361px;"><h1>Dein Wissen ist gefragt bei Twick.it.</h1></div><div id="popup-content" class="popup-body">Du bist ein Experte für ein bestimmtes Wissensgebiet? Und du kannst gut erklären? Dann bist du bei Twick.it genau richtig. Hier kannst du Erklärungen für jedes beliebige Thema erstellen und diese von anderen Nutzern bewerten lassen.<br /><br />Die beste Erklärung wird bei Suchanfragen von allen Suchmaschinen, Websites und Handys, die unsere Datenbank nutzen, angezeigt. So kann deine Erklärung von Menschen auf der ganzen Welt gelesen werden. Und deine Online-Reputation wächst mit jedem guten Twick.<br /><br />

<a href="javascript:;" id="popup_ok" style="cursor:pointer;margin-left:100px;float:left;position:absolute;" onclick="$('curtain').hide();$('welcomePopup').hide();">Jetzt mitmachen!</a>
</div><div class="popup-footer" style="width:361px;"><div style="width: 100%;"></div></div></div>
<script type="text/javascript">
	fade($("curtain"), 0.6);
	var popup = $('welcomePopup');
	popup.style.left = ((document.documentElement.clientWidth/2) - (popup.offsetWidth/2)) + "px";
</script>

</body>
</html>