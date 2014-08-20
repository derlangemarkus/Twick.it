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
$title = getArrayElement($_GET, "title");
if(trim($title) == "") {
	$title = getArrayElement($_GET, "old_title");
} 
$acronym = trim(getArrayElement($_GET, "acronym", ""));
$text = strtr(trim(getArrayElement($_GET, "text")), "\n\r\t", "  ");
$link = getArrayElement($_GET, "link");
$user = getUser(true);

$topic = array_pop(Topic::fetchByTitle(htmlspecialchars($title)));

if ($id) { 
	$backUrl = $topic->getUrl() . "?edit=$id&text=" . urlencode($text) . "&link=" . urlencode($link) . "&acronym=" . urlencode($acronym) . "#$id"; 
} else {
	if ($topic) {
		$backUrl = $topic->getUrl() . "?edit=&new_text=" . urlencode($text) . "&new_link=" . urlencode($link) . "&new_acronym=" . urlencode($acronym) . "#yourText";
	} else {
		$backUrl = "show_topic.php?title=" . urlencode($title) . "&edit=&title=" . urlencode($title) . "&new_text=" . urlencode($text) . "&new_link=" . urlencode($link) . "&new_acronym=" . urlencode($acronym) . "#yourText";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo htmlspecialchars($title) ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php echo htmlspecialchars($title) ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($title) ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php echo htmlspecialchars($title) ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.twicksForTopic', htmlspecialchars($title)) ?>" href="interfaces/rss/topic.php?title=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.topicsByTag', htmlspecialchars($title)) ?>" href="interfaces/rss/tag.php?tag=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>" />
	<?php include("inc/inc_global_header.php"); ?>
	<style type="text/css">
	a#backbutton { padding-left:22px;color:#444444;font-size:15px;background-image: url(html/img/pfeilbutton-zurueck.jpg); background-position: left 1px; background-repeat: no-repeat; }
	a:hover#backbutton { background-image: url(html/img/pfeilbutton-zurueck_hover.jpg); color:#777777; }
	</style>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
	<?php
	$enableTwick = true; 
	if (!SpamBlocker::check($_GET, 2)) { 
		popup(_loc('confirmTwick.error.spam', NOSPAM_MAIL_RECEIVER));
		$enableTwick = false;
	} else if(mb_strlen($text, "utf8") > 140) { 
		popup(_loc('confirmTwick.error.140', mb_strlen($text, "utf8")));
		$enableTwick = false;
	} else if(containsBlacklistWords($text)) { 
		popup(_loc('confirmTwick.error.blacklist'));
		$enableTwick = false;
	} else if(mb_strlen($text, "utf8") < 1) {
		popup(_loc('confirmTwick.error.noText'));
		$enableTwick = false;
	} else if(!$id && !$user->isAnonymous() && $topic && $topic->findNumberOfTwicksForUserInTheLastHours(getUserId()) >= 2) {
		popup(_loc('confirmTwick.error.limit'));
		$enableTwick = false;
	} 
	?>
	
    <div id="contentFrame">
    	<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1><?php loc('confirmTwick.headline', htmlspecialchars($title)) ?></h1>
   		</div>
   		
   		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<div class="teekesselchen" id="achtung"><span><b><?php loc('confirmTwick.subline') ?></b></span><div class="clearbox"></div></div>
				
				<!-- Sprechblase | START -->
				<div class="sprechblase">
				    <h2><?php loc('confirmTwick.about', array($user->getLogin(), htmlspecialchars($title))) ?></h2>
				    <div class="sprechblase-main">
				        <div class="sprechblase-links"> 
				        	<?php if(trim($user->getName()) != "") { ?><i>(<?php echo($user->getName()) ?>)</i><?php } ?>
				            <div class="bilderrahmen">
								<?php 
								if($user->isAnonymous()) { 
									?><img src="html/img/avatar/anonymous64.jpg" alt="" /><?php
								} else { 
									?><a href="<?php echo($user->getUrl()) ?>" title="<?php echo htmlspecialchars($user->getDisplayName()) ?>"><?php echo($user->getAvatar(64)) ?></a><?php 
								} 
								?>
							</div>
				        </div>
				        <div class="sprechblase-rechts">
				            <div class="blase-header" style="background-image:url(html/img/blase__header_ohne.jpg);">
				                <div class="kurzerklaerung" style="width:330px;">
				                	<?php if($acronym != "") { ?>
				                	<span><?php loc('twick.accronym') ?>:</span><span class="acronym"><?php echo htmlspecialchars($acronym) ?></span>
				                	<?php } else { 
				                		loc('confirmTwick.noAccronym', htmlspecialchars($title));
				                	}
				                	?>
				                </div>
				            </div>
				            <div class="blase-body">
				                <dl>
				                    <dt style="display:none;"><?php echo htmlspecialchars($title) ?>:</dt>
				                    <dd><?php echo htmlspecialchars($text) ?></dd>
				                </dl>
				                <div class="twick-link">
				                	<?php if ($link) { ?>
				                	<a href="<?php echo htmlspecialchars($link) ?>" target="_blank" class="moreinfos" id="moreinfos"><?php echo str_replace("&lt;wbr /&gt;", "<wbr />", str_replace("?", "?<wbr />", htmlspecialchars(str_replace("&", "&<wbr />", $link)))) ?></a>
				                	<?php } else { ?>
				                	<i><?php loc('confirmTwick.noUrl') ?></i>
				                	<?php }  ?>
				                </div>
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer">
				            	<div style="width:210px;float:left;"><a href="<?php echo($backUrl) ?>" id="backbutton"><?php loc('core.back') ?></a></div>
				            	<div style="width:150px;float:left;color:#F00;" id="confirm">
				            	<?php if ($enableTwick) { ?>
				                <?php loc('confirmTwick.countdown.1') ?> 3 <?php loc('confirmTwick.countdown.2') ?>
				                <?php } ?>
				                </div>
				            </div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- Sprechblase | ENDE -->
				
				
				<?php 
				if ($enableTwick) {
					?><form action="action/save_twick.php" method="get" id="twickit-blase">
						<?php echo(SpamBlocker::printHiddenTags()) ?>
						<input type="hidden" name="secret" value="<?php echo($user->getSecret()) ?>" />
						<input type="hidden" name="id" value="<?php echo($id) ?>" />
						<input type="hidden" name="title" value="<?php echo htmlspecialchars($title) ?>" />
					  	<input type="hidden" name="acronym" value="<?php echo htmlspecialchars($acronym) ?>" />
					  	<input type="hidden" name="text" value="<?php echo htmlspecialchars($text) ?>" />
					  	<input type="hidden" name="link" value="<?php echo htmlspecialchars($link) ?>" />
					</form><?php 
				} 
				?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			   
			   	<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('confirmTwick.info.headline') ?></h2></div>
			        <div class="teaser-body">
			        	<?php loc('confirmTwick.info.text') ?>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
			   
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
			    if (sizeof($stem) >= 1) {
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
						?><a href="<?php echo($moreUrl) ?>" class="teaser-link" title="mehr"><img src="html/img/pfeil_weiss.gif" /><?php loc('core.more') ?></a><br /><?php 
		                }
						?>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Verwandte Themen | ENDE -->  
			    <?php 
			    }
			    ?>

    
			    <?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?> 
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
					
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

	<?php 
	if ($enableTwick) { 
		drillDown(_loc('confirmTwick.subline'));
	?>
    <script type="text/javascript">
	function countDown(inTimeLeft) {
		if (inTimeLeft > 0) {
			$("confirm").update("<?php loc('confirmTwick.countdown.1') ?>" + inTimeLeft + "<?php loc('confirmTwick.countdown.2') ?>");
			window.setTimeout("countDown(" + (inTimeLeft-1) + ")", 1001);
		} else {
			var link = new Element("a", { "href": "javascript:;", "id": "twickit", "class": "twickitconfirm"}).update("<?php loc('yourTwick.confirm') ?>");
			link.onclick = function() { waitPopup(); $('twickit-blase').submit(); };
			$("confirm").update("");
			$("confirm").appendChild(link);
			link.pulsate({from:0.65});
		}
	}
	countDown(3);
    </script>
	<?php 
	} 
	?>
</body>
</html>