<?php
require_once("../../../util/inc.php");

header("Content-Type: application/vnd.google-earth.kml+xml; charset=utf-8");
printXMLHeader();

setDBCacheTimeout(600);

$topics = Topic::fetchBySQL("latitude is not null");
//$topics = array_slice($topics, 0, 10);
?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document>
	<name>Twick.it</name>
    <description>Show short explanations with at most 140 characters.</description>
	<Style id="highlightPlacemark">
      <IconStyle>
        <Icon>
          <href><?php echo(HTTP_ROOT) ?>/html/img/avatar/_64.png</href>
        </Icon>
		<scale>1.4</scale>
      </IconStyle>
    </Style>
    <Style id="normalPlacemark">
      <IconStyle>
        <Icon>
          <href><?php echo(HTTP_ROOT) ?>/html/img/avatar/_64.png</href>
        </Icon>
      </IconStyle>
    </Style>
    <StyleMap id="twickitStyle">
      <Pair>
        <key>normal</key>
        <styleUrl>#normalPlacemark</styleUrl>
      </Pair>
      <Pair>
        <key>highlight</key>
        <styleUrl>#highlightPlacemark</styleUrl>
      </Pair>
    </StyleMap>
    <?php
    foreach($topics as $topic) {
        $twick = $topic->findBestTwick();
		$user = $twick->findUser();
    ?>
      <Placemark>
        <name><?php xecho(utf8_decode($topic->getTitle())) ?></name>
        <description>
			<![CDATA[
				<table><tr>
					<td valign="top"><img src="<?php echo($user->getAvatarUrl()) ?>" style="float:left;"/></td>
					<td><b><?php echo(utf8_decode($user->getDisplayName())) ?> sagt: </b><?php echo(utf8_decode($twick->getText())) ?><br />
					<br />
					<a href="<?php echo($topic->getUrl()) ?>"><?php echo($topic->getUrl()) ?></a>
					</td>
				</tr></table>
			 ]]>
		</description>
		<styleUrl>#twickitStyle</styleUrl>
        <Point>
          <coordinates><?php xecho($topic->getLongitude()) ?>, <?php xecho($topic->getLatitude()) ?></coordinates>
        </Point>
      </Placemark>
    <?php
    }
    ?>
</Document>
</kml>