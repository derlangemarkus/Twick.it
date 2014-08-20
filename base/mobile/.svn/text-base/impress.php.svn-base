<?php 
require_once("inc.php");

$languageSuffix = "";
if (getLanguage() != "de") {
	$languageSuffix .= "_" . getLanguage();
}

$blogUserName = BLOG_DB_USERNAME . $languageSuffix;
$blogPassword = BLOG_DB_PASSWORD;
$blogDatabase = BLOG_DB_DATABASE . $languageSuffix;

$conn = mysql_connect(BLOG_DB_HOSTNAME, $blogUserName, $blogPassword);
mysql_select_db($blogDatabase);
$result = mysql_query("SELECT * FROM wp_posts WHERE post_status='publish' AND ID=2");
while ($row = mysql_fetch_assoc($result)) {
    $title = $row["post_title"];
    $text = $row["post_content"];
}
mysql_free_result($result);

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php echo(utf8_encode(nl2br($title))) ?></h1>
<?php echo(utf8_encode(nl2br($text))) ?>
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>