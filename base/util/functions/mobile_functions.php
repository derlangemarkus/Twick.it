<?php
function setMobileCookie($inIsMobile) {
	if (!headers_sent()) {
		setcookie("mobile", $inIsMobile ? 1 : 0, time()+60*60*24*365, "/", ".twick.it");
	}
}


function isMobileBrowser() {
    if (getArrayElement($_COOKIE, "mobile", 1) == 0 || getArrayElement($_GET, "nomobile")) {
        return false;
    }
    if (getArrayElement($_COOKIE, "mobile") && !getArrayElement($_GET, "nomobile")) {
        return true;
    }
	if (contains(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows')) {
		return false;
	}
	if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|android|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		return true;
	}
	if(contains(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') or isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])) {
		return true;
	}
	$mobile_agents = array(
		'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
		'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		'wapr','webc','winw','winw','xda','xda-');
	if(in_array(strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4)) ,$mobile_agents)) {
		return true;
	}
	if (contains(strtolower($_SERVER['ALL_HTTP']), 'operamini')) {
		return true;
	}
	return false;
}


function redirectMobile($inMobileUrl) {
    if(isMobileBrowser()) {
        if (contains($inMobileUrl, "?")) {
            $mobileUrl = $inMobileUrl . "&msg=mobile.switchMessage";
        } else {
            $mobileUrl = $inMobileUrl . "?msg=mobile.switchMessage";
        }
        redirect($mobileUrl);
    }
}
?>
