<?php
require_once("../../util/inc.php");
header("Content-Type: application/rss+xml; charset=utf-8");

$self = HTTP_ROOT . "/interfaces/rss/wall_post.php";
if ($_SERVER["QUERY_STRING"]) {
	$self .= "?" . htmlspecialchars($_SERVER["QUERY_STRING"]);
}

$postId = getArrayElement($_GET, "id");

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(600);
}

$post = WallPost::fetchById($postId);

printXMLHeader();
if(!$post || $post->isDeleted()) {
	exit;
}
?> 
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><![CDATA[Twick.it - <?php loc('rss.wallPost', truncateString($post->getMessage())) ?>]]></title>
    <link><?php echo(HTTP_ROOT) ?></link>
    <description><![CDATA[<?php loc('rss.wallPost', truncateString($post->getMessage())) ?>]]></description>
    <language><?php echo(getLanguage()) ?></language>
    <copyright>Twick.it</copyright>
    <atom:link href="<?php echo($self) ?>" rel="self" type="application/rss+xml" />
    <!-- <pubDate>Erstellungsdatum("Tue, 8 Jul 2008 2:43:19")</pubDate>-->
    
 	<?php 
	foreach($post->findChildren() as $child) { 
		$author = $child->findAuthor();
		if($child->isDeleted()) {
			continue;
		}
	?> 
    <item>
      <title><![CDATA[<?php echo($author->getDisplayName()) ?>]]></title>
      <description><![CDATA[<?php echo($child->getMessage()) ?>]]></description>
      <link><?php echo($child->getUrl()) ?></link>
      <author><![CDATA[noreply@twick.it (<?php echo($author->getDisplayName()) ?>)]]></author>
      <guid><?php echo($child->getUrl()) ?></guid>
      <pubDate><?php echo(convertDateForRss($child->getCreationDate())) ?></pubDate>
    </item>
 	<?php
	} 
	?>
  </channel>
</rss>
		
