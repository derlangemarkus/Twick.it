<?php
require_once("../../../util/inc.php");

header("Content-Type: application/vnd.google-earth.kml+xml; charset=utf-8");
printXMLHeader();

setDBCacheTimeout(600);

$topics = Topic::fetchBySQL("latitude is not null");
?>
<kml xmlns="http://earth.google.com/kml/2.1" xmlns:aloqa="http://www.aloqa.com/2009/feed">
<Document>
    <?php
    foreach($topics as $topic) {
        $twick = $topic->findBestTwick();
		$user = $twick->findUser();
    ?>
    <Placemark id="<?php echo($topic->getId()) ?>">
        <name><![CDATA[<?php xecho($topic->getTitle()) ?>]]></name>
        <description><?php xecho(utf8encode($twick->getText())) ?> (erklärt von <![CDATA[<?php xecho (utf8encode($user->getDisplayName())) ?>)]]></description>
		<Style>
			<IconStyle>
				<Icon><href><![CDATA[<?php echo($user->getAvatarUrl(200)) ?>]]></href></Icon>
			</IconStyle>
		</Style>
        <Point>
			<coordinates><?php xecho($topic->getLongitude()) ?>,<?php xecho($topic->getLatitude()) ?>,0</coordinates>
        </Point>
		<aloqa:onView>
			<aloqa:actions>
				<aloqa:map/>
				<aloqa:web>
					<aloqa:customLabel><![CDATA[Twick.it öffnen]]></aloqa:customLabel>
					<aloqa:url><![CDATA[<?php echo($topic->getUrl()) ?>]]></aloqa:url>
				</aloqa:web>
			</aloqa:actions>
	   </aloqa:onView>
    </Placemark>
    <?php
    }
    ?>
</Document>
</kml>