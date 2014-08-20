<?php
require_once("../../util/inc.php");

$id = getArrayElement($_GET, "id");
$user = User::fetchById($id);
$url = $user->getAvatarUrl(200);

$fileName = DOCUMENT_ROOT . "/writable/cache/user_" . md5($url) . ".jpg";

if (!file_exists($fileName)) {
	$mime = exif_imagetype($url);

	switch ($mime) {
		case IMAGETYPE_PNG:
			$img = imagecreatefrompng($url);
			break;

		case IMAGETYPE_JPEG:
			$img = imagecreatefromjpeg($url);
			break;

		case IMAGETYPE_GIF:
			$img = imagecreatefromgif($url);
			break;

		case IMAGETYPE_BMP:
			$img = imagecreatefrombmp($url);
			break;

		default:
			#echo("Was ist $mime?"); exit;
			header("Content-Type: " . $info["mime"]);
			readfile($url);
			exit;
	}
	imagejpeg($img, $fileName, 100);
}

header("Content-Type: image/jpeg");
readfile($fileName);
?>
