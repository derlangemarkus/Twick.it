<?php
require_once("../../util/inc.php"); 

checkCronjobLogin();

$account = getArrayElement($_GET, "name");

$xml = @simplexml_load_file("http://derlangemarkus:tragic7t@twitter.com/users/show.xml?screen_name=" . $account);
if ($xml->error) {
	echo("Gesperrt");
} else {
	$mailer = new PHPMailer();
	$mailer->CharSet = 'utf-8';
	$mailer->From = USER_MAIL_SENDER;
	$mailer->FromName = "Twick.it";
	$mailer->Subject = "Twickit ist wieder frei!";
	$mailer->Body = "Der Accoutn $account ist bei Twitter nicht mehr gesperrt. Sofort sichern!";
	$mailer->AddAddress("markus.moeller@gmx.de");
	$mailer->AddAddress("markus@twick.it");
	$mailer->Send();
}

?>
