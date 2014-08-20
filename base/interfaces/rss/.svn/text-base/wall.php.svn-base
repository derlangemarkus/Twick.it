<?php
require_once("../../util/inc.php");
header("Content-Type: application/rss+xml; charset=utf-8");

$self = HTTP_ROOT . "/interfaces/rss/wall.php";
if ($_SERVER["QUERY_STRING"]) {
	$self .= "?" . htmlspecialchars($_SERVER["QUERY_STRING"]);
}

$login = getArrayElement($_GET, "username");
$noChilds = getArrayElement($_GET, "noChilds");

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(600);
}

$user = User::fetchByLogin($login);
if ($user) {
	$login = $user->getDisplayName();
}

?> 
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><![CDATA[Twick.it - <?php loc('rss.wall', $login) ?>]]></title>
    <link><?php echo(HTTP_ROOT) ?></link>
    <description><![CDATA[<?php loc('rss.wall', $login) ?>]]></description>
    <language><?php echo(getLanguage()) ?></language>
    <copyright>Twick.it</copyright>
    <atom:link href="<?php echo($self) ?>" rel="self" type="application/rss+xml" />
    <!-- <pubDate>Erstellungsdatum("Tue, 8 Jul 2008 2:43:19")</pubDate>-->
    
 	<?php 
 	if ($user) {
		foreach(WallPost::fetchByUserId($user->getId()) as $post) { 
			$author = $post->findAuthor();
			if($post->isDeleted()) {
				continue;
			}
			if($noChilds && $post->getParentId()) {
				continue;
			}
	?> 
    <item>
      <title><![CDATA[<?php echo($author->getDisplayName()) ?>]]></title>
      <description><![CDATA[<?php echo($post->getMessage()) ?>]]></description>
      <link><?php echo($post->getUrl()) ?></link>
      <author><![CDATA[noreply@twick.it (<?php echo($author->getDisplayName()) ?>)]]></author>
      <guid><?php echo($post->getUrl()) ?></guid>
      <pubDate><?php echo(convertDateForRss($post->getCreationDate())) ?></pubDate>
    </item>
 	<?php
		} 
	} 
	?>
  </channel>
</rss>
		
