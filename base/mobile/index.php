<?php 
require_once("inc.php");
$title = _loc('mobile.home.title');
$canonical = "http://twick.it";

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc('mobile.home.headline') ?></h1>
<?php loc('mobile.home.text') ?><br />
<?php if(contains(strtolower($_SERVER['HTTP_USER_AGENT']), "android") && !getArrayElement($_GET, "apple")) { ?>
<br /><br />
<a href="http://android.twick.it"><img src="html/img/android.png" style="width:50px;height:50px;border:none;float:left;"><?php loc('mobile.home.android') ?></a>
<br style="clear:both;" />
<br />
<?php } else if(contains(strtolower($_SERVER['HTTP_USER_AGENT']), "iphone") || contains(strtolower($_SERVER['HTTP_USER_AGENT']), "ipad") || getArrayElement($_GET, "apple")) { ?>
<br /><br />
<a href="http://iphone.twick.it"><img src="html/img/apple.png" style="width:50px;height:50px;border:none;float:left;margin-top:-5px;"><?php loc('mobile.home.iphone') ?></a>
<br style="clear:both;" />
<br />

<?php } ?>
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>