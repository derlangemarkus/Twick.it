<?php 
getLanguage();
?>

Sprache: 
<?php 
$separator = "";
foreach($languages as $languageData) { 
	echo($separator);
	if ($languageData["code"] == getLanguage()) { 
	?><b><?php echo($languageData["name"]) ?></b><?php 
	} else {
	?><a href="<?php echo(HTTP_ROOT) ?>/index.php?lng=<?php echo($languageData["code"]) ?>"><?php echo($languageData["name"]) ?></a><?php 
	}
	$separator = " | ";
} 
?><br />