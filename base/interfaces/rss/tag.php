<?php
require_once("../../util/inc.php");
require_once("../../util/thirdparty/stemming/StemmingFactory.class.php"); 
header("Content-Type: application/rss+xml; charset=utf-8");

$self = HTTP_ROOT . "/interfaces/rss/tag.php";
if ($_SERVER["QUERY_STRING"]) {
	$self .= "?" . htmlspecialchars($_SERVER["QUERY_STRING"]);
}

$tag = strtolower(getArrayElement($_GET, "tag"));

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(600);
}

printXMLHeader();
?> 
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><![CDATA[Twick.it - <?php loc('rss.topicsByTag', $tag) ?>]]></title>
    <link><?php echo(HTTP_ROOT) ?></link>
    <description><![CDATA[<?php loc('rss.topicsByTag', $tag) ?>]]></description>
    <language><?php echo(getLanguage()) ?></language>
    <copyright>Twick.it</copyright>
    <atom:link href="<?php echo($self) ?>" rel="self" type="application/rss+xml" />
    <!-- <pubDate>Erstellungsdatum("Tue, 8 Jul 2008 2:43:19")</pubDate>-->
    
 	<?php 
	foreach(Topic::findRelatedTopicsByTitle(StemmingFactory::stem($tag)) as $topic) { 
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
    </item>
 	<?php 
	} 
	?>
  </channel>
</rss>
		
