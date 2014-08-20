<?php
/*
 * Created at 09.08.2010
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php");
ini_set("display_errors", 1);

function error($inMessage) {
    ob_end_clean();
    header('HTTP/1.0 400 Bad Request');
    $output = array("error"=>$inMessage);
    die(json_encode($output));
}

ob_start();

if (
    getArrayElement($_SERVER, "HTTP_CLIENT") != "Twick.it-Search/1.0" ||
    getArrayElement($_SERVER, "HTTP_APIKEY") != "Jooce"
) {
    error("Access Denied");
}

$json = @file_get_contents('php://input');
if ($json === null) {
    error("Invalid JSON");
}

$login = getArrayElement($_SERVER, "HTTP_LOGIN");
$password = getArrayElement($_SERVER, "HTTP_PASSWORD");


$data = json_decode($json);
$id = $data->id;
$title = trim($data->title);
$accronym = trim($data->accronym);
$text = trim($data->text);
$link = trim($data->link);

if($title == "" && $id == "") {
    error("Title resp. ID is missing.");
} else if($text == "") {
    error("Text is missing.");
} 

if (strtolower($title) == strtolower($acronym)) {
	$acronym = "";
}

if(mb_strlen($text, "utf8") > 140) {
	error ("Text must not be longer than 140 characters, but is " . mb_strlen($text, "utf8") . " long.");
}

$title = htmlspecialchars($title);
$acronym = htmlspecialchars($acronym);
$text = htmlspecialchars($text);
$link = htmlspecialchars($link);


$user = User::fetchByLogin($login);
if ($user && !$user->getDeleted() && $password === $user->getPassword() && !contains($login, ":")) {
    $_SESSION["userId"] = $userId;
} else {
    error("Access denied for user $login");
}


if ($id) {
    $twick = Twick::fetchById($id);
    $twickInfo = TwickInfo::fetchById($id);
    if ($twickInfo->isEditable()) {
        $twick->setAcronym($acronym);
        $twick->setText($text);
        $twick->setLink($link);
        $twick->save();
        $topic = $twick->findTopic();
    } else {
        error("Cannot modify Twick. It is not editable any longer.");
    }

} else {
    $topic = array_pop(Topic::fetchByTitle($title));
    if (!$topic) {
        $topic = new Topic();
        $topic->setTitle($title);
        $topic->updateStemming();
        $topic->updateCoreTitle();
        $topic->setLanguageCode(getLanguage());
        $topic->setCreationDate(getCurrentDate());
        $topic->setUrlId($topic->createUrlId());
        $topic->save();
    }

    if (sizeof(Twick::fetchByTextAndTopicId($text, $topic->getId()))) {
        error("Twick already exists.");
    } else {
        $twick = new Twick();
        $twick->setTopicId($topic->getId());
        $twick->setAcronym($acronym);
        $twick->setText($text);
        $twick->setLink($link);
        $twick->setCreationDate(getCurrentDate());
        $twick->setUserId($user->getId());
		$twick->setInputSource(getArrayElement($_SERVER, "HTTP_CLIENT"));
        if ($user->getReminder()==2) {
            $user->setReminder(0);
            $user->save();
        }
        $twick->save();
    }
}

$twickInfo = $twick->findTwickInfo();

ob_end_clean();

header("Content-Type: application/json; charset=utf-8");
?>
{
    "topic" : {
        "id" : "<?php jecho($topic->getId()) ?>",
        "title" : "<?php jecho($topic->getTitle()) ?>",
        "url" : "<?php jecho($topic->getUrl()) ?>",
        "geo" : {
            "latitude" : "<?php jecho($topic->getLatitude()) ?>",
            "longitude" : "<?php jecho($topic->getLongitude()) ?>"
        },
        "tags" : [
        <?php
            $separator = "";
            foreach($topic->getTags() as $tag=>$count) {
                if(trim($tag) != "") {
                    jecho($separator);
            ?>
                {
                    "tag" : "<?php jecho($tag) ?>",
                    "count" : <?php jecho($count) ?>
                }
            <?php
                    $separator = ", ";
                }
            }
        ?>
        ],
        "twick" : {
            "id" : <?php jecho($twick->getId()) ?>,
            "acronym" : "<?php jecho($twick->getAcronym()) ?>",
            "text" : "<?php jecho($twick->getText()) ?>",
            "link" : "<?php jecho($twick->getLink()) ?>",
            "url" : "<?php jecho($twick->getUrl()) ?>",
            "standalone_url" : "<?php jecho($twick->getStandaloneUrl) ?>",
            "creation_date" : "<?php jecho($twick->getCreationDate()) ?>",
            "rating" : {
                "count" : <?php jecho($twickInfo->getRatingCount()) ?>,
                "sum" : <?php jecho($twickInfo->getRating()) ?>,
                "ratio" : <?php jecho($twickInfo->getRatingRatio()) ?>
            },
            "user" : {
                "gravatar" : "<?php jecho($user->getAvatarUrl()) ?>",
                "name" : "<?php jecho($user->getDisplayName()) ?>",
                "username" : "<?php jecho($user->getLogin()) ?>",
                "url" : "<?php jecho($user->getUrl()) ?>"
            }
        }
    }
}
