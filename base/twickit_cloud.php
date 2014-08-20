<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Twick.it - Cloud</title>
</head>
<body>


<h1>Cloud</h1>

<?php 
$keywords = array();
foreach(Topic::fetchAll() as $topic) {
	foreach($topic->getTags() as $tag=>$count) {
		if ($tag != "") {
			$keywords[$tag] = getArrayElement($keywords, $tag, 0) + 1;
		}
	}
}
arsort($keywords);
$keywords = array_slice($keywords, 0, 300);
$cloudWidth = 800;
include(DOCUMENT_ROOT . "/inc/inc_cloud.php");
?>
	
<?php include(DOCUMENT_ROOT . "/inc/inc_analytics.php"); ?>
</body>
</html>
