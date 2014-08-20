<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

// Parameter auslesen
$urlId = getArrayElement($_GET, "urlId");
$title = getArrayElement($_GET, "title");

if ($urlId) {
	$topic = Topic::fetchByUrlId($urlId);
} else {
	$topic = array_pop(Topic::fetchByTitle($title));
}
if ($topic) {
	$title = $topic->getTitle();
	$titleStemming = $topic->getStemming();
	$id = $topic->getId();
	$twicks = $topic->findTwicks();
	$shortUrl = $topic->getShortUrl();
	$isNew = false;
	$keywords = $topic->getTags();
    $url = $topic->getShortUrl();
    $myUrl = $topic->getUrl();
    $rawTitle = $title;
} else {
	require_once(DOCUMENT_ROOT . "/util/thirdparty/stemming/StemmingFactory.class.php");
	$title = correctCapitalization(getArrayElement($_GET, "title"));
    $rawTitle = $title;
	$titleStemming = StemmingFactory::stem($title);
	$twicks = array();
	$shortUrl = "";
	$isNew = true;
	$keywords = array();
    $myUrl = HTTP_ROOT . "/show_topic.php?title=" . urlencode(utf8_encode($rawTitle));
    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
}
$coreTitle = getCoreTitle($title);
?>
<script type="text/javascript">
$("search").value="<?php echo ($rawTitle) ?>";
$("myUrl").value="<?php echo($shortUrl) ?>";
</script>
<!-- Ergebnis-Feld -->
<div class="header-ergebnisfeld" id="header-ergebnisfeld">
	<h1>&quot;<span id="topicTitle"><?php echo htmlspecialchars($title) ?></span><?php 
		if(isAdmin() && $id) { 
		?><form action="#" id="topicTitleForm" style="display:none;">
			<input type="hidden" name="id" value="<?php echo($id) ?>" />
			<input type="text" name="title" value="<?php echo($title) ?>" />
			<a href="javascript:;" onclick="changeTitle()"><?php loc('core.save') ?></a>
		</form><?php 
		} 
		?>&quot; <?php loc('topic.headline') ?>:
<?php if(isAdmin() && $id) { ?>
<a href="javascript:;" onclick="$('topicTitle').hide();$('topicTitleForm').style.display='inline';$('topicTitleChangeLink').hide();" id="topicTitleChangeLink"><img src="<?php echo(STATIC_ROOT) ?>/html/img/stift.gif" alt="" width="21" height="20" /></a>
<script type="text/javascript">
function changeTitle() {
	new Ajax.Request(
		"action/edit_topic_title.php", 
		{
			method: 'POST',
			parameters: $('topicTitleForm').serialize(true),
		  	onSuccess: function(transport) {
				$("topicTitle").update(transport.responseText);
				$('topicTitleForm').hide();
				$('topicTitle').show();
				$('topicTitleChangeLink').show();
	  		}	
		}
	);
}
</script>
<?php } ?>
<?php if(isGeo() && $id) { ?>
<a href="admin/geo.php?id=<?php echo($id) ?>" target="_blank"><img src="<?php echo(STATIC_ROOT) ?>/html/img/world<?php if(!$topic->hasCoordinates()) { echo("_off"); } ?>.png" /></a>
<?php } ?>
</h1></div>

<!-- Content-Bereich | START -->
<div class="content">
	
	<!-- Linke Haelfte | START -->
	<div class="inhalte-links">
		<!-- Teekesselchen | START -->
		<?php 
		$homonyms = Topic::findHomonymsByTitle($title, $id);
		if ($homonyms) {
			?><div class="teekesselchen" id="achtung"><b><?php loc('homonyms.header.attention') ?>:</b><span style="padding-left:10px;"><?php loc('homonyms.header.text') ?></span><a href="javascript:;" onclick="Effect.toggle('teekesselchencontent', 'blind');" class="more-<?php echo(getLanguage()) ?>"></a><div class="clearbox"></div></div>
			<script type="text/javascript">
				Event.observe(window, 'load', function() {$('achtung').pulsate();});
			</script>
			<!-- Kasten | START -->
			<div class="blog-kasten" id="teekesselchencontent" style="display:none;">
				<div class="blog-head"><?php loc('homonyms.header.otherMeanings') ?></div>
				<div class="blog-body">
					<ul class="bulletsbig">
					<?php
						foreach($homonyms as $homonym) { 
							?><li><a href="<?php echo($homonym->getUrl()) ?>"><?php echo(htmlspecialchars($homonym->getTitle())) ?></a></li><?php 
						}
						?>
					</ul>
				</div>
				<div class="blog-footer">
				<a rel="nofollow" href="create_homonym.php?title=<?php echo(urlencode($coreTitle)) ?>&id=<?php echo($id) ?>" id="createLink" style="margin-top:15px; float:left"><img src="html/img/pfeil_weiss.gif" /><?php loc('homonyms.header.createNewMeaning') ?></a>
				</div>
			</div>
			<!-- Kasten | ENDE -->
			<?php 
		} else if($isNew) {
			?><div class="teekesselchen"><span><b><?php loc('topic.noTwicks.text', htmlspecialchars($title)) ?></b></span><div class="clearbox"></div></div><?php
		} else {
			?><div class="teekesselchen"><span><?php loc('homonyms.header.question') ?></span><a href="create_homonym.php?title=<?php echo(urlencode($coreTitle)) ?>&id=<?php echo($id) ?>" class="more-<?php echo(getLanguage()) ?>"></a><div class="clearbox"></div></div><?php
		}
		?>	   	
	   	<!-- Teekesselchen | ENDE -->
	    
		<?php 
		if($isNew) { 
			drillDown(_loc('topic.noTwicks.text', $title));

			include(DOCUMENT_ROOT . "/inc/inc_your_text.php");
			
			if (!getArrayElement($_GET, "skipSuggestions")) {
				$suggestions = Topic::findSuggestions($title);
				if (sizeof(array_keys($suggestions))) {
			?>
				<!-- Vertippt? | START -->
				<div class="sprechblase" onclick="$('suggestionList').style.maxHeight='900px';$('suggestionList').style.cursor='auto'">
					<h2>&nbsp;<span>&nbsp;</span></h2>
					<div class="sprechblase-main">
				    	<div class="sprechblase-achtung">&nbsp;</div>
				        <div class="sprechblase-rechts">
				        	<div class="blase-header" id="eingabeblase-head">
				            	<div class="kurzerklaerung"><span><?php loc('suggestions.title') ?></span></div>
				            </div>
				            <div class="blase-body" style="padding:0px; margin-top:-20px;">
								<div class="twick-link" style="line-height: 33px; padding-left: 15px; margin-top:0px;">
									<ul id="suggestionList" class="bulletsbig" <?php if(sizeof($suggestions) < 6) { ?>style="cursor:auto"<?php } ?>>
									<?php
									foreach(array_keys($suggestions) as $suggestion) {
										?><li><a href="show_topic.php?title=<?php echo(urlencode($suggestion)) ?>&skipSuggestions=true"><?php echo htmlspecialchars($suggestion) ?></a></li><?php 
									}
									?>
									</ul>
								</div>
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer"><?php loc('suggestions.write', $title) ?></div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- Vertippt? | ENDE -->
				<?php 
				}
			}
		} else {
			$isBest = true;
			$numberOfTwicks = sizeof($twicks);
			$indexCounter=0;
			foreach($twicks as $twick) {
				$indexCounter++;
				$follow = $indexCounter==1 || $indexCounter / $numberOfTwicks <= 0.5;	
				if ($twick->isBlocked()) {
					continue;
				}
				$twick->display($follow, false, $isBest);
				
				if (getArrayElement($_GET, "new") == $twick->getId() && $twick->getUserId() == getUserId()) {
                    $user = getUser();
                    $numberOfTwicks = $user->findNumberOfTwicks();
                    if ($level = Badge::reachedLevel(Badge::BUBBLE, $numberOfTwicks)) {
                        $number = Badge::$levels[Badge::BUBBLE][$level];
                        $level = Badge::getLevelName($level);
                        $twitter = "https://twitter.com?status=" . rawurlencode(utf8encode(_loc('badges.popup.bubble.share'))) . " " . $user->getUrl();
                        $facebook = "http://www.facebook.com/share.php?u=" . $user->getUrl();

						Message::send(
							Message::TYPE_BADGE,
							User::TWICKIT_USER_ID,
							$twick->getUserId(), 
							_loc("badges.popup.bubble.title"), 
							_loc("badges.popup.bubble.text." . $level, $number) . "\n" . _loc("badges.popup.bubble.text2", array($twitter, $facebook)),
                            "bubble_$level"
						);
						
                        ?><script language='javascript' type='text/javascript'>badgePopup("bubble", "<?php loc("badges.popup.bubble.title") ?>", "<?php loc("badges.popup.bubble.text." . $level, $number) ?> <?php loc("badges.popup.bubble.text2", array($twitter, $facebook)) ?>", "<?php echo($level) ?>")</script><?php
                    }
					$text = _loc('topic.thx.title') . "<br /><br />";
					$text .= "<a href='https://twitter.com?status=" . rawurlencode(utf8encode(_loc('topic.thx.twitter.text', $title . ": " . $twick->getUrl()))) . "' target='_blank'>" . _loc('topic.thx.twitter') . "</a> " . _loc('topic.thx.or') . " ";
					$text .= "<a href='http://www.facebook.com/share.php?u=" . urlencode($twick->getUrl()) . "' target='_blank'>" . _loc('topic.thx.facebook') . "</a>.";
					drillDown($text, 10000);
				}
				
				if ($isBest) {
					include(DOCUMENT_ROOT . "/inc/inc_your_text.php");
				}
				$isBest = false;
			}
		} 
		?>
	</div>
	<!-- Linke Haelfte | ENDE -->
	
	
	<!-- Rechte Haelfte | START -->
	<div class="inhalte-rechts unimportant">
		<?php if(false) { ?>
	   	<!-- Tooltip | START -->
	    <div class="teaser">
	    	<div class="teaser-head"><h2><?php loc('tooltip.marginal.header') ?></h2></div>
	        <div class="teaser-body">
	        	<p><?php loc('tooltip.marginal.text') ?></p>
	        	<a href="http://twick.it/blog/2009/12/twick-it-tool-tip/" class="teaser-link"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('core.more') ?></a><br />
	        </div>
	        <div class="teaser-footer"></div>                        
	    </div>
	    <!-- Tooltip | ENDE -->
		<?php } ?>
	      
	   	<?php if (isAdmin()) { ?>
	   	<!-- Wikipedia | START -->
	    <div class="teaser" id="wikipedia-teaser">
	    	<div class="teaser-head"><h2>Wikipedia</h2></div>
	        <div class="teaser-body">
	        	<p id="wikipedia"><img src="<?php echo(STATIC_ROOT) ?>/html/img/ajax-loader.gif" alt="..." /></p>
	        </div>
	        <div class="teaser-footer"></div>                        
	    </div>
	    <!-- Wikipedia | ENDE -->  
	   	<?php } ?>
	   
	   
	   	<?php 
		if (false && sizeof($twicks) > 2) {
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
				?><a href="<?php echo($moreUrl) ?>" class="teaser-link"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('core.more') ?></a><br /><?php 
                }
				?>
	        </div>
	        <div class="teaser-footer"></div>                        
	    </div>
	    <!-- Verwandte Themen | ENDE -->  
	    <?php 
	    }
	    ?>

    	
        <?php 
		if ($topic && $topic->hasCoordinates()) {
			$nearest = $topic->findNearest(30000, 10);
			if (sizeof($nearest) > 1) {
			?>
			<!-- In der Naehe | START -->
			<div class="teaser">
				<div class="teaser-head"><h2><?php loc('topic.near.title') ?></h2></div>
				<div class="teaser-body nopadding">
					<ul class="bullets">
						<?php
						foreach($nearest as $info) {
							list($distance, $relatedTopic) = $info;
							if($relatedTopic->getId() != $topic->getId()) {
								?><li><a href="<?php echo($relatedTopic->getUrl()) ?>"><?php echo($relatedTopic->getTitle()) ?> (<?php echo(number_format($distance/1000, 2)) ?> km)</a></li><?php
							}
						}
						?>
					</ul>
				</div>
				<div class="teaser-footer"></div>
			</div>
			<!-- In der Naehe | ENDE -->
			<?php
			}
		}
	    ?>
		
		<?php if (isAdmin()) { ?>
		<!-- Amazon | START -->
	    <div class="teaser">
	    	<div class="teaser-head"><h2><?php loc('topic.amazon') ?></h2></div>
	        <div class="teaser-body">
				<iframe src="http://rcm-de.amazon.de/e/cm?t=wwwtwickitde-21&o=3&p=9&l=st1&mode=books-de&search=<?php echo(urlencode($rawTitle . ";" . implode(";", $keywords))) ?>&fc1=000000&lt1=_blank&lc1=6B8F00&bg1=FFFFFF&npa=1&f=ifr" marginwidth="0" marginheight="0" width="300" height="150" border="0" frameborder="0" style="border:none;" scrolling="no"></iframe>
	        </div>
	        <div class="teaser-footer"></div>                        
	    </div>
	    <!-- Amazon | ENDE -->
	    
	    <!-- Google | START -->
	    <div class="teaser">
	    	<div class="teaser-head"><h2><?php loc('topic.google') ?></h2></div>
	        <div class="teaser-body nopadding">
				<script type="text/javascript"><!--
				google_ad_client = "pub-1682967926576527";
				/* 200x200, Erstellt 04.04.10 */
				google_ad_slot = "0940773145";
				google_ad_width = 200;
				google_ad_height = 200;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
	        </div>
	        <div class="teaser-footer"></div>                        
	    </div>
	    <!-- Google | ENDE -->
        <?php } ?>
        
		<!-- RSS | START -->
	    <div class="teaser">
	    	<div class="teaser-head"><h2>RSS</h2></div>
	        <div class="teaser-body nopadding">
	        	<ul>
	        		<li><img src="<?php echo(STATIC_ROOT) ?>/html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/topic.php?title=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.twicksForTopic', $title) ?></a></li>
					<li><img src="<?php echo(STATIC_ROOT) ?>/html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/tag.php?tag=<?php echo(urlencode($title)) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.topicsByTag', $title) ?></a></li>
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
<form style="display:none"><input type="hidden" id="myUrl" name="myUrl" value="<?php echo($myUrl) ?>" /></form>