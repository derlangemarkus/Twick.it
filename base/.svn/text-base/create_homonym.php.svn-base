<?php
require_once("util/inc.php"); 

$title = getArrayElement($_GET, "title");
$category = getArrayElement($_GET, "category", "");
if ($category != "") {
	redirect("show_topic.php?title=" . urlencode("$title ($category)"));
}

$id = getArrayElement($_GET, "id");
$homonyms = Topic::findHomonymsByTitle($title, $id);
$wikipedia= getWikipediaHomonymSuggestions($title);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('homonyms.title', htmlspecialchars($title)) ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('homonyms.title', htmlspecialchars($title)) ?>" />
    <meta name="description" content="<?php loc('homonyms.title', htmlspecialchars($title)) ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php echo(htmlspecialchars($title)) ?>" />
    <?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript">
	function gotoTopic() {
		document.location.href = "show_topic.php?title=" + encodeURIComponent("<?php echo($title) ?> (" + document.homonym.category.value + ")");
		return false;
	}

	function updateTopic() {
		var category = document.homonym.category.value;
		if (category == "") {
			$("createLink").hide();
		} else {
			var newTopic = "<?php echo($title) ?> (" + category + ")";
			$("newTopic").update(newTopic);
			$("createLink").show();
		} 
	}
	</script>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('homonyms.headline', array(htmlspecialchars($title), "show_topic.php?title=" . urlencode($title))) ?></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
			
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head" style="height:auto;"><h1><?php loc('homonyms.subline') ?></h1></div>
					<div class="blog-body">
						<?php loc('homonyms.example') ?> <br />
						<br />
						<?php loc('homonyms.text') ?><br />
						<br />
						
						<?php if (sizeof($homonyms)) { ?>
							<h1><?php loc('homonyms.existing') ?></h1>
							<?php foreach($homonyms as $homonym) { ?>
							<a href="<?php echo($homonym->getUrl()) ?>&skipSuggestions=1"><?php echo(htmlspecialchars($homonym->getTitle())) ?></a><br />
							<?php } ?>
							<br />
						<?php } ?>
						
						<?php if (sizeof($wikipedia)) { ?>
							<h1><?php loc('homonyms.suggestion') ?></h1>
							<?php foreach($wikipedia as $homonym) { ?>
							<a href="show_topic.php?title=<?php echo(urlencode("$title ($homonym)")) ?>&skipSuggestions=1"><?php echo("$title ($homonym)") ?></a><br />
							<?php } ?>
							<br />
							<h1><?php loc('homonyms.other') ?></h1>
						<?php } else if (sizeof($homonyms)) { ?>
						<h1><?php loc('homonyms.your') ?></h1>
						<?php } ?>
						
						<form action="" name="homonym" id="homonymForm" onsubmit="gotoTopic()">
							<input type="hidden" name="title" value="<?php echo(htmlspecialchars($title)) ?>" />
							<?php echo(htmlspecialchars($title)) ?> (<input type="text" name="category" onkeyup="updateTopic()"/>)<br />
							<br />
							<a href="javascript:;" onclick="gotoTopic()" id="createLink" style="display:none;"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('homonyms.button') ?></a>
						</form>
					</div>
					<div class="blog-footer"></div>
				</div>
				<!-- Kasten | ENDE -->
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Wikipedia | START -->
			    <div class="teaser" id="wikipedia-teaser">
			    	<div class="teaser-head"><h2><?php loc('homonyms.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div><?php loc('homonyms.info.text') ?></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Wikipedia | ENDE -->  
		
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>   
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>