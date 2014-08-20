<?php 
if(!getArrayElement($_GET, "plain")) { 
	setMobileCookie(true);
}

$user = getUser();

$noMobileUrl = "http://twick.it?nomobile=1";
if($canonical) {
    $noMobileUrl = $canonical;
    if(contains($noMobileUrl, "?")) {
        $noMobileUrl .= "&";
    } else {
        $noMobileUrl .= "?";
    }
    $noMobileUrl .= "nomobile=1";
}
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Twick.it - <?php echo($title) ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if($canonical) { ?><link rel="canonical" href="<?php echo($canonical) ?>" /><?php } ?>
<link rel="apple-touch-icon" type="image/x-icon" href="http://twick.it/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="http://twick.it/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="http://twick.it/apple-touch-icon-114x114.png" />
<link rel="apple-touch-startup-image" href="http://twick.it/apple-touch-startup-image.png" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="fluid-icon" type="image/x-icon" href="http://twick.it/fluid-icon.png" />
<meta name="viewport" content="width=device-width" />
<style type="text/css">
* {margin:0px;padding:0px;}
body {background-color:#ffffff;color:#333333;font-family: Helvetica,sans-serif;font-size:12px;} 
h1 {font-size:14px;font-weight:bold;padding-bottom:10px;}
div {display:block;width:100%}
label {display:block;padding-top:15px;font-weight:bold;}
.class_divider {border-bottom:2px solid #638301;clear:both;}
.class_header {width:100%;}
a:link, a:visited {text-decoration:none; font-size: 12px; color:#638301;}
a:hover, a:focus {background-color:#333333;color:#FFFFFF;}
.class_content {padding-top:5px;padding-bottom:5px;padding-left:1%;padding-right:1%;margin-top:5px;}
.class_footer {padding:0px;margin:0px 0px 40px 0px;font-size:12px;}
.class_footer a b {display:block;width:18px;float:left;}
.class_search input {font-size:20px;}
.class_button {background-color:#FFFFFF;border:1px solid #AAAAAA;color:#000000;background-color:#cccccc;}
.class_twick img {width:20px;height:20px;border:none;}
.class_twick td {background-image:url(html/img/bg.gif);background-repeat:repeat-x;border-top:1px solid #999;border-bottom:1px solid #ccc;padding:5px;}
.class_twick td.class_left {border-left:1px solid #ccc;border-radius-topleft:10px;-moz-border-radius-topleft:10px;-webkit-border-top-left-radius:10px;}
.class_twick td.class_right {border-right:1px solid #ccc;border-radius-topright:10px;-moz-border-radius-topright:10px;-webkit-border-top-right-radius:10px;}
a.class_rate {width:50%;display:block;float:left;text-align:center;color:#000;font-size:20px;line-height:22px;}
.class_bottom_left {border-radius-bottomleft:10px;-moz-border-radius-bottomleft:10px;-webkit-border-bottom-left-radius:10px;}
.class_bottom_right {border-radius-bottomright:10px;-moz-border-radius-bottomright:10px;-webkit-border-bottom-right-radius:10px;}
a.class_rate_bad {background-color:#FCC;}
a.class_rate_good {background-color:#CFC;}
a.class_rate_bad:hover, a.class_rate_bad:focus, a.class_rate_bad_active {background-color:#F33;}
a.class_rate_good:hover, a.class_rate_good:focus, a.class_rate_good_active {background-color:#3F3;}
.class_longbutton, form#loginform input, form#loginform textarea, form#your_twick input, form#your_twick textarea {width:95%;padding:9px 0px 9px 0px;border:1px solid #666;}
.class_message, .class_message a {padding:6px;background-color:#E75C24;color:#FFFFFF;line-height:19px;}
.class_message a {padding:0px;}
.class_footer a {color:#638301;display:block;padding:10px;background-image:url(html/img/bg.gif);background-repeat:repeat-x;border-top:1px solid #999;border-bottom:1px solid #ccc;}
.class_footer a:hover, .class_footer a:active {background-color:#FFF;font-weight:bold;}
#searchSuggest a {color:#333}
#searchSuggest a:hover {color:#FFF;}
#searchSuggest a span {font-weight:bold;}
#searchSuggest li{margin:5px 5px 5px 20px}
.class_userinfo label{width:120px;float:left;padding:0px 10px 0px 0px;}
.class_userinfo br{clear:both;}
#userSearchSuggestBox{border:1px solid #333;width:95%}
#userSearchSuggestBox li{list-style-type:none;padding:5px}
</style>
<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
<script type="text/javascript">
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
			var url = "http://m.twick.it/interfaces/api/suggest.json?limit=13&search=" + search;
		
			new Ajax.Request(url, {
				method: 'get',
			  	onSuccess: function(transport) {
			    	var suggests = transport.responseText.evalJSON(true);
			    	var suggestText = "";
					var query = suggests.query.toQueryParams().search;
					
			    	for (var i=0; i<suggests.topics.length; i++) {
				    	if(i>=12) {
				    		suggestText += "<li style='color:#333;'>...</li>";
				    	} else {
				    		var title = suggests.topics[i].title;
				    		var regex = eval("/(" + query + ")/gi");
				    		title = title.replace(regex, "<span>$1</span>");
				    		suggestText += "<li><a href='topic.php?search=" + encodeURIComponent(suggests.topics[i].title) + "' id='searchSuggest" + i + "' class='searchSuggest'>" + title + "</a></li>";				    		
				    	}
			    	}
			    	suggestLength = suggests.topics.length;

			    	if (suggestLength > 0) {
			    		$('searchSuggest').update("<ul>" + suggestText + "</ul>");	
				    	$('such-klappfeldinhalt').style.display = "block";
				    } else {
				    	$('searchSuggest').update("<i><?php loc('misc.noMatches') ?></i>");	
				    	$('such-klappfeldinhalt').hide();
				    }
			  	}	
			});
		} else {
			$('such-klappfeldinhalt').hide();
			document.getElementById('searchSuggest').update("");
		}	
		prevSearch = search;		
	}
}

function rateTwick(inId, inSum, inCount, inRating) {
	if (inCount == 1) {
		if (inSum== 1) {
			text = "<?php loc('twick.points.1.1') ?>";
		} else {
			text = "<?php loc('twick.points.-1.1') ?>";
		}
	} else {
		if (inSum == 1) {
			text = "<?php loc('twick.points.1.n') ?>";
		} else {
			text = "<?php loc('twick.points.n.n') ?>";
		}
	}
	
	text = text.replace("{1}", inSum);
	text = text.replace("{2}", inCount);
	
	$("rating" + inId).update(text);
	
	if(inRating>0) {
		$("minus" + inId).className = "class_rate class_rate_bad class_bottom_left";
		$("plus" + inId).className = "class_rate class_rate_good_active class_bottom_right";
		url = $("plus" + inId).href;
	} else {
		$("minus" + inId).className = "class_rate class_rate_bad_active class_bottom_left";
		$("plus" + inId).className = "class_rate class_rate_good class_bottom_right";
		url = $("minus" + inId).href;
	}
	
	if(inSum < 0) {
		$("rating" + inId).style.color='#F33';
	} else {
		$("rating" + inId).style.color='#333';
	}
	
	new Ajax.Request(url);
	return false;
}

Ajax.Request.prototype.abort = function() {
    this.transport.onreadystatechange = Prototype.emptyFunction;
    this.transport.abort();
    Ajax.activeRequestCount--;
};
</script>
</head>
<body>
<a name="top"></a>
<table class="class_header">
	<tr>
		<td><a href="index.php"><img src="<?php echo(HTTP_ROOT) ?>/html/img/logo.jpg" alt="Twick.it" style="width:63px;height:26px;border:none;"/></a><?php if(!getArrayElement($_GET, "plain")) { ?> <i>mobile</i><?php } ?></td>
		<td align="right">
			<?php if($user) { ?>
			<?php echo($user->getLogin())?>&nbsp;<br /><a href="logout.php?secret=<?php echo($user->getSecret()) ?>&r=<?php echo(urlencode($_SERVER["REQUEST_URI"])) ?>"><?php loc('mobile.menu.logout') ?></a>&nbsp;
			<?php } else { ?>
			<a href="register.php?r=<?php echo(urlencode($_SERVER["REQUEST_URI"])) ?>"><?php loc('mobile.menu.register') ?></a>&nbsp;<br /><a href="login.php?r=<?php echo(urlencode($_SERVER["REQUEST_URI"])) ?>"><?php loc('mobile.menu.login') ?></a>&nbsp;
			<?php } ?>
		</td>
	</tr>
</table>
<?php if(!getArrayElement($_GET, "plain")) { ?>
<?php if($msg = getArrayElement($_GET, "msg")) { ?>
<div class="class_message"><?php loc($msg) ?></div>
<?php } ?>
<form action="topic.php" method="get" name="searchForm" class="class_search class_content" style="background-color:#638301;background-image:url(html/img/header.jpg);background-repeat:repeat-x;">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td><input type="text" name="search" style="width:100%" width="100%" xonblur="$('such-klappfeldinhalt').hide();" onkeyup="updateSuggest()" autocomplete="off"/>
				<div style="position:absolute;z-index:1000;padding:5px;width:auto;background-image:url(html/img/bg.gif);background-repeat:repeat-x;background-color:#FFF;display:none;border:1px solid #333;" id="such-klappfeldinhalt">
					<div id="searchSuggest"></div>
				</div>
			</td>
			<td align="right" style="width:100px"><input type="submit" value="<?php loc('mobile.header.search') ?>" class="class_button" /></td>
		</tr>
	</table>
</form>
<div class="class_divider"></div>
<?php } ?>