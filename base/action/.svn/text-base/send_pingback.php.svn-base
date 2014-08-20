<?php
require_once("../util/inc.php");
require_once("../util/thirdparty/trackback/trackback_cls.php");

//checkCronjobLogin();

$id = getArrayElement($_POST, "twick");

$twick = Twick::fetchById($id);
$user = $twick->findUser();

$trackback = new Trackback('Twick.it', $user->getLogin(), 'UTF-8');
$trackback->ping($twick->getLink(), $twick->getUrl());
?>