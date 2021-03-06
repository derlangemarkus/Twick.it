<?php 
require_once("../util/inc.php");
header("Content-Type: text/xml; charset=utf-8");

printXMLHeader();
?>
<urlset 
	xmlns="http://www.google.com/schemas/sitemap/0.84"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84
	http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
<?php 
foreach(Topic::fetchAll(array("ORDER BY"=>"id DESC", "LIMIT"=>500)) as $topic) {
?>
<url>
	<loc><?php echo($topic->getUrl()) ?></loc>
	<changefreq>daily</changefreq>
	<priority>0.8</priority>
</url>
<?php 
}
?>
</urlset>