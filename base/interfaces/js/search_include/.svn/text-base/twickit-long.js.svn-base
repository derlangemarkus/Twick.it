var TwickitSearchInclude = {
	theme : "twickit",

	load: function() {
        var myself = "";
		var js = /search_include\/twickit.js(\?.*)?$/;

        var scripts = document.getElementsByTagName("script");
        for(var i=0; i<scripts.length; i++) {
            var s = scripts[i];
            if(s.src.match(js)) {
                var themes = s.src.match(/\?.*theme=([a-z,]*)/);
                var theme = themes ? themes[1] : "twickit";
                TwickitSearchInclude.theme = theme;
                myself = s;
            }
        }

		TwickitSearchInclude.observe(window, 'load', function() {
            var search = document.createElement("div");
            search.setAttribute("id", "twickit_search");
            search.innerHTML = "<form action='' id='twickit_searchform'><input type='text' name='search' id='twickit_search_include_searchterm' autocomplete='off'/></form><div id='twickit_search_include_wait' style=' display:none;'></div><div style='clear:both;'></div><div id='twickit_search_include_results'></div>";
            myself.parentNode.appendChild(search);

            TwickitSearchInclude.observe(
                document.getElementById('twickit_search_include_searchterm'),
                'keyup',
                function(inEvent) {
                    TwickitSearchInclude.startSearch(document.getElementById('twickit_search_include_searchterm').value);
                }
            );

            // CSS + JavaScript-Include
            if (document.getElementById('twickit_fill_results_js') != null) {
                var element = document.getElementById('twickit_fill_results_js');
                element.parentNode.removeChild(element);
            }

            if (TwickitSearchInclude.theme != "custom") {
                if (document.getElementById('twickit_search_include_css') != null) {
                    var element = document.getElementById('twickit_search_include_css');
                    element.parentNode.removeChild(element);
                }

                var css = document.createElement("link");
                css.setAttribute("type", "text/css");
                css.setAttribute("id", "twickit_search_include_css");
                css.setAttribute("rel", "stylesheet");
                css.setAttribute("href", "http://twick.it/interfaces/js/search_include/theme_" + TwickitSearchInclude.theme + ".css");
                document.getElementsByTagName("head")[0].appendChild(css);
            }
        });
	},

    startSearch: function(inText) {
        document.getElementById("twickit_search_include_wait").style.display = 'block';
        if (document.getElementById('twickit_search_include_fill_results_js') != null) {
            var element = document.getElementById('twickit_search_include_fill_results_js');
            element.parentNode.removeChild(element);
        }
        if (inText.replace(/^\s+/, '').replace(/\s+$/, '') == "") {
            TwickitSearchInclude.callback("");
        } else {
            var script = document.createElement("script");
            script.setAttribute("type", "text/javascript");
            script.setAttribute("charset", "utf-8");
            script.setAttribute("id", "twickit_search_include_fill_results_js");
            script.setAttribute("src", "http://twick.it/interfaces/js/search_include/twickit_fill_results_js.php?text=" + encodeURIComponent(inText.replace(/^\s+/, '').replace(/\s+$/, '')) + "&noCache=" + (new Date()).getTime());

            try {
                if(twickitLanguage) {
                    script.src += "&lng=" + twickitLanguage;
                }
            } catch(ignored) {}

            document.getElementsByTagName("head")[0].appendChild(script);
        }
    },

	callback: function(inText) {
        document.getElementById("twickit_search_include_wait").style.display="none";
        var text = inText;
        text += "<br /><a href='http://twick.it";
        try {
            if(twickitLanguage) {
                text += "?lng=" + twickitLanguage;
            }
        } catch(ignored) {}
        text += "' target='blank' title='powerd by Twick.it' style='font-style:italic;'>powered by <img src='http://twick.it/interfaces/js/search_include/logo.png  ' border='0' alt='Twick.it'/></a>"
		document.getElementById("twickit_search_include_results").innerHTML = text;
	},

    observe: function(inObject, inEventType, inFunction) {
        if (inObject.addEventListener) {
            inObject.addEventListener(inEventType, inFunction, false);
        } else if (inObject.attachEvent) {
            inObject["e"+inEventType+inFunction] = inFunction;
            inObject[inEventType+inFunction] = function() {inObject["e"+inEventType+inFunction](window.event);}
            inObject.attachEvent("on"+inEventType, inObject[inEventType+inFunction]);
        }
    }
}

TwickitSearchInclude.load();