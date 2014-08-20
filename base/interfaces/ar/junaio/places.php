<?php
require_once("../../../util/inc.php");
header("Content-Type: text/xml; charset=utf-8");

$perimeter = getArrayElement($_GET, "p", 100000);
$limit = getArrayElement($_GET, "m");
$location = getArrayElement($_GET, "l");
list($latitude, $longitude, $altitude) = explode(",", $location);

$items = Topic::findNear($latitude, $longitude, $perimeter, $limit);

printXMLHeader();
?>
<results>
    <?php
    foreach($items as $info) {
        list($distance, $topic) = $info;
        $twick = $topic->findBestTwick();
        $user = $twick->findUser();
    ?>
    <poi id="<?php echo($twick->getId()) ?>" interactionfeedback="none">
        <name><![CDATA[<?php echo($topic->getTitle()) ?>]]></name>
        <author><![CDATA[<?php echo($user->getDisplayName()) ?>]]></author>
        <description><![CDATA[<?php echo($twick->getText()) ?>]]></description>
        <l><?php echo($topic->getLatitude()) ?>,<?php echo($topic->getLongitude()) ?>,0</l>
        <o>0,0,0</o>
        <mime-type>text/plain</mime-type>
        <thumbnail><![CDATA[<?php echo($user->getAvatarUrl(64)) ?>]]></thumbnail>
        <icon><?php echo(HTTP_ROOT) ?>/interfaces/ar/junaio/icon.php</icon>
        <homepage><![CDATA[<?php echo($topic->getUrl()) ?>]]></homepage>
        <route>true</route>
    </poi>
    <?php } ?>

</results>
