<?php 
require_once("../util/inc.php");
header("Content-Type: text/xml; charset=utf-8");

function _convertDate($inDate) {
	$str = date("Y-m-d\\TH:i:sO", strtotime($inDate));
	return substr($str, 0, strlen($str)-2) . ":" . substr($str, strlen($str)-2);
}

printXMLHeader();
?>
<sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84">
   <sitemap>
      <loc><?php echo(HTTP_ROOT) ?>/sitemap/sitemap_topics.php</loc>
   </sitemap>
   <sitemap>
      <loc><?php echo(HTTP_ROOT) ?>/sitemap/sitemap_users.php</loc>
   </sitemap>
   <sitemap>
      <loc><?php echo(HTTP_ROOT) ?>/sitemap/sitemap_twicks.php</loc>
   </sitemap>
   <sitemap>
      <loc>http://twick.it/blog/de/sitemap.xml</loc>
   </sitemap>
   <sitemap>
      <loc>http://twick.it/blog/en/sitemap.xml</loc>
   </sitemap>
</sitemapindex>