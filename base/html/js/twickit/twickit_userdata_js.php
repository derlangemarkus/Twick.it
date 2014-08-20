<?php 
header('Content-Type: text/javascript');
require_once("../../../util/inc.php"); 
?>
function comparePasswords() {
	$('checkPassword2').update("");
	userDataValidationPassword2 = true;
	if (document.userForm.password.value != document.userForm.password2.value) {
		$('checkPassword2').update("<span class='check_error'><?php loc('userdata.error.password.repeat') ?></span>");
		userDataValidationPassword2 = false;
	}
	checkUserData();
}


function checkPassword() {
	if (!skipPasswordTest) {
		$('checkPassword').update("");
		userDataValidationPassword = true;
		if (document.userForm.password.value == "") {
			$('checkPassword').update("<span class='check_error'><?php loc('userdata.error.password.empty') ?></span>");
			userDataValidationPassword = false;
		}
	}
	comparePasswords();
}


function checkMail() {
	$('checkMail').update("");
	userDataValidationMail = true;
	if (document.userForm.mail.value == "" || !document.userForm.mail.value.match(/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i)) {
		$('checkMail').update("<span class='check_error'><?php loc('userdata.error.email.invalidOrEmpty') ?></span>");
		userDataValidationMail = false;
	}
	checkUserData();
}


function checkAgb() {
	$('checkAgb').update("");
	userDataValidationAgb = true;
	if (!document.userForm.agb.checked) {
		$('checkAgb').update("<span class='check_error'><?php loc('userdata.error.terms.accept') ?></span>");
		userDataValidationAgb = false;
	}
	checkUserData();
}


var checkLoginTimeouts;
function checkLogin() {
	if(checkLoginTimeouts != null) {
		clearTimeout(checkLoginTimeouts); 
		checkLoginTimeouts=window.setTimeout("_checkLogin()", 300);
	} else {
		checkLoginTimeouts=window.setTimeout("_checkLogin()", 0);
	}
}

function _checkLogin() {
	var search = document.userForm.login.value;
	if (login != null && login==search) {
		$('checkLogin').update("<span class='check_ok'><?php loc('userdata.error.login.ok') ?></span>");
    	userDataValidationLogin = true;
    	checkUserData();
    	return;
	}
	$('checkLogin').update("<img src='html/img/ajax-loader.gif' alt='' style='vertical-align: middle;'/> <?php loc('userdata.error.login.testing') ?>");
	
	if (search.length > 0) {
		if (!search.match(/^[a-zA-Z_\d]+$/g)) {
			$('checkLogin').update("<span class='check_error'><?php loc('userdata.error.login.invalidChars') ?></span>");
			userDataValidationLogin = false;
		} else { 
			var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/find_user.json&limit=1&exact=1&search=" + search;
			new Ajax.Request(url, {
				method: 'get',
				asynchronous: false,
			  	onSuccess: function(transport) {
			    	var suggests = transport.responseText.evalJSON(true);
			    	if (suggests.users.length > 0) {
			    		$('checkLogin').update("<span class='check_error'><?php loc('userdata.error.login.taken') ?></span>");
			    		userDataValidationLogin = false;
			    		checkUserData();
			    	} else {
			    		$('checkLogin').update("<span class='check_ok'><?php loc('userdata.error.login.ok') ?></span>");
			    		userDataValidationLogin = true;
			    		checkUserData();
			    	}
			  	}	
			});
		}
	}  else {
		$('checkLogin').update("<span class='check_error'><?php loc('userdata.error.login.empty') ?></span>");
		userDataValidationLogin = false;
	}
	checkUserData();		
}


var skipPasswordTest = false;
var userDataValidationLogin = false;
var userDataValidationPassword = false;
var userDataValidationPassword2 = false;
var userDataValidationMail = false;
var userDataValidationAgb = false;
var login = null;
function checkUserData() {
	var ok = userDataValidationLogin && userDataValidationPassword2 && userDataValidationPassword && userDataValidationMail && userDataValidationAgb;
	changeSaveButtonState(ok);
}


function changeSaveButtonState(inOn) {
	if(inOn) {
		$('createLink').className = "";
		$('createLink').onclick = function() { $("twickit-blase").submit(); };
	} else {
		$('createLink').className = "disabled";
		$('createLink').onclick = function() { doPopup('<?php loc('userdata.error.popup') ?>') };
	}
}
