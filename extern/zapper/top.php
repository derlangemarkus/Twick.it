<html>
<head>
<title>Twick.it - Zapper</title>
<script type="text/javascript" src="html/js/scriptaculous/lib/prototype.js"></script>
<script type="text/javascript" src="html/js/scriptaculous/src/scriptaculous.js"></script>
<script type="text/javascript">
function nextTopic() {
	$("gravatar").src = "html/img/ajax-loader.gif";
	$("gravatar").alt = $("gravatar").title = "Bitte warten";
	$("top").update("Bitte warten...");
	
    var theTime = new Date();
	new Ajax.Request(
			"proxy.php?nocache=" + theTime.getTime(),
			{
				method: 'GET',
			  	onSuccess: function(transport) {
					var info = transport.responseText.evalJSON(true);
								
					if(info.topics[0].topic.twick.link != "") {
						updateContent(info);
					} else {
						nextTopic();
					}
		  		}	
			}
		);
}


function updateContent(inInfo) {
	var topic = inInfo.topics[0].topic;
	var twick = topic.twick;
	var user = topic.twick.user;
	
	var title = topic.title;
	var url = topic.url;
	var link = twick.link;
	var text = twick.text;
	var gravatar = user.gravatar;
	var user = user.name;

	parent.content.location.href=link;
	
	//$("website").src = link;
	$("top").update("<b>" + title + "</b>: " + text + "<br /><a href='" + link + "' target='_blank'>" + link + "</a>");
	$("logo_link").href = url;
	$("gravatar").src = gravatar;
	$("gravatar").title = $("gravatar").title = user;
}

window.onload=nextTopic;

</script>
<style type="text/css">
body {
	margin: 0px;
	padding: 0px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	background-color: #84b204;
}

#topdiv {
	height: 10%;
	width: 90%;
	float: left;
}

#logo {
	margin-right: 10px;
	border: 0px;
}

#gravatar {
	margin-right: 10px;
	border: 0px;
}

#next {
	height: 10%;
	width: 10%;
	float: right;
}

#next_link {
	line-height: 40px;
	font-size: 50px;
	font-weight:bold;
	text-decoration: none;
	color: #222222;
	margin-top: -10px;
	padding-top: 0px;
}

#next_link:hover {
	color: #666666;
}
</style>
</head>
<body>
	<div id="topdiv">
		<a href="http://twick.it" target="_blank" id="logo_link"><img src='logo.jpg' align="left" id="logo"/></a>
		<img src="" alt="" id="gravatar" align="left"/>
		<span id="top"><img src="html/img/ajax-loader.gif" alt="" /></span>
	</div>
	<div id="next"><a href="javascript:;" onclick="nextTopic();this.blur();" id="next_link">&gt;&gt;</a></div>
</body>
</html>