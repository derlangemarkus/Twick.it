<?php
header('Content-Type: text/javascript'); 
require_once '../../../util/inc.php'; 
?>
function debug(inText) {
	//	document.getElementById("debug").innerHTML += inText + "<br />";
}
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
// Vertical usage:		var ticker = new TickerTape('tickerTape', 'dataurl.php', 5000);
// Horizontal usage:	var ticker = new TickerTape('tickerTape', 'dataurl.php', 5000, true);
//
function TickerTape(url, cssClassName, scrollInterval, horizontal) {

	this.readyState = 0;
	
	// Set whether this ticker scrolls horizontally
	// if it is not set or is false, then it will
	// be a vertical ticker by default.
	this.horizontal = horizontal;

	// Request JSON data from this url.
	this.dataUrl = url;

	// The classname which will be assigned to the tickertape container
	// Note: this is assigned in addition to 'basicTickerTape'.
	this.cssClassName = cssClassName;

	// How many milliseconds to wait between scrolling an item.
	this.scrollInterval = scrollInterval;

	// The id of the last item retrieved from the dataUrl.
	this.lastId = 0;

	// The total number of pixels which have been scrolled since the
	// ticker started. Used to keep track of where to scroll to next.
	this.totalScroll = 0;

	// Used to track the window.setInterval id for the scroll
	// so that we only have one scroll going at once.
	this.scrollIntervalId = null;

	// The number of items returned in the last update.
	this.numberReturned = 0;

	// Tracks the item within the container which was just scrolled.
	this.currentChild = 0;

	// Has the scroll been paused by user interaction?
	this.isScrollPaused = false;

	// If a scroll is paused, we can use this to resume
	// Otherwise it simply tracks how much we need to scroll for 
	// the currently scrolling element.
	this.amountToScroll = 0;

	// Start it up!
	this.init();
};


// Creates a <div> element at the point where the TickerTape script
// was included. The <div> has a class of tickerTape and a random id.
TickerTape.prototype.createDom = function() {

	// Generate a random number and use it to build for the id of the <ul>
	var randomId = "tickerTape" + Math.floor(Math.random()*999);

	// Write out a <div> element to the calling document
	document.write('<div class="'+ this.cssClassName +' basicTickerTape" id="' + randomId +'"><ul></ul></div>');

	var tickerTapeWrapper = document.getElementById(randomId);

	xb.addEvent(tickerTapeWrapper, 'mouseenter', this.pauseScroll.simpleBind(this));

	xb.addEvent(tickerTapeWrapper, 'mouseleave', this.resumeScroll.simpleBind(this));

	// Assign the new <div> element to a property of the tickertape class for easy access
	this.container = tickerTapeWrapper.getElementsByTagName('ul')[0];
}


// Calls the server with lastId we received to get the next lot of items back. Note
// that this.lastId will be 0 if this is the first time the update has been called
TickerTape.prototype.update = function() {

	// We need to be able to handle a dataUrl with existing querystring parameters
	var concatCharacter = this.dataUrl.indexOf('?') > -1 ? '&' : '?';
	var urlWithParams = this.dataUrl + concatCharacter + "lastId=" + this.lastId;

	// Make a call to the server, passing through a function
	// which will be called when the update is complete
	var xhr = new XMLHttpRequest();

	// Set up a callback function
	xhr.onreadystatechange = this.updateCallback.simpleBind(this, xhr);

	// Make the request
	xhr.open("GET", urlWithParams);
	xhr.send("");
}


// The server should return an array of objects that we can use
// to form an item on the tape.
TickerTape.prototype.updateCallback = function(e) {

	//this.readyState = e.readyState;
	
	// Only run this if the XHR has finished loading
	if (e.readyState != 4) {
		return;
	}
	// Probably should swap this call to eval for something safer?
	var json = eval(e.responseText);
	// Remember the number returned in this request so we can use it elsewhere
	this.numberReturned = json.length;
	// Now loop through all the returned items and build HTML from them
	for(var i = 0; i < this.numberReturned; i++) {
		// Produces HTML like this:
		// <li><p>Title</p><p class="tickerLink"><a href="Url">LinkText</a></p>
		var listItem = document.createElement('li');
		var title = document.createElement('p');
		var anchorHolder = document.createElement('p');
		anchorHolder.className = 'tickerLink';
		
		var anchor = document.createElement('a');
		anchor.href = json[i].Url;
		anchor.title = json[i].Title;

		
		title.innerHTML = json[i].Title;
		
		anchor.innerHTML = "<div class='left'></div><img src='" + json[i].Avatar + "' style='float:left;margin-right:4px;width:32px;height:132px;' /><nobr style='display:block;float:left;'>" + json[i].User + " <?php loc('homepage.about')?> " + json[i].LinkText + "</nobr><br style='clear:both;' />" + json[i].Title + "<div class='right'></div>";
		
		anchorHolder.appendChild(anchor);
		
		listItem.appendChild(anchorHolder);

		// Add the built item to the document
		this.container.appendChild(listItem);

		// Track the Id of the items which are added
		// so that we can send it back to the server
		// on the next update.
		this.lastId = json[i].Id;
	}
	
	this.readyState = 4;
}


// Pauses a scroll if it is currently taking place.
TickerTape.prototype.pauseScroll = function() {
	if(this.scrollIntervalId) {
		window.clearInterval(this.scrollIntervalId);
		this.scrollIntervalId = null;
		this.isScrollPaused = true;
		this.currentChild--;
	}
}


// 
TickerTape.prototype.resumeScroll = function() {
	this.isScrollPaused = false;
}


// Scrolls the innerContainer by an amount determined by the current element height.
TickerTape.prototype.scroll = function() {
	// Do not scroll if paused, or if another scroll is taking place
	if(!this.isScrollPaused && !this.scrollIntervalId) {
		// Find the element we are about to scroll and compute its top and bottom margins
		var element = this.container.childNodes[this.currentChild];
		// Amount to scroll will be zero unless we are resuming after a pause.
		// If resuming, we do not want to recalculate the amount to scroll, instead we
		// need to start from where we left off before the pause
		if(this.amountToScroll == 0) {
			this.amountToScroll = this.horizontal ? this.getElementWidth(element) : this.getElementHeight(element);
		}
		// "Save" the current context so it can be used in the setInterval callback
		var context = this;
		// Begin the scroll
		this.scrollIntervalId = window.setInterval(function() {
			context.totalScroll++;
			context.amountToScroll--;
			if(!context.horizontal) {
				context.container.style.top = (-context.totalScroll) + 'px';
			} else {
				context.container.style.left = (-context.totalScroll) + 'px';
			}
			if(context.amountToScroll == 0) {
				window.clearInterval(context.scrollIntervalId);
				context.scrollIntervalId = null;
			}
		}, 20);
		this.currentChild++;
		// Since we've scrolled some elements we may need to load more
		// to ensure there are always items in the container.
		this.updateIfNecessary();
	}
}
// Only calls update if the currentChild has passed the update threshold.
TickerTape.prototype.updateIfNecessary = function() {
	var updateThreshold = Math.round(this.numberReturned / 2) - 1;
	var mod = this.currentChild % Math.round(this.numberReturned / 2);
	if(mod >= updateThreshold) {
		this.update();
	}
}
// Called when the TickerTape class is instantiated.
TickerTape.prototype.init = function() {
	this.createDom();
	this.update();
	var timeoutCallback = this.scroll.simpleBind(this);
	context = this;
	window.setInterval(function() { debug(new Date() + " :" +  context.readyState);if(context.readyState==4) timeoutCallback(); }, 500);
}


// Computes the height including top and bottom margins of an element
TickerTape.prototype.getElementHeight = function(element) {
	var height = element.offsetHeight;
	var topMargin = 0;
	var bottomMargin = 0;
	if (element.currentStyle) {
		topMargin		= element.currentStyle['marginTop'];
		bottomMargin	= element.currentStyle['marginBottom'];
	} else if (window.getComputedStyle) {
		topMargin = document.defaultView.getComputedStyle(element,null).getPropertyValue('margin-top');
		bottomMargin = document.defaultView.getComputedStyle(element,null).getPropertyValue('margin-bottom');
	}
	var isSafari = false;
	if(navigator.vendor && navigator.vendor.indexOf('Apple') > -1) {
		isSafari = true;
	}
	if(!isSafari) {
		topMargin = topMargin.replace('px', '');
		bottomMargin = bottomMargin.replace('px', '');
	}
	if(topMargin == 'auto') topMargin = 0;
	if(bottomMargin == 'auto') bottomMargin = 0;
	return parseFloat(height) + parseFloat(topMargin) + parseFloat(bottomMargin);
}


// Computes the height including top and bottom margins of an element
TickerTape.prototype.getElementWidth = function(element) {
	var height = element.offsetWidth;
	var leftMargin = 0;
	var rightMargin = 0;
	if (element.currentStyle) {
		leftMargin	= element.currentStyle['marginLeft'];
		rightMargin	= element.currentStyle['marginRight'];
	} else if (window.getComputedStyle) {
		leftMargin = document.defaultView.getComputedStyle(element,null).getPropertyValue('margin-left');
		rightMargin = document.defaultView.getComputedStyle(element,null).getPropertyValue('margin-right');
	}
	var isSafari = false;
	if(navigator.vendor && navigator.vendor.indexOf('Apple') > -1) {
		isSafari = true;
	}
	if(!isSafari) {
		leftMargin = leftMargin.replace('px', '');
		rightMargin = rightMargin.replace('px', '');
	}
	if(leftMargin == 'auto') leftMargin = 0;
	if(rightMargin == 'auto') rightMargin = 0;
	return parseFloat(height) + parseFloat(leftMargin) + parseFloat(rightMargin);
}


// Simple version of the Prototype library's bind() which will only work in
// this case, but doing it this way removes the need for Prototype's $A support.
Function.prototype.simpleBind = function() {
	var	__method = this;
	var args =	[arguments[1]];
	var object =	arguments[0];
	return function() {
		return __method.apply(object, args);
	}
}


// Cross browser way of getting XMLHttpRequest from Jonathan Snook, see:
// http://snook.ca/archives/javascript/short_xmlhttprequest_abstraction/
/*@cc_on
@if (@_jscript_version >= 5 && @_jscript_version < 5.7)
  function XMLHttpRequest() {
    try{
      return new ActiveXObject('Msxml2.XMLHTTP');
      }catch(e){}
  }
@end
@*/


var xb =
{
	evtHash: [],
	ieGetUniqueID: function(_elem)
	{
		if (_elem === window) { return 'theWindow'; }
		else if (_elem === document) { return 'theDocument'; }
		else { return _elem.uniqueID; }
	},
	addEvent: function(_elem, _evtName, _fn, _useCapture)
	{
		if (typeof _elem.addEventListener != 'undefined')
		{
			if (_evtName == 'mouseenter')
				{ _elem.addEventListener('mouseover', xb.mouseEnter(_fn), _useCapture); }
			else if (_evtName == 'mouseleave')
				{ _elem.addEventListener('mouseout', xb.mouseEnter(_fn), _useCapture); } 
			else
				{ _elem.addEventListener(_evtName, _fn, _useCapture); }
		}
		else if (typeof _elem.attachEvent != 'undefined')
		{
			var key = '{FNKEY::obj_' + xb.ieGetUniqueID(_elem) + '::evt_' + _evtName + '::fn_' + _fn + '}';
			var f = xb.evtHash[key];
			if (typeof f != 'undefined')
				{ return; }
			f = function()
			{
				_fn.call(_elem);
			};
		
			xb.evtHash[key] = f;
			_elem.attachEvent('on' + _evtName, f);
	
			// attach unload event to the window to clean up possibly IE memory leaks
			window.attachEvent('onunload', function()
			{
				_elem.detachEvent('on' + _evtName, f);
			});
		
			key = null;
			//f = null;   /* DON'T null this out, or we won't be able to detach it */
		}
		else
			{ _elem['on' + _evtName] = _fn; }
	},	

	removeEvent: function(_elem, _evtName, _fn, _useCapture)
	{
		if (typeof _elem.removeEventListener != 'undefined')
			{ _elem.removeEventListener(_evtName, _fn, _useCapture); }
		else if (typeof _elem.detachEvent != 'undefined')
		{
			var key = '{FNKEY::obj_' + xb.ieGetUniqueID(_elem) + '::evt' + _evtName + '::fn_' + _fn + '}';
			var f = xb.evtHash[key];
			if (typeof f != 'undefined')
			{
				_elem.detachEvent('on' + _evtName, f);
				delete xb.evtHash[key];
			}
		
			key = null;
			//f = null;   /* DON'T null this out, or we won't be able to detach it */
		}
	},
	
	mouseEnter: function(_pFn)
	{
		return function(_evt)
		{
			var relTarget = _evt.relatedTarget;				
			if (this == relTarget || xb.isAChildOf(this, relTarget))
				{ return; }

			_pFn.call(this, _evt);
		}
	},
	
	isAChildOf: function(_parent, _child)
	{
		if (_parent == _child) { return false };
		
		while (_child && _child != _parent)
			{ _child = _child.parentNode; }
		
		return _child == _parent;
	}	
};