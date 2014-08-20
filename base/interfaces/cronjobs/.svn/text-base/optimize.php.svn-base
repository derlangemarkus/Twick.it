<?php
require_once("../../util/inc.php"); 
checkCronjobLogin();


$conn = @mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);  
mysql_select_db(DB_DATABASE);

$tables = mysql_list_tables(DB_DATABASE);
while ($cells = mysql_fetch_array($tables)) {
	$table = $cells[0];
	if(startsWith($table, "tbl_")) {
		executeSQL("OPTIMIZE TABLE $table");
	}
}
?>