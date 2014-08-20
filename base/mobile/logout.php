<?php 
require_once("inc.php");
checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$secret = getArrayElement($_GET, "secret");
$referrer = getArrayElement($_GET, "r");

$title = _loc('mobile.logout.title');

include("inc/header.php");
?>
<div class="class_content">
<h1><?php loc('mobile.logout.title') ?></h1>
<?php loc('mobile.logout.text') ?><br />
<br />
<a href="<?php echo($referrer) ?>" style="font-weight:bold;background-color:#3F3;color:#000;padding:35px 0px 35px 0px;width:98%;display:block;border-top:1px solid #ccc">&nbsp;&nbsp;<?php loc('mobile.core.no') ?></a>
<br />
<a href="action/logout.php?secret=<?php echo($secret) ?>&r=<?php echo(urlencode($referrer)) ?>" style="font-weight:bold;background-color:#F33;color:#000;padding:20px 0px 20px 00px;width:98%;display:block;border-top:1px solid #ccc">&nbsp;&nbsp;<?php loc('mobile.core.yes') ?></a> 
<br />
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>