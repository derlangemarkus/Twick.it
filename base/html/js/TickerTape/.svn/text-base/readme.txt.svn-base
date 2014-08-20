-------------------------------------
TickerTape RELEASE NOTES
v1.1 - Colin Ramsay
http://colinramsay.co.uk/tickertape/
------------------------------------

Note
----

The TickerTape script is licensed under the MIT license which means you can do whatever you want with it so long as you keep the license intact. I'd appreciate a mention where ever you use it as well :>

Usage
-----

You simply need to instantiate a new TickerTape in your HTML, where you want it to appear. Example:

<body>
	<script type="text/javascript" src="TickerTape.js"></script>
	<script type="text/javascript">var ticker = new TickerTape('url', 'myTickerTape', 6000, false);</script>
</body>

TickerTape requires three parameters:

dataUrl:	The url to request JSON data from.
cssClassName:	A class name to add to the TickerTape container div, in addition to 'basicTickerTape'.
scrollInterval:	The number of milliseconds to wait between scrolling each item.
horizontal (OPTIONAL): if set to true, the TickerTape will scroll horizontally.

Supplying Data
--------------

The TickerTape expects JSON from the dataUrl in this format:

[
	{
		"Id":1,
		"LinkText":"text",
		"Url":"url",
		"Title":"title"
	},
	{
		"Id":2,
		"LinkText":"text",
		"Url":"url",
		"Title":"title"
	}
]

When requesting data from a url, the TickerTape will send a "lastId" parameter on the querystring. If this is the first update, this parameter will be 0. You can use this on the server to determine the next lot of data to send.

IE7
---

Apparently IE7 does not allow XMLHttpRequests to the local filesystem. That means if you download the demo to your computer and try to run it, it'll fail. You need to view the demos on a webserver.

CSS Styling
-----------

The styles which are required for the scrolling to work can be found in tickertape.css. .basicTickerTape is applied to all tickertapes, and you can add an additional class in the ticker tape constructor. IMPORTANT: if you are using a horizontal tickertape, you need to specify CSS like this:

	div.myHorizontalTickerTape ul {
		width: 500000px;
	}

This is to allow the tickertape container to contain all of the items without having them wrap to two lines.

Margin Collapsing
-----------------

If you decide to do something like this:

.basicTickerTape li {
	margin: 10px 0;
}

You'll throw the scrolling off. This is because the vertical margin between two items will collapse. Chances are you'll get the same effect with:

.basicTickerTape li {
	margin: 10px 0 0 0;
}

Changelog
---------

1.1		Added horizontal scrolling and pause on hover
1.01	Fix for the demo in Firefox (thanks Ajaxian!)
1.0		Initial release