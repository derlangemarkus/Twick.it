<?php
if(getUserId() != $user->getId()) {
    redirect($user->getUrl());
    exit;
}
?>
<style type="text/css">
form.alerts label {
    margin-top:0px;
    font-weight:normal;
    color:#666;
    width:300px;
}

form.alerts table tr td {
    padding-top:14px;
}

#user-search {
    width:285px!important;
}

#user-search.searchOn {
    background-image: url(html/img/ajax-loader.gif);
    background-position: 266px 2px;
    background-repeat: no-repeat;
}


div#userSearchSuggestBox {
    width:267px!important;
    position: absolute;
}

div#selected div {
    width:285px;
    color:#333;
    font-weight: bold;
    padding:2px;
    float:left;
    padding:5px;
}
div#selected div:hover {
    background-color: #EFEFEF;
}

div#selected a {
    color:#ccc;
    font-style: italic;
    float:right;
}
div#selected a:hover {
    color:#000;
    font-weight: bold;
}


div#selected div.rahmen {
    float:left;
    background-color:#FFF;
    background-image:none;
    width:20px;
    height:20px;
    padding:1px;
    border:1px solid #333;
    -moz-border-radius:0px;
    -webkit-border-radius:0px;
}
</style>

<!-- EINGABE-Sprechblase | START -->
<div class="sprechblase">
    <br />
    <div class="sprechblase-main">
        <div class="sprechblase-links"><i>&nbsp;</i>
            <div class="bilderrahmen"><a href="<?php echo($user->getUrl()) ?>"><?php echo($user->getAvatar(64)) ?></a></div>
        </div>
        <div class="sprechblase-rechts">
        <div class="blase-header" id="eingabeblase-head"></div>
            <div class="blase-body">
                <form class="alerts eingabeblase" action="action/save_alerts.php" name="userSearchForm" method="post" id="twickit-blase" style="width:320px;">
                    <input type="hidden" name="secret" value="<?php echo($user->getSecret()) ?>" />
                    <b><?php loc('alerts.description') ?></b><br />
                    <br />
                    <?php loc('alerts.alert') ?><br />

                    <table border="0">
						<tr>
                            <td valign="top"><input type="checkbox" class="checkbox" id="<?php echo(Notificator::NOTIFICATION_WALL_POST) ?>" name="<?php echo(Notificator::NOTIFICATION_WALL_POST) ?>" <?php if($user->hasAlert(Notificator::NOTIFICATION_WALL_POST)) { ?>checked="checked"<?php } ?>/></td>
                            <td valign="top"><label for="<?php echo(Notificator::NOTIFICATION_WALL_POST) ?>"><?php loc('alerts.alert.wallPost') ?></label></td>
                        </tr>
                        <tr>
                            <td valign="top"><input type="checkbox" class="checkbox" id="<?php echo(Notificator::NOTIFICATION_SAME_TOPIC) ?>" name="<?php echo(Notificator::NOTIFICATION_SAME_TOPIC) ?>" <?php if($user->hasAlert(Notificator::NOTIFICATION_SAME_TOPIC)) { ?>checked="checked"<?php } ?>/></td>
                            <td valign="top"><label for="<?php echo(Notificator::NOTIFICATION_SAME_TOPIC) ?>"><?php loc('alerts.alert.sameTopic') ?></label></td>
                        </tr>
						<!--
                        <tr>
                            <td valign="top"><input type="checkbox" class="checkbox" id="<?php echo(Notificator::NOTIFICATION_TWICK_POSITION_CHANGED) ?>" name="<?php echo(Notificator::NOTIFICATION_TWICK_POSITION_CHANGED) ?>" <?php if($user->hasAlert(Notificator::NOTIFICATION_TWICK_POSITION_CHANGED)) { ?>checked="checked"<?php } ?>/></td>
                            <td><label for="<?php echo(Notificator::NOTIFICATION_TWICK_POSITION_CHANGED) ?>">TODO: <?php loc('alerts.alert.twickPositionChanged') ?></label></td>
                        </tr>
						-->
                        <tr>
                            <td valign="top"><input type="checkbox" class="checkbox" id="<?php echo(Notificator::NOTIFICATION_RATE_TWICK) ?>" name="<?php echo(Notificator::NOTIFICATION_RATE_TWICK) ?>" <?php if($user->hasAlert(Notificator::NOTIFICATION_RATE_TWICK)) { ?>checked="checked"<?php } ?>/></td>
                            <td><label for="<?php echo(Notificator::NOTIFICATION_RATE_TWICK) ?>"><?php loc('alerts.alert.rateTwick') ?></label></td>
                        </tr>
						<!--
                        <tr>
                            <td valign="top"><input type="checkbox" class="checkbox" id="<?php echo(Notificator::NOTIFICATION_USER_RANKING_CHANGED) ?>" name="<?php echo(Notificator::NOTIFICATION_USER_RANKING_CHANGED) ?>" <?php if($user->hasAlert(Notificator::NOTIFICATION_USER_RANKING_CHANGED)) { ?>checked="checked"<?php } ?>/></td>
                            <td><label for="<?php echo(Notificator::NOTIFICATION_USER_RANKING_CHANGED) ?>">TODO: <?php loc('alerts.alert.userRankingChanged') ?></label></td>
                        </tr>
						-->
                        <tr>
                            <td valign="top"><input type="checkbox" class="checkbox" disabled checked/></td>
                            <td>
                                <label><?php loc('alerts.alert.user') ?></label>
                                <div id="selected"></div>
                                <br style="clear:both;"/>
                                <?php loc('alerts.alert.add') ?>:<br />
                                <input type="text" name="username" autocomplete="off" id="user-search" onfocus="this.select();"/><br />
                                <div id="userSearchSuggestBox" style="display:none;">
                                    <ul id="userSearchSuggest"></ul>
                                </div>

                                <input type="hidden" name="users" id="users" />
                            </td>
                        </tr>
                    </table>
                    <br />
                    <a href="javascript:;" onclick="$('twickit-blase').submit();" id="createLink"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('userdata.save') ?></a>
                </form>
            </div>
            <div class="blase-footer" id="eingabeblase-footer"></div>
        </div>
        <div class="clearbox">&nbsp;</div>
    </div>
</div>
<!-- EINGABE-Sprechblase | ENDE -->


<script type="text/javascript">
var suggestUserTimeouts;
var prevUserSearch;
var userSuggestRequest = null;
var userSuggestIndex = -1;
var userSuggestLength = -1;
var userNames = new Array();

$("user-search").onkeyup = userSearchUpDown;

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
            var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/find_user.php?type=json&size=20&limit=13&search=" + encodeURIComponent(search);
            $("user-search").className = "searchOn";

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
                                var regex = eval("/(" + query + ")/gi");
                                title = title.replace(regex, "<span>$1</span>");

                                suggestText += "<li><a href='javascript:;' onclick='addUser(" + suggests.users[i].id + ", \"" + suggests.users[i].display_name + "\", \"" + suggests.users[i].avatar + "\")' id='userSearchSuggest" + i + "'>" + title + "</a></li>";
                            }
                        }
                        $('userSearchSuggest').update(suggestText);
                        $('userSearchSuggestBox').show();
                    }
                    $("user-search").className = "";
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
            $("user-search").value = title.replace(/ \(.+\)/g, "");
            prevUserSearch = title;
        }
    } else if (code == 40) {
        if (userSuggestIndex < userSuggestLength-1) {
            updateUserSuggestIndex(true);
            userSuggestIndex++;
            title = $("userSearchSuggest" + userSuggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
            $("user-search").value = title.replace(/ \(.+\)/g, "");
            prevUserSearch = title;
        }
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


function addUser(inId, inName, inGravatar) {
    if($('userSearchSuggestBox') != null) {
        $('userSearchSuggestBox').hide();
    }

    if (userNames[inId] != null) {
        alert("Der Spieler ist bereits Teil des Kartenspiels.");
        return;
    }

    if ($("users").value!="") {
        $("users").value += ",";
    }
    $("users").value += inId
    userNames[inId] = inName;

    var newEntry = "<div id='user_" + inId + "'><div class='rahmen'><img src='" + inGravatar + "' width='20' style='vertical-align:top;'/></div>&nbsp;" + inName + "<a href='javascript:;' onclick='removeUser(" + inId + ")'>[<?php loc('alerts.alert.remove') ?>]</a></div>";

    $("selected").update($("selected").innerHTML + newEntry);
    $("user-search").value = "";
}



function removeUser(inId) {
    if(confirm("<?php loc('core.areYouSure') ?>")) {
        $("user_" + inId).remove();

        var users = "";
        var separator = "";
        $("users").value.scan(
            /\d+/,
            function(match) {
                if(match[0] != inId) {
                    users += separator + match[0];
                    separator = ",";
                }
            }
        );

        $("users").value = users;
        userNames[inId] = null;
    }
}

<?php foreach(UserAlert::findAuthorsByUserId($user->getId()) as $author) { ?>
addUser(<?php echo($author->getId()) ?>, "<?php echo htmlspecialchars($author->getDisplayName(20)) ?>", "<?php echo($author->getAvatarUrl(20)) ?>");
<?php } ?>
</script>