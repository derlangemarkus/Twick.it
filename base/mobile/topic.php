<?php 
require_once("inc.php");

$search = getArrayElement($_GET, "search");
if ($search == "") {
	redirect(HTTP_ROOT . "/index.php");
}

$topic = Topic::fetchByTitle($search);
if (sizeof($topic)) {
	// Thema gefunden
	$topic = array_pop($topic);
	$id = $topic->getId();
	$title = $topic->getTitle();
	$twicks = $topic->findTwicks();
	$shortUrl = $topic->getShortUrl();
    $canonical = $topic->getUrl("http://twick.it");
	$isNew = false;
} else {
	$title = correctCapitalization($search);
	$twicks = array();
    $canonical = "http://twick.it/show_topic.php?title=" . urlencode($title);
	$isNew = true;
}

$homonyms = Topic::findHomonymsByTitle($title, $id);

include("inc/header.php"); 
?>

<?php
if($isNew && !getArrayElement($_GET, "skipSuggestions")) {
	$suggestions = Topic::findSuggestions($title);
	if (sizeof(array_keys($suggestions))) {
		?>
		<div class="class_content">
			<h1><?php loc('mobile.twick.suggestions') ?></h1>
			<?php 
			$separator = "";
			foreach(array_keys($suggestions) as $suggestion) {
				echo($separator);
				?><a href="topic.php?search=<?php echo(urlencode($suggestion)) ?>&skipSuggestions=1"><?php echo($suggestion) ?></a><?php 
				$separator = ", ";
			} 
			?>
		</div>
		<div class="class_divider"></div>
		<?php
	}
}
?>

<?php if($homonyms) { ?>
<div class="class_content">
<h1><?php loc('mobile.twick.homonym') ?></h1>
<?php 
$separator = "";
foreach($homonyms as $homonym) { 
	echo($separator);
	?><a href="topic.php?search=<?php echo(urlencode($homonym->getTitle())) ?>"><?php echo($homonym->getTitle()) ?></a><?php 
	$separator = ", ";
} 
?>
</div>
<div class="class_divider"></div>
<?php } ?>


<?php if($twicks) { ?>
<div class="class_content">
<?php if(!getArrayElement($_GET, "plain")) { ?>
<h1><?php loc('mobile.twick.headline', $title) ?></h1>
<?php } ?>
<table style="width:96%" cellpadding="0" cellspacing="0">
<?php 
foreach($twicks as $twick) {
	showTwick($twick, 1, $search);
}
?>
</table>
</div> 
<?php if(isLoggedIn()) { ?>
<div class="class_divider"></div>
<div class="class_content">
<h1><?php loc('mobile.yourTwick.title') ?>:</h1>
<?php include("inc/your_twick.php"); ?>
<?php } else { ?>
<a href="login.php" style="padding:10px;"><?php loc('mobile.twick.login') ?></a>
<?php } ?>
</div>

<?php } else { ?>
<div class="class_content">
<h1>&quot;<?php echo($title) ?>&quot;</h1>
<?php loc('mobile.twick.noTwicksYet') ?><br /><br />
<?php if(isLoggedIn()) { ?>
	<?php loc('mobile.twick.beTheFirst') ?><br />
	<?php include("inc/your_twick.php"); ?>
<?php } else {?>
	<a href="login.php" style="padding:10px;"><?php loc('mobile.twick.loginAndBeTheFirst') ?></a>
<?php } ?>
</div>
<?php } ?>

<?php include("inc/footer.php"); ?>
</body>
</html>