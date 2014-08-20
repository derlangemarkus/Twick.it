<?php
require_once("../../../util/inc.php");

function convertHexToRGB($inHex) {
	if (strlen($inHex) == 3) {
		$rHex = substr($inHex, 0, 1) . substr($inHex, 0, 1);
		$gHex = substr($inHex, 1, 1) . substr($inHex, 1, 1);
		$bHex = substr($inHex, 2, 1) . substr($inHex, 2, 1);
	} else if (strlen($inHex) == 6) {
		$rHex = substr($inHex, 0, 2);
		$gHex = substr($inHex, 2, 2);
		$bHex = substr($inHex, 4, 2);
	} else {
		die("Wrong hex-color $inHex");
	}
	return array(hexdec($rHex), hexdec($gHex), hexdec($bHex));
}


$image = imagecreate(20, 20);
$background_color = ImageColorAllocateAlpha ($image, 0, 0, 0, 127);

$colors = convertHexToRGB(getArrayElement($_GET, "color", "B3D361"));
imagefilledellipse($image, 10, 10, 19, 19, imagecolorallocate($image, $colors[0], $colors[1], $colors[2]));

header("Content-type: image/png");
imagepng($image);
?>