<?php
require_once("../../util/inc.php");

foreach(User::fetchAll() as $user) {
	$url = $user->getAvatarUrl(200);
	$fileName = DOCUMENT_ROOT . "/writable/cache/supertrumpf/user_" . md5($url) . ".jpg";

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
				echo("$url<br />Was ist $mime?"); exit;
				exit;
		}
		imagejpeg($img, $fileName, 100);
	}
}
?>Fertig
