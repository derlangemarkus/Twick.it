<?php 
require_once("inc.php");
$title = _loc("support.title");
$error = getArrayElement($_GET, "error");
$message = getArrayElement($_GET, "t");

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc('support.ok.headline') ?></h1>
<?php if($error) { ?>
<div style="background-color:#F00;color:#FFF;font-weight:bold;padding:10px;"><?php loc($error) ?></div>
<?php } ?>
<?php loc('support.ok.text') ?><br /><br />
<?php echo(nl2br(($message))) ?>
<br />
</div> 
<?php include("inc/footer.php"); ?>

</body>
</html>