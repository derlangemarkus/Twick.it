<?php
require_once("../../util/inc.php");
header("Content-Type: application/rss+xml; charset=utf-8");

$self = HTTP_ROOT . "/interfaces/rss/latest_topics.php";
if ($_SERVER["QUERY_STRING"]) {
	$self .= "?" . htmlspecialchars($_SERVER["QUERY_STRING"]);
}

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(600);
}

printXMLHeader();
?> 
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#">
  <channel>
    <title>Twick.it - <?php loc('rss.latestTopics') ?></title>
    <link><?php echo(HTTP_ROOT) ?></link>
    <description><?php loc('rss.latestTopics') ?></description>
    <language><?php echo(getLanguage()) ?></language>
    <copyright>Twick.it</copyright>
    <atom:link href="<?php echo($self) ?>" rel="self" type="application/rss+xml" />
 	<?php 
	foreach(Topic::fetchNewest(50) as $topic) { 
		$twick = $topic->findBestTwick();
		$user = $twick->findUser();
	?> 
    <item>
      <title><![CDATA[<?php echo($topic->getTitle()) ?>]]></title>
      <description><![CDATA[<?php echo($twick->getLongText()) ?>]]></description>
      <link><?php echo($topic->getUrl()) ?></link>
      <author><![CDATA[noreply@twick.it (<?php echo($user->getDisplayName()) ?>)]]></author>
      <guid><?php echo($topic->getUrl()) ?></guid>
      <pubDate><?php echo(convertDateForRss($twick->getCreationDate())) ?></pubDate>
	  <?php if($topic->hasCoordinates()) { ?>
	  <geo:lat><?php echo($topic->getLatitude()) ?></geo:lat>
      <geo:long><?php echo($topic->getLongitude()) ?></geo:long>
	  <?php } ?>
    </item>
 	<?php 
	} 
	?>
  </channel>
</rss>
