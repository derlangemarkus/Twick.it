<?php 
$topic = isset($_GET["search"]) ? $_GET["search"] : "twick.it";
$days = isset($_GET["days"]) ? $_GET["days"] : 180;  
?>
<html>
<head>
	<title>Twick.it - Chart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="html/js/scriptaculous/lib/prototype.js"></script>
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
			if (search.length > 0) {
				new Ajax.Request("proxy.php?search=" + encodeURI(search) + "&days=" + document.searchForm.days.value, {
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
				    		suggestText += "<a href='javascript:;' onclick='document.location.href=\"index.php?search=" + encodeURI(suggests.topics[i].title) + "&days=" + document.searchForm.days.value + "\";'><div style='width:300px;float:left;display:inline;font-weight:bold;'>" + suggests.topics[i].title + "</div><span style='color:#666;'>" + tags + "</span></a><br />";
				    	}
				      	notice.update(suggestText);
				  	}	
				});
			} else {
				$('searchSuggest').update("");
			}	
			prevSearch = search;		
		}
	}
	//-->
	</script>
</head>
<body>
<form name="searchForm">
Thema: <input type="text" name="search" autocomplete="off" onkeyup="updateSuggest()" value="<?php echo($topic) ?>"/>
Zeige die letzen 
<select name="days">
	<option <?php if ($days==10) echo("selected") ?>>10</option>
	<option <?php if ($days==30) echo("selected") ?>>30</option>
	<option <?php if ($days==90) echo("selected") ?>>90</option>
	<option <?php if ($days==180) echo("selected") ?>>180</option>
	<option <?php if ($days==365) echo("selected") ?>>365</option>
</select> Tage.<br />
<div id="searchSuggest"></div>
<input type="submit" value="Zeig's als Chart" />
</form>
<hr />
<?php 
include_once 'php-ofc-library/open-flash-chart-object.php';
open_flash_chart_object(1000, 600, "data.php?topic=" . urlencode($topic) . "&days=" . $days, false);
?>
</body>
</html>	