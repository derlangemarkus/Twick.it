<?php
require_once("../../util/inc.php");

setDBCacheTimeout(600);

$show = getArrayElement($_GET, "show", "all");
$doNotCluster = getArrayElement($_GET, "doNotCluster");
$username = trim(getArrayElement($_GET, "username"));
$center = getArrayElement($_GET, "center", "0, 180");
$zoom = getArrayElement($_GET, "zoom", 6);
$highlight = "";

$where = "latitude is not null";
if ($show == "filter" && $username) {
    $theUser = User::fetchByLogin($username);
	if ($theUser) {
		$userId = $theUser->getId();
	} else {
		$userId = -1;
	}
    $where .= " AND id IN (SELECT distinct topic_id FROM tbl_twicks WHERE user_id=" . $userId . ")";
} else if($show == "highlight") {
	$highlight = $username;
}

$topics = Topic::fetchBySQL($where);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Twick.it Map - Erklärungen auf einer Landkarte</title>
<link href="../html/css/twick-styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo(HTTP_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
<script type="text/javascript" src="<?php echo(HTTP_ROOT) ?>/html/js/scriptaculous/src/scriptaculous.js?load=effects"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="<?php echo(HTTP_ROOT) ?>/html/js/markerclusterer.js" type="text/javascript"></script>
<style type="text/css">
*{font-family:Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;font-size:12px;line-height:18px;color:#333;}
#preview img {
	width:30px;
	height:30px;
}

#username {
	width:100px;
}

#userSearchSuggest {
	position:absolute;
	border:1px solid #333;
	z-index:1000;
	background-color:#FFF;
	min-width:100px;
	top:30px;
}

#userSearchSuggest a {
	display:block;
}

#userSearchSuggest a span{
	font-size:bold;
	color:#000;
}
</style>
<script type="text/javascript">
var longitudes = new Array();
var latitudes = new Array();
var descriptions = new Array();
var titles = new Array();
var usernames = new Array();
var gravatars = new Array();

<?php
foreach($topics as $counter=>$topic) {
    $twick = $topic->findBestTwick();
    $user = $twick->findUser();
?>
longitudes[<?php echo($counter) ?>] = <?php echo($topic->getLongitude()) ?>;
latitudes[<?php echo($counter) ?>] = <?php echo($topic->getLatitude()) ?>;
descriptions[<?php echo($counter) ?>] = "<?php echo htmlspecialchars(utf8encode(utf8_decode($twick->getText()))) ?>";
titles[<?php echo($counter) ?>] = "<?php echo htmlspecialchars(utf8encode(utf8encode($topic->getTitle()))) ?>";
usernames[<?php echo($counter) ?>] = "<?php echo htmlspecialchars(utf8encode(utf8_decode($user->getLogin()))) ?>";
gravatars[<?php echo($counter) ?>] = "<?php echo ($user->getAvatarUrl(64)) ?>";
<?php
}
?>

var map = null;
var bounds = new google.maps.LatLngBounds();
var points = new Array();
var markers = [];

function showAddresses() {
    map =
        new google.maps.Map(
            document.getElementById("map"),
            {
                zoom: <?php echo($zoom) ?>,
                mapTypeId: google.maps.MapTypeId.TERRAIN,
                center:new google.maps.LatLng(<?php echo($center) ?>)
            }
        );	
		
    for(i=0; i<longitudes.length; i++) {
        showAddress(i);
    }
	
	<?php if ($show == "filter" && $username && !sizeof($topics)) { ?>
		alert("Der Nutzer <?php echo($username) ?> hat keinen Twick geschrieben, der zu einem geokodierten Thema an erster Stelle steht. Noch nicht ;-)");
	<?php } else { ?>
        <?php if(!isset($_GET["zoom"]) && !isset($_GET["center"])) { ?>
            map.fitBounds(bounds);
        <?php } ?>
    <?php if(!$doNotCluster) { ?>
    new MarkerClusterer(
        map,
        markers,
        {
            gridSize:30,
            styles:[
                {
                    url: 'http://twick.it/html/img/avatar/_20.png',
                    height: 20,
                    width: 20
                },
                {
                    url: 'http://twick.it/html/img/avatar/_38.png',
                    height: 38,
                    width: 38
                },
                {
                    url: 'http://twick.it/html/img/avatar/_50.png',
                    height: 50,
                    width: 50
                }
            ]
        }
    );
	<?php } ?>
    <?php } ?>
	
	google.maps.event.addListener(map, 'bounds_changed', function() {
		var url = "<?php echo(HTTP_ROOT) ?>/playground/map/index.php";
		url += "?zoom=" + map.getZoom();
		url += "&amp;center=" + map.getCenter().lat() + "," + map.getCenter().lng();
		url += "&amp;show=<?php echo($show) ?>";
		url += "&amp;doNotCluster=<?php echo($doNotCluster) ?>";
		url += "&amp;username=<?php echo($username) ?>";
		url += "&amp;lng=<?php echo(getLanguage()) ?>";
		$("permalink").update("Link zur Karte: <input type='text' value='" + url + "' size='180' onfocus='this.select()'/>");
	});
}

function showAddress(inIndex) {
    var shadow =
        new google.maps.MarkerImage(
            "http://labs.google.com/ridefinder/images/mm_20_shadow.png",
            new google.maps.Size(47, 34),
            new google.maps.Point(0,0),
            new google.maps.Point(5,20)
        );

    var icon = "";
    var zIndex = 1;
    if (usernames[inIndex].toLowerCase() == "<?php echo(strtolower($highlight)) ?>") {
        icon =
            new google.maps.MarkerImage(
                "http://labs.google.com/ridefinder/images/mm_20_orange.png"
            );
        zIndex = 9999;
    } else {
        icon =
            new google.maps.MarkerImage(
                "http://labs.google.com/ridefinder/images/mm_20_green.png"
            );
    }

    point = new google.maps.LatLng(latitudes[inIndex], longitudes[inIndex]);
    bounds.extend(point);

    var infowindow = new google.maps.InfoWindow({content: "<table><tr><td valign='top'><img src='" + gravatars[inIndex] +"' style='margin-right:10px;'/></td><td><b>" + usernames[inIndex] + "</b> erklärt <b>" + titles[inIndex] + "</b><br />" + descriptions[inIndex] + "</td></tr></table>"});

    var marker = new google.maps.Marker({
          position: point,
          title:titles[inIndex],
          icon:icon,
          map:map,
          shadow:shadow,
          zIndex:zIndex,
		  infoWindow:infowindow
      });

    markers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
                map.panTo(marker.getPosition());
            });
			
	google.maps.event.addListener(marker, 'mouseover', function() {
		$("permalink").hide();
		$("preview").update(marker.infoWindow.getContent());
	});
    google.maps.event.addListener(marker, 'mouseout', function() {
		$("preview").update("");
		$("permalink").show();
	});

    bounds.extend(point);
}

function changeShow() {
	if(document.configForm.show.value == "all") {
		$("username").hide();
	} else {
		$("username").show();
	}
}


function focusUsername() {
	if($("username").value == "Benutzername") {
		$("username").value = "";
		$("username").style.color = "#666";
	}
}



function blurUsername() {
	if($("username").value == "") {
		$("username").value = "Benutzername";
		$("username").style.color = "#CECECE";
	}
}


var suggestUserTimeouts;
var prevUserSearch;
function updateUserSuggest() {
	if(suggestUserTimeouts != null) {
		clearTimeout(suggestUserTimeouts); 
		suggestUserTimeouts=window.setTimeout("_updateUserSuggest()", 250);
	} else {
		suggestUserTimeouts=window.setTimeout("_updateUserSuggest()", 0);
	}
}


function _updateUserSuggest() {
	var search = document.configForm.username.value;
	if (search != prevUserSearch) {
		userSuggestIndex = -1;
		if (search.length > 0) {
			var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/find_user.php?type=json&limit=13&search=" + search;
		
			new Ajax.Request(url, {
				method: 'get',
				onSuccess: function(transport) {
					var suggests = transport.responseText.evalJSON(true);
					userSuggestLength = suggests.users.length;
					var query = suggests.query.toQueryParams().search;
					if (suggests.users.length == 0) {
						$('userSearchSuggest').update("<i><?php loc('users.search.noUserFound') ?></i>");
						$('userSearchSuggest').fade({duration: 3});
					} else {
						var suggestText = "";
						for (var i=0; i<suggests.users.length; i++) {
							if(i>=12) {
								suggestText += "...";
								break;
							} else {
								var title = suggests.users[i].display_name;
								var regex = eval("/(" + query + ")/gi");
								title = title.replace(regex, "<span>$1</span>");

								suggestText += "<a href='javascript:;' onclick='selectUser(\"" + suggests.users[i].user_name + "\")' id='userSearchSuggest" + i + "'>" + title + "</a>";
							}
						}
						$('userSearchSuggest').update(suggestText);
						$('userSearchSuggest').style.left = (2+$('username').offsetLeft) + "px";
						$('userSearchSuggest').show();
					}
				}	
			});
		} else {
			$('userSearchSuggest').hide();
		}
		prevUserSearch = search;			
	}
}


var userSuggestIndex = -1;
var userSuggestLength = -1;
function userSearchUpDown(inEvent) {
	var code; //variable to save keystroke
	if (!inEvent) var inEvent = window.event;
	if (inEvent.keyCode) code = inEvent.keyCode;

	if (code == 38) {
		if (userSuggestIndex > 0) {
			updateUserSuggestIndex(false);
			userSuggestIndex--;
			title = $("userSearchSuggest" + userSuggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
			$("username").value = title.replace(/ \(.+\)/g, "");
			prevUserSearch = title;
		}
	} else if (code == 40) {
		if (userSuggestIndex < userSuggestLength-1) {
			updateUserSuggestIndex(true);
			userSuggestIndex++;
			title = $("userSearchSuggest" + userSuggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
			$("username").value = title.replace(/ \(.+\)/g, "");
			prevUserSearch = title;
		}
	} else if (code == 27) {
        $('userSearchSuggest').fade({duration: 1});
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


function selectUser(inUsername) {
	$("username").value = inUsername;
	$('userSearchSuggest').fade({duration: 1});
}
</script>
</head>

<body onload="showAddresses();" style="background-image:none;background-color:#FFF;">
	<table width="100%" height="100%">
		<tr style="height:30px;">
			<td>
				<a href="http://twick.it" target="_blank"><img src="<?php echo(HTTP_ROOT) ?>/html/img/logo_klein.jpg" border="0" style="float:left;margin-right:20px;"/></a>
				<form action="" name="configForm" style="margin-top:6px;">
					<select name="show" onchange="changeShow();">
						<option value="all">Alles anzeigen</option>
						<option value="highlight" <?php if($show == "highlight") { ?>selected<?php } ?>>Alles anzeigen und diesen Nutzer hervorheben:</option>
						<option value="filter" <?php if($show == "filter") { ?>selected<?php } ?>>Nur die Twicks dieses Nutzers zeigen:</option>
					</select>
					<input type="text" name="username" onblur="$('userSearchSuggest').fade({duration: 2});" autocomplete="off" <?php if($show == "all") { ?>style="display:none;"<?php } ?> id="username" <?php if($username == "") { ?>value="Benutzername" style="color:#CCC;"<?php } else { ?>value="<?php echo($username); ?>"<?php } ?>" onfocus="focusUsername()" onblur="blurUsername()"/>
					<script type="text/javascript">
						$("username").onkeyup = userSearchUpDown;
					</script>
					<div id="userSearchSuggest" style="display:none;"></div>
					<input type="checkbox" value="1" <?php if($doNotCluster) { ?>checked="checked"<?php } ?> name="doNotCluster" style="margin-left: 30px;vertical-align:-2px;"/> Benachbarte Twicks nicht zusammenfassen.
					<input type="submit" value="Ansicht aktualisieren"  style="margin-left: 30px;"/>
				</form>
			</td>
		</tr>
		<tr>
			<td><div id="map" style="width:100%;height:100%;border:1px solid #333;float: left;"></div><div id="permalink"></div></td>
		</tr>
		<tr>
			<td id="preview" style="height:40px;"></td>
		</tr>
	</table>
</body>
</html>