<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");

setLanguage("de");

$podcastId = getArrayElement($_GET, "id");
$page = getArrayElement($_GET, "page", 1);
$title = "Twick.it-Podcast";

if($podcastId) {
	$podcast = Podcast::fetchById($podcastId);
	if($podcast) {
		$podcasts = array($podcast);
		$title .= ": " . $podcast->getTitle() . " von " . $podcast->getAuthor()->getLogin();
	} else {
		redirect("404.php");
	}
} else {
	$perPage = 5;
	$podcasts = Podcast::fetchLatest($perPage, ($page-1)*$perPage);
	$numberOf = Podcast::findNumberOfPodcasts();
	$numberOfPages = ceil($numberOf/$perPage);
}


$speakerUrls = 
	array(
		"Tabitha Hammer" => "http://www.anderes-hoeren.de",
		"Sebastian Bäcker" => "http://www.sebastianbaecker.de",
		"Stefanie Puke" => "http://stefaniepuke.wordpress.com",
		"Philipp Gorges" => "http://www.damienslife.de",
		"Maximilian Weigl" => "http://www.longwayhome.de",
		"Mario Gießler" => "http://www.mariogiessler.de"
	);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo($title) ?> | Jeden Tag eine neue gesprochene Kurz-Erklärung</title>
	<meta property="og:title" content="Twick.it-Podcast" />
    <meta name="description" content="<?php echo($title) ?> | Jeden Tag eine neue gesprochene Kurz-Erklärung" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>, Podcast" />
    <?php include("inc/inc_global_header.php"); ?>
	<link rel="alternate" type="application/rss+xml" title="RSS - die neuesten gesprochenen Twicks" href="interfaces/rss/podcast.php" />
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1>Podcast - jeden Tag ein gesprochener Twick</h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php 
				foreach($podcasts as $podcast) { 
					$speaker = $podcast->getSpeaker();
					$speakerUrl = getArrayElement($speakerUrls, $speaker);
				?>
				<div class="blog-kasten">
					<div class="blog-head"><h1><a href="<?php echo($podcast->getUrl()) ?>"><?php echo($podcast->getTitle()) ?></a></h1></div>
					<div class="blog-body">
						<div class="audiobox" style="float:left;">
                            <object type="application/x-shockwave-flash" data="html/swf/emff.swf?src=<?php echo(HTTP_ROOT) ?>/mp3/<?php echo($podcast->getMp3File()) ?>" width="200" height="70">
                            <param name="movie" value="html/swf/emff.swf?src=<?php echo(HTTP_ROOT) ?>/mp3/<?php echo($podcast->getMp3File()) ?>" />
                            </object>
							<p><a href="../mp3/<?php echo($podcast->getMp3File()) ?>">MP3-Download (<?php echo($podcast->getSize()) ?> KB)</a></p>
						</div>
						<div style="width:275px;float:left;padding-left:20px;padding-top:6px;">
							<p>
								<label>Thema:</label> <a href="<?php echo($podcast->getTopicUrl()) ?>"><?php echo($podcast->getTitle()) ?></a><br />
								<label>Autor:</label> <a href="<?php echo($podcast->getAuthor()->getUrl()) ?>"><?php echo($podcast->getAuthor()->getLogin()) ?></a><br />
								<label>Gelesen von:</label> 
								<?php if($speakerUrl) { ?>
									<a href="<?php echo($speakerUrl); ?>" target="_blank" title="Webseite von <?php echo($speaker); ?> öffnen"><?php echo($speaker); ?></a>
								<?php 
								} else {
									echo($speaker);
								}
							?></p>
						</div>
						<br/>
					</div>
					<div class="blog-footer">
						<br/><span>Erstellt am <?php echo convertDate($podcast->getPublishDate()) ?></span>
					</div>
				</div>
				<div class="clearbox" style="border-bottom:1px solid #FFFFFF;"></div>
				<?php if($podcastId) { ?>
					<div class="haupt-buttonfeld">
						<a id="userTwicksMoreLink" href="podcast.php">Zurück zum Podcast</a>
					</div>
				<?php } ?>
				<?php } ?>
				
				<div style="padding:20px;">
				<?php 
				if (!$twickId && $numberOfPages > 1) {
					if ($page != 1) {
						?><a href="podcast.php?page=<?php echo($page-1) ?>" class="pager">&laquo;</a><?php
					}
					$dotdotdot = false;
					for($p=1; $p<=$numberOfPages; $p++) {
						if($numberOfPages > 10 && ($p<$page-3 || $p>$page+3) && $p>3 && $p<$numberOfPages-2) {
							if(!$dotdotdot) {
								echo("<a href='javascript:;' class='pager'>&hellip;</a>");
								$dotdotdot = true;
							}
							continue;
						}
						$dotdotdot = false;
						$class = $p == $page ? "pager-aktiv" : "pager";
						?><a href="podcast.php?page=<?php echo($p) ?>" class="<?php echo($class) ?>" style="<?php echo($style) ?> <?php if($p>9) { ?>padding-right:6px;<?php } ?>"><?php echo($p) ?></a><?php
					}
					
					if ($page != $numberOfPages) {
						?><a href="podcast.php?page=<?php echo($page+1) ?>" class="pager">&raquo;</a><?php
					}
				}
				?>
				<br /><br />
				</div>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<div class="teaser">
					<div class="teaser-head"><h2>Über diesen Podcast</h2></div>
					<div class="teaser-body">
						Dies ist der Twick.it-Podcast. Der Podcast für freies Wissen in Kurzform.<br />
						<br />
						Täglich gibt es auf's neue eine gesprochene Kurzerklärung von <a href="http://twick.it">Twick.it, der Erklärmaschine.</a> Alle Beiträge stehen unter der Lizenz <a href="http://creativecommons.org/licenses/by/3.0/de/" target="_blank">Creative Commons Namensnennung</a>.<br />
					</div>
					<div class="teaser-footer"></div>
				</div>

				<div class="teaser">
					<div class="teaser-head"><h2>iTunes</h2></div>
					<div class="teaser-body">
						<a href="http://itunes.twick.it"><img src="html/img/itunes.png" style="float:left;margin-right:10px;margin-bottom:10px;border:none;width:50px;height:50px;"/></a>Uns gibt es auch bei iTunes! <a href="http://itunes.twick.it">Hier entlang</a>.<br />
					</div>
					<div class="teaser-footer"></div>
				</div>

				<div class="teaser">
					<div class="teaser-head"><h2>Letzte Beiträge</h2></div>
					<div class="teaser-body" style="height:295px;overflow:auto;" onscroll="checkScroll()" id="scrollContainer">
                        <ul class="bullets" style="margin-top:0px;" id="podcastList">
                            <?php foreach(Podcast::fetchLatest(20) as $podcast) { ?>
                            <li><a href="<?php echo($podcast->getUrl()) ?>"><?php echo($podcast->getTitle()) ?></a></li>
                            <?php } ?>
                        </ul>
					</div>
					<div class="teaser-footer"></div>
				</div>

				<div class="teaser">
					<div class="teaser-head"><h2>RSS</h2></div>
					<div class="teaser-body nopadding">
						<ul>
							<li><img src="html/img/rss.gif" class="rss"/><a rel="alternate" type="application/rss+xml" href="interfaces/rss/podcast.php">Podcast abonieren</a></li>
						</ul>
						<div class="clearbox"></div>
					</div>
					<div class="teaser-footer"></div>
				</div>
						              
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>      
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>
    <script type="text/javascript">
    var podcastListOffset=20;
    function updatePodcastList() {
        new Ajax.Request(
            "inc/ajax/get_latest_podcasts.php", {
                method: 'get',
                parameters: {'offset': podcastListOffset},
                onSuccess: function(transport) {
                    var response = transport.responseText.evalJSON(true);
                    for(var i=0; i<response.data.length; i++) {
                        var li = new Element("li");
                        var a = new Element("a", {"href":response.data[i].url});
                        a.update(response.data[i].title);
                        li.insertBefore(a, null);
                        $("podcastList").appendChild(li);

                    }
                    if (response.data.length > 0) {
                        scrollBlock = false;
                    }
                }
        });

        podcastListOffset+=10;
    }


    var scrollBlock = false;
    function checkScroll() {
        var element = $("scrollContainer");
        var height = element.scrollHeight;
        var scroll = element.scrollTop;

        var diff = height - scroll;

        if(diff <= 390 && scrollBlock == false) {
            scrollBlock = true;
            updatePodcastList();
        }
    }
    </script>
</body>
</html>
