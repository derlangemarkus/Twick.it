<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 
?>
<html>
<head>
<title>Twick.it</title>
<script type="text/javascript" src="<?php echo(HTTP_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
<script type="text/javascript" src="<?php echo(HTTP_ROOT) ?>/html/js/scriptaculous/src/scriptaculous.js"></script>
<script type="text/javascript">
<!--
Ajax.Request.prototype.abort = function() {
    this.transport.onreadystatechange = Prototype.emptyFunction;
    this.transport.abort();
    Ajax.activeRequestCount--;
};

var suggestRequest = null;
var suggestTimeouts;
var prevSearch;
var suggestIndex = -1;
var suggestLength = -1;
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
			var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/explain.json?similar=1&lng=<?php echo(getLanguage()) ?>&limit=20&search=" + encodeURIComponent(search);
		
			if (suggestRequest != null) {
                suggestRequest.abort();
            }
			suggestRequest = new Ajax.Request(url, {
				method: 'get',
			  	onSuccess: function(transport) {
			    	var notice = $('searchSuggest');
			    	var suggests = transport.responseText.evalJSON(true);
			    	var suggestText = "";
			    	for (var i=0; i<suggests.topics.length; i++) {
						var tags = "";
						var separator = "";
				  
				    	tags = suggests.topics[i].twicks[0].text;
				    	if(i>=30) {
				    		if (i==30) {
				    			suggestText += "<a href='http://twick.it/find_topic.php?search=" + encodeURIComponent(search) + "' target='_blank'><?php loc('interfaces.igoogle.more') ?></a>";
				    		}
				    	} else {
				    		suggestText += "<a href='" + suggests.topics[i].url.replace(/'/g, "%27") + "' target='_top'><span id='searchSuggest" + i + "' class='searchSuggest'>" + suggests.topics[i].title + "</span><span class='searchSuggestTags' id='searchSuggestTags" + i + "'>" + tags + "</span></a>";				    		
				    	}
			    	}
			    	suggestLength = suggests.topics.length;
			      	notice.update(suggestText);
			  	}	
			});
		} else {
			$('searchSuggest').update("");
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
			$("search").value = $("searchSuggest" + suggestIndex).innerHTML;
			prevSearch = $("search").value;
		}	
	} else if (code == 40) {
		if (suggestIndex < suggestLength-1) {
			updateSuggestIndex(true);
			suggestIndex++;
			$("search").value = $("searchSuggest" + suggestIndex).innerHTML;
			prevSearch = $("search").value;
		}
	} else {
		updateSuggest();
	}
} 

function updateSuggestIndex(inDown) {
	var nextIndex = inDown ? suggestIndex+1 : suggestIndex-1;
	if (suggestIndex >= 0) { 
		$("searchSuggest" + suggestIndex).style.backgroundColor = "#FFF";
		$("searchSuggestTags" + suggestIndex).style.backgroundColor = "#FFF";
	}
	$("searchSuggest" + nextIndex).style.backgroundColor = "#CCC";
	$("searchSuggestTags" + nextIndex).style.backgroundColor = "#CCC";
}
//-->
</script>
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
</head>
<body>
<form action="<?php echo(HTTP_ROOT) ?>/find_topic.php" method="GET" name="searchForm" target="_top">
	<input type="text" name="search" id="search" autocomplete="off" onfocus="this.select();"/>
	<input type="submit" value="<?php loc('interfaces.igoogle.search') ?>" style="float:left;"/><a href="http://twick.it?lng=<?php echo(getLanguage()) ?>" target="_blank" class="powered">powered by Twick.it</a><br style="clear:both;" />
</form>
<div id="searchSuggest"></div>
<script type="text/javascript">
$("search").onkeyup = searchUpDown;
</script>
</body>
</html>