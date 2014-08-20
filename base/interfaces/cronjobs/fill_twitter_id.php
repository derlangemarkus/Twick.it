<?php
require_once("../../util/inc.php"); 
require_once("../../util/thirdparty/pclzip-2-8/pclzip.lib.php"); 

checkCronjobLogin();

$users = User::fetchBySQL("twitter like '_%' AND thirdparty_id NOT LIKE 'Twitter:_%' AND mail NOT LIKE '%:%' and deleted=0");

foreach($users as $user) {
    if(!$user->getDeleted()) {
        $user->save();
    }
}

?>