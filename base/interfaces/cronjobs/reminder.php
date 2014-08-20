<?php
require_once("../../util/inc.php"); 
require_once("../../util/thirdparty/pclzip-2-8/pclzip.lib.php"); 

checkCronjobLogin();

// Erste Erinnerung
$users = User::fetchBySQL("approved=0 AND deleted=0 AND reminder=0 AND register_language_code='" . getLanguage() . "' AND creation_date<='" . date("Y-m-d", time()-7*24*60*60). "'");

foreach($users as $user) {
	$user->setReminder(1);
	$user->save();

    if($user->isAnonymous()) {
        continue;
    }

    srand((double)microtime() * 1000008);
	$rand = rand(65, 99);
	if ($rand > 90) {
		$char = $rand-90;
	} else {
		$char = chr($rand);
	}
	$link = HTTP_ROOT . "/register_approve.php?id=" . $user->getId() . "&secret=$char" . urlencode($user->getSecretSecret()) . "&lng=" . getLanguage();
	
	$mailText = _loc('email.reminder.first.text', array($user->getLogin(), UserInfo::findNumberOfUsers(true), Twick::findNumberOfTwicks(true), $link));
	$mailText .= "\n-- \n";
	$mailText .= _loc('email.footer') . "\n";
	
	$mailer = new PHPMailer();
	$mailer->CharSet = 'utf-8';
	$mailer->From = USER_MAIL_SENDER;
	$mailer->FromName = "Twick.it";
	$mailer->Subject = _loc('email.reminder.first.subject');
	$mailer->Body = $mailText;
	$mailer->AddAddress($user->getMail());
	$mailer->Send();
}


// Zweite Erinnerung
$users = User::fetchBySQL("approved=1 AND deleted=0 AND reminder<>2 AND creation_date<='" . date("Y-m-d", time()-7*24*60*60). "' AND register_language_code='" . getLanguage() . "' AND id NOT IN (SELECT distinct user_id FROM tbl_twicks WHERE creation_date>='" . date("Y-m-d", time()-4*7*24*60*60). "') AND id NOT IN (SELECT distinct user_id FROM tbl_twick_ratings WHERE creation_date>='" . date("Y-m-d", time()-4*7*24*60*60). "')");

foreach($users as $user) {
	$user->setReminder(2);
	$user->save();

    if($user->isAnonymous()) {
        continue;
    }
	
	srand((double)microtime() * 1000008);
	$rand = rand(65, 99);
	if ($rand > 90) {
		$char = $rand-90;
	} else {
		$char = chr($rand);
	}
	
	$mailText = _loc('email.reminder.second.text', array($user->getLogin(), $user->findNumberOfTwicks(), $user->findRatingPosition(), UserInfo::findNumberOfUsers(true), Twick::findNumberOfTwicks(true), $user->getUrl()));
	$mailText .= "\n-- \n";
	$mailText .= _loc('email.footer') . "\n";
	
	$mailer = new PHPMailer();
	$mailer->CharSet = 'utf-8';
	$mailer->From = USER_MAIL_SENDER;
	$mailer->FromName = "Twick.it";
	$mailer->Subject = _loc('email.reminder.second.subject');
	$mailer->Body = $mailText;
	$mailer->AddAddress($user->getMail());
	$mailer->Send();
}


//---------------------

// Profil ergänzen (14 Tage dabei, in den letzen Tagen getwickt oder bewertet und keine Profildaten)
$users = User::fetchBySQL("twitter='' AND bio='' AND location='' AND approved=1 AND deleted=0 AND system_reminder<>1 AND creation_date<='" . date("Y-m-d", time()-14*24*60*60). "' AND register_language_code='" . getLanguage() . "' AND (id IN (SELECT distinct user_id FROM tbl_twicks WHERE creation_date>='" . date("Y-m-d", time()-7*24*60*60). "') OR id IN (SELECT distinct user_id FROM tbl_twick_ratings WHERE creation_date>='" . date("Y-m-d", time()-13*24*60*60). "'))");

foreach($users as $user) {
    $user->setSystemReminder(1);
    $user->save();
    
    if($user->isAnonymous()) {
        continue;
    }

    $text = _loc('email.reminder.userdata.text', $user->getLogin()) . "<a href='" . HTTP_ROOT . "/user_data.php'>" . HTTP_ROOT . "/user_data.php</a>";

    Message::send(
        Message::TYPE_TWICKIT,
        User::TWICKIT_USER_ID,
        $user->getId(),
        _loc('email.reminder.userdata.subject'),
        $text
    );

    if($user->getEnableMessages() && !$user->getThirdpartyId()) {
        $text = str_replace("<a ", "<a style='color:#638301;' ", $text);

        $mailer = new TwickitMailer();
        $mailer->From = "message_" . getLanguage() . "@twick.it";
        $mailer->AddAddress($user->getMail());
        $mailer->Subject = _loc('email.reminder.userdata.subject');
        $mailer->setPlainMessage($text);
        $mailer->setTitle(_loc('email.reminder.userdata.subject'));
        $mailer->setHtmlMessage(nl2br($text));
        $mailer->Send();
    }
}
?>