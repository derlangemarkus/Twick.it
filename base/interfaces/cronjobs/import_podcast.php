<?php
require_once("../../util/inc.php"); 
checkCronjobLogin();

define("PODCAST_DIR", simplifyUrl(DOCUMENT_ROOT . "/../mp3"));
define("PODCAST_IMPORT_DIR", PODCAST_DIR . "/import");

$handle = opendir(PODCAST_IMPORT_DIR);
while (($file = readdir($handle)) !== false) {
    if ($file !== ".." && $file !== ".") {
        $fileName = PODCAST_IMPORT_DIR . "/" . $file;
        if(is_dir($fileName) && !startsWith($file, "_")) {
            importPodcastDir($fileName);
        } 
    }
}
closedir($handle);


function importPodcastDir($inDirname) {
    $speaker = substringAfterLast($inDirname, "/");
    $handle = opendir($inDirname);
    while (($file = readdir($handle)) !== false) {
        if ($file !== ".." && $file !== ".") {
            $fileName = $inDirname . "/" . $file;
            if(is_file($fileName)) {
                $twickId = false;
                if(startsWith($file, "Twick_")) {
                    $twickId = substringBetween(strtolower($file), "twick_", ".mp3");
                } else if(startsWith($file, "ID")) {
                    $twickId = substringBetween(strtolower($file), "id", ".mp3");
                }

                if($twickId && is_numeric($twickId)) {
                    if(Podcast::fetchByTwickId($twickId)) {
                        echo("Doppelter Twick $twickId<br />");
                    } else {
                        $podcast = new Podcast();
                        $podcast->setTwickId($twickId);
                        $podcast->setSpeaker($speaker);
                        $podcast->setCreationDate(getCurrentDate());
                        $podcast->save();

                        if(copy($fileName, PODCAST_DIR . "/Twick_" . $twickId . ".mp3")) {
                            unlink($fileName);
                        }
                    }
                }
            }
        }
    }
    closedir($handle);
}

?>