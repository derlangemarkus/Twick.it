<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 

$answer = new PollAnswer();
$answer->setCreationDate(getCurrentDate());
$answer->setUserId(getUserId());
$answer->setIp($_SERVER["REMOTE_ADDR"]);

$questions = array(
    'gewinnspiel',
    'cent',
    'weltreise',
    'seo',
    'tagesschau',
    'gadgets',
    'adminrechte',
    'vorschlag',
    'stars',
    'kinder',
    'mailing',
    'text',
    'mail'
);

foreach($questions as $question) {
    $setter = "set" . ucfirst($question);
    $answer->$setter(getArrayElement($_POST, $question));
}

$answer->save();

redirect("../poll_thanks.php");
?>