<?php 
require_once("inc.php");

$latitude = getArrayElement($_GET, "lat", getArrayElement($_SESSION, "latitude"));
$longitude = getArrayElement($_GET, "long", getArrayElement($_SESSION, "longitude"));

$title = _loc('mobile.nearest.title');

include("inc/header.php"); 
?>
<script type="text/javascript">
function updateGeoPosition() {
	if (navigator.geolocation) {
        $("updatePosition").update("<?php loc("core.pleaseWait") ?> <img src='html/img/ajax-loader.gif' alt='' border='0'/>");
        $("updatePosition").style.backgroundColor = '#FFF';
        navigator.geolocation.getCurrentPosition(
            function(inPosition) {
                document.location.href = "nearby.php?lat=" + inPosition.coords.latitude + "&long=" + inPosition.coords.longitude;
            }
       );
    } else {
		alert("<?php loc('mobile.nearest.error') ?>");
	}
}
</script>
<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script type="text/javascript">
var map = null;
var bounds = new google.maps.LatLngBounds();

function initMap() {
	 map =
        new google.maps.Map(
            document.getElementById("map"),
            {
                zoom:8,
                mapTypeId:google.maps.MapTypeId.ROADMAP,
                center:new google.maps.LatLng(0, 180),
				draggable:true,
				navigationControl: true,
				navigationControlOptions: {
					style: google.maps.NavigationControlStyle.DEFAULT,
					position: google.maps.ControlPosition.RIGHT
				},
				mapTypeControl: true,
				mapTypeControlOptions: {
					style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
					position: google.maps.ControlPosition.LEFT
				},
				scaleControl: false
            }
        );
		
	document.getElementById("map").style.display="block";
	showHomeInMap();
}


function showAddressInMap(inIndex, inLatitude, inLongitude) {
    var image = new google.maps.MarkerImage("<?php echo(HTTP_ROOT) ?>/html/img/marker/marker" + inIndex + ".png",
		new google.maps.Size(14, 24),
		new google.maps.Point(0,0),
		new google.maps.Point(9, 34),
		new google.maps.Size(14, 24)
	);
	
	var shadow = new google.maps.MarkerImage("http://www.google.com/mapfiles/shadow50.png",
		new google.maps.Size(26, 24),
		new google.maps.Point(0,0),
		new google.maps.Point(9, 34),
		new google.maps.Size(26, 24)
	);
	
	var point = new google.maps.LatLng(inLatitude, inLongitude);
	
    var marker = 
		new google.maps.Marker({
			position: point,
			map:map,
			shadow: shadow,
			icon: image
		});
    	
	google.maps.event.addListener(marker, 'click', function() {
			$("twick" + inIndex).scrollTo();
		});
	
		
	bounds.extend(point);
	map.fitBounds(bounds);
}


function showHomeInMap() {
	var image = new google.maps.MarkerImage("http://maps.gstatic.com/intl/de_de/mapfiles/ms/micons/man.png",
		new google.maps.Size(32, 32),
		new google.maps.Point(0,0),
		new google.maps.Point(9, 34),
		new google.maps.Size(32, 32)
	);
	
	var shadow = new google.maps.MarkerImage("http://maps.gstatic.com/intl/de_de/mapfiles/ms/micons/man.shadow.png",
		new google.maps.Size(59, 32),
		new google.maps.Point(0,0),
		new google.maps.Point(9, 34),
		new google.maps.Size(59, 32)
	);
	
	var point = new google.maps.LatLng(<?php echo($latitude) ?>, <?php echo($longitude) ?>);
	
    var marker = 
		new google.maps.Marker({
			position: point,
			map:map,
			shadow: shadow,
			icon: image
		});
		
	
	bounds.extend(point);
	map.fitBounds(bounds);
	map.setCenter(point);
}
</script>
<div class="class_content">
<h1><?php loc('mobile.nearest.headline') ?></h1>
<a href="javascript:;" onclick="updateGeoPosition()" class="class_button class_longbutton" style="display:block;text-align:center;color:#000;font-weight:bold;width:94%;" id="updatePosition"><?php loc('mobile.nearest.update') ?></a>

<?php 
if ($latitude && $longitude) {
	$near = Topic::findNear($latitude, $longitude, 100000, 20);
	$_SESSION["latitude"] = $latitude;
	$_SESSION["longitude"] = $longitude;
    ?>
	<div id="map" style="border:1px solid #333; width:94%; height:200px;display:none;margin-bottom:10px;padding:9px;"></div>
	<script type="text/javascript">
	initMap();
	</script>
	<table style="width:96%" cellpadding="0" cellspacing="0">
	<?php 
	foreach($near as $counter=>$info) {
		$index = $counter+1;
		list($distance, $topic) = $info;
		$twick = $topic->findBestTwick();
		echo("<tr id='twick" . $index . "'><td colspan='2'><img src='" . HTTP_ROOT . "/html/img/marker/marker$index.png' alt='$index'/ style='width:14px;height:24px;vertical-align:middle;margin-bottom:2px;'> " . number_format($distance/1000, 2) . "km - <a href='http://maps.google.com/maps?saddr=$latitude,$longitude" . "&daddr=" . $topic->getLatitude() . "," . $topic->getLongitude() . "' target='_blank'>" . _loc('mobile.nearest.route') . "</a></td></tr>");
		showTwick($twick, 3, "", true);
		?>
		<script type="text/javascript">
		showAddressInMap(<?php echo($index) ?>, <?php echo($topic->getLatitude()) ?>, <?php echo($topic->getLongitude()) ?>);
		</script>
		<?php
	}
	?>
	</table>
<?php } else { ?>
	<br /><?php loc('mobile.nearest.updateFirst') ?>
<?php } ?>
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>