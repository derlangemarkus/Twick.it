<?php 
require_once("inc.php");
$title = _loc('mobile.home.title');
$canonical = "http://twick.it";

include("inc/header.php"); 

if (!isLoggedIn()) {
	redirect("index.php");
}

$user = getUser();
$replyTo = getArrayElement($_GET, "reply");
$receiverId = getArrayElement($_GET, "receiver");

if($replyTo) {
	$parent = Message::fetchById($replyTo);
	if(!$parent->maySee()) {
		$parent = false;
	}
	if($parent) {
		$subject = _loc("message.write.re") . ": " . $parent->getSubject();
		$text = "";
		
		$receiverId = $parent->getSenderId();

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
	}
}

$receiver = User::fetchById($receiverId);

$title = $receiver ? _loc('message.write.headline', $receiver->getLogin()) : _loc('message.write.title');
?>
<div class="class_content">
<h1><?php echo($title) ?></h1>
<form action="action/send_message.php" method="POST" id="your_twick">
	<?php echo(SpamBlocker::printHiddenTags()) ?>
    <?php if(!$receiver) { ?>
    <label for="receiver_name"><?php loc('message.write.receiver') ?>:</label>
    <input type="text" name="username" autocomplete="off" id="receiver-search" onfocus="this.select();" style="background-repeat:no-repeat;background-position:right;"/>
    <div id="userSearchSuggestBox" style="display:none;">
        <ul id="userSearchSuggest"></ul>
    </div>
    <?php } ?>
    <input type="hidden" name="parent_id" value="<?php echo($replyTo) ?>" />
	<input id="receiver" type="hidden" name="receiver" value="<?php echo($receiverId) ?>" />
	<label for="subject"><?php loc('message.write.subject') ?>:</label>
	<input id="subject" name="subject" type="text" value="<?php echo(htmlspecialchars($subject)) ?>" style="width:95%"/>
	<label for="textfield"><?php loc('message.write.message') ?>:</label>
	<textarea name="message" id="textfield" style="height:100px;"><?php echo(htmlspecialchars($text)) ?></textarea>
	<br /><br />
	<input type="submit" value="<?php loc('message.write.send') ?>" class="class_button class_longbutton" />
</form>
<br />
<br />
<a href="messages.php">&lt;&lt; <?php loc('message.marginal.back') ?></a>

<br style="clear:both;" />
<br />

</div> 
<?php include("inc/footer.php"); ?>
<script type="text/javascript">

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
    var search = $("receiver-search").value;
    if (search != prevUserSearch) {
        userSuggestIndex = -1;
        if (search.length > 0) {
            var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/find_user.php?type=json&size=100&limit=13&search=" + encodeURIComponent(search);
            $('receiver-search').style.backgroundImage = "url(html/img/ajax-loader.gif)";

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
                                suggestText += "<li>...</li>";
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
                    $('receiver-search').style.backgroundImage = "none";
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

}</script>
</body>
</html>