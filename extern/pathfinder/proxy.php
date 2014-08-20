<?php
readfile("http://twick.it/interfaces/api/explain.json&search=" . urlencode($_GET["search"]));
?>