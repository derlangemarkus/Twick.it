<?php
$js = <<< END

var s;
if (document.selection) {
    s=document.selection.createRange().text;
} else {   
	s=document.getSelection();
}

for (i=0; i<frames.length; i++) {
	if (document.selection) {
    	s=frames[i].document.selection.createRange().text;
    } else {
		s=frames[i].document.getSelection();
	}
	if (s) {
		break;
	}
}
u = 'http://twick.it/find_topic.php?search=' + s + '&link=' + document.location.href;
var f = window.open(u, 'twickit', 'width=800,height=600,resizable=yes,scrollbars=yes,left=0,top=0'); 
void(0);

END;

$js = str_replace("\n", "", $js);
$js = str_replace("\r", "", $js);
$js = str_replace("; ", ";", $js);
$js = str_replace(" ", "%20", $js);
$js = str_replace("\t", "%20", $js);

echo($js);
?>