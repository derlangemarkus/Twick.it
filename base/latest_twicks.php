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

redirectMobile("http://m.twick.it/latest.php");

if (!isAdmin()) {
	setDBCacheTimeout(70);
}
$numberOfTwicks = number_format(TwickInfo::findNumberOfTwicks(true), 0, _loc('format.number.decimal'), _loc('format.number.thousand'));

$onlyNew = getArrayElement($_GET, "new");
if ($onlyNew) {
	$twicks = Twick::fetchNewestFromRookies(100);	
} else {
	$twicks = Twick::fetchNewest(50);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('latestTwicks.title') ?> | <?php loc('core.titleClaim') ?></title>
    <meta property="og:title" content="<?php loc('core.titleClaim') ?>" />
    <meta name="description" content="<?php loc('latestTwicks.title') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <meta http-equiv="refresh" content="300; URL=<?php echo(HTTP_ROOT) ?>/latest_twicks.php<?php if($onlyNew) { ?>?new=1<?php } ?>" />
    <link rel="canonical" href="http://twick.it/latest_twicks.php" />
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript" src="html/js/swfobject.js"></script>
	<script type="text/javascript">
		if(isMobile()) {
			document.location.href="http://m.twick.it/latest.php?msg=mobile.switchMessage";
		}
	</script>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('latestTwicks.headline') ?><?php if($onlyNew) { ?> (Rookies)<?php } ?></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php 
				foreach($twicks as $twick) { 
					$twick->display(false, 5);
				} 
				?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts unimportant">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('latestTwicks.info.title') ?><?php if($onlyNew) { ?> (Rookies)<?php } ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php
			        		if(isAdmin()) { 
			        			if ($onlyNew) {
			        				loc('latestTwicks.info.text.admin.rookie', number_format(TwickInfo::findNumberOfTwicks(true), 0, _loc('format.number.decimal'), _loc('format.number.thousand')));
			        			} else {
			        				loc('latestTwicks.info.text.admin.normal', $numberOfTwicks);
			        			}
			        		} else {
			        			loc('latestTwicks.info.text');
			        		} 
			        		?>
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
		
				<!-- Zufaelliger Artikel | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('404.random.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<a href="random.php"><?php loc('404.random.text') ?></a><br /> 
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Zufaelliger Artikel | ENDE -->  
			    
			    <!-- RSS | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>RSS</h2></div>
			        <div class="teaser-body nopadding">
			        	<ul>
			        		<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/latest.php?lng=<?php echo(getLanguage()) ?>"><?php loc('rss.latestTwicks', $title) ?></a></li>
							<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/latest_topics.php?lng=<?php echo(getLanguage()) ?>"><?php loc('rss.latestTopics', $title) ?></a></li>
			            </ul>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- RSS | ENDE --> 
						              
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>     
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>
	<script type="text/javascript">
		expandPageTitles();
	</script>	
</body>
</html>
