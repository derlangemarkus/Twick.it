<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
require_once("../util/thirdparty/trackback/trackback_cls.php"); 

checkAdmin();
$trackback = new Trackback('Twick.it', 'Twick.it', 'UTF-8');

$blogUserName = BLOG_DB_USERNAME;
$blogPassword = BLOG_DB_PASSWORD;
$blogDatabase = BLOG_DB_DATABASE;

$conn = mysql_connect(BLOG_DB_HOSTNAME, $blogUserName, $blogPassword);
mysql_select_db($blogDatabase);
$result = mysql_query("SELECT * FROM wp_posts WHERE ID=759");
if ($row = mysql_fetch_assoc($result)) {
    $content = $row["post_content"];
	
    $pattern = array();
	$replacement = array();
	
	preg_match_all('/<a href="(http(s?):\/\/.+?)"/', $content, $matches);
	$links = $matches[1];
	foreach($links as $link) {
		echo($link . "<br />");
		try {
			$trackback->ping($link, "http://twick.it/blog/de/presse/pressespiegel/");
		} catch(Exception $e) {}
		
	}
}
mysql_free_result($result);