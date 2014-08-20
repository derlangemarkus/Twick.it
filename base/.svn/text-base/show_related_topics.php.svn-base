<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 
$enableSearchSwitch = true;

// Parameter auslesen
$title = getArrayElement($_GET, "title");
$urlId = getArrayElement($_GET, "urlId");

if ($urlId) {
	//$lng = substringBefore($urlId, "/");
	//setLanguage($lng, true);
	
	$topic = Topic::fetchByUrlId($urlId);
	$title = $topic->getTitle();
	$relatedTopics = $topic->findRelatedTopics();
	$backUrl = $topic->getUrl();
} else {
	$relatedTopics = Topic::findRelatedTopicsByTitle($title);
	$backUrl = "show_topic.php?title=" . urlencode($title);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('relatedTopics.title', $title) ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('relatedTopics.title', $title) ?>" />
    <meta name="description" content="<?php loc('relatedTopics.title', $title) ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php echo($title) ?>, <?php loc('core.keywords') ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.twicksForTopic', $title) ?>" href="interfaces/rss/topic.php?title=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.topicsByTag', $title) ?>" href="interfaces/rss/tag.php?tag=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>" />
	<script type="text/javascript" src="html/js/swfobject.js"></script>
	<?php include("inc/inc_global_header.php"); ?>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><?php loc('relatedTopics.headline', "<a href='$backUrl'>$title</a>") ?></h1></div>
					<div class="blog-body">
						<ul class="bulletsbig">
						<?php 
						foreach($relatedTopics as $relatedTopic) {
							echo("<li><a href='" . $relatedTopic->getUrl() . "'>" . $relatedTopic->getTitle() . "</a></li>");
						}
						?>
						</ul>
					</div>
					<div class="blog-footer"></div>
				</div>
				<!-- Kasten | ENDE -->
				
				<div class="haupt-buttonfeld">
                    <a id="userTwicksMoreLink" href="<?php echo($backUrl) ?>"><?php loc('relatedTopics.back') ?></a>
                </div>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			   	<?php 
			   	if ($topic) {
					$keywords = $topic->getTags();
				?>
			    <!-- Tagcloud | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('core.tagCloud') ?></h2></div>
			        <div class="teaser-body">
			        	<?php include(DOCUMENT_ROOT . "/inc/inc_cloud.php"); ?>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Tagcloud | ENDE -->  
			    <?php 
			   	}
			   	?>
			    
			    <?php 
			    $stem = Topic::findRelatedTopicsByStemming($title);
			    if (sizeof($stem) > 1) {
			    ?>
			    <!-- Stemming | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('topic.stemming.title') ?></h2></div>
			        <div class="teaser-body nopadding">
			        	<ul class="bullets">
			                <?php 
			                foreach($stem as $related) { 
								if ($coreTitle != $related->getCoreTitle()) {
									?><li><a href="<?php echo($related->getUrl()) ?>"><?php echo($related->getTitle()) ?></a></li><?php 
								}
			                } 
							?>
						</ul>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Stemming | ENDE -->  
			    <?php 
			    }
			    ?>
		
		    	<!-- RSS | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>RSS</h2></div>
			        <div class="teaser-body nopadding">
			        	<ul>
			        		<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/topic.php?title=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.twicksForTopic', $title) ?></a></li>
							<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/tag.php?tag=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.topicsByTag', $title) ?></a></li>
			            </ul>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- RSS | ENDE --> 
			                 
				<!-- Icon-Bookmark Leiste | START -->
				<div class="bookmark-leiste" style="margin-left:40px;">
					<?php $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>
					<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($url); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=400&amp;font=arial" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:135px;height:23px;" allowTransparency="true"></iframe>
					<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo($url) ?>" data-count="horizontal" data-via="TwickIt" data-related="twickit_<?php echo(getLanguage()) ?>" data-lang="<?php echo(getLanguage()) ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
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