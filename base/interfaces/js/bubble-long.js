var TwickitBubble = {
    stopFadding : false,

    open: function(inX, inY, inTheme, inColor, inTextC, inTitleC) {
	    if (inTheme != "custom") {
			if(inTheme == null || inTheme == "undefined") {
				inTheme = "twickit";
			}
            if (document.getElementById('twickit_open_popup_css') != null) {
                var element = document.getElementById('twickit_open_popup_css');
                element.parentNode.removeChild(element);
            }

            var css = document.createElement("link");
            css.setAttribute("type", "text/css");
            css.setAttribute("id", "twickit_open_popup_css");
            css.setAttribute("rel", "stylesheet");
            css.setAttribute("href", "http://static.twick.it/interfaces/js/popup/theme_" + inTheme + ".php?color=" + inColor + "&text=" + inTextC + "&title=" + inTitleC + "&id=" + Math.random());
            document.getElementsByTagName("head")[0].appendChild(css);
        }
	
        var twicktip = document.getElementById('twicktip');
        if (twicktip != null) {
			twicktip.parentNode.removeChild(twicktip);
		}
		twicktip = document.createElement("div");
		twicktip.id = "twicktip";
		var table = document.createElement("table");
		table.setAttribute("cellPadding", 0);
		table.setAttribute("cellSpacing", 0);
		var tbody = document.createElement("tbody");

		var rows = new Array("t", "u", "m", "l");
		for(var r=0; r<rows.length; r++) {
			var tr = document.createElement("tr");
			var td1 = document.createElement("td");
			td1.id = "twicktip_" + rows[r] + "l";
			var td2 = document.createElement("td");
			td2.id = "twicktip_" + rows[r] + "m";
			var td3 = document.createElement("td");
			td3.id = "twicktip_" + rows[r] + "r";
			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			tbody.appendChild(tr);
		}
		table.appendChild(tbody);
		twicktip.appendChild(table);
		document.getElementsByTagName("body")[0].appendChild(twicktip);
		twicktip = document.getElementById('twicktip');
	
        document.getElementById('twicktip').style.display="none";


        if (inX < 0){
            inX = 0;
        }
        if (inY < 0){
            inY = 0;
        }
        twicktip.style.top=inY + "px";
        twicktip.style.left=inX + "px";
        twicktip.style.position="absolute";
        twicktip.style.display="none";


   
    },

    fill: function(inText, inClose) {
        TwickitBubble.stopFadding = true;
        document.getElementById("twicktip").style.display = "block";
        document.getElementById("twicktip").style.opacity = '1';
        document.getElementById("twicktip").style.filter = 'alpha(opacity = 100)';
        document.getElementById("twicktip_mm").innerHTML = inText;
        if (inClose) {
            TwickitBubble.fadeOut("twicktip", 4000.0);
        }
    },

    fadeOut: function(inElementId, inTimeToFade) {
        TwickitBubble.stopFadding = false;
        element.FadeTimeLeft = inTimeToFade;
        var element =  typeof inElementId == object ? inElementId : document.getElementById(inElementId);
        setTimeout("TwickitBubble.animateFade(" + new Date().getTime() + ",'" + inElementId + "', " + inTimeToFade + ")", 33);
    },

    animateFade: function(inLastTick, inElementId, inTimeToFade) {
        var curTick = new Date().getTime();
        var elapsedTicks = curTick - inLastTick;

        var element = document.getElementById(inElementId);

        if(TwickitBubble.stopFadding || element.FadeTimeLeft <= elapsedTicks) {
            element.style.display="none";
            element.style.opacity = '1';
            element.style.filter = 'alpha(opacity = 100)';
            return;
        }

        element.FadeTimeLeft -= elapsedTicks;
        var newOpVal = element.FadeTimeLeft/inTimeToFade;

        element.style.opacity = newOpVal;
        element.style.filter = 'alpha(opacity = ' + (newOpVal*100) + ')';

        setTimeout("TwickitBubble.animateFade(" + curTick + ",'" + inElementId + "', "+ inTimeToFade + ")", 33);
    }
}