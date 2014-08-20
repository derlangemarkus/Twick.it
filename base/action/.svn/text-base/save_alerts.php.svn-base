<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
checkLogin();

// Parameter auslesen
$secret = getArrayElement($_POST, "secret");
$user = getUser();
if ($user->getSecret() != $secret) {
	redirect(HTTP_ROOT . "/index.php");
	exit;
}


$alerts = 0;
for($i=0; $i<10; $i++) {
    $alert = pow(2, $i);
    if(getArrayElement($_POST, $alert)) {
        $alerts += $alert;
    }
}
$user->setAlerts($alerts);
$user->save();


$authors = explode("," , getArrayElement($_POST, "users"));
foreach(UserAlert::fetchByUserId($user->getId()) as $alert) {
    if(!in_array($alert->getAuthorId(), $authors)) {
        $alert->delete();
    }
}
foreach($authors as $author) {
    UserAlert::create($user->getId(), $author);
}


redirect($user->getUrl() . "?inc=alerts&msg=alerts.success.saved");
?>
