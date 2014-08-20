<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

header("Content-Type: application/json; charset=utf-8"); 

$id = getArrayElement($_GET, "id");

// Tipps holen
$tipp = "";
$languageSuffix = "";
if (getLanguage() != "de") {
	$languageSuffix .= "_" . getLanguage();
}

$blogUserName = BLOG_DB_USERNAME . $languageSuffix;
$blogPassword = BLOG_DB_PASSWORD;
$blogDatabase = BLOG_DB_DATABASE . $languageSuffix;

$conn = mysql_connect(BLOG_DB_HOSTNAME, $blogUserName, $blogPassword);
mysql_select_db(BLOG_DB_DATABASE);
$result = mysql_query("SELECT * FROM wp_posts WHERE post_status='publish' AND post_parent=" . BLOG_DB_POST . " AND ID>$id ORDER BY ID LIMIT 1");
$row = mysql_fetch_assoc($result);
if (!$row) {
	$result = mysql_query("SELECT * FROM wp_posts WHERE post_status='publish' AND post_parent=" . BLOG_DB_POST . " ORDER BY ID LIMIT 1");
	$row = mysql_fetch_assoc($result);
}

$title = $row["post_title"];
    
$tipp = $row["post_content"];
mysql_free_result($result);
echo(
	json_encode(
		array(
			"title" => utf8_encode($title),
			"tipp" => utf8_encode(str_replace("\r\n", "", nl2br($tipp))),
			"id" => $row["ID"]
		)
	)
);
?>
