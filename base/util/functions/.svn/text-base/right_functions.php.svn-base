<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
function login($inUser, $inPassword, $inSkipPassword=false) {
    $msg = "";
    if ($inUser) {
        $msg = urlencode($inUser->getAvatar() . " " . _loc('login.success', $inUser->getLogin()));
    }

    if (
        $inUser &&
        !$inUser->getDeleted() &&
        ($inSkipPassword || md5($inPassword) === $inUser->getPassword()) &&
        !contains($login, ":")
    ) {
        if ($inUser->getApproved()) {
            if ($inUser->isBlocked()) {
                $msg = 'login.blocked';
            } else {
                $_SESSION["userId"] = $inUser->getId();
                $_SESSION["relogin"] = true;
                setcookie("twickit_token", $inUser->getId() . "@" . md5($inUser->getSecret().$inUser->getPassword()), time()+60*60*24*600, "/");
                if ($inUser->getReminder()==2) {
                    $inUser->setReminder(0);
                    $inUser->save();
                }
            }
        } else {
            $msg = 'login.notApproved';
        }
    }  else {
        $msg = 'login.accessDenied';
    }

	$targetUrl = $_SESSION["login.targetPage"];
	if($targetUrl) {
		unset($_SESSION["login.targetPage"]);
	} else {
		$targetUrl = getArrayElement($_GET, "url");
	}

    $url = HTTP_ROOT . str_replace(CONTEXT_PATH, "", $targetUrl);
    $url = preg_replace("/&?msg=.*&?/", "", $url);

    if (contains($url, "?")) {
        $url .= "&";
    } else {
        $url .= "?";
    }
    $url .= "msg=$msg";

    return $url;
}


function getUserId() {
	$userId = getArrayElement($_SESSION, "userId", false);
	
	if (!$userId && getArrayElement($_GET, "msg") != "login.logout") {
		$token = getArrayElement($_COOKIE , "twickit_token", false);
		if ($token) {
			$id = substringBefore($token, "@");
			$sec = substringAfter($token, "@");
			$user = User::fetchById($id);
			if (
				$user && 
				!$user->getDeleted() && 
				$user->getApproved() && 
				(md5($user->getSecret().$user->getPassword()) == $sec || md5($user->getSecret()) == $sec)
			) {
				if (!$user->isBlocked()) {
					$_SESSION["userId"] = $id;
                    $_SESSION["relogin"] = true;
					drillDown($user->getAvatar() . " " . _loc('login.welcomeBack', $user->getLogin()));
					return $id;
				} else {
					// Zugang gesperrt! 					
					return false;
				}
			} else {
				setcookie("twickit_token", "", time(), "/");
			}
		}
	}
	
	return $userId;
}


function getUser($inReturnAnonymous=false) {
	$user = User::fetchById(getUserId());
	if($inReturnAnonymous && !$user) {
		$user = User::getAnonymous();
	}
	return $user;
}


function isLoggedIn() {
	return getUserId() !== false;
}


function checkLogin() {
	if (!isLoggedIn()) {
		rememberLoginUrl();
		redirect(HTTP_ROOT . "/access_denied.php");
		exit;
	}
}


function rememberLoginUrl($inUrl=false) {
	$_SESSION["login.targetPage"] = $inUrl ? $inUrl: $_SERVER["REQUEST_URI"];
}

function isAdmin() {
	$user = getUser();
	return $user && $user->getAdmin();
}


function checkAdmin() {
	if (!isAdmin()) {
		redirect(HTTP_ROOT . "/index.php");
		exit;
	}
}


function isBeta() {
	$user = getUser();
	return $user && ($user->getAdmin() || in_array($user->getLogin(), array("DannyFaak", "simon", "textsektor")));
}


function isGeo() {
	$user = getUser();
	return $user && ($user->getAdmin() || in_array($user->getLogin(), array("derlangemarkus", "Hortulus", "AchimRaschka")));
}


function checkCronjobLogin() {
	if(
		getArrayElement($_SERVER, "PHP_AUTH_USER") !== CRON_LOGIN || 
		getArrayElement($_SERVER, "PHP_AUTH_PW") !== CRON_PASSWORD
	) {
		$realm = "Twick.it cronjobs (" . date("Y-m-d") . ")";
		header('WWW-Authenticate: Basic realm="' . $realm . '"');
		header('HTTP/1.0 401 Unauthorized');
		echo("Please log in");
		exit;
	}
}
?>
