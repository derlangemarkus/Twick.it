<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");
ini_set("display_errors", 1);
$activeTab = "dashboard";

// Tipps holen
$tipp = "";

$languageSuffix = "";
if (getLanguage() != "de") {
	$languageSuffix .= "_" . getLanguage();
}

$blogUserName = BLOG_DB_USERNAME . $languageSuffix;
$blogPassword = BLOG_DB_PASSWORD;
$blogDatabase = BLOG_DB_DATABASE . $languageSuffix;

$conn = mysql_connect(BLOG_DB_HOSTNAME, $blogUserName, $blogPassword);
mysql_select_db($blogDatabase);
$result = mysql_query("SELECT * FROM wp_posts WHERE post_status='publish' AND post_parent=" . BLOG_DB_POST . " ORDER BY rand() LIMIT 1");
while ($row = mysql_fetch_assoc($result)) {
    $title = $row["post_title"];
    $tipp = $row["post_content"];
    $tippId = $row["ID"];
}
mysql_free_result($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo(HTTP_ROOT) ?>/" />
    <title><?php loc('dashboard.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('dashboard.title') ?>" />
    <meta name="description" content="<?php loc('dashboard.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1><?php loc('dashboard.headline') ?></h1>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links" style="width:920px;background-color:#EFEFEF;">
				<div class="dashboard-teaser">
					<div class="text">
						<h2 style="margin-bottom:5px;" id="tippTitle"><?php echo(utf8_encode($title)) ?></h2>
						<span id="tippText" style="clear:both;"><?php echo(utf8_encode(nl2br($tipp))) ?></span><br />
						<a href="javascript:;" onclick="nextTipp();" class="teaser-link" id="nextTipp"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9" style="padding-top:4px;" /><?php loc('dashboard.tipp.next') ?></a>
					</div>
				</div>
			
				<?php 
				if (!isAdmin()) {
					setDBCacheTimeout(60);
				}
				$result = mysql_query("SELECT * FROM wp_posts WHERE post_status='publish' AND post_type='post' ORDER BY post_date DESC LIMIT 1");
				while ($row = mysql_fetch_assoc($result)) {
				    $title = $row["post_title"];
				    
				    $tipp = $row["post_content"];
				    $tipp = strip_tags($tipp);
                    while(preg_match("/\r\n\s*\r\n/", $tipp)) {
                        $tipp = preg_replace("/\r\n\s*\r\n/", "\r\n", $tipp);
                    }
				    $tipp = str_replace("[/twickit]", "", str_replace("[twickit]", "", $tipp));
                    $tipp = preg_replace('/\[(\S+).*\].*\[\/\1\]/is', "", $tipp);
                    $tipp = truncateString($tipp, 150);

				    $guid = $row["guid"];
				    $tippId = $row["ID"];
				}
				mysql_free_result($result);
				
				?>
				<div class="dashboard-teaser">
					<div class="text">
						<h2><?php echo(utf8_encode($title)) ?></h2>
						<span id="tippText" style="clear:both;"><?php echo(utf8_encode(nl2br($tipp))) ?></span><br />
						<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/index.php?p=" . $tippId) ?>" class="teaser-link" id="readMore"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9" style="padding-top:4px;" /><?php loc('dashboard.blog.more') ?></a>
					</div>
				</div>
				
				<div class="dashboard-teaser">
					<div class="text">
						<h2><?php loc('dashboard.latestTwicks') ?></h2>
						<ul>
							<?php 
							foreach(Twick::fetchNewest(3) as $twick) { 
								$theUser = $twick->findUser();
                                $login = $theUser->getLogin();
                                if($theUser->getDeleted()) {
                                    $login = _loc('misc.deletedUser');
                                }
								$url = $theUser->isAnonymous() ? $twick->getUrl() : $theUser->getUrl();
							?>
							<li><a href="<?php echo($url) ?>"><div class="bilderrahmen"><?php echo($theUser->getAvatar()) ?></div></a><a href="<?php echo($twick->getUrl()) ?>"><?php echo($login) ?> <?php loc('dashboard.random.about') ?> <?php echo($twick->getTitle()) ?></a></li>
							<?php 
							}
							?>
						</ul>
						<a href="latest_twicks.php" class="teaser-link" id="moreLatestTwicks"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9" style="padding-top:4px;" /><?php loc('core.more') ?></a>
					</div>
				</div>
			
			
				<?php 
				if (!isAdmin()) {
					setDBCacheTimeout(600);
				}
				?>
				<div class="dashboard-teaser">
					<div class="text">
						<h2><?php loc('dashboard.mostTwicked') ?></h2>
						<ul class="bullets">
							<?php 
							foreach(Topic::fetchMostTwicked(4) as $topicInfos) {
								list($topic, $numberOfTwicks) = $topicInfos; 
							?>
							<li><a href="<?php echo($topic->getUrl()) ?>"><?php echo($topic->getTitle()) ?> (<?php echo ($numberOfTwicks) ?> Twicks)</a></li>						
							<?php 
							}
							?>
						</ul>
					</div>
				</div>
				
				<div class="dashboard-teaser">
					<div class="text">
						<h2><?php loc('dashboard.lessTwicked') ?></h2>
						<ul class="bullets">
							<?php 
							$topics = Topic::fetchLessTwicked(111);
							shuffle($topics);
							$topics = array_slice($topics, 0, 4);
							
							foreach($topics as $topicInfos) {
								list($topic, $numberOfTwicks) = $topicInfos; 
							?>
							<li><a href="<?php echo($topic->getUrl()) ?>"><?php echo($topic->getTitle()) ?> (<?php echo ($numberOfTwicks) ?> Twick<?php if($numberOfTwicks != 1) { ?>s<?php } ?>)</a></li>						
							<?php 
							} 
							?>
						</ul>
					</div>
				</div>
				
				<?php 
				if (!isAdmin()) {
					resetDBCacheTimeout();
				}
				?>
				<div class="dashboard-teaser">
					<div class="text">
						<h2><?php loc('dashboard.randomTopic') ?></h2>
						<ul class="bullets">
							<?php 
							foreach(Topic::fetchRandom(4) as $topic) { 
							?>
							<li><a href="<?php echo($topic->getUrl()) ?>"><?php echo($topic->getTitle()) ?></a></li>						
							<?php 
							}
							?>
						</ul>
					</div>
				</div>
				
				<div class="dashboard-teaser" style="margin-bottom:30px;">
					<div class="text">
						<?php 
			        	?>
						<h2><?php loc('dashboard.random.title') ?></h2>
						<div id="randomTwickMain" style="display:none;">
			        		<div class="bilderrahmen"><a href="#" id="randomTwickGravatarLink"><img src="" border="0" width="32" height="32" style="width:32px; height: 32px;" id="randomTwickGravatar"/></a></div><b><a href="#" id="randomTwickUser"></a> <?php loc('dashboard.random.about') ?> <a href="#" id="randomTwickTitle"></a>:</b>
							<span id="randomTwickText"></span><br />
						</div>
						<a href="javascript:;" onclick="nextRandomTwick();" class="teaser-link" id="randomTwickNext" style="margin-top:10px;display:none;"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9" style="padding-top:4px;" /><?php loc('dashboard.random.next') ?></a>
						<img src="<?php echo(STATIC_ROOT) ?>/html/img/ajax-loader.gif" width="16" height="11" alt="..." id="randomTwickNextWait" style="float:right; margin-top:18px;" />
					</div>
				</div>
				
				
				<?php 
				if (!isAdmin()) {
					setDBCacheTimeout(600);
				}
				?>
				<div class="dashboard-teaser">
					<div class="text">
						<h2><?php loc('dashboard.bestTwicks') ?></h2>
						<ul>
							<?php 
							foreach(Twick::fetchAll(array("ORDER BY"=>"rating_sum DESC", "LIMIT"=>3)) as $twick) { 
								$user = $twick->findUser();	
							?>
							<li><a href="<?php echo($user->getUrl()) ?>"><div class="bilderrahmen"><?php echo($user->getAvatar()) ?></div></a><a href="<?php echo($twick->getUrl()) ?>"><?php echo($user->getLogin()) ?> <?php loc('dashboard.random.about') ?> <?php echo($twick->getTitle()) ?> (<?php echo($twick->getRatingSumCached()) ?> Punkte)</a></li>						
							<?php 
							}
							?>
						</ul>
					</div>
				</div>
				
				<div class="dashboard-teaser">
					<div class="text">
						<div style="display:block; float:left;">
							<h2><?php loc('dashboard.twitter.title') ?></h2>
							<span id="tweet"></span>
						</div>
						<br style="clear:both;" />
						<a href="javascript:;" onclick="nextRandomTweet();" class="teaser-link" id="randomTweetNext" style="margin-top:10px;display:none;"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9" style="padding-top:4px;" /><?php loc('dashboard.twitter.next') ?></a>
						<img src="<?php echo(STATIC_ROOT) ?>/html/img/ajax-loader.gif" width="16" height="11" alt="..." id="randomTweetNextWait" style="float:right; margin-top:18px;" />
					</div>
				</div>
				
				<?php if (false && isLoggedIn()) { ?>
				<div class="dashboard-teaser">
					<div class="text">
						<h2><?php loc('dashboard.help.title') ?></h2>
						<a href="topic_suggestions.php"><?php loc('dashboard.help.text') ?></a>
					</div>
				</div>
				<?php } ?>
		
				<div class="clearbox"></div>
			</div>
			<!-- Linke Haelfte | ENDE -->
		
		
		<div class="clearbox"></div>
	</div>
	<!-- Content-Bereich | ENDE -->
</div>

<?php
include(DOCUMENT_ROOT . "/inc/inc_footer.php"); 
?>
<script type="text/javascript">
function nextRandomTwick() {
    $("randomTwickNext").hide();
    $("randomTwickNextWait").show();
    new Ajax.Request(
        "interfaces/api/random_twick.json?limit=1",
        {
            method: 'GET',
            onSuccess: function(transport) {
                var info = transport.responseText.evalJSON(true);

                var topic = info.topics[0].topic;
                var twick = topic.twick;
                var user = twick.user;

                $("randomTwickTitle").update(topic.title);
                $("randomTwickTitle").href = topic.url;
                $("randomTwickText").update(twick.text);
                $("randomTwickGravatar").src = user.gravatar;
                $("randomTwickUser").update(user.name);
                $("randomTwickUser").href = user.url;
                $("randomTwickGravatarLink").href = user.url;

                $("randomTwickMain").show();
                $("randomTwickNextWait").hide();
                $("randomTwickNext").show();
            }
        }
    );
}

var tweetId = -2;

function nextRandomTweet() {
    $("randomTweetNext").hide();
    $("randomTweetNextWait").show();
    new Ajax.Request(
        "inc/ajax/get_next_tweet.php?id=" + tweetId,
        {
            method: 'GET',
            onSuccess: function(transport) {
                var info = transport.responseText.evalJSON(true);


                var content = "<i style='height:auto;'>" + info.content + "</i>";
                var img = "<div class='bilderrahmen'><a href='" + info.link[0] + "'><img target='_blank' src='" + info.image + "' border='0' title='" + info.author_name + "'/></a></div>";

                $("tweet").update("<b>" + info.author_name + "</b>:<br />" + img + content);
                tweetId = info.id;

                $("randomTweetNextWait").hide();
                $("randomTweetNext").show();
            }
        }
    );
}


var tippId = <?php echo($tippId) ?>;
function nextTipp() {
    new Ajax.Request(
        "inc/ajax/get_next_tip.php?id=" + tippId,
        {
            method: 'GET',
            onSuccess: function(transport) {
                var info = transport.responseText.evalJSON(true);

                $("tippTitle").update(info.title);
                $("tippText").update(info.tipp);
                tippId = info.id;
            }
        }
    );
}

Event.observe(
    window,
    'load',
    function() {
        nextRandomTweet();
        nextRandomTwick();
    }
);
</script>
</body>
</html>