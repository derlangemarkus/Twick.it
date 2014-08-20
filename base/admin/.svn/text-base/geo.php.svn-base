<?php
require_once("../util/inc.php");
#checkAdmin();
if (!isGeo()) {
	redirect(HTTP_ROOT . "/index.php");
	exit;
}


$id = getArrayElement($_GET, "id");
$longitude = $latitude = 0;
$zoom = 3;

$topic = Topic::fetchById($id);

if(getArrayElement($_GET, "noGeo")) {
    $topic->setLatitude(null);
	$topic->setLongitude(null);
    $topic->setNoGeo(true);
	$topic->save();
	?>
	<script type="text/javascript">
	window.opener.location.reload();
	self.close();
	</script>
	<?php
}

$lat = getArrayElement($_GET, "latitude");
$lng = getArrayElement($_GET, "longitude");
if ($lat && $lng) {
	$topic->setLatitude($lat);
	$topic->setLongitude($lng);
    $topic->setNoGeo(false);
	$topic->save();
	?>
	<script type="text/javascript">
	window.opener.location.reload();
	self.close();
	</script>
	<?php
}

if ($topic->hasCoordinates()) {
	$latitude = $topic->getLatitude();
	$longitude = $topic->getLongitude();
	$zoom = 18;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
*{font-family:Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;font-size:12px;line-height:18px;color:#333;}
</style>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
var map = null;
var marker = null;
var zoom = <?php echo($zoom) ?>;

function initMap() {
    map =
        new google.maps.Map(
            document.getElementById("map"),
            {
                zoom: <?php echo($zoom) ?>,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center:new google.maps.LatLng(<?php echo($latitude) ?>,<?php echo($longitude) ?>)
            }
        );

    <?php if ($topic && $topic->hasCoordinates()) { ?>
        addMarker(<?php echo($latitude) ?>, <?php echo($longitude) ?>);
    <?php } ?>

    google.maps.event.addListener(map, 'click', function(event) {
        addMarker(event.latLng.lat(), event.latLng.lng());
    });
	
	google.maps.event.addListener(marker, 'dragend', function(event) {
		addMarker(event.latLng.lat(), event.latLng.lng());
	});		
	
	google.maps.event.addListener(map, 'zoom_changed', function() {
		var newZoom = map.getZoom();
		if (newZoom > 14 && zoom <= 14) {
			map.setMapTypeId(google.maps.MapTypeId.HYBRID);
		}
		zoom = newZoom;	
	});
}


function addMarker(inLatitude, inLongitude) {
	if (marker == null) {
		marker = new google.maps.Marker({
				  position: new google.maps.LatLng(inLatitude, inLongitude),
				  map:map,
				  draggable: true
				});
	} else {
		marker.setPosition(new google.maps.LatLng(inLatitude, inLongitude));
	}
	document.geoForm.latitude.value = inLatitude;
    document.geoForm.longitude.value = inLongitude;
}


function importWikipedia() {
	var input = prompt("Wikipedia-Koordinaten im Format 53.621389°, 10.021111° eingeben");
	var regex = /(.+), (.+)/;
	regex.exec(input);
	document.geoForm.latitude.value = RegExp.$1.substring(0, RegExp.$1.length-1);
    document.geoForm.longitude.value = RegExp.$2.substring(0, RegExp.$2.length-1);
}


function searchGeo() {
	var search = document.searchForm.search.value;
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode( 
		{ 'address': search}, 
		function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				addMarker(results[0].geometry.location.lat(), results[0].geometry.location.lng());
				map.setZoom(16);
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		}
	);

}
</script>
</head>

<body>
    <h1><?php echo($topic->getTitle()) ?></h1>
    <form action="" name="geoForm" style="float:left;">
        <input type="hidden" name="id" value="<?php echo($id) ?>" />
        <input type="text" name="latitude" />
        <input type="text" name="longitude" />
        <input type="submit" value="Speichern" />
		<a href="javascript:;" onclick="importWikipedia()">Von Wikipedia &uuml;bernehmen</a>
		<a href="?noGeo=1&id=<?php echo($id) ?>" style="margin-left:30px;">Keine Geokodierung</a>
    </form>
	<form action="" name="searchForm" style="float:right;margin-left:200px:" onsubmit="searchGeo();return false;">
		<input type="text" name="search" value="<?php echo(htmlspecialchars(strtr($topic->getTitle(), "()", "  "))) ?>" size="50"/>
		<a href="javascript:;" onclick="searchGeo();">Suchen</a>
	</form>
    <div id="map" style="width:100%;height:90%;border:1px solid #333;float: left;"></div>
    <script language="JavaScript" type="text/javascript">
  	initMap();
  	</script>

</body>
</html>