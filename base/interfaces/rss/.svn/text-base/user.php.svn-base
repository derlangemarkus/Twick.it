<?php
require_once("../../util/inc.php");
header("Content-Type: application/rss+xml; charset=utf-8");

$self = HTTP_ROOT . "/interfaces/rss/user.php";
if ($_SERVER["QUERY_STRING"]) {
	$self .= "?" . htmlspecialchars($_SERVER["QUERY_STRING"]);
}

$login = getArrayElement($_GET, "username");

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(600);
}

$user = User::fetchByLogin($login);
if ($user) {
	$login = $user->getDisplayName();
}

printXMLHeader();
?> 
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><![CDATA[Twick.it - <?php loc('rss.twicksFromUser', $login) ?>]]></title>
    <link><?php echo(HTTP_ROOT) ?></link>
    <description><![CDATA[<?php loc('rss.twicksFromUser', $login) ?>]]></description>
    <language><?php echo(getLanguage()) ?></language>
    <copyright>Twick.it</copyright>
    <atom:link href="<?php echo($self) ?>" rel="self" type="application/rss+xml" />
    <!-- <pubDate>Erstellungsdatum("Tue, 8 Jul 2008 2:43:19")</pubDate>-->
    
 	<?php 
 	if ($user) {
		foreach($user->findTwicks(false, array("ORDER BY"=>"creation_date DESC")) as $twick) {
	?> 
    <item>
      <title><![CDATA[<?php echo($twick->getTitle()) ?>]]></title>
      <description><![CDATA[<?php echo($twick->getLongText()) ?>]]></description>
      <link><?php echo($twick->getUrl()) ?></link>
      <author><![CDATA[noreply@twick.it (<?php echo($user->getDisplayName()) ?>)]]></author>
      <guid><?php echo($twick->getUrl()) ?></guid>
      <pubDate><?php echo(convertDateForRss($twick->getCreationDate())) ?></pubDate>
    </item>
 	<?php
		} 
	} 
	?>
  </channel>
</rss>
		
