<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php");

$name = getArrayElement($_POST, "n");
$mail = getArrayElement($_POST, "m");
$subject = getArrayElement($_POST, "s");
$message = getArrayElement($_POST, "t");

try {
	$mailer = new PHPMailer();
	$mailer->CharSet = 'utf-8';
	$mailer->From = $mail;
	$mailer->FromName = $name;
	$mailer->Subject = $subject;
	$mailer->Body = $message;
	$mailer->AddAddress(SUPPORT_MAIL_RECEIVER);
	$ok = $mailer->Send();
} catch(Exception $exception) {
	$ok = false;
}


if ($ok) {
    redirect("../support_ok.php?t=" . urlencode($message));
} else {
    redirect("../support.php?n=" . urlencode($name) . "&m=" . urlencode($mail) . "&s=" . urlencode($subject) . "&t=" . urlencode($message) . "&error=" . urlencode(_loc('support.error.text', SUPPORT_MAIL_RECEIVER)));
}
?>.