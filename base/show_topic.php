<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

// Parameter auslesen
$urlId = getArrayElement($_GET, "urlId");
$enableSearchSwitch = true;

if ($urlId && $topic = Topic::fetchByUrlId($urlId)) {
	$id = $topic->getId();
	$title = $topic->getTitle();
	$twicks = $topic->findTwicks();
	$shortUrl = $topic->getShortUrl();
	$description = $twicks[0]->getText();
    $canonical = $topic->getUrl();
	$isNew = false;
} else {
	$title = correctCapitalization(getArrayElement($_GET, "title"));
	if ($title == "") {
		redirect(HTTP_ROOT . "/index.php");
	}
	$twicks = array();
	$isNew = true;
    $canonical = "http://twick.it/show_topic.php?title=" . urlencode($title);
	$description = "$title | " . _loc('core.titleClaim');
}

if (getArrayElement($_GET, "nomobile")) {
    setMobileCookie(false);
}
redirectMobile("http://m.twick.it/topic.php?search=" . urlencode($title));

$title = htmlspecialchars($title);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('topic.title', $title) ?><?php if(!isset($_GET["skipSuggestions"]) && !isset($_GET["tag"])) { ?> | <?php loc('core.titleClaim') ?><?php } ?></title>
	<meta property="og:title" content="<?php loc('topic.title', $title) ?>" />
	<?php if(!$isNew && $topic->hasCoordinates()) { ?>
	<meta property="og:latitude" content="<?php echo($topic->getLatitude()) ?>" />
	<meta property="og:longitude" content="<?php echo($topic->getLongitude()) ?>" />
	<meta name="geo.position" content="<?php echo($topic->getLatitude()) ?>;<?php echo($topic->getLongitude()) ?>" />
	<meta name="ICBM" content="<?php echo($topic->getLatitude()) ?>, <?php echo($topic->getLongitude()) ?>" />
	<?php } ?>
    <meta name="description" content="<?php echo($title) ?>: <?php echo(htmlspecialchars($description)) ?>" />   
    <meta name="keywords" content="<?php echo($title) ?>, <?php loc('core.keywords') ?>" />
    <link rel="canonical" href="<?php echo($canonical) ?>" />
    <link rel="alternate" type="application/rss+xml" title='RSS - <?php loc('rss.twicksForTopic', htmlspecialchars($title)) ?>' href="interfaces/rss/topic.php?title=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title='RSS - <?php loc('rss.topicsByTag', htmlspecialchars($title)) ?>' href="interfaces/rss/tag.php?tag=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>" />
	<?php if($topic) { ?>
	<link rel='shortlink' href='<?php echo($topic->getShortUrl()) ?>'/>
	<?php } ?>
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript">
	var topicTitle = "<?php echo($title) ?>";
	
	function updateContent(inTitle) {
		var url = "<?php echo(HTTP_ROOT) ?>/inc_show_topic.php?tag=1&title=" + encodeURIComponent(inTitle);
		new Ajax.Request(
			url, 
			{
				method: 'get',
			  	onSuccess: function(transport) {
				    $("contentFrame").update(transport.responseText);
					title = $("topicTitle").innerHTML;
					document.title = title + " | Twick.it";
				    topicTitle = title;
				    if($("loginForm")) {
				   		$("loginForm").action="<?php echo(HTTP_ROOT) ?>/action/login.php?title=" + encodeURIComponent(title);
				    }
				    insertWikipediaLink(inTitle);
					window.history.pushState(new Object(), title, $("myUrl").value);
					
				    expandPageTitles();
		  		}
			}
		);
	}

	preloadImage("<?php echo(HTTP_ROOT)?>/html/img/stern_hover.jpg");
	preloadImage("<?php echo(HTTP_ROOT)?>/html/img/totenkopf_hover.gif");
	preloadImage("<?php echo(HTTP_ROOT)?>/html/img/daumen_hoch_hover.jpg");
	preloadImage("<?php echo(HTTP_ROOT)?>/html/img/daumen_runter_hover.jpg");
	preloadImage("<?php echo(HTTP_ROOT)?>/html/img/pfeilbutton-vor.jpg");
	preloadImage("<?php echo(HTTP_ROOT)?>/html/img/pfeilbutton-vor_hover.jpg");
	preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo(getLanguage()) ?>/buttons/bt_tee_hover.jpg");
	</script>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
	    
		<?php 
		include("inc_show_topic.php");
		?>
		
		<script type="text/javascript">
			insertWikipediaLink("<?php echo($title) ?>");
			//linkToTwickIt($$(".acronym"), {wholeWord:true});
			expandPageTitles();
			<?php if (getArrayElement($_GET, "edit")) { ?>
				showEditor(<?php echo($_GET["edit"]) ?>);
			<?php } ?>
		</script>
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

	<!--[if IE]>
	<script type="text/javascript" src="html/js/png.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/interfaces/js/popup/twickit.js"></script>
</body>
</html>