<?php
require_once("../../util/inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <base href="http://twick.it/" />
        <title>Supertrump! Ein Spiel von Twick.it - Die Erklärmaschine im Netz</title>
        <meta name="description" content="Supertrump! Ein Spiel von Twick.it - Die Erklärmaschine im Netz" />
        <meta name="keywords" content="Erklärung, Lexikon, Supertrumpf, Spiel, Kartenspiel" />
        <meta name="language" content="de" />

        <meta name="robots" content="index,follow" />
        <meta name="revisit-after" content="1 days" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="interfaces/browser_plugins/twickit-search.xml" />

        <link href="html/css/twick-styles.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="http://static.twick.it/html/js/scriptaculous/lib/prototype.js"></script>
        <script type="text/javascript" src="http://static.twick.it/html/js/scriptaculous/src/scriptaculous.js?load=effects,dragdrop"></script>
        <script type="text/javascript" src="html/js/twickit/twickit_twick_js.php"></script>
		<script type="text/javascript" src="http://twick.it/interfaces/js/popup/twickit.js"></script>
        <!--[if IE]>
        <script type="text/javascript" src="http://static.twick.it/html/js/png.js"></script>
		<![endif]-->
		<style type="text/css">
            fieldset {
                border:none;background-color:#FFF;padding:10px;margin-bottom:20px;
            }
            legend {
                font-weight: bold;
                font-size: 16px;
            }
            #game, #intro {
                margin:20px;
                background-color: #FFF;
                position:relative;
            }
            #kasten_links {
                display:block;
                float:left;
                width:595px;
                padding:10px;
                margin:0px;
            }
            #kasten_rechts {
                display:block;
                float:left;
                width:230px;
                padding:30px 0px 30px 30px;
                margin:0px;
            }
            #gravatar {
                position: absolute;
                margin-left: -154px;
                margin-top: 47px;
                width:110px;
            }
            *+html #gravatar {
                margin-left: -157px;
            }
            * html #gravatar {
                margin-left: -157px;
            }
            div#selected div {
                width:120px;
                border:1px solid #333;
                margin-bottom:4px;
                background-image: url("html/img/toten-popup.png");
                background-repeat: repeat;
                color:#FFF;
                font-weight: bold;
                padding:2px;
				cursor:move;
				float:left;
				padding:5px;
				margin:3px;
				height:60px;
                -moz-border-radius:8px;
                -webkit-border-radius:8px;
                -moz-box-shadow:0 0 15px #666;
                -webkit-box-shadow:0 0 15px #666;
            }
            div#selected a {
                color:#FFF;
                font-weight: bold;
            }
			.subfield {
				border:1px solid #ccc;
				background-color:#FAFAFA;
			}
			.subfield legend {
				font-size:12px;
			}
			div#userSearchSuggestBox {
				position:absolute;
				z-index:9999;
			}
            #intro p {
                font-size:15px;
                margin-bottom: 20px;
            }
            #intro h2 {
                font-size:15px;
            }
			div#selected div.rahmen {
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
    </head>
    <body>
        <div class="website">

            <div class="main" id="main">
                <!-- Header | START -->
                <!-- Login-Bereich | START -->
                <div class="header-login">
                    <div class="anmelde-status">Eine Spielerei von <a href="http://twick.it">Twick.it, der Erklärmaschine</a></div>
                </div>
                <!-- Login-Bereich | ENDE -->

                <!-- Suchfeld oder Wissensbaum | START -->
                <div class="header-suchfeld" id="header-suchfeld" style="height:80px;background-position: 740px 20px;">
                    <div class="suchnavigation">
                        <br />
                        <div class="clearbox"></div>
                    </div>
                </div>
                <!-- Suchfeld oder Wissensbaum | ENDE -->

                <!-- Header | ENDE -->

                <div id="contentFrame">
                    <div class="header-ergebnisfeld" id="header-ergebnisfeld">
                        <h1>Mit Twick.it-Supertrumph wirst DU zum Joker!</h1>
                    </div>

                    <!-- Content-Bereich | START -->
                    <div class="content">

                        <!-- Linke Haelfte | START -->
                        <div class="inhalte-links" style="width:920px;background-color:#EFEFEF;">
                            <div id="intro" style="padding:20px;">
                                <img src="playground/supertrumpf/front_card.jpg" width="200" height="300" alt="Supertrumpf" style="float:right;margin-left: 20px;"/>
                                <h2>Erinnerst du dich noch?</h2>
                                <p>
                                    Wir haben Karten mit Rennautos, Schiffen oder LKW gegen einander antreten lassen.
                                    Wer hat den längsten, die meisten PS oder die höchste Geschwindigkeit? Der Gewinner einer jeden Runde
                                    bekam die Karten der Mitspieler und durfte die Daten einer neuen Karte vorlesen.
                                </p>
                                <h2>Wer hat an der Uhr gedreht?</h2>
                                <p>
                                    Wir holen dieses Gefühl aus den Kindheitstagen zurück. Doch anstatt Boliden treten nun Twick.it-Nutzer
                                    gegeneinander an. Jeder registrierte User kann Teil des Kartenspiels werden. Wer hat am meisten
                                    Twicks geschrieben, ist am längsten dabei oder konnte die besten Bewertungen abstauben?
                                </p>
                                <h2>Los geht's. Erstelle dein Kartenspiel!</h2>
                                <p>
                                    Suche einfach einige Benutzer aus oder lasse die Karten mit zufällig ausgewählten Usern füllen.
                                    Wir erstellen ein PDF mit den Karten, das du ausdrucken kannst.
                                    Bist du bereit?
                                </p>
                                <div class="haupt-buttonfeld" style="width:500px">
                                    <a href="javascript:;" onclick="$('intro').blindUp();$('game').show()" style="margin-left:250px;">Los geht's</a>
                                </div>
                            </div>
                            <div id="game" style="display:none;">
                                <div id="kasten_links">
                                    <form action="playground/supertrumpf/generate.php" name="options">
                                        <input type="hidden" name="cards" value="32" />
                                        <input type="hidden" name="users" id="users"/>
                                    </form>

                                    <form action="#" name="userSearchForm" id="userSearchForm" onsubmit="return false;">
                                        <fieldset>
                                            <legend>Schritt 1: Nutzer für Karten auswählen</legend>
                                            Ein Kartenspiel besteht aus 32 Karten. Du kannst beliebig viele Twick.it-User wählen. <br />
                                            Freie Karten werden dann durch zufällig ausgewählte Nutzer gefüllt.<br />
                                            <br />
                                            <br />
                                            <fieldset class="subfield">
                                                <legend>Welcher Benutzer soll Teil des Kartenspiels werden?</legend>

                                                <input type="text" name="username" autocomplete="off" id="user-search" onfocus="this.select();"/>
                                                <img src="html/img/ajax-loader.gif" alt="..." style="display:none;" id="loader"/><br />
                                                <div id="userSearchSuggestBox" style="display:none;">
                                                    <ul id="userSearchSuggest"></ul>
                                                </div>
                                            </fieldset>
                                            <br />
                                            <fieldset class="subfield">
                                                <legend>Folgende Benutzer sind schon Teils des Kartenspiels:</legend>
                                                <div id="selected"></div>
                                            </fieldset>
                                        </fieldset>

                                        <fieldset>
                                            <legend>Schritt 2: Kartenspiel generieren</legend>
                                            Es wird ein PDF erzeugt, das die Spielkarten beinhaltet. Bitte habe ein wenig Geduld. Die Generierung kann ein wenig länger dauern...
                                            <div class="haupt-buttonfeld" style="width:500px">
                                                <a href="javascript:;" onclick="generate()" style="margin-left:250px;">Kartenspiel erzeugen</a>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div id="kasten_rechts">
                                    <img id="card" src="playground/supertrumpf/front_card.jpg" width="200" height="300" alt="Supertrumpf"/>
                                    <img style="display:none;" id="gravatar" src="http://www.gravatar.com/avatar/c437dd814266449417f7c3a0560de037?s=110&d=http%3A%2F%2Ftwick.it%2Futil%2Fthirdparty%2FphpThumb%2FphpThumb.php%3Fw%3D208%26h%3D208%26far%3D1%26src%3Dhttp%253A%252F%252Fa3.twimg.com%252Fprofile_images%252F617827442%252FtwitterProfilePhoto.jpg%26err%3Dhttp%253A%252F%252Fstatic.twick.it%252Fhtml%252Fimg%252Favatar%252F208.jpg" />
                                </div>

                                <br style="clear:both;"/>
                                <br />
                            </div>
                        </div>
                        <!-- Linke Haelfte | ENDE -->


                        <div class="clearbox"></div>
                    </div>
                    <!-- Content-Bereich | ENDE -->
                </div>

                <?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

    <script type="text/javascript">
    var suggestUserTimeouts;
    var prevUserSearch;
    var userSuggestRequest = null;
    var userSuggestIndex = -1;
    var userSuggestLength = -1;
    var userNames = new Array();
    var userAvatars = new Array();

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
                                    var regex = eval("/(" + query + ")/gi");
                                    title = title.replace(regex, "<span>$1</span>");

                                    suggestText += "<li><a href='javascript:;' onclick='addUser(" + suggests.users[i].id + ", \"" + suggests.users[i].display_name + "\", \"" + suggests.users[i].avatar + "\")' id='userSearchSuggest" + i + "'>" + title + "</a></li>";
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

		if(isFull()) {
            return;
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
        userAvatars[inId] = inGravatar;

        var newEntry = "<div id='user_" + inId + "' onmouseover='showUser(" + inId + ")'><div class='rahmen'><img src='" + inGravatar + "' width='20' style='vertical-align:top;'/></div>&nbsp;" + inName + "<a href='javascript:;' onclick='removeUser(" + inId + ")'><i>[löschen]</i></a></div>";

        $("selected").update($("selected").innerHTML + newEntry);
        $("user-search").value = "";

        $("card").src="playground/supertrumpf/card.jpg";
        showUser(inId);

        Sortable.create(
            "selected",
            {
                tag:'div',
				constraint:'',
                dropOnEmpty:true,
                onUpdate:
                    function() {
                        $("users").value = getIds();
                    }
            }
        );

		isFull();
    }

	
	function isFull() {
		if($$("div#selected div").length == 64) {
			alert("Alle Karten des Spiels sind nun belegt. Du kannst das Spiel jetzt erzeugen.");
            return true;
		} else {
			return false;
		}
	}

    function getIds() {
        var ids = Sortable.serialize("selected").replace(/&selected\[\]=/g, ",");
        ids = ids.replace("selected[]=", "");
        return ids;
    }


    function removeUser(inId) {
		if(confirm("Bist du sicher?")) {
			$("user_" + inId).remove();
			$("users").value = getIds();

			userNames[inId] = null;
			userAvatars[inId] = null;

			$("card").src="playground/supertrumpf/front_card.jpg";
			$("gravatar").hide();
		}
    }

    function showUser(inId) {
        $("gravatar").src=userAvatars[inId];
        $("gravatar").show();
    }
	
	function generate() {
		doPopup(
			"<div style='width:100%;text-align: center; font-size:20px;'><img src='<?php echo(HTTP_ROOT)?>/html/img/ajax-loader.gif' /> <div id='waitMessage' style='height:40px;overflow:auto;'><?php loc('core.pleaseWait') ?>...</div></div>", " ", 
			true
		);
		window.setTimeout("waitMessage()", 1000);
		document.forms['options'].submit();
	}
	
	var waitMessages = 
		new Array(
			"Gleich geht's weiter.",
			"Lalala...",
			"Nicht mehr lang.",
			"Versprochen!",
			"Wir haben ja gesagt, dass es ein wenig dauern kann.",
			"Jetzt abzubrechen wäre ja auch doof, oder?",
			"Gleich haben wir's.",
			"Und sonst so?!",
			"So, Trommelwirbel....",
			"Oh, dauert doch länger als gedacht.",
			"Zzzzzzzzzzzzzzzz!",
			"Mann, welcher Trottel hat das denn programmiert?!",
			"Mmh"
		);
	var waitCounter = 0;
	function waitMessage() {
		$('waitMessage').update(waitMessages[waitCounter%waitMessages.length] + "<br />" + $('waitMessage').innerHTML);
		waitCounter++;
		window.setTimeout("waitMessage()", 3000+waitCounter*100);
	}

    <?php if($user=getUser()) { ?>
        addUser(<?php echo($user->getId()) ?>, '<?php echo($user->getDisplayName()) ?>', '<?php echo($user->getAvatarUrl(100)) ?>');
    <?php } ?>
    </script>

</body>
</html>
