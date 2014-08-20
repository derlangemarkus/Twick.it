<?php
require_once("../../../../util/inc.php");
ini_set("display_errors", 1);
require_once '../config/config.php';
require_once '../library/junaio.class.php';

if (!Junaio::checkAuthentication()) {
	#header('HTTP/1.0 401 Unauthorized');
	#exit;
}


header("Content-Type: text/xml; charset=utf-8");

$perimeter = getArrayElement($_GET, "p", 100000);
$limit = getArrayElement($_GET, "m");

printXMLHeader();
?>
<results trackingurl="http://twick.it/interfaces/ar/glue/html/tracking.xml_enc">
    <?php
	$titles = array("Vier Mädchen auf der Brücke", "Mona Lisa", "Die Beständigkeit der Erinnerung", "Zwölf Sonnenblumen in einer Vase", "Der Tiger", "Die Erschaffung Adams", "Der Schrei");
	foreach($titles as $counter=>$title) {
		$topic = array_pop(Topic::fetchByTitle($title));
		$twick = $topic->findBestTwick();
		$user = $twick->findUser();
		?>
		<poi id="<?php echo($topic->getId()) ?>" cosid="<?php echo($counter+1) ?>" interactionfeedback="none">
			 <name><![CDATA[<?php echo($topic->getTitle()) ?>]]></name>
			 <author><![CDATA[<?php echo($user->getDisplayName()) ?>]]></author>
			 <description><![CDATA[<?php echo($twick->getText()) ?>]]></description>
			 <translation>0,0,0</translation>
			 <l>0.0,0.0,0.0</l>
			 <o>0.0,0.0,0.0</o>
			 <minaccuracy>2</minaccuracy>
			 <maxdistance>100000</maxdistance>
			 <mime-type>text/plain</mime-type>
			 <thumbnail><![CDATA[http://twick.it/html/img/avatar/64.png]]></thumbnail>
			 <icon><?php echo(HTTP_ROOT) ?>/interfaces/ar/junaio/icon.php</icon>
			 <homepage><![CDATA[<?php echo($topic->getUrl()) ?>]]></homepage>
			 <route>false</route>
	   </poi>
	<?php } ?>
</results>
