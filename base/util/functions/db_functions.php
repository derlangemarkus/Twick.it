<?php
/*
 * Created at 21.05.2007
 *
 * @author Markus Moeller - Twick.it
 */
$__TWICKIT_DB_CACHE_TIMEOUT = 0;
function setDBCacheTimeout($inSeconds){
	global $__TWICKIT_DB_CACHE_TIMEOUT;
	$__TWICKIT_DB_CACHE_TIMEOUT = $inSeconds;
}

function resetDBCacheTimeout(){
	setDBCacheTimeout(0);
}

function getDBCacheTimeout() {
	global $__TWICKIT_DB_CACHE_TIMEOUT;
	return $__TWICKIT_DB_CACHE_TIMEOUT;
}


function executeSQL($inSQL, $inSkipDebugOutput=false) {
	if (SQL_DEBUG && !$inSkipDebugOutput) {
		echo ("<i>$inSQL</i><br>\n");
	}
	$db =& DB::getInstance();
	return $db->execute($inSQL);
}


function saveDBObject($inTableName, $inValues, $inWhereClause) {
	$insertNew = true;

	$where = "";
	$separator = "";
	foreach($inWhereClause as $field=>$value) {
		$where .= $separator . $field . "='$value'";
		$separator = " AND ";
	}
	

	if (sizeof($inWhereClause)) {		
		// Evtl. vorhandenen Eintrag finden
		$sql = "SELECT * FROM $inTableName WHERE $where";
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$insertNew = false;			
		}
	}
	
	
	if ($insertNew) {
		// Neu anlegen			
		$fieldNames = "";
		$values = "";
		
		$fieldNames = "";
		$values = "";
		$separator = "";
		foreach($inValues as $field=>$value) {
			$fieldNames .= $separator . $field;
			$values .= "$separator'$value'";
			$separator = ", ";
		}	

		return executeSQL("INSERT INTO $inTableName ($fieldNames) VALUES ($values)");
	} else {
		// Vorhandenen Eintrag aktualisieren			
		$set = "";	
		$separator = "";
		foreach($inValues as $field=>$value) {
			if ($value === "null") {
				$set .= $separator . $field . "=null";				
			} else {
				$set .= $separator . $field . "='$value'";
			}
			$separator = ", ";
		}		
		
		return executeSQL("UPDATE $inTableName SET $set WHERE $where");
	}
}
	
	
function getAllDatabaseTables() {
	if (!mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)) {
	    echo 'Keine Verbindung zur Datenbank möglich';
	    exit;
	}
	
	$result = mysql_list_tables(DB_DATABASE);
	   
	if (!$result) {
	    echo "DB Fehler, Tabellen können nicht angezeigt werden\n";
	    echo "MySQL Fehler: " . mysql_error();
	    exit;
	}
	
	$tables = array();
	while ($row = mysql_fetch_row($result)) {
	    array_push($tables, $row[0]);
	}
	
	mysql_free_result($result);
	
	return $tables;
}
	
	
	
?>