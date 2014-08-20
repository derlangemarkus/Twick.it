<?php
require_once '../../util/inc.php';

$id = getArrayElement($_GET, "id");
$topic = Topic::fetchById($id);

$topics = $topic->findNearest(400000, 10);
?>
<html>
<head>
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
</head>
<body>
    <div id="map" style="width:800px; height:400px;border:1px solid #333;"></div>
    <script type="text/javascript">
        var bounds = new google.maps.LatLngBounds();
        map =
            new google.maps.Map(
                $("map"),
                {
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    center:new google.maps.LatLng(<?php echo($topic->getLatitude()) ?>,<?php echo($topic->getLongitude()) ?>)
                }
            );

        <?php
        foreach($topics as $info) {
            list($distance, $aTopic) = $info;
            ?>showAddress(<?php echo($aTopic->getLatitude()) ?>, <?php echo($aTopic->getLongitude()) ?>, '<?php echo($aTopic->getTitle()) ?>', <?php echo($distance) ?>);
            <?php
        ?>
        <?php } ?>

        map.fitBounds(bounds);

        function showAddress(inLatitude, inLongitude, inTitle, inDistance) {
            var title = inTitle + " (" + Math.round(inDistance/10)/100 + " km)";

            var shadow =
                new google.maps.MarkerImage(
                    "http://www.google.com/mapfiles/shadow50.png",
                    new google.maps.Size(37, 34),
                    new google.maps.Point(0,0),
                    new google.maps.Point(10,34)
                );

            var icon =
                new google.maps.MarkerImage(
                    "http://www.google.com/mapfiles/marker.png"
                );

            point = new google.maps.LatLng(inLatitude, inLongitude);
            bounds.extend(point);

            var infowindow = new google.maps.InfoWindow({content: title});

            var marker = new google.maps.Marker({
                  position: point,
                  map: map,
                  title:title,
                  icon:icon,
                  shadow:shadow
              });

            google.maps.event.addListener(marker, 'click', function() {
                //infowindow.open(map, marker);
                map.panTo(marker.getPosition());
            });

        }
    </script>
</body>
</html>
