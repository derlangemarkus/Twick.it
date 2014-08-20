<?php
header('Content-Type: text/javascript');
require_once("../../../util/inc.php");
$language = getLanguage();
if ($user = getUser()) {
$secret = $user->getSecret();
}
?>
var inOneYear = (new Date((new Date).getTime()+31536000000)).toGMTString();
var twickitLanguage = '<?php echo($language) ?>';
Ajax.Request.prototype.abort = function() {
this.transport.onreadystatechange = Prototype.emptyFunction;
this.transport.abort();
Ajax.activeRequestCount--;
};
function validateSpamForm(inId) {
for(var i=0; i<document.forms["missbrauch" + inId].elements.length; i++) {
if (document.forms["missbrauch" + inId].elements[i].checked) {
return true;
}
}
return false;
}
function rateTwick(inTwickId, inRating, inSum, inCount) {
$("rating-text" + inTwickId).update("<img src='<?php echo(HTTP_ROOT) ?>/html/img/ajax-loader.gif' alt='<?php loc('core.pleaseWait') ?>' />");
_changeRatingText(inTwickId, inRating, inSum, inCount);
new Effect.Shake("rating-text" + inTwickId, {"distance":"10"});
var url = "<?php echo(HTTP_ROOT) ?>/inc/ajax/rate_twick.php?secret=<?php echo($secret) ?>&id=" + inTwickId + "&rating=" + inRating;
new Ajax.Request(url, {
method: 'get',
onSuccess: function(transport) {
var response = transport.responseText;
if (response) {
var info = response.evalJSON(true);
var badge = info.badge;
if (badge != "" && badge != "off") {
<?php
if ($user) {
$twitter = "https://twitter.com?status=" . _loc('badges.popup.thumb.share') . " " . $user->getUrl();
$facebook = "http://www.facebook.com/share.php?u=" . $user->getUrl();
}
?>
if(badge == "bronze") {
text = "<?php loc("badges.popup.thumb.text.bronze", Badge::$levels[Badge::THUMB][Badge::BRONZE]) ?><?php loc("badges.popup.thumb.text2", array($twitter, $facebook)) ?>";
} else if(badge == "silver") {
text = "<?php loc("badges.popup.thumb.text.silver", Badge::$levels[Badge::THUMB][Badge::SILVER]) ?><?php loc("badges.popup.thumb.text2", array($twitter, $facebook)) ?>";
} else if(badge == "gold") {
text = "<?php loc("badges.popup.thumb.text.gold", Badge::$levels[Badge::THUMB][Badge::GOLD]) ?><?php loc("badges.popup.thumb.text2", array($twitter, $facebook)) ?>";
} else if(badge == "diamond") {
text = "<?php loc("badges.popup.thumb.text.diamond", Badge::$levels[Badge::THUMB][Badge::DIAMOND]) ?><?php loc("badges.popup.thumb.text2", array($twitter, $facebook)) ?>";
}
badgePopup("thumb", "<?php loc("badges.popup.thumb.title") ?>", text, badge);
}
try {
rateTwickCallback(inTwickId, inRating, inSum, inCount);
} catch(e) {}
} else {
doPopup("<?php loc('twick.rating.error') ?>");
}
}
});
if(inRating == 1) {
doDrillDown("<?php loc('twick.rating.good.thanx') ?>", 5000);
} else {
doDrillDown("<?php loc('twick.rating.bad.thanx') ?>", 5000);
}
}
function _changeRatingText(inId, inRating, inSum, inCount) {
var text = "";
if (inCount == 1) {
if (inSum == 1) {
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
text = text.replace(/\{1\}/, inSum).replace(/\{2\}/, inCount);
$("rating-text" + inId).update(text);
$("rating-text" + inId).className = inSum<0 ? "anzahl-schlecht" : "anzahl-gut";
if (inRating == 1) {
$("thumb-down" + inId).className = "negativ-aus";
$("thumb-up" + inId).className = "positiv-button";
$("thumb-down" + inId).onclick = function() {rateTwick(inId, -1, parseInt(inSum)-2, inCount);};
$("thumb-up" + inId).onclick = function() {doPopup('<?php loc('twick.rating.alreadyPositive') ?>');};
$("thumb-up" + inId).blur();
} else {
$("thumb-down" + inId).className = "negativ-button";
$("thumb-up" + inId).className = "positiv-aus";
$("thumb-down" + inId).onclick = function() {doPopup('<?php loc('twick.rating.alreadyNegative') ?>');};
$("thumb-up" + inId).onclick = function() {rateTwick(inId, 1, parseInt(inSum)+2, inCount);};
$("thumb-down" + inId).blur();
}
}
function addFavorite(inTwickId) {
var url = "<?php echo(HTTP_ROOT) ?>/action/save_favorite.php?add=1&secret=<?php echo($secret) ?>&id=" + inTwickId;
new Ajax.Request(url, {
method: 'get',
onSuccess: function(transport) {
var success = transport.responseText;
if (success == "OK") {
$('fav'+inTwickId).className="stern-aktiviert";
$('fav'+inTwickId).onclick = function() {removeFavorite(inTwickId); };
$('fav'+inTwickId).title = "<?php loc('twick.removeFavorite') ?>";
$('fav'+inTwickId).blur();
doDrillDown("<?php loc('twick.addFavorite.success') ?>", 5000);
} else {
popup("<?php loc('twick.addFavorite.error') ?>");
}
}
});
}
function removeFavorite(inTwickId) {
var url = "<?php echo(HTTP_ROOT) ?>/action/save_favorite.php?secret=<?php echo($secret) ?>&id=" + inTwickId;
new Ajax.Request(url, {
method: 'get',
onSuccess: function(transport) {
var success = transport.responseText;
if (success == "OK") {
$('fav'+inTwickId).className="stern";
$('fav'+inTwickId).onclick= function() {addFavorite(inTwickId); };
$('fav'+inTwickId).blur();
$('fav'+inTwickId).title = "<?php loc('twick.addFavorite') ?>";
doDrillDown("<?php loc('twick.removeFavorite.success') ?>", 5000);
} else {
popup("<?php loc('twick.removeFavorite.error') ?>");
}
}
});
}
function updateCharCounter(inId) {
var counterId = "charCounter";
if (inId != null) {
counterId += inId;
}
var textfieldId = "textfield";
if (inId != null) {
textfieldId += inId;
}
var textLength = $(textfieldId).value.length;
var charsLeft = 140-textLength;
$(counterId).update(charsLeft);
if (charsLeft < 0) {
disableTwickitButton(inId);
$(counterId).className = "charCounterError";
$(textfieldId).className = "error";
} else if (charsLeft == 140) {
disableTwickitButton(inId);
} else {
enableTwickitButton(inId);
$(counterId).className = "charCounterOK";
$(textfieldId).className = "ok";
}
}
function enableTwickitButton(inId) {
var buttonId = "twickit";
var formId = "twickit-blase";
if (inId != null) {
buttonId += inId;
formId += inId;
}
var button = $(buttonId);
button.className = "twickitpreview";
button.onclick = function() { $(formId).submit(); };
};
function disableTwickitButton(inId) {
var buttonId = "twickit";
if (inId != null) {
buttonId += inId;
}
var button = $(buttonId);
button.className = "twickitpreview-off";
button.onclick = null;
};

var wikipediaTimeout;
function insertWikipediaLink(inTitle) {
try {
var url = "<?php echo(HTTP_ROOT) ?>/inc/ajax/get_wikipedia_link.php?title=" + encodeURIComponent(inTitle);

new Ajax.Request(url, {
method: 'get',
onSuccess: function(transport) {
var response = transport.responseText;
if (response) {
var wikipedia = response.evalJSON(true);
var text = "Wikipedia über &quot;" + wikipedia.title + "&quot;:<br />";
text += wikipedia.description + "<br /><a href='" + wikipedia.link + "' target='_blank' class='teaser-link'><img src='<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif' width='15' height='9'/><?php loc('core.more') ?></a><br />";
$("wikipedia").update(text);
clearTimeout(wikipediaTimeout);
} else {
$("wikipedia-teaser").fade();
}
}
});
wikipediaTimeout = window.setTimeout("try{$('wikipedia-teaser').fade()} catch(ignoredException) {}", 10000);
} catch(ignoredException) {}
}
var youtubeMovies = new Array();
function onYouTubePlayerReady(inPlayerId) {
var ytplayer = $(inPlayerId);
ytplayer.cueVideoById(youtubeMovies[inPlayerId]);
ytplayer.playVideo();
}
function expandPageTitles() {
var links = $$(".moreinfos");
for(var i=0; i<links.length; i++) {
var link = links[i];
var url = "<?php echo(HTTP_ROOT) ?>/inc/ajax/get_page_title.php?url="+encodeURIComponent(link)+"&id=" + link.id;

new Ajax.Request(url, {
asynchronous: true,
method: 'get',
onSuccess: function(transport) {
var page = transport.responseText.evalJSON(true);
$(page.i).update("<img src='http://getfavicon.appspot.com/"+page.u+"?defaulticon=lightpng' class='favicon' />" + page.t);
if(page.p) {
var preview = new this[page.p + "Preview"](page);
$(page.i).onmouseover = function() { preview.open(); };
$(page.i).onmouseout = function() { preview.close(); };
}
$(page.i).className="";
}
});
}
}
function createPreview(inId, inHtml) {
var preview =
new Element(
"div",
{
"id":"preview"+inId,
"class":"linkpreview",
"style":"display:none"
}
);
preview.update(inHtml);
$(inId).appendChild(preview);
}
var StandardPreview = function(inInfo) {
this.html = inInfo.h;
this.id = inInfo.i;
this.created = false;

this.open = function() {
if (!this.created) {
createPreview(this.id, this.html);
this.created = true;
}
$("preview" + this.id).show();
},

this.close = function() {
$("preview" + this.id).hide();
if($("movie" + this.id)) {
$("movie" + this.id).pauseVideo();
}
}
}
var YoutubePreview = function(inInfo) {
this.html = inInfo.h;
this.id = inInfo.i;
this.created = false;

this.open = function() {
if (!this.created) {
createPreview(this.id, this.html);
this.created = true;
}
$("preview" + this.id).show();
},

this.close = function() {
$("preview" + this.id).hide();
if($("movie" + this.id)) {
$("movie" + this.id).pauseVideo();
}
}
}

var more = new Array();
function showMore(inId, inQueryString, inCount) {
var offset = more[inId];
if (offset == null) {
offset = 0;
}
offset += inCount;
$(inId + "MoreLink").hide();
$(inId + "MoreLinkWait").show();
var url = "<?php echo(HTTP_ROOT) ?>/inc/ajax/show_more_" + inId + ".php?" + inQueryString + "&offset=" + offset + "&limit=" + inCount;
new Ajax.Request(url, {
method: 'get',
onSuccess: function(transport) {
$(inId + "MoreLinkWait").hide();
var response = transport.responseText;
var status = response.substring(0, 1);
var text = response.substring(1);

if (text != "") {
var nextContainer = new Element("div", { "class": "dummy-container" }).update(text);
$(inId).appendChild(nextContainer);
}
if (status == 1) {
$(inId + "MoreLink").show();
} else {
$(inId + "MoreLink").hide();
}
expandPageTitles();
}
});

more[inId] = offset;
}

function showEditor(inId) {
$("twick" + inId).hide();
$("twick_editor" + inId).show();
}

function hideEditor(inId) {
$("twick" + inId).show();
$("twick_editor" + inId).hide();
}


function hover(inId) {
$(inId + "-link").style.backgroundImage = "url(lang/<?php echo($language) ?>/buttons/bt_" + inId + "_hover.png)";
try {
alphaBackgrounds();
} catch(NoIE) {}
}

function reset(inId) {
$(inId + "-link").style.backgroundImage = "url(lang/<?php echo($language) ?>/buttons/bt_" + inId + ".png)";
try {
alphaBackgrounds();
} catch(NoIE) {}
}



var suggestTimeouts;
var prevSearch;
var suggestRequest = null;
var suggestIndex = -1;
var suggestLength = -1;
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
var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/suggest.json?limit=13&search=" + search;

if (suggestRequest != null) {
suggestRequest.abort();
}
suggestRequest = new Ajax.Request(url, {
method: 'get',
onSuccess: function(transport) {
var suggests = transport.responseText.evalJSON(true);
var suggestText = "";
var query = suggests.query.toQueryParams().search;

for (var i=0; i<suggests.topics.length; i++) {
if(i>=12) {
suggestText += "<li style='color:#FFFFFF;'>...</li>";
} else {
var title = suggests.topics[i].title;
var regex = eval("/(" + query + ")/gi");
title = title.replace(regex, "<span>$1</span>");
suggestText += "<li><a href='" + suggests.topics[i].url.replace(/'/g, "%27") + "' id='searchSuggest" + i + "' class='searchSuggest'>" + title + "</a></li>";
}
}
suggestLength = suggests.topics.length;

if (suggestLength > 0) {
$('searchSuggest').update("<ul>" + suggestText + "</ul>");
$('such-klappfeldinhalt').style.display = "block";
$('search').className = "active";
} else {
$('searchSuggest').update("<i><?php loc('misc.noMatches') ?></i>");
$('such-klappfeldinhalt').fade({duration: 3});
$('search').className = "";
}
}
});
} else {
$('such-klappfeldinhalt').hide();
$('searchSuggest').update("");
$('search').className = "";
}
prevSearch = search;
}
}

function searchUpDown(inEvent) {
var code; //variable to save keystroke
if (!inEvent) var inEvent = window.event;
if (inEvent.keyCode) code = inEvent.keyCode;

if (code == 38) {
if (suggestIndex > 0) {
updateSuggestIndex(false);
suggestIndex--;
title = $("searchSuggest" + suggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
$("search").value = title.unescapeHTML();
prevSearch = $("search").value;
}
} else if (code == 40) {
if (suggestIndex < suggestLength-1) {
updateSuggestIndex(true);
suggestIndex++;
title = $("searchSuggest" + suggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
$("search").value = title.unescapeHTML();
prevSearch = $("search").value;
}
} else {
updateSuggest();
}
}

function updateSuggestIndex(inDown) {
var nextIndex = inDown ? suggestIndex+1 : suggestIndex-1;
if (suggestIndex >= 0) {
$("searchSuggest" + suggestIndex).style.fontWeight="normal";
$("searchSuggest" + suggestIndex).style.fontSize="12px";
}
$("searchSuggest" + nextIndex).style.fontWeight="bold";
$("searchSuggest" + nextIndex).style.fontSize="14px";
}


function waitPopup() {
doPopup("<div style='width:100%;text-align: center; font-size:20px;'><img src='<?php echo(HTTP_ROOT)?>/html/img/ajax-loader.gif' /> <?php loc('core.pleaseWait') ?>...</div>", " ", true);
}


function confirmPopup(inText, inLink) {
doPopup(inText + "<br /><br />", " ", true);
var myUrl = window.location.href.gsub('<?php echo(HTTP_ROOT) ?>', '');
$("popup-footer").innerHTML += '<div><a href="' + inLink + '" id="popup_yes" class="teaser-link"><?php loc('core.yes') ?></a><a href="javascript:;" onclick="$(\'curtain\').remove(); $(\'popup-kasten\').remove();" id="popup_no" class="teaser-link"><?php loc('core.no') ?></a></div>';
}

function popup(inText, inTitle, inWithoutOK) {
Event.observe(
window,
'load',
function() {
doPopup(inText, inTitle, inWithoutOK);
}
);
}


function badgePopup(inType, inTitle, inText, inLevel) {
doPopup(
"<table><tr><td valign='top'><img src='/html/img/badges/80/" + inType + "_" + inLevel + ".png' width='80' height='80' /></td><td>" + inText + "</td></tr></table>",
inTitle
);
}

function doLoginPopup(inText, inTitle, inWithoutOK) {
doPopup(inText, inTitle, inWithoutOK);
var myUrl = window.location.href.gsub('<?php echo(HTTP_ROOT) ?>', '');
$("popup-content").innerHTML += '<br /><br /><form id="loginForm3" action="action/login.php?url='+ myUrl + '" method="post"><label for="login" style="width:80px;display:block;float:left;"><?php loc('header.label.user') ?>:&nbsp;</label><input type="text" name="login" id="loginField2" onfocus="this.select()"/><br /><label for="password" style="width:80px;display:block;float:left;"><?php loc('header.label.password') ?>:&nbsp;</label><input type="password" name="password" id="passwordField2" onfocus="this.select()"/><br /><a href="javascript:;" onclick="$(\'loginForm3\').submit();" class="einloggen-<?php echo($language) ?>" style="margin:5px 0px 0px 80px;float:none;border-radius:10px;">&nbsp;</a></form>';
$("popup-content").innerHTML += '<br /><a href="register_form.php"><?php loc('yourTwick.notRegistered') ?></a>';
$("popup-content").innerHTML += '<br /><br /><?php loc('yourTwick.oauth') ?><br />';
$("popup-content").innerHTML += '<a rel="nofollow" href="action/twitter_login.php?url='+ myUrl + '"><img src="html/img/signin_twitter_s.png" alt="<?php loc('oauth.twitter.login') ?>" style="vertical-align:middle;"/> Twitter</a>';
$("popup-content").innerHTML += '<a rel="nofollow" href="action/facebook_login.php?url='+ myUrl + '" style="margin-left:30px;"><img src="html/img/signin_facebook_s.png" alt="<?php loc('oauth.facebook.login') ?>" style="vertical-align:middle;"/> Facebook</a>';
$("popup_ok").update("<?php loc('core.close') ?>");
}

function doPopup(inText, inTitle, inWithoutOK) {
var curtain = new Element("div", { "id": "curtain" });
$$("body")[0].appendChild(curtain);
fade($("curtain"), 0.6);

if (!inTitle) {
inTitle = "<?php loc('core.error') ?>";
}

var popup = new Element("div", { "class": "popup-kasten", "id": "popup-kasten" });
var popupHead = new Element("div", { "class": "popup-head" });
popupHead.appendChild(new Element("h1").update(inTitle));
var popupBody = new Element("div", { "class": "popup-body", "id": "popup-content" }).update(inText);
var popupFooter = new Element("div", { "class": "popup-footer", "id": "popup-footer" });
if (!inWithoutOK) {
var okHolder = new Element("div", { "style":  "width:100%; text-align:right;" });
var ok = new Element("a", { "id": "popup_ok", "href": "javascript:;" }).update("OK");
ok.onclick =
function() {
$$("body")[0].removeChild(curtain);
$$("body")[0].removeChild(popup);
};
okHolder.appendChild(ok);
popupFooter.appendChild(okHolder);
}

popup.appendChild(popupHead);
popup.appendChild(popupBody);
popup.appendChild(popupFooter);

$$("body")[0].appendChild(popup);

popup.style.top = ((document.documentElement.clientHeight/2) - (popup.offsetHeight/2)) + "px";
popup.style.left = ((document.documentElement.clientWidth/2) - (popup.offsetWidth/2)) + "px";
}


function drillDown(inText, inTimeout) {
Event.observe(
window,
'load',
function() {
doDrillDown(inText, inTimeout);
}
);
}


var drilldownTimeouts;
function doDrillDown(inText, inTimeout) {
if(drilldownTimeouts != null) {
clearTimeout(drilldownTimeouts);
}
_removeAllDrilldowns();

var drillDown = new Element("div", { "id": "drill-down", "class": "drill-down", "style": "display:none;", "title": "<?php loc('misc.clickToClose') ?>"});
drillDown.onclick = function() {
this.blindUp();
};
var drillDownBox = new Element("div", { "id": "drill-down-box"}).update(inText);
drillDown.appendChild(drillDownBox);
$("main").appendChild(drillDown);
fade(drillDown, 0.95);
drillDown.blindDown();
drilldownTimeouts=window.setTimeout("_removeAllDrilldowns()", inTimeout);
}
function _removeAllDrilldowns() {
var drillDowns = $$(".drill-down");
for (var i=0; i<drillDowns.length; i++) {
drillDowns[i].blindUp();
}
}
function fade(inObject, inValue) {
//CSS3
if (typeof inObject.style.opacity == "string") {
inObject.style.opacity = inValue;
//Mozilla Filter Implementation
} else if (typeof inObject.style.MozOpacity == "string") {
inObject.style.MozOpacity = inValue;
//Microsoft Filter Implementation
} else if (typeof inObject.style.filter == "string") {
inObject.style.filter = "alpha( opacity = " + inValue * 100 + ")";
}
}
function evalKeyForSubmit(inEvent, inForm) {
if (inEvent && inEvent.which == 13) {
inForm.submit();
} else {
return true;
}
}
function preloadImage(inSrc) {
img = new Image();
img.src = inSrc;
}
function preloadButtonImages() {
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_start_hover.png");
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_benutzer_hover.png");
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_dashboard_hover.png");
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_favoriten_hover.png");
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_blog_hover.png");
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_wissensbaum_hover.jpg");
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_suchfeld_hover.jpg");
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_logout_active.jpg");
preloadImage("<?php echo(HTTP_ROOT)?>/lang/<?php echo($language) ?>/buttons/bt_login_active.jpg");
preloadImage("<?php echo(HTTP_ROOT)?>/html/img/bt_lupe_hover.jpg");
preloadImage("<?php echo(STATIC_ROOT)?>/html/img/ajax-loader.gif");
preloadImage("<?php echo(HTTP_ROOT)?>/html/img/stift_hover.gif");
preloadImage("<?php echo(HTTP_ROOT)?>/html/img/muelleimer_hover.gif");
preloadImage("<?php echo(HTTP_ROOT)?>/html/img/ansicht_hover.gif");
preloadImage("<?php echo(HTTP_ROOT)?>/html/img/totenkopf_hover.gif");
}
Event.observe(
window,
'load',
preloadButtonImages
);
// Copyright (C) 2005-2008 Ilya S. Lyubinskiy. All rights reserved.
// Technical support: http://www.php-development.ru/
//
// YOU MAY NOT
// (1) Remove or modify this copyright notice.
// (2) Re-distribute this code or any part of it.
//     Instead, you may link to the homepage of this code:
//     http://www.php-development.ru/javascripts/dropdown.php
//
// YOU MAY
// (1) Use this code on your website.
// (2) Use this code as part of another product.
//
// NO WARRANTY
// This code is provided "as is" without warranty of any kind.
// You expressly acknowledge and agree that use of this code is at your own risk.


// ***** Popup Control *********************************************************

// ***** at_show_aux *****

function at_show_aux(parent, child)
{
var p = document.getElementById(parent);
var c = document.getElementById(child );

var top  = (c["at_position"] == "y") ? p.offsetHeight+2 : 0;
var left = (c["at_position"] == "x") ? p.offsetWidth +2 : 0;

for (; p; p = p.offsetParent)
{
top  += p.offsetTop;
left += p.offsetLeft;
}

c.style.position   = "absolute";
c.style.top        = top +'px';
c.style.left       = left+'px';
c.style.visibility = "visible";
}

// ***** at_show *****

function at_show()
{
var p = document.getElementById(this["at_parent"]);
var c = document.getElementById(this["at_child" ]);

at_show_aux(p.id, c.id);
clearTimeout(c["at_timeout"]);
}

// ***** at_hide *****

function at_hide()
{
var p = document.getElementById(this["at_parent"]);
var c = document.getElementById(this["at_child" ]);

c["at_timeout"] = setTimeout("document.getElementById('"+c.id+"').style.visibility = 'hidden'", 333);
}

// ***** at_click *****

function at_click()
{
var p = document.getElementById(this["at_parent"]);
var c = document.getElementById(this["at_child" ]);

if (c.style.visibility != "visible") at_show_aux(p.id, c.id); else c.style.visibility = "hidden";
return false;
}

// ***** at_attach *****

// PARAMETERS:
// parent   - id of the parent html element
// child    - id of the child  html element that should be droped down
// showtype - "click" = drop down child html element on mouse click
//            "hover" = drop down child html element on mouse over
// position - "x" = display the child html element to the right
//            "y" = display the child html element below
// cursor   - omit to use default cursor or specify CSS cursor name

function at_attach(parent, child, showtype, position, cursor)
{
var p = document.getElementById(parent);
var c = document.getElementById(child);

p["at_parent"]     = p.id;
c["at_parent"]     = p.id;
p["at_child"]      = c.id;
c["at_child"]      = c.id;
p["at_position"]   = position;
c["at_position"]   = position;

c.style.position   = "absolute";
c.style.visibility = "hidden";

if (cursor != undefined) p.style.cursor = cursor;

switch (showtype)
{
case "click":
p.onclick     = at_click;
p.onmouseout  = at_hide;
c.onmouseover = at_show;
c.onmouseout  = at_hide;
break;
case "hover":
p.onmouseover = at_show;
p.onmouseout  = at_hide;
c.onmouseover = at_show;
c.onmouseout  = at_hide;
break;
}
}
function at_attach_spam(id, returnParameter, secret) {
var spamWindow = new Element("div", { "id": "toteninhalt"+id, "class": "totenauswahl"}).update("<img src='<?php echo(STATIC_ROOT)?>/html/img/ajax-loader.gif' alt='...' width='16' height='11' />");
Element.insert($("totenkopf"+id), {"after":spamWindow});
at_attach("totenkopf"+id, "toteninhalt"+id, "click", "y", "pointer");

$("totenkopf"+id).onclick =
function() {
if (!$("toteninhalt"+id)["ajaxLoaded"]) {
new Ajax.Request("<?php echo(HTTP_ROOT) ?>/inc/ajax/spam_menu.php?id=" + id + "&r=" + returnParameter + "&secret=" + secret, {
method: 'get',
onSuccess: function(transport) {
$("toteninhalt"+id).update(transport.responseText);
}
});
$("toteninhalt"+id)["ajaxLoaded"] = true;
}
if ($("toteninhalt"+id).style.visibility != "visible") at_show_aux("totenkopf"+id, "toteninhalt"+id); else $("toteninhalt"+id).style.visibility = "hidden";
return false;
};
}
function at_attach_message(id, user) {
var messageWindow = new Element("div", { "id": "messageinhalt"+id, "class": "totenauswahl"}).update("<img src='<?php echo(STATIC_ROOT)?>/html/img/ajax-loader.gif' alt='...' width='16' height='11' />");
Element.insert($("message"+id), {"after":messageWindow});
at_attach("message"+id, "messageinhalt"+id, "click", "y", "pointer");

$("message"+id).onclick =
function() {
if (!$("messageinhalt"+id)["ajaxLoaded"]) {
new Ajax.Request("<?php echo(HTTP_ROOT) ?>/inc/ajax/message_menu.php?id=" + id + "&user=" + user, {
method: 'get',
onSuccess: function(transport) {
$("messageinhalt"+id).update(transport.responseText);
}
});
$("messageinhalt"+id)["ajaxLoaded"] = true;
}
if ($("messageinhalt"+id).style.visibility != "visible") at_show_aux("message"+id, "messageinhalt"+id); else $("messageinhalt"+id).style.visibility = "hidden";
return false;
};
}
function isMobile() {
<?php if(getArrayElement($_COOKIE, "mobile", 1) == 0) { ?>
return false;
<?php } ?>
clients = ["240x320","android","benq","blackberry","configuration/cldc","ipod","iphone","midp","mda","mmp/","mot-","netfront","nokia","opera mini","palmos","palmsource","panasonic","philips","phone","pocket pc","portable","portalmmm","sagem","samsung","sda","sgh-","sharp","sie-","sonyericsson","symbian","up.browser","vodafone","web'n'walk","windows ce","xda"];
try {
agent = navigator.userAgent.toLowerCase();
for(var i = 0; i < clients.length; i++) {
if (agent.indexOf(clients[i]) != -1) {
return true;
}
}
} catch(e) {}
return false;
}