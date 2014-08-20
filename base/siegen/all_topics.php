<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
ini_set("display_errors", 1);	
setDBCacheTimeout(60);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo(HTTP_ROOT) ?>/" />
    <title><?php loc('allTopics.title') ?> | Twick.it</title>
    <meta name="description" content="<?php loc('allTopics.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="interfaces/browser_plugins/twickit-search.xml" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTwicks') ?>" href="interfaces/rss/latest.php?lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTopics') ?>" href="interfaces/rss/latest_topics.php?lng=<?php echo(getLanguage()) ?>" />
	
    <link href="html/css/twick-styles.css" rel="stylesheet" type="text/css" />
	
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
			<h1><?php loc('allTopics.title') ?></h1>
		</div>
    
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
			
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1>Hier findest du eine kleine (nicht vollständige) Auswahl von bereits<br />erklärten Begriffen</h1></div>
					<div class="blog-body">
						<ul class="bulletsbig">
							<?php 
							$prevChar = "";
							foreach(Topic::fetchBySQL("id IN (SELECT x.topic_id FROM tbl_twicks x, tbl_twick_favorites f WHERE f.user_id=710 AND f.twick_id=x.id) ORDER BY title", true) as $topic) { 
								$thisChar = strtoupper(substr($topic->getTitle(), 0, 1));
								if (htmlentities($thisChar) != $thisChar) {
									$thisChar = substr(htmlentities($thisChar), 1, 1);
								} else {
									if ($thisChar == "Ä") {
										$thisChar = "A";
									} else if ($thisChar == "Ö") {
										$thisChar = "O";
									} else if ($thisChar == "Ü") {
										$thisChar = "U";
									} 
								}
								if ($thisChar != $prevChar) {
									if ($prevChar) {
										echo("<br /><br />");
									}
									echo("<h1>$thisChar</h1>");
								}
							?>
							<li><a href="<?php echo($topic->getUrl()) ?>"><?php echo($topic->getTitle()) ?></a></li>
							<?php 
								$prevChar = $thisChar;
							} 
							?>
						</ul>
						<br />
					</div>
					<div class="blog-footer">
					
					</div>
				</div>
				<!-- Kasten | ENDE -->
				
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
				<!-- Alle Twicks | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>Noch mehr Twicks</h2></div>
			        <div class="teaser-body">
			        	Twick.it, die Erklärmaschine hat auch zu anderen Themen außer Siegen viele Erklärungen. Hier findest du über 10.000 Erklärungen zu den unterschiedlichsten Themen.<br />
			        	<a href="all_topics.php" class="teaser-link"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('core.more') ?></a><br />
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Alle Twicks | ENDE -->  
			    
		    	<!-- RSS | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>RSS</h2></div>
			        <div class="teaser-body nopadding">
			        	<ul>
			        		<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/latest.php?lng=<?php echo(getLanguage()) ?>"><?php loc('rss.latestTwicks') ?></a></li>
							<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/latest_topics.php?lng=<?php echo(getLanguage()) ?>"><?php loc('rss.latestTopics') ?></a></li>
			            </ul>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- RSS | ENDE --> 
			                 
				<!-- Icon-Bookmark Leiste | START -->
				<?php 
				$bookmarks = new Bookmarker(_loc('relatedTopics.title', $title), substringBefore(HTTP_ROOT, CONTEXT_PATH) . $_SERVER["REQUEST_URI"]);
				?>
		    	<div class="bookmark-leiste">
		        	<a href="<?php $bookmarks->printBookmarkLink("del.icio.us") ?>" class="bookmark" id="book_1" title="del.icio.us"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("MisterWong") ?>" class="bookmark" id="book_2" title="MisterWong"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("facebook") ?>" class="bookmark" id="book_3" title="facebook"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("Twitter") ?>" class="bookmark" id="book_4" title="Twitter"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("Digg") ?>" class="bookmark" id="book_5" title="Digg"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("StumbleUpon") ?>" class="bookmark" id="book_6" title="StumbleUpon"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("Technorati") ?>" class="bookmark" id="book_7" title="Technorati"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("Google Bookmarks") ?>" class="bookmark" id="book_8" title="Google Bookmarks"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("Live") ?>" class="bookmark" id="book_9" title="Live"></a>
		            <a href="<?php $bookmarks->printBookmarkLink("Yigg") ?>" class="bookmark" id="book_10" title="Yigg"></a>
		            <div class="clearbox"></div>
		        </div>
			    <!-- Icon-Bookmark Leiste | START -->         
			
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
