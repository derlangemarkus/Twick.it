<?php
// "RE: RE: RE: foobar" zusammenfassen zu "RE^3: foobar"
$re = _loc("message.write.re") . ": ";
if(startsWith($subject, $re)) {
	if(preg_match('/^' . $re . _loc("message.write.re") . '\^(\d+): (.*)$/', $subject, $matches)) {
		$subject = str_repeat($re, $matches[1]+1) . $matches[2];
	}

	$counter = 0;
	while(startsWith($subject, $re)) {
		$counter++;
		$subject = substringAfter($subject, $re);
	}

	if($counter == 1) {
		$subject = $re . $subject;
	} else {
		$subject = _loc("message.write.re") . "^" . $counter . ": " . $subject;
	}
}
?>
<br />
<div class="sprechblase">
	<div class="sprechblase-main">
		<div class="sprechblase-links">
			<i>&nbsp;</i>
			<div class="bilderrahmen"><a href="<?php echo($user->getUrl()) ?>" title="<?php echo htmlspecialchars($user->getDisplayName()) ?>"><?php echo($user->getAvatar(64)) ?></a></div>
			<i><?php echo htmlspecialchars($user->getDisplayName()) ?></i>
		</div>
		<div class="sprechblase-rechts">
			<div class="blase-header" id="eingabeblase-head">&nbsp;</div>
			<div class="blase-body">
				<form class="eingabeblase" id="message-blase" action="action/send_user_message.php" method="post" name="userSearchForm">
					<?php echo(SpamBlocker::printHiddenTags()) ?>
					<input type="hidden" name="parent_id" value="<?php echo($replyTo) ?>" />
                    <input id="receiver" type="hidden" name="receiver" value="<?php echo($receiverId) ?>" />
                    <?php if(!$receiverId) { ?>
                    <label for="receiver_name"><?php loc('message.write.receiver') ?>:</label>
					<input type="text" name="username" autocomplete="off" id="receiver-search" onfocus="this.select();"/>
                    <img src="html/img/ajax-loader.gif" alt="..." style="display:none;" id="loader"/><br />
                    <div id="userSearchSuggestBox" style="display:none;width:307px;">
                        <ul id="userSearchSuggest"></ul>
                    </div>
                    <?php } ?>
					<label for="subject"><?php loc('message.write.subject') ?>:</label>
					<input id="subject" name="subject" type="text" value="<?php echo(htmlspecialchars($subject)) ?>"/>
					<label for="textfield"><?php loc('message.write.message') ?>:</label>
					<textarea name="message" id="textfield" style="height:210px;" onkeyup="checkUserMessageLength()" onkeypress="checkUserMessageLength()"><?php echo(htmlspecialchars($text)) ?></textarea>
				</form>    
			</div>
			<div class="blase-footer" id="eingabeblase-footer">
				<a href="javascript:;" id="sendButton" class="twickitpreview-off"><?php loc('message.write.send') ?></a>
			</div>
		</div>
		<div class="clearbox">&nbsp;</div>
	</div>
</div>
<script type="text/javascript">
function checkUserMessageLength() {
	if($("textfield").value.length > 0 && $("receiver").value != "") {
		var button = $("sendButton");
		button.className = "twickitpreview";
		button.onclick = function() { $('message-blase').submit(); };
	} else {
		var button = $("sendButton");
		button.className = "twickitpreview-off";
		button.onclick = null;
	}
}

<?php if($receiverId) { ?>
if($("subject").value == "") {
	$("subject").focus();
} 
<?php } else { ?>
$("receiver-search").focus();

var suggestUserTimeouts;
var prevUserSearch;
var userSuggestRequest = null;
var userSuggestIndex = -1;
var userSuggestLength = -1;
var userSuggestIds = new Array();

$("receiver-search").onkeyup = userSearchUpDown;

function updateUserSuggest() {
    if(suggestUserTimeouts != null) {
        clearTimeout(suggestUserTimeouts);
        suggestUserTimeouts=window.setTimeout("_updateUserSuggest()", 250);
    } else {
        suggestUserTimeouts=window.setTimeout("_updateUserSuggest()", 0);
    }
}


function _updateUserSuggest() {
    var search = document.userSearchForm.username.value;
    if (search != prevUserSearch) {
        userSuggestIndex = -1;
        if (search.length > 0) {
            var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/find_user.php?type=json&size=100&limit=13&search=" + encodeURIComponent(search);
            $("loader").style.display='inline';

            if (userSuggestRequest != null) {
                userSuggestRequest.abort();
            }
            userSuggestRequest = new Ajax.Request(url, {
                method: 'get',
                onSuccess: function(transport) {
                    var suggests = transport.responseText.evalJSON(true);
                    userSuggestLength = suggests.users.length;
                    var query = suggests.query.toQueryParams().search;

                    if (suggests.users.length == 0) {
                        $('userSearchSuggest').update("<i><?php loc('users.search.noUserFound') ?></i>");
                        $('userSearchSuggestBox').fade({duration: 3});
                    } else {
                        var suggestText = "";
                        for (var i=0; i<suggests.users.length; i++) {
                            if(i>=12) {
                                suggestText += "<li style='color:#FFFFFF;'>...</li>";
                                break;
                            } else {
                                var title = suggests.users[i].display_name;
                                userSuggestIds[i] = suggests.users[i].id;
                                var regex = eval("/(" + query + ")/gi");
                                title = title.replace(regex, "<span>$1</span>");

                                suggestText += "<li><a href='javascript:;' onclick='addReceiver(" + suggests.users[i].id + ", \"" + suggests.users[i].display_name + "\")' id='userSearchSuggest" + i + "'>" + title + "</a></li>";
                            }
                        }
                        $('userSearchSuggest').update(suggestText);
                        $('userSearchSuggestBox').show();
                    }
                    $("loader").style.display='none';
                }
            });
        } else {
            $('userSearchSuggestBox').hide();
        }
        prevUserSearch = search;
    }
}

function userSearchUpDown(inEvent) {
    var code; //variable to save keystroke
    if (!inEvent) var inEvent = window.event;
    if (inEvent.keyCode) code = inEvent.keyCode;

    if (code == 38) {
        if (userSuggestIndex > 0) {
            updateUserSuggestIndex(false);
            userSuggestIndex--;
            title = $("userSearchSuggest" + userSuggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
            $("receiver").value = userSuggestIds[userSuggestIndex];
            $("receiver-search").value = title.replace(/ \(.+\)/g, "");
            prevUserSearch = title;
        }
    } else if (code == 40) {
        if (userSuggestIndex < userSuggestLength-1) {
            updateUserSuggestIndex(true);
            userSuggestIndex++;
            title = $("userSearchSuggest" + userSuggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
            $("receiver").value = userSuggestIds[userSuggestIndex];
            $("receiver-search").value = title.replace(/ \(.+\)/g, "");
            prevUserSearch = title;
        }
    } else if (code == 13) {  // Return
        $('userSearchSuggestBox').hide();
    } else if (code == 27) {  // ESC
        addReceiver("", "");
    } else {
        updateUserSuggest();
    }
}

function updateUserSuggestIndex(inDown) {
    var nextIndex = inDown ? userSuggestIndex+1 : userSuggestIndex-1;
    if (userSuggestIndex >= 0) {
        $("userSearchSuggest" + userSuggestIndex).style.fontWeight="normal";
        $("userSearchSuggest" + userSuggestIndex).style.fontSize="12px";
    }
    $("userSearchSuggest" + nextIndex).style.fontWeight="bold";
    $("userSearchSuggest" + nextIndex).style.fontSize="14px";
}


function addReceiver(inId, inName) {
    if($('userSearchSuggestBox') != null) {
        $('userSearchSuggestBox').hide();
    }

    $("receiver").value = inId;
    $("receiver-search").value = inName;

    checkUserMessageLength();
}
<?php } ?>
</script>
