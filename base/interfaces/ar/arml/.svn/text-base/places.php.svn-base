<?php
require_once("../../../util/inc.php");
header("Content-Type: text/xml; charset=utf-8");

$latitude = getArrayElement($_GET, "latitude");
$longitude = getArrayElement($_GET, "longitude");
$limit = getArrayElement($_GET, "maxNumberOfPois", 50);

$items = Topic::findNear($latitude, $longitude, false, $limit);
printXMLHeader();
?>
<kml xmlns="http://www.opengis.net/kml/2.2"
     xmlns:ar="http://www.openarml.org/arml/1.0"
     xmlns:wikitude="http://www.openarml.org/wikitude/1.0"
     xmlns:wikitudeInternal="http://www.openarml.org/wikitudeInternal/1.0">

    <Document>
        <ar:provider id="twick.it">
            <ar:name>Twick.it</ar:name>
            <ar:description>Twick.it, die Erklärmaschine für deine Themen</ar:description>
            <wikitude:providerUrl>http://twick.it</wikitude:providerUrl>
            <wikitude:tags>twick.it, explain engine, erklärmaschine, erklärungen</wikitude:tags>
            <wikitude:logo><?php echo(HTTP_ROOT) ?>/html/img/avatar/96.png</wikitude:logo>
            <wikitude:icon><?php echo(HTTP_ROOT) ?>/html/img/avatar/32.png</wikitude:icon>
        </ar:provider>
        <?php 
        foreach($items as $info) { 
			list($distance, $topic) = $info;
        	$twick = $topic->findBestTwick();
        	$user = $twick->findUser();
        ?>
        <Placemark id="<?php xecho($topic->getId()) ?>">
            <ar:provider>twick.it</ar:provider>
            <name><?php xecho($topic->getTitle()) ?></name>
            <description><![CDATA[<?php echo htmlspecialchars_decode($user->getLogin()) ?> sagt: <?php echo htmlspecialchars_decode($twick->getText()) ?>]]></description>
            <wikitude:info>
                <wikitude:thumbnail><![CDATA[<?php echo($user->getAvatarUrl(64)) ?>]]></wikitude:thumbnail>
                <wikitude:url><?php xecho($topic->getUrl()) ?></wikitude:url>
            </wikitude:info>
            <Point>
                <coordinates><?php xecho($topic->getLongitude()) ?>,<?php xecho($topic->getLatitude()) ?></coordinates>
            </Point>
        </Placemark>
       	<?php } ?>
    </Document>
</kml>