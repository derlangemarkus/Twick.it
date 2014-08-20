<?php
require_once("../../util/inc.php"); 
require_once("../../util/thirdparty/pclzip-2-8/pclzip.lib.php"); 

checkCronjobLogin();

define("BACKUP_DIR", DOCUMENT_ROOT . "/writable/backup/");
$fileName = "backup_" . date("ymd") . "_" . date("His");
$fileHandle = fopen(BACKUP_DIR . "$fileName.sql", "w");


// Dump erzeugen
$conn = @mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);  
mysql_select_db(DB_DATABASE);

$tables = mysql_list_tables(DB_DATABASE);
while ($cells = mysql_fetch_array($tables)) {
	$table = $cells[0];
	if(startsWith($table, "tbl_")) {
		fwrite($fileHandle, "/* DROP TABLE IF EXISTS `$table`; */\n");
		$result = mysql_query("SHOW CREATE TABLE `$table`");
		if ($result) {
			$create = mysql_fetch_array($result);
			$create[1] .= ";";
			$line = str_replace("\n", "", $create[1]);
			fwrite($fileHandle, $line . "\n");
			$data = mysql_query("SELECT * FROM `$table`");
			$num = mysql_num_fields($data);
			while ($row = mysql_fetch_array($data)) {
				$line = "INSERT INTO `$table` VALUES(";
				for ($i=1;$i<=$num;$i++) {
					$line .= "'" . mysql_real_escape_string(utf8_encode($row[$i-1])) . "', ";
				}
				$line = substr($line,0,-2);
				fwrite($fileHandle, $line . ");\n");
			}
		}
	}
}
fclose($fileHandle);


// Zippen
$archive = new PclZip(BACKUP_DIR . "$fileName.zip");
$archive->add(BACKUP_DIR . "$fileName.sql", "", BACKUP_DIR);


// SQL-Dump loeschen
//unlink(BACKUP_DIR . "$fileName.sql");


// Per Mail verschicken
$mailer = new PHPMailer();
$mailer->CharSet = 'utf-8';
$mailer->From = USER_MAIL_SENDER;
$mailer->FromName = "Twick.it";
$mailer->Subject = "Backup $fileName.zip";
$mailer->Body = "Anbei das Backup $fileName.zip";
$mailer->AddAddress("markus@twick.it");
$mailer->AddAttachment(BACKUP_DIR . "$fileName.zip"); 
$mailer->Send();


// Alte Backups loeschen
$handle = opendir(BACKUP_DIR);
while (($file = readdir($handle)) !== false) {
	if ($file !== ".." && $file !== ".") {
		$fileName = BACKUP_DIR . $file;
		$stat = stat($fileName);
		if($stat["mtime"] < time()-10*24*60*60) {
			unlink($fileName);
		}
	}
}
closedir($handle);

?>