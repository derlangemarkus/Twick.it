<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php");

printXMLHeader();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:widget="http://www.netvibes.com/ns/">
  <head>
  	<title>Twick.it</title>
    <link rel="icon" type="image/png" href="http://twick.it/interfaces/uwa/favicon.ico" />
	<meta name="author" content="Markus M&amp;ouml;ller - Twick.it" />
	<meta name="author_email" content="markus@twick.it" />
	<meta name="website" content="http://www.twick.it" />
	<meta name="description" content="Allows to search explanations at Twick.it, the explain-engine." />
	<meta name="version" content="0.1" />
	<meta name="keywords" content="twick.it, explain engine, Erklärmaschine" />
	<meta name="screenshot" content="http://twick.it/interfaces/uwa/screenshot.png" />
	<meta name="thumbnail" content="http://twick.it/interfaces/uwa/thumbnail.png" />
	<meta name="author_photo" content="http://www.gravatar.com/avatar/c437dd814266449417f7c3a0560de037?s=208" />
	<meta name="author_link" content="http://twick.it/user/derlangemarkus" />
    
    <meta name="apiVersion" content="1.0" />
    <meta name="debugMode" content="true" />

    <link rel="stylesheet" type="text/css" href="http://www.netvibes.com/themes/uwa/style.css" />

    <script type="text/javascript" src="http://www.netvibes.com/js/UWA/load.js.php?env=Standalone"></script>

    <widget:preferences>
    	<preference name="language" type="list" label="Language" onchange="refresh" defaultValue="de">
    		<option value="auto" label="auto" />
    		<?php foreach($languages as $languageData) { ?>
    		<option value="<?php echo($languageData["code"]) ?>" label="<?php echo($languageData["name"]) ?>" />
	    	<?php } ?>
    	</preference>
   </widget:preferences>

    <style type="text/css">
body {
	font-family: arial,sans-serif;
	font-size:11px;
}

#search {
	width:100%;
	background-image:url(logo.gif);
	background-position:right 1px;
	background-repeat:no-repeat;
	height:33px;
	font-size:20px;
	border: 1px solid #666;
}

.searchSuggest {
	display:block;
	color: #84b204;
	font-weight:bold;
}

#searchSuggest {
	height:200px;
	overflow: auto;
}

#searchSuggest a {
	text-decoration: none;
	display:block;
}

#searchSuggest a:hover {
	background-color:#EEE;
}

#searchSuggest span {
	display:block;
}


.searchSuggestTags {
	color:#333;
	display:block;
	overflow:hidden;
	border-bottom:1px solid #333;
}

a.powered:link, a.powered:active, a.powered:visited {
	float:right;
	color:#666;
	text-decoration: none;
	padding-top:4px;
}
a.powered:hover, a.powered:focus {
	color:#333;
	text-decoration: underline;
}

</style>
<script type="text/javascript" src="<?php echo(HTTP_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
<script type="text/javascript">
var suggestTimeouts;
var suggestIndex = -1;
var suggestLength = -1;
var prevSearch;
function updateSuggest() {
	if(suggestTimeouts != null) {
		clearTimeout(suggestTimeouts); 
		suggestTimeouts=window.setTimeout("_updateSuggest()", 150);
	} else {
		suggestTimeouts=window.setTimeout("_updateSuggest()", 0);
	}
}


function _updateSuggest() {
	var search = document.searchForm.search.value;
	if (search != prevSearch) {
		suggestIndex = -1;
		if (search.length > 1) {
			var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/explain.json?similar=1&lng=" + Twickit.getLanguage() + "&limit=20&search=" + encodeURIComponent(search);

			UWA.Data.getJson(url, Twickit.display);
		} else {
			document.getElementById('searchSuggest').innerHTML = "";
		}	
		prevSearch = search;		
	}
}

function searchUpDown(inEvent) {
	var code; //variable to save keystroke
	if (!inEvent) var inEvent = window.event; //did i get any event
	if (inEvent.keyCode) code = inEvent.keyCode;
	
	if (code == 38) {
		if (suggestIndex > 0) {
			updateSuggestIndex(false);
			suggestIndex--;
			document.getElementById("search").value = document.getElementById("searchSuggest" + suggestIndex).innerHTML;
			prevSearch = document.getElementById("search").value;
		}	
	} else if (code == 40) {
		if (suggestIndex < suggestLength-1) {
			updateSuggestIndex(true);
			suggestIndex++;
			document.getElementById("search").value = document.getElementById("searchSuggest" + suggestIndex).innerHTML;
			prevSearch = document.getElementById("search").value;
		}
	} else {
		updateSuggest();
	}
} 

function updateSuggestIndex(inDown) {
	var nextIndex = inDown ? suggestIndex+1 : suggestIndex-1;
	if (suggestIndex >= 0) { 
		document.getElementById("searchSuggest" + suggestIndex).style.backgroundColor = "#FFF";
		document.getElementById("searchSuggestTags" + suggestIndex).style.backgroundColor = "#FFF";
	}
	document.getElementById("searchSuggest" + nextIndex).style.backgroundColor = "#CCC";
	document.getElementById("searchSuggestTags" + nextIndex).style.backgroundColor = "#CCC";
}

	var Twickit = {}
	Twickit.updatePreferences = function() {
		document.getElementById("twickitSubmitButton").value = Twickit.getLanguage() == "de" ? "Suchen" : "Search";
		widget.setTitle("<a href='http://twick.it?lng=" + Twickit.getLanguage() + "'>Twick.it</a>");
	}

	Twickit.getLanguage = function() {
		var curlang=widget.getValue('language');

		if(curlang=='auto') { 
		  curlang=widget.lang.substring(0,2);
		}

		return curlang;
	}

	Twickit.display = function(suggests) {
    	var suggestText = "";
    	for (var i=0; i<suggests.topics.length; i++) {
			var tags = "";
			var separator = "";
	  
	    	tags = suggests.topics[i].twicks[0].text;
	    	if(i>=30) {
	    		if (i==30) {
	    			suggestText += "<a href='http://twick.it/find_topic.php?search=" + encodeURIComponent(search) + "&lng=" + Twickit.getLanguage() + "' target='_blank'>" + (Twickit.getLanguage() == "de" ? "mehr" : "more") + "</a>";
	    		}
	    	} else {
	    		suggestText += "<a href='" + suggests.topics[i].url.replace(/'/g, "%27") + "' target='_top'><span id='searchSuggest" + i + "' class='searchSuggest'>" + suggests.topics[i].title + "</span><span class='searchSuggestTags' id='searchSuggestTags" + i + "'>" + tags + "</span></a>";				    		
	    	}
    	}
    	suggestLength = suggests.topics.length;
      	notice.innerHTML = suggestText;
	}
    </script>

  </head>
  <body>
    <p><form action="<?php echo(HTTP_ROOT) ?>/find_topic.php" method="GET" name="searchForm" target="_top">
	<input type="text" name="search" id="search" autocomplete="off" onfocus="this.select();"/>
	<input type="submit" value="<?php loc('interfaces.igoogle.search') ?>" style="float:left;" id="twickitSubmitButton"/><a href="http://twick.it?lng=<?php echo(getLanguage()) ?>" target="_blank" class="powered">powered by Twick.it</a><br style="clear:both;" />
</form>
<div id="searchSuggest"></div>
<script type="text/javascript">
document.getElementById("search").onkeyup = searchUpDown;

widget.onRefresh = Twickit.updatePreferences;
widget.onLoad = Twickit.updatePreferences;
</script></p>
  </body>
</html>