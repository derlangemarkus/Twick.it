<?php
require_once("TwickitPathFinder.class.php");

$maxDepth = 20;
$source = isset($_GET["topic1"]) ? $_GET["topic1"] : "";
$destination = isset($_GET["topic2"]) ? $_GET["topic2"] : ""; 

$path = false;
if ($source && $destination) {
	$pathFinder = new TwickitPathFinder($source, $destination, $maxDepth);
	$path = $pathFinder->findPath();
}

?>
<html>
<head>
	<title>Twick.it - PathFinder</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="html/js/scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript">
	<!--
	function addTags() {
		var steps = $$(".step");
		for(var i=0; i<steps.length; i++) {
			addTagsToStep(steps[i]);
		}
	}

	function addTagsToStep(inStep) {
		if(inStep.id != "") {
			new Ajax.Request("proxy.php?search=" + encodeURI(inStep.id), {
				method: 'get',
			  	onSuccess: function(transport) {
			    	var suggests = transport.responseText.evalJSON(true);
		    	   	var original = inStep.innerHTML;
			    	inStep.update("");
			    	var pos=0;
			    	for(var h=0; h<suggests.topics.length; h++) {
				    	var topic = suggests.topics[h];
				    	var hit = false;
				    	var tagContent = "";
				    	for(var t=0; t<topic.tags.length; t++) {
					    	var tag = topic.tags[t].tag;
					    	if (tag == original) {
					    		hit = true;
						    	pos = t;
						    	tag = "<a href='http://twick.it/find_topic.xml?search=" + encodeURI(tag) + "' target='_blank'>" + tag + "</a>";
					    	}
					    	tagContent += tag + "<br />";
				    	}
				    	if (hit) {
				    		inStep.update(tagContent);
				    	}
			    	}
			    	var frame = $(inStep.id + "_frame");
			    	for(var i=0; i<10-pos; i++) {
			    		frame.innerHTML = "<br />" + frame.innerHTML;
			    	}
			  	}	
			});
		}
	}
	

	
	var suggestTimeouts = new Array();
	var prevSearch;
	function updateSuggest(inIndex) {
		if(suggestTimeouts != null) {
			clearTimeout(suggestTimeouts[inIndex]); 
			suggestTimeouts[inIndex] = window.setTimeout("_updateSuggest(" + inIndex + ")", 250);
		} else {
			suggestTimeouts[inIndex] = window.setTimeout("_updateSuggest(" + inIndex + ")", 0);
		}
	}
	
	
	function _updateSuggest(inIndex) {
		var search = document.searchForm.elements["topic" + inIndex].value;
		if (search != prevSearch) {
			if (search.length > 0) {
				new Ajax.Request("proxy.php?search=" + encodeURI(search), {
					method: 'get',
				  	onSuccess: function(transport) {
				    	var notice = $('searchSuggest' + inIndex);
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
	<style type="text/css">
	div {
		width:auto;
		float:left;
		padding:2px;
		margin:3px;
	}
	</style>
</head>
<body>
<form name="searchForm">
Start: <input type="text" name="topic1" autocomplete="off" onkeyup="updateSuggest(1)" value="<?php echo($source) ?>"/>
<div id="searchSuggest1"></div>
Ziel: <input type="text" name="topic2" autocomplete="off" onkeyup="updateSuggest(2)" value="<?php echo($destination) ?>"/>
<div id="searchSuggest2"></div>
<input type="submit" value="Finde den Pfad" />
</form>
<hr />
<?php 
if ($path !== false) {
	if (sizeof($path)) {
		echo("<h1>Nach " . sizeof($path) . " Schritten wurde eine Verbindung gefunden:</h1>");
		$separator = "";
		$prevTopic = "";
		$indent = str_repeat("<br />", 10);
		$isFirst = true;
		foreach($path as $topic) {
			?>
			<div style=""><?php echo($separator); ?></div>
			<div id="<?php echo($prevTopic) ?>_frame">
				<?php if ($isFirst) { echo($indent); $isFirst=false; } ?>
				<div style="border:1px solid #666;" class="step" id="<?php echo($prevTopic) ?>"><?php echo($topic) ?></div>
			</div>
			<?php 
			$separator = $indent . " --&gt; ";
			$prevTopic = $topic;
		}
	} else {
		echo("<h1>Es wurde nach $maxDepth Schritten keine Verbindung zwischen gefunden.</h1>");				
	}
}
?>
<script type="text/javascript">addTags();</script>
</body>
</html>
