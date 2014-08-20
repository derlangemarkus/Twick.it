<?php
$js = <<< END

var username = window.location.href.match(/^http(s)?:\/\/(www.)?twitter.com\/([a-zA-Z0-9_]+)/i);

if (username == null) {
	alert('Das Bookmarklet funktioniert nur mit Seiten unter http://twitter.com/');
} else {
	u = 'http://twick.it/user/Twitter-User-' + username[3];
	var f = window.open(u, 'twickit', 'width=800,height=600,resizable=yes,scrollbars=yes,left=0,top=0'); 
	void(0);
}



END;

$js = str_replace("\n", "", $js);
$js = str_replace("\r", "", $js);
$js = str_replace("; ", ";", $js);
$js = str_replace(" ", "%20", $js);
$js = str_replace("\t", "%20", $js);

echo($js);
?>