<?php 
require_once("inc.php");
$title = _loc('mobile.languages.title');

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc('mobile.languages.headline') ?></h1>
<?php foreach($languages as $languageData) { ?>
	<a href="index.php?lng=<?php echo($languageData["code"]) ?>" style="padding:20px 0px 20px 0px;width:100%;display:block;border-top:1px solid #ccc"><?php echo($languageData["name"]) ?></a>
<?php } ?> 
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>