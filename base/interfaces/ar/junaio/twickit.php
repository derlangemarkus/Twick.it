<?php
require_once("../../../util/inc.php");
ini_set("display_errors", 1);
header("Content-Type: text/xml; charset=utf-8");

$perimeter = getArrayElement($_GET, "p", 100000);
$limit = getArrayElement($_GET, "m");
$location = getArrayElement($_GET, "l");
list($latitude, $longitude, $altitude) = explode(",", $location);

$items = Topic::findNear($latitude, $longitude, $perimeter, $limit);

printXMLHeader();
?>
<results trackingurl="http://www.junaio.com/publisherDownload/tutorial/tracking_tutorial.xml_enc" _trackingurl="http://twick.it/interfaces/ar/junaio/trackingxml.xml_enc">
    <?php
    $topic = array_pop(Topic::fetchByTitle("Twick.it"));
    $twick = $topic->findBestTwick();
    $user = $twick->getUser();
    ?>
    <poi id="-1" interactionfeedback="none">
         <name><![CDATA[<?php echo($topic->getTitle()) ?>]]></name>
         <author><![CDATA[<?php echo($user->getDisplayName()) ?>]]></author>
         <description><![CDATA[<?php echo($twick->getText()) ?>]]></description>
         <l>0.0,0.0,0.0</l>
         <o>0.0,0.0,0.0</o>
         <minaccuracy>2</minaccuracy>
         <maxdistance>100000</maxdistance>
         <mime-type>text/plain</mime-type>
         <thumbnail><![CDATA[<?php echo($user->getAvatarUrl(64)) ?>]]></thumbnail>
         <icon><?php echo(HTTP_ROOT) ?>/interfaces/ar/junaio/icon.php</icon>
         <homepage><![CDATA[<?php echo($topic->getUrl()) ?>]]></homepage>
         <route>false</route>
   </poi>
</results>
