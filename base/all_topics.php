<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

if (!isAdmin()) {
	setDBCacheTimeout(600);
}

$LIMIT = 50;
$page = getArrayElement($_GET, "page", 1);
$char = getArrayElement($_GET, "char", "A");
$offset = ($page-1) * $LIMIT;

$numberOf = Topic::findNumberOfTwicksForCharacter($char);
$numberOfPages = ceil($numberOf/$LIMIT);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('allTopics.title') ?> - <?php echo($char) ?><?php echo($page > 1 ? " - " . $page  : "") ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('allTopics.title') ?>" />
    <meta name="description" content="<?php loc('allTopics.title') ?> - <?php echo($char) ?><?php echo($page > 1 ? " - " . $page  : "") ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?> <?php echo($char) ?> <?php echo($page > 1 ? $page  : "") ?>" />
    <?php include("inc/inc_global_header.php"); ?>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
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
					<div class="blog-head">
					<h1>
					<?php 
					for($c=65; $c<91; $c++) { 
						$style = chr($c) == $char ? "style='font-size:30px;'" :"";
					?>
					<a href="all_topics.php?char=<?php echo(chr($c)) ?>" <?php echo($style) ?>><?php echo(chr($c)) ?></a>
					<?php 
					} 
					?>
					</h1>
					</div>
					<div class="blog-body">
						<ul class="bulletsbig">
							<?php foreach(Topic::fetchBySQL("title LIKE '$char%' ORDER BY title LIMIT $LIMIT OFFSET $offset") as $topic) { ?>
							<li style="width:auto;"><a href="<?php echo($topic->getUrl()) ?>" title="<?php echo($topic->getId()) ?>"><?php echo($topic->getTitle()) ?></a></li>
							<?php } ?>
						</ul>
						<br />
					</div>
					<div class="blog-footer" style="padding:0px 50px 20px 20px;width:521px;">
					<?php 
					if ($numberOfPages > 1) {
						if ($page != 1) {
							?><a href="all_topics.php?page=<?php echo($page-1) ?>&char=<?php echo($char) ?>" class="pager">&laquo;</a><?php
						}
						
						$dotdotdot = false;
						for($p=1; $p<=$numberOfPages; $p++) {
							if($numberOfPages > 14 && ($p<$page-4 || $p>$page+4) && $p>3 && $p<$numberOfPages-2) {
								if(!$dotdotdot) {
									echo("<a href='javascript:;' class='pager'>&hellip;</a>");
									$dotdotdot = true;
								}
								continue;
							}
							$dotdotdot = false;
							$class = $p == $page ? "pager-aktiv" : "pager";
							?><a href="all_topics.php?page=<?php echo($p) ?>&char=<?php echo($char) ?>" class="<?php echo($class) ?>" style="<?php echo($style) ?> <?php if($p>9) { ?>padding-right:6px;<?php } ?>"><?php echo($p) ?></a><?php
						}
						
						if ($page != $numberOfPages) {
							?><a href="all_topics.php?page=<?php echo($page+1) ?>&char=<?php echo($char) ?>" class="pager">&raquo;</a><?php
						}
					}
					?>
					</div>
				</div>
				<!-- Kasten | ENDE -->
				
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
                <!-- Liste | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc("allTopics.view.glossary") ?></h2></div>
			        <div class="teaser-body">
                        <a rel="glossary" href="glossary.php?page=<?php echo($page) ?>&char=<?php echo($char) ?>"><?php loc("allTopics.view.glossary.text") ?></a>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>
			    </div>
			    <!-- Liste | ENDE -->

		    	<!-- RSS | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>RSS</h2></div>
			        <div class="teaser-body nopadding">
			        	<ul>
                            <li><img alt="" src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/latest.php?lng=<?php echo(getLanguage()) ?>"><?php loc('rss.latestTwicks') ?></a></li>
                            <li><img alt="" src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/latest_topics.php?lng=<?php echo(getLanguage()) ?>"><?php loc('rss.latestTopics') ?></a></li>
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
</body>
</html>
