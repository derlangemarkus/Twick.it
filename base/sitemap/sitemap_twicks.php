<?php 
require_once("../util/inc.php");
header("Content-Type: text/xml; charset=utf-8");
ini_set("display_errors", 1);
printXMLHeader();
?>
<urlset 
	xmlns="http://www.google.com/schemas/sitemap/0.84"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84
	http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
<url>
	<loc><?php echo(HTTP_ROOT) ?></loc>
	<changefreq>always</changefreq>
	<priority>1</priority>
</url>
<?php 
foreach(Twick::fetchAll(array("ORDER BY"=>"id DESC", "LIMIT"=>1000), true) as $twick) {
	?><url>
		<loc><?php echo($twick->getStandaloneUrl()) ?></loc>
		<changefreq>daily</changefreq>
		<priority>0.5</priority>
	</url>
<?php 
}
?>
</urlset>