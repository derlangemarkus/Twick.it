<?php
/*
 * Created at 04.04.2012
 *
 * @author Markus Moeller - Twick.it
 */
$url = "http://test.twick.it/" . $_GET["url"];

header("Content-type: " . mime_content_type($url) . "; charset=utf-8");
readfile($url);
?>