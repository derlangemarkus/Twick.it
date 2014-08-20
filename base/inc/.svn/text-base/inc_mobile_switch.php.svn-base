<?php
if (getArrayElement($_GET, "nomobile")) {
	setMobileCookie(false);
}

if (getArrayElement($_COOKIE, "mobile") && !getArrayElement($_GET, "nomobile")) {
	$msg = "<a href='http://twick.it?nomobile=1'>" . _loc('mobile.switchMessage') . "</a>";
	redirect("http://m.twick.it?msg=" . urlencode($msg));
}
setMobileCookie(false);
?>