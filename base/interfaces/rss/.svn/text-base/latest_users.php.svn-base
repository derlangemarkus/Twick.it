<?php
require_once("../../util/inc.php");
header("Content-Type: application/rss+xml; charset=utf-8");

$self = HTTP_ROOT . "/interfaces/rss/user.php";
if ($_SERVER["QUERY_STRING"]) {
	$self .= "?" . htmlspecialchars($_SERVER["QUERY_STRING"]);
}

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(10000);
}

printXMLHeader();
?> 
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><![CDATA[Twick.it - <?php loc('rss.latestUsers') ?>]]></title>
    <link><?php echo(HTTP_ROOT) ?></link>
    <description><![CDATA[<?php loc('rss.latestUsers') ?>]]></description>
    <language><?php echo(getLanguage()) ?></language>
    <copyright>Twick.it</copyright>
    <atom:link href="<?php echo($self) ?>" rel="self" type="application/rss+xml" />
    <!-- <pubDate>Erstellungsdatum("Tue, 8 Jul 2008 2:43:19")</pubDate>-->
    
 	<?php 
 	foreach (UserInfo::fetchAll(false, false, array("LIMIT"=>20, "ORDER BY"=>"creation_date DESC")) as $user) {
	?> 
    <item>
      <title><![CDATA[<?php echo($user->getDisplayName()) ?>]]></title>
      <description><![CDATA[<?php echo($user->getBio()) ?>]]></description>
      <link><?php echo($user->getUrl()) ?></link>
      <author><![CDATA[noreply@twick.it]]></author>
      <guid><?php echo($user->getUrl()) ?></guid>
      <pubDate><?php echo(convertDateForRss($user->getCreationDate())) ?></pubDate>
    </item>
 	<?php
	} 
	?>
  </channel>
</rss>
		
