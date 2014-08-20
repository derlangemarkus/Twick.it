<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

if (getArrayElement($_GET, "nomobile")) {
    setMobileCookie(false);
}

redirectMobile("http://m.twick.it/index.php");
$activeTab = "start";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
	<meta name="google-site-verification" content="J0wbPBp478hZfTYDXu67X2sBh6A7qgEE1n6osQWWul4" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <meta property="og:title" content="<?php loc('core.titleClaim') ?>" />
    <link rel="canonical" href="http://twick.it" />
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/TickerTape/TickerTape_js.php"></script>
	<?php redirectMobile("http://m.twick.it/index.php"); ?>
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
					<div class="text"><?php loc('homepage.step.1') ?><br /><br /><?php loc('homepage.whatIsTwickIt') ?></div>
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
$footerMessage = "<a href='all_topics.php' style='padding-left:22px;float:left;'>". _loc('homepage.summary', number_format(Twick::findNumberOfTwicks(true), 0, _loc('format.number.decimal'), _loc('format.number.thousand'))) . "</a>";
include(DOCUMENT_ROOT . "/inc/inc_footer.php"); 
?>

</body>
</html>