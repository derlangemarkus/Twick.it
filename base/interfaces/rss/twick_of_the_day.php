<?php
require_once("../../util/inc.php");
header("Content-Type: application/rss+xml; charset=utf-8");

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(600);
}

printXMLHeader();
?> 
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#">
  <channel>
    <title>Twick.it - <?php loc('rss.twickOfTheDay') ?></title>
    <link><?php echo(HTTP_ROOT) ?></link>
    <description><?php loc('rss.twickOfTheDay') ?></description>
    <language><?php echo(getLanguage()) ?></language>
    <copyright>Twick.it</copyright>
    <atom:link href="<?php echo(HTTP_ROOT . "/interfaces/rss/twick_of_the_day.php") ?>" rel="self" type="application/rss+xml" />
    <!-- <pubDate>Erstellungsdatum("Tue, 8 Jul 2008 2:43:19")</pubDate>-->
    
 	<?php 
	foreach(TwickOfTheDay::fetchLatest(50) as $twickOfTheDay) {
        $twick = $twickOfTheDay->findTwick();
		$user = $twick->findUser();
		$topic = $twick->findTopic();
	?> 
    <item>
      <title><![CDATA[<?php loc('rss.core.about', array($user->getDisplayName(), $twick->getTitle())) ?>]]></title>
      <description><![CDATA[<?php echo($twick->getLongText()) ?>]]></description>
      <link><?php echo($twick->getUrl()) ?></link>
      <author><![CDATA[noreply@twick.it (<?php echo($user->getDisplayName()) ?>)]]></author>
      <guid><?php echo($twick->getUrl()) ?></guid>
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
