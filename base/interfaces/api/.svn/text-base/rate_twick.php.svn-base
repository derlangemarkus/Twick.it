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
$rating = $data->rate;

if($id == "") {
    error("ID is missing.");
} else if ($rating != -1 && $rating != 1) {
    error("Rate must bei -1 oder 1");
}

$user = User::fetchByLogin($login);
if ($user && !$user->getDeleted() && $password === $user->getPassword() && !contains($login, ":")) {
    $_SESSION["userId"] = $userId;
} else {
    error("Access denied for user $login");
}


$twick = Twick::fetchById($id);
if (!$twick) {
    error("There is not Twick with ID $id");
}
if ($twick->getUserId() == $user->getId()) {
    error("User may not rate his own Twick");
}

$twick->rate($rating, $user->getId());
$twickInfo = TwickInfo::fetchById($id);

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
