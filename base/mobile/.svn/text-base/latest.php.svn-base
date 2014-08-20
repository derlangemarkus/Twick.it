<?php 
require_once("inc.php");

$twicks = Twick::fetchNewest(30);
$title = _loc('mobile.latest.title');
$canonical = "http://twick.it/latest_twicks.php";

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc('mobile.latest.headline', 30) ?></h1>
<table style="width:96%" cellpadding="0" cellspacing="0">
<?php 
foreach($twicks as $twick) {
	showTwick($twick, 3, "", true);
}
?>
</table>
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>