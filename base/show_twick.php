<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 
$enableSearchSwitch = true;

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$twick = Twick::fetchById($id);
if(!$twick) {
	redirect(HTTP_ROOT . "/" . substringAfter(substringBeforeLast($_SERVER["REQUEST_URI"], "/"), "twick/"));
}
$topic = $twick->findTopic();
$user = $twick->findUser();

//setLanguage($twick->getLanguageCode(), true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('singleTwick.title', array(htmlspecialchars($user->getDisplayName()), $twick->getTitle())) ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('singleTwick.title', array(htmlspecialchars($user->getDisplayName()), htmlspecialchars($twick->getTitle()))) ?>" />
    <meta name="description" content="<?php loc('singleTwick.title', array(htmlspecialchars($user->getDisplayName()), htmlspecialchars($twick->getTitle()))) ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>, <?php echo($twick->getTitle()) ?>" />
    <link rel="canonical" href="<?php echo($topic->getUrl()) ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.twicksForTopic', htmlspecialchars($topic->getTitle())) ?>" href="interfaces/rss/topic.php?title=<?php echo(urlencode($topic->getTitle())) ?>&lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.topicsByTag', htmlspecialchars($topic->getTitle())) ?>" href="interfaces/rss/tag.php?tag=<?php echo(urlencode($topic->getTitle())) ?>&lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.twicksFromUser', htmlspecialchars($user->getDisplayName())) ?>" href="interfaces/rss/user.php?username=<?php echo($user->getLogin()) ?>&lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.userTopics', htmlspecialchars($user->getDisplayName())) ?>" href="interfaces/rss/user_topics.php?username=<?php echo($user->getLogin()) ?>&lng=<?php echo(getLanguage()) ?>" />
	<?php include("inc/inc_global_header.php"); ?>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1><?php loc('singleTwick.headline', array(htmlspecialchars($user->getDisplayName()), $twick->getTitle(), $topic->getUrl())) ?></h1>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<div class="teekesselchen"><span><b><?php loc('singleTwick.position', array($twick->getTitle(), $twick->findRatingPosition(), $twick->findSiblingCount())) ?></b></span><div class="clearbox"></div></div>
				<?php $twick->display(false, 2, true, true) ?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			   	<?php 
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
			    $stem = Topic::findRelatedTopicsByStemming($twick->getTitle());
			    if (sizeof($stem) > 1) {
			    ?>
			    <!-- Stemming | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('topic.stemming.title') ?></h2></div>
			        <div class="teaser-body nopadding">
			        	<ul class="bullets">
			                <?php 
			                foreach($stem as $related) { 
								?><li><a href="<?php echo($related->getUrl()) ?>"><?php echo($related->getTitle()) ?></a></li><?php 
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
		
				<?php 
			    if ($topic) {
			    	$relatedTopics = $topic->findRelatedTopics(9);
			    	$moreUrl = $topic->getUrl() . "/related";
			    } else {
			    	$relatedTopics = Topic::findRelatedTopicsByTitle($title);
			    	$moreUrl = "show_related_topics.php?title=" . urlencode($title);
			    }
			    if (sizeof($relatedTopics)) {
			    	$hasMore = sizeof($relatedTopics) > 8;
			    	if ($hasMore) {
			    		$relatedTopics = array_slice($relatedTopics, 0, 8);
			    	}
			    ?>
			    <!-- Verwandte Themen | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('topic.related.title') ?></h2></div>
			        <div class="teaser-body nopadding">
			        	<ul class="bullets">
			                <?php 
			                foreach($relatedTopics as $relatedTopic) { 
								?><li><a href="<?php echo($relatedTopic->getUrl()) ?>"><?php echo($relatedTopic->getTitle()) ?></a></li><?php 
			                }
			                ?> 
			            </ul>
			            <?php
			            if($hasMore) {
						?><a href="<?php echo($moreUrl) ?>" class="teaser-link" title="mehr"><img src="html/img/pfeil_weiss.gif" width="15" height="9"/>mehr</a><br /><?php 
		                }
						?>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Verwandte Themen | ENDE -->  
			    <?php 
			    }
			    ?>
		    	
		    	<!-- RSS | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>RSS</h2></div>
			        <div class="teaser-body nopadding">
			        	<ul>
			        		<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/topic.php?title=<?php echo(urlencode($topic->getTitle())) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.twicksForTopic', $topic->getTitle()) ?></a></li>
							<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/tag.php?tag=<?php echo(urlencode($topic->getTitle())) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.topicsByTag', $topic->getTitle()) ?></a></li>
							<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/user.php?username=<?php echo($user->getLogin()) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.twicksFromUser', htmlspecialchars($user->getDisplayName())) ?></a></li>
							<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/user_topics.php?username=<?php echo($user->getLogin()) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.userTopics', htmlspecialchars($user->getDisplayName())) ?></a></li>
			            </ul>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- RSS | ENDE --> 
			                 
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>  
			
			<br />
		</div>
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