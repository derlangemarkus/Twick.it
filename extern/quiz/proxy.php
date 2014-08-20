<?php
readfile("http://twickit.de/interfaces/api/random_twick.json?best=1&limit=" . $_GET["limit"]);
?>