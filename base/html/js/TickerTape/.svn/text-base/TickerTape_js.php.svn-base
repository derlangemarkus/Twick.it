<?php
header('Content-Type: text/javascript');
require_once '../../../util/inc.php';
?>
//
// Copyright (c) 2007 Colin Ramsay
//
// Permission is hereby granted, free of charge, to any person
// obtaining a copy of this software and associated documentation
// files (the "Software"), to deal in the Software without
// restriction, including without limitation the rights to use,
// copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following
// conditions:
//
// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
// OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
// WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
// OTHER DEALINGS IN THE SOFTWARE.
//
// Cross browser mouseenter and mouseleave courtest of stchur:
// http://ecmascript.stchur.com/2007/03/15/mouseenter-and-mouseleave-events-for-firefox-and-other-non-ie-browsers/
//
// TickerTape v1.1 - http://colinramsay.co.uk/tickertape/
// A scrolling ticker-tape component which dynamically loads in articles using ajax.
//
// Vertical usage:		var ticker=new TickerTape('tickerTape', 'dataurl.php', 5000);
// Horizontal usage:	var ticker=new TickerTape('tickerTape', 'dataurl.php', 5000, true);
//
function TickerTape(url,cssClassName,scrollInterval,horizontal){
this.readyState=0;
this.horizontal=horizontal;
this.dataUrl=url;
this.cssClassName=cssClassName;
this.scrollInterval=scrollInterval;
this.lastId=0;
this.totalScroll=0;
this.scrollIntervalId=null;
this.numberReturned=0;
this.currentChild=0;
this.isScrollPaused=false;
this.amountToScroll=0;
this.init();
};
TickerTape.prototype.createDom=function(){
var randomId="tickerTape"+Math.floor(Math.random()*999);
document.write('<div class="'+this.cssClassName+' basicTickerTape" id="'+randomId +'"><ul></ul></div>');
var tickerTapeWrapper=document.getElementById(randomId);
xb.addEvent(tickerTapeWrapper,'mouseenter',this.pauseScroll.simpleBind(this));
xb.addEvent(tickerTapeWrapper,'mouseleave',this.resumeScroll.simpleBind(this));
this.container=tickerTapeWrapper.getElementsByTagName('ul')[0];
}
TickerTape.prototype.update=function(){
var concatCharacter=this.dataUrl.indexOf('?')>-1?'&':'?';
var urlWithParams=this.dataUrl+concatCharacter+"lastId="+this.lastId;
var xhr=new XMLHttpRequest();
xhr.onreadystatechange=this.updateCallback.simpleBind(this,xhr);
xhr.open("GET",urlWithParams);
xhr.send("");
}
TickerTape.prototype.updateCallback=function(e){
if (e.readyState!=4){
return;
}
var json=eval(e.responseText);
this.numberReturned=json.length;
for(var i=0;i<this.numberReturned;i++){
var listItem=document.createElement('li');
var title=document.createElement('p');
var anchorHolder=document.createElement('p');
anchorHolder.className='tickerLink';
var anchor=document.createElement('a');
anchor.href=json[i].Url;
anchor.title=json[i].Title;
title.innerHTML=json[i].Title;
anchor.innerHTML="<div class='left'></div><img src='"+json[i].Avatar+"' style='float:left;margin-right:4px;width:32px;height:32px;' /><nobr style='display:block;float:left;'>"+json[i].User+" <?php loc('homepage.about')?> <br />"+json[i].LinkText+"</nobr><div class='right'></div>";
anchorHolder.appendChild(anchor);
listItem.appendChild(anchorHolder);
this.container.appendChild(listItem);
this.lastId=json[i].Id;
}
this.readyState=4;
}
TickerTape.prototype.pauseScroll=function(){
if(this.scrollIntervalId){
window.clearInterval(this.scrollIntervalId);
this.scrollIntervalId=null;
this.isScrollPaused=true;
this.currentChild--;
}
}
TickerTape.prototype.resumeScroll=function(){
this.isScrollPaused=false;
}
TickerTape.prototype.scroll=function(){
if(!this.isScrollPaused && !this.scrollIntervalId){
var element=this.container.childNodes[this.currentChild];
if(this.amountToScroll==0){
this.amountToScroll=this.horizontal ? this.getElementWidth(element) : this.getElementHeight(element);
}
var context=this;
this.scrollIntervalId=window.setInterval(function(){
context.totalScroll++;
context.amountToScroll--;
if(!context.horizontal){
context.container.style.top=(-context.totalScroll)+'px';
} else {
context.container.style.left=(-context.totalScroll)+'px';
}
if(context.amountToScroll==0){
window.clearInterval(context.scrollIntervalId);
context.scrollIntervalId=null;
}
},20);
this.currentChild++;
this.updateIfNecessary();
}
}
TickerTape.prototype.updateIfNecessary=function(){
var updateThreshold=Math.round(this.numberReturned / 2) - 1;
var mod=this.currentChild % Math.round(this.numberReturned / 2);
if(mod >= updateThreshold){
this.update();
}
}
TickerTape.prototype.init=function(){
this.createDom();
this.update();
var timeoutCallback=this.scroll.simpleBind(this);
context=this;
window.setInterval(function(){if(context.readyState==4) timeoutCallback();},500);
}
TickerTape.prototype.getElementHeight=function(element){
var height=element.offsetHeight;
var topMargin=0;
var bottomMargin=0;
if (element.currentStyle){
topMargin=element.currentStyle['marginTop'];
bottomMargin=element.currentStyle['marginBottom'];
} else if (window.getComputedStyle){
topMargin=document.defaultView.getComputedStyle(element,null).getPropertyValue('margin-top');
bottomMargin=document.defaultView.getComputedStyle(element,null).getPropertyValue('margin-bottom');
}
var isSafari=false;
if(navigator.vendor && navigator.vendor.indexOf('Apple') > -1){
isSafari=true;
}
if(!isSafari){
topMargin=topMargin.replace('px','');
bottomMargin=bottomMargin.replace('px','');
}
if(topMargin=='auto') topMargin=0;
if(bottomMargin=='auto') bottomMargin=0;
return parseFloat(height)+parseFloat(topMargin)+parseFloat(bottomMargin);
}
TickerTape.prototype.getElementWidth=function(element){
var height=element.offsetWidth;
var leftMargin=0;
var rightMargin=0;
if (element.currentStyle){
leftMargin	= element.currentStyle['marginLeft'];
rightMargin	= element.currentStyle['marginRight'];
} else if (window.getComputedStyle){
leftMargin=document.defaultView.getComputedStyle(element,null).getPropertyValue('margin-left');
rightMargin=document.defaultView.getComputedStyle(element,null).getPropertyValue('margin-right');
}
var isSafari=false;
if(navigator.vendor && navigator.vendor.indexOf('Apple')>-1){
isSafari=true;
}
if(!isSafari){
leftMargin=leftMargin.replace('px','');
rightMargin=rightMargin.replace('px','');
}
if(leftMargin=='auto') leftMargin=0;
if(rightMargin=='auto') rightMargin=0;
return parseFloat(height)+parseFloat(leftMargin)+parseFloat(rightMargin);
}
Function.prototype.simpleBind=function(){
var	__method=this;
var args=[arguments[1]];
var object=arguments[0];
return function(){
return __method.apply(object,args);
}
}
/*@cc_on
@if (@_jscript_version >= 5 && @_jscript_version < 5.7)
function XMLHttpRequest(){
try{
return new ActiveXObject('Msxml2.XMLHTTP');
}catch(e){}
}
@end
@*/
var xb={
evtHash: [],
ieGetUniqueID: function(_elem)
{
if (_elem === window){return 'theWindow';}
else if (_elem === document){return 'theDocument';}
else {return _elem.uniqueID;}
},
addEvent: function(_elem,_evtName,_fn,_useCapture)
{
if (typeof _elem.addEventListener!='undefined')
{
if (_evtName=='mouseenter')
{_elem.addEventListener('mouseover',xb.mouseEnter(_fn),_useCapture);}
else if (_evtName=='mouseleave')
{_elem.addEventListener('mouseout',xb.mouseEnter(_fn),_useCapture);}
else
{_elem.addEventListener(_evtName,_fn,_useCapture);}
}
else if (typeof _elem.attachEvent!='undefined')
{
var key='{FNKEY::obj_'+xb.ieGetUniqueID(_elem)+'::evt_'+_evtName+'::fn_'+_fn+'}';
var f=xb.evtHash[key];
if (typeof f!='undefined')
{return;}
f=function()
{
_fn.call(_elem);
};
xb.evtHash[key]=f;
_elem.attachEvent('on'+_evtName,f);
window.attachEvent('onunload',function()
{
_elem.detachEvent('on'+_evtName,f);
});
key=null;
}
else
{_elem['on'+_evtName]=_fn;}
},
removeEvent: function(_elem,_evtName,_fn,_useCapture)
{
if (typeof _elem.removeEventListener!='undefined')
{_elem.removeEventListener(_evtName,_fn,_useCapture);}
else if (typeof _elem.detachEvent!='undefined')
{
var key='{FNKEY::obj_'+xb.ieGetUniqueID(_elem)+'::evt'+_evtName+'::fn_'+_fn+'}';
var f=xb.evtHash[key];
if (typeof f!='undefined')
{
_elem.detachEvent('on'+_evtName,f);
delete xb.evtHash[key];
}
key=null;
}
},
mouseEnter: function(_pFn){return function(_evt)
{
var relTarget=_evt.relatedTarget;
if (this==relTarget || xb.isAChildOf(this,relTarget))
{return;}
_pFn.call(this,_evt);
}
},
isAChildOf: function(_parent,_child)
{
if (_parent==_child){return false};
while (_child && _child!=_parent)
{_child=_child.parentNode;}
return _child==_parent;
}
};