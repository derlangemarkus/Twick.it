<script type="text/javascript">
<!--
var suggestTimeouts;
var prevSearch;
function updateSuggest() {
	if(suggestTimeouts != null) {
		clearTimeout(suggestTimeouts); 
		suggestTimeouts=window.setTimeout("_updateSuggest()", 250);
	} else {
		suggestTimeouts=window.setTimeout("_updateSuggest()", 0);
	}
}


function _updateSuggest() {
	var search = document.searchForm.search.value;
	if (search != prevSearch) {
		suggestIndex = -1;
		if (search.length > 1) {
			var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/find_topic.json?limit=13&search=" + search;
		
			new Ajax.Request(url, {
				method: 'get',
			  	onSuccess: function(transport) {
			    	var notice = $('searchSuggest');
			    	var suggests = transport.responseText.evalJSON(true);
			    	var suggestText = "";
			    	for (var i=0; i<suggests.topics.length; i++) {
						var tags = "";
						var separator = "";
				    	for(var t=0; t<suggests.topics[i].tags.length; t++) {
					    	tags += separator + suggests.topics[i].tags[t].tag;
					    	separator = ", ";
				    	}
				    	if(i>=12) {
				    		suggestText += "...";
				    	} else {
				    		suggestText += "<a href='" + suggests.topics[i].url.replace(/'/g, "%27") + "'><span style='width:300px;float:left;display:inline;font-weight:bold;' id='searchSuggest" + i + "'>" + suggests.topics[i].title + "</span><span style='color:#666;'>" + tags + "</span></a><br />";				    		
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


var suggestIndex = -1;
var suggestLength = -1;
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
	}
	$("searchSuggest" + nextIndex).style.backgroundColor = "#FCC";
}
//-->
</script>
<form action="<?php echo(HTTP_ROOT) ?>/find_topic.php" method="GET" name="searchForm">
	<input type="text" name="search" id="search" autocomplete="off" />
	<input type="submit" value="Suchen" />
</form>
<div style="border:1px solid #000" id="searchSuggest"></div>
<script type="text/javascript">
$("search").onkeyup = searchUpDown;
</script>
