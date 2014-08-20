<?php
/*
 * Created at 24.05.2007
 *
 * @author Markus Moeller - Twick.it
 */
function redirect($inUrl, $inDelay=0, $inSilent=true) {
	if (!headers_sent()) {
		header("Location: $inUrl");
	}
	echo("<html>
			<head>
			<title>Weiterleitung...</title>
			<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
			<meta http-equiv='refresh' content='$inDelay;URL=" . str_replace("'", "%27", $inUrl) . "'>
			</head>
			<body bgcolor='#FFFFFF'>" .
			($inSilent ? "" : "Sie werden weitergeleitet zu <a href='$inUrl'>$inUrl</a>...") .
			"</body>
			</html>\n");
	exit;
}


function redirectParent($inUrl) {
	echo("<script type='text/javascript'>
			opener.document.location.href='$inUrl';
			window.self.close();
		  </script>\n");
}


function debug($inMessage) {
	if (ENABLE_DEBUG) {
		echo($inMessage);
	}
}


function print_rr($inObject, $inStop=false) {
	echo("<pre>");
	print_r($inObject);
	echo("</pre>");
	if ($inStop) {
		debugstop();
	}
}


function popup($inMessage, $inTitle=false) {
    $title = $inTitle !== false ? ',"' . $inTitle . '"' : "";
	echo("<script language='javascript' type='text/javascript'>popup(\"$inMessage\"$title)</script>");
}


function drillDown($inMessage, $inTimeout=8000) {
	global $footerContent;
	$footerContent .= "<script language='javascript' type='text/javascript'>drillDown(\"$inMessage\", $inTimeout)</script>";
}


function alert($inMessage) {
	echo("<script language='javascript' type='text/javascript'>alert(\"$inMessage\")</script>");
}


function debugstop() {
	alert("DEBUGSTOP: " . $_SERVER["SCRIPT_NAME"]);
}


function confirm($inMessage, $inOKUrl, $inCancelUrl) {
	$message = str_replace("\n", "\\n", $inMessage);
	echo("
		<script type='text/javascript'>
		<!--
			Check = confirm(\"$message\");
			if(Check == false){
				document.location.href='$inCancelUrl';
			}else{
				document.location.href='$inOKUrl';
			}
		//-->
		</script>"
	);
}


function backToParent() {
	echo("
		<script type='text/javascript'>
		<!--
			window.parent.opener.location.reload();
			window.parent.self.close();
		//-->
		</script>
	");
}


function confirmLink($inLink, $inMessage="Sind Sie sicher?") {
	$result = "javascript:if(confirm('$inMessage')) { ";
	if (startsWith($inLink, "javascript:")) {
		$result .= $inLink;	
	} else {
		$result .= "location.href='$inLink';";
	}
	$result .= " }";
	
	return $result;
}


function insertAutoLinks($inText) {
	$pattern = array();
	$replacement = array();
	
	$pattern[] 	   = '"(\s|^|[()\.;:])(((ftp|http|https){1}://)[-a-zA-Z0-9@:;%_+.~#?&//=]+)"im';
	$replacement[] = '\1<a href="\2" target="_blank">\2</a>';
	
	$pattern[]     = '"(( |^)HTTP_ROOT([-a-zA-Z0-9@:%_+.~#?&//=]+))"i';
	$replacement[] = '<a href="' . HTTP_ROOT . '\3" target="_blank">\1</a>';

	$pattern[]     = '"(\s|^|[()\.;:])(www.[-a-zA-Z0-9@:%_+.~#?&//=]+)"i';
	$replacement[] = '\1<a href="http://\2" target="_blank">\\2</a>';

	$pattern[]     = '"([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})"i';
	$replacement[] = '<a href="mailto:\1">\\1</a>';
	
	return preg_replace($pattern, $replacement, $inText);
} 



function ajaxHeader($inPrefix) {
	echo("<script type='text/javascript'>
			function createRequestObject$inPrefix() {
				if (window.XMLHttpRequest) { // Mozilla, Safari,...
					http_request = new XMLHttpRequest();
					if (http_request.overrideMimeType) {
						http_request.overrideMimeType('text/xml');
					}
				} else if (window.ActiveXObject) { // IE
					try {
						http_request = new ActiveXObject('Msxml2.XMLHTTP');
					} catch (e) {
					try {
						http_request = new ActiveXObject('Microsoft.XMLHTTP');
					} catch (e) {
						/*
						coded by Kae - http://verens.com/
						use this code as you wish, but retain this notice
						*/
						
						var kXHR_instances=0;
						var kXHR_objs=[];
						
						XMLHttpRequest=function(){
							var i=0;
							var url='';
							var responseText='';
							var iframe='';
							this.onreadystatechange=function(){
								return false;
							}
							this.open=function(method,url){
								//TODO: POST methods
								this.i=++kXHR_instances; // id number of this request
								this.url=url;
								document.body.appendChild(document.createElement('<iframe id=\"kXHR_iframe_'+this.i+'\" style=\"display:none\" src=\"/\"></iframe>'));
							}
							this.send=function(postdata){
								//TODO: use the postdata
								document.getElementById('kXHR_iframe_'+this.i).src=this.url;
								kXHR_objs[this.i]=this;
								setTimeout('XMLHttpRequest_checkState('+this.i+',2)',2);
							}
								return true;
							}
							XMLHttpRequest_checkState=function(inst,delay){
							var el=document.getElementById('kXHR_iframe_'+inst);
							if(el.readyState=='complete'){
								var responseText=document.frames['kXHR_iframe_'+inst].document.body.innerHTML;
								kXHR_objs[inst].responseText=responseText;
								kXHR_objs[inst].readyState=4;
								kXHR_objs[inst].status=200;
								kXHR_objs[inst].onreadystatechange();
								el.parentNode.removeChild(el);
							}else{
								delay*=1.5;
								setTimeout('XMLHttpRequest_checkState('+inst+','+delay+')',delay);
							}
						}	
						
						http_request = new XMLHttpRequest();	            	
						}
					}
				}
				return http_request;
			}

			
			var http$inPrefix = createRequestObject$inPrefix();
			
			</script>\n");
}


function jecho($inText) {
	echo(str_replace("\r", "", str_replace("\n", "", str_replace('"', '\"', $inText))));
}


function xecho($inText) {
	echo(htmlspecialchars($inText));
}
?>
