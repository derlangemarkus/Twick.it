var TwickitAutolink = {
    load: function() {
        if(!document.getElementById("twickit_bubble_js")) {
            var script = document.createElement("script");
            script.setAttribute("type", "text/javascript");
            script.setAttribute("charset", "utf-8");
            script.setAttribute("id", "twickit_bubble_js");
            script.setAttribute("src", "http://static.twick.it/interfaces/js/bubble.js");
            document.getElementsByTagName("head")[0].appendChild(script);
        }
    },

    autolink: function(inNodes, inOptions) {
        if (typeof(inNodes.length)=="undefined") {
            nodes = new Array();
            nodes[0] = inNodes;
        } else {
            nodes = inNodes;
        }
		
        for(var n=0; n<nodes.length; n++) {
            var node = nodes[n];
            if (node.id == null || node.id == "") {
                node.setAttribute("id", "twickidDummyId" + (new Date()).getTime() + Math.round(Math.random()*1000));
            }
            var script = document.createElement("script");
            var src = "http://static.twick.it/interfaces/js/autolink/insert_links_js.php?id=" + node.id + "&text=" + encodeURIComponent(node.innerHTML) + "&minlength=" + inOptions.minLength + "&skipSingleWord=" + (inOptions.skipSingleWord ? 1 : 0) + "&wholeWord=" + (inOptions.wholeWord ? 1 : 0);
            if(inOptions.target) {
                src += "&target=" + inOptions.target;
            }
            script.setAttribute("src", src + "&noCache=" + (new Date()).getTime());
            script.setAttribute("type", "text/javascript");
            script.setAttribute("charset", "utf-8");

            if (inOptions.language) {
                script.src += "&lng=" + inOptions.language;
            } else {
                try {
                    if(twickitLanguage) {
                        script.src += "&lng=" + twickitLanguage;
                    }
                } catch(ignored) {}
            }
            document.getElementsByTagName("head")[0].appendChild(script);
        };
    },
	
    callback: function(inId, inTarget, inInfo) {
		if(inInfo == null || inInfo.length == 0) {
			return;
		}
		
        var twicks = "";		
		for(var i=0; i<inInfo.length; i++) {
			twicks += "<a href='" + inInfo[i].u + "' target='" + inTarget + "' class='twick'>" + inInfo[i].t + "</a>"; 
			if(inInfo[i].g != null) {
				twicks += "&nbsp;<a href='http://maps.google.de/maps?z=12&q=" + inInfo[i].g + "' target='_blank'><img src='http://static.twick.it/html/img/world.png' class='twicktip_geo'/></a>";
			}
			twicks += "<br />" + inInfo[i].d + "<br />";
		}
		
		var element = document.getElementById(inId);
		var link = document.createElement("a");
		link.setAttribute("href", inInfo[0].u);
		link.setAttribute("target", inTarget);
		link.setAttribute("class", "twickit_link");
		
		link.appendChild(document.createTextNode(element.innerHTML));
		
		TwickitAutolink.observe(
			link,
			"mouseover",
			function(inEvent) {
				var target = inEvent.relatedTarget || inEvent.toElement;
				if(target.id.indexOf("twicktip") != -1) {
					return;
				}
				
				var pos = TwickitAutolink.getRect(link);
				tempX = pos.left;
				tempY = pos.top + pos.height/2;
		
				TwickitBubble.open(tempX, tempY, "twickit");
				TwickitBubble.fill(twicks);
				
				TwickitAutolink.observe(
					document.getElementById("twicktip"),
					"mouseout",
					function(inEvent) {
						var target = inEvent.relatedTarget || inEvent.toElement;
						if(!target || target.id.indexOf("twicktip") == -1 && target.parentNode.id.indexOf("twicktip") == -1 && target.parentNode.parentNode.id.indexOf("twicktip") == -1) {
							document.getElementById("twicktip").style.display = "none";
						}
					}
				);
			}
		);
            
		TwickitAutolink.observe(
			link,
			"mouseout",
			function(inEvent) {
				var target = inEvent.relatedTarget || inEvent.toElement;
				if(target.id.indexOf("twicktip") == -1) {
					document.getElementById("twicktip").style.display = "none";
				}
			}
		);
        
		element.innerHTML = "";
		element.appendChild(link);
    },

    observe: function(inObject, inEventType, inFunction) {
        if (inObject.addEventListener) {
            inObject.addEventListener(inEventType, inFunction, false);
        } else if (inObject.attachEvent) {
            inObject["e"+inEventType+inFunction] = inFunction;
            inObject[inEventType+inFunction] = function() {
                inObject["e"+inEventType+inFunction](window.event);
            }
            inObject.attachEvent("on"+inEventType, inObject[inEventType+inFunction]);
        }
    },

	getRect: function(inObject) {
		var r = { top:0, left:0, width:0, height:0 };
		if(!inObject) {
			return r;
		} else if(typeof inObject == 'string' ) {
			inObject = document.getElementById(inObject);
		}

		if(typeof inObject != 'object') {
			return r;
		}

		if(typeof inObject.offsetTop != 'undefined') {
			 r.height = inObject.offsetHeight;
			 r.width = inObject.offsetWidth;
			 r.left = r.top = 0;
			 while (inObject && inObject.tagName != 'BODY') {
				  r.top  += parseInt(inObject.offsetTop);
				  r.left += parseInt(inObject.offsetLeft);
				  inObject = inObject.offsetParent;
			 }
		}
		return r;
	},
	
    getElementsByClassName: function (className, tag, elm) {
        if (document.getElementsByClassName) {
            getElementsByClassName = function (className, tag, elm) {
                elm = elm || document;
                var elements = elm.getElementsByClassName(className),
                nodeName = (tag)? new RegExp("\\b" + tag + "\\b", "i") : null,
                returnElements = [],
                current;
                for(var i=0, il=elements.length; i<il; i+=1){
                    current = elements[i];
                    if(!nodeName || nodeName.test(current.nodeName)) {
                        returnElements.push(current);
                    }
                }
                return returnElements;
            };
        }
        else if (document.evaluate) {
            getElementsByClassName = function (className, tag, elm) {
                tag = tag || "*";
                elm = elm || document;
                var classes = className.split(" "),
                classesToCheck = "",
                xhtmlNamespace = "http://www.w3.org/1999/xhtml",
                namespaceResolver = (document.documentElement.namespaceURI === xhtmlNamespace)? xhtmlNamespace : null,
                returnElements = [],
                elements,
                node;
                for(var j=0, jl=classes.length; j<jl; j+=1){
                    classesToCheck += "[contains(concat(' ', @class, ' '), ' " + classes[j] + " ')]";
                }
                try	{
                    elements = document.evaluate(".//" + tag + classesToCheck, elm, namespaceResolver, 0, null);
                }
                catch (e) {
                    elements = document.evaluate(".//" + tag + classesToCheck, elm, null, 0, null);
                }
                while ((node = elements.iterateNext())) {
                    returnElements.push(node);
                }
                return returnElements;
            };
        }
        else {
            getElementsByClassName = function (className, tag, elm) {
                tag = tag || "*";
                elm = elm || document;
                var classes = className.split(" "),
                classesToCheck = [],
                elements = (tag === "*" && elm.all)? elm.all : elm.getElementsByTagName(tag),
                current,
                returnElements = [],
                match;
                for(var k=0, kl=classes.length; k<kl; k+=1){
                    classesToCheck.push(new RegExp("(^|\\s)" + classes[k] + "(\\s|$)"));
                }
                for(var l=0, ll=elements.length; l<ll; l+=1){
                    current = elements[l];
                    match = false;
                    for(var m=0, ml=classesToCheck.length; m<ml; m+=1){
                        match = classesToCheck[m].test(current.className);
                        if (!match) {
                            break;
                        }
                    }
                    if (match) {
                        returnElements.push(current);
                    }
                }
                return returnElements;
            };
        }
        return getElementsByClassName(className, tag, elm);
    }
};

TwickitAutolink.observe(window, "load", function() {
    TwickitAutolink.load();
    TwickitAutolink.autolink(TwickitAutolink.getElementsByClassName("twickit"), {
        minLength:1
    });
    TwickitAutolink.autolink(document.getElementsByTagName("Twick:it"), {
        minLength:1,
        wholeWord:true
    });
    TwickitAutolink.autolink(document.getElementsByTagName("it"), {
        minLength:1,
        wholeWord:true
    });
});