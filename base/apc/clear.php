<?php
require_once("../util/inc.php");
ini_set("display_errors", 1);

checkCronjobLogin();
apc_clear_cache();
redirect("index.php");
?>