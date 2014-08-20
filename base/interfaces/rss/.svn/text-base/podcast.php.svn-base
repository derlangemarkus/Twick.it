<?php
require_once("../../util/inc.php");
header("Content-Type: application/rss+xml; charset=utf-8");

if (!getArrayElement($_GET, "noCache")) {
    setDBCacheTimeout(600);
}

printXMLHeader();
?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#">
    <channel>
        <title>Twick.it - Podcast</title>
        <itunes:subtitle>Jeden Tag ein neuer Twick</itunes:subtitle>
        <itunes:summary>Täglich gibt es auf's neue eine gesprochene Kurzerklärung von Twick.it, der Erklärmaschine.</itunes:summary>
        <link>http://twick.it</link>
        <description>Täglich gibt es auf's neue eine gesprochene Kurzerklärung von Twick.it, der Erklärmaschine.</description>
        <language>de</language>
        <webMaster>Twick.it</webMaster>
        <managingEditor>Twick.it</managingEditor>
        <atom:link rel="self" type="application/rss+xml" title="Twick.it - Podcast" href="<?php echo(HTTP_ROOT) ?>/interfaces/rss/podcast.rss" xmlns:atom="http://www.w3.org/2005/Atom" />
        <itunes:owner>
            <itunes:name>Markus Möller</itunes:name>
            <itunes:email>podcast@twick.it</itunes:email>
        </itunes:owner>
        <itunes:author>Twick.it</itunes:author>
        <itunes:category text="Education" />
        <itunes:category text="Technology" />
        <itunes:keywords>Twick.it, Erklärmaschine, Erklärungen, Allgemeinwissen</itunes:keywords>
        <itunes:image href="http://twick.it/html/img/avatar/300.jpg" />
        <itunes:new-feed-url>http://twick.it/interfaces/rss/podcast.php</itunes:new-feed-url>
        <image>
            <url>http://twick.it/html/img/avatar/300.jpg</url>
            <title>Twick.it - Podcast</title>
            <link>http://twick.it</link>
        </image>
        <itunes:explicit>no</itunes:explicit>
        <ttl>20</ttl>
        <?php 
		foreach (Podcast::fetchLatest(60) as $podcast) { 
			$topic = $podcast->getTwick()->findTopic();
		?>
            <item>
                <title><![CDATA[<?php echo($podcast->getTitle()) ?>]]></title>
                <description>
                    <![CDATA[
                    <label>Thema:</label> <a href="<?php echo($podcast->getTopicUrl()) ?>" target="_blank"><?php echo($podcast->getTitle()) ?></a><br />
                    <label>Autor:</label> <a href="<?php echo($podcast->getAuthor()->getUrl()) ?>" target="_blank"><?php echo($podcast->getAuthor()->getLogin()) ?></a><br />
                    <label>Gelesen von:</label> <?php echo($podcast->getSpeaker()) ?></p>
                    ]]>
                </description>
                <author><![CDATA[<?php echo($podcast->getSpeaker()) ?>]]></author>
                <pubDate><?php echo(convertDateForRss($podcast->getPublishDate())) ?></pubDate>
                <guid isPermaLink="true"><?php echo($podcast->getUrl()) ?></guid>
                <link><?php echo($podcast->getUrl()) ?></link>
                <enclosure url="<?php echo(HTTP_ROOT) ?>/mp3/<?php echo($podcast->getMp3File()) ?>" length="<?php echo($podcast->getSize(false)) ?>" type="audio/mpeg"/>
				<?php if($topic && $topic->hasCoordinates()) { ?>
			    <geo:lat><?php echo($topic->getLatitude()) ?></geo:lat>
			    <geo:long><?php echo($topic->getLongitude()) ?></geo:long>
			    <?php } ?>
            </item>
        <?php } ?>
    </channel>
</rss>