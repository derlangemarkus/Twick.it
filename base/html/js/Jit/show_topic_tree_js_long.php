<?php
header('Content-Type: text/javascript'); 
require_once '../../../util/inc.php';
?>
var Log = {
    elem: false,
    write: function(text){
        if (!this.elem) 
            this.elem = document.getElementById('log');
        this.elem.innerHTML = text;
        this.elem.style.left = (100 - this.elem.offsetWidth / 2) + 'px';
    }
};
var treeInit = false;
var magicTree;
var computeCounter = 0;
function init() {
	if (treeInit) {
		return;
	}
	treeInit = true;
    //init data
    <?php 
    $topic = array_pop(Topic::fetchByTitle(getArrayElement($_GET, "title")));
    if (!$topic) {
    	$topic = new Topic();
    	$topic->setTitle(getArrayElement($_GET, "title"));
    }
    ?>
    var json = {
        id: "<?php echo(strtolower($topic->getTitle())) ?>",
        name: "<?php echo(strtolower($topic->getTitle())) ?>",
        data: {},
        children: [
        <?php 
        $separator = "";
        foreach(array_keys($topic->getTags()) as $tag) {
        	if ($tag == "") {
        		continue;
        	}
        	echo($separator);
        ?>
            {
	            id: "<?php echo(strtolower($tag)) ?>",
	            name: "<?php echo(strtolower($tag)) ?>",
	            data: {},
	            children: []
	        }
	    <?php 
	     	$separator = ",";
        }
        ?>
        ]
    };
    //end
    
    
    var readTree = (function() {
        	return function(nodeId, level, onComplete) {
        		var title = nodeId;
        		var startIndex = title.indexOf("@@");
        		if (startIndex < 0) {
        			startIndex = 0;
        		} else {
        			startIndex += 2;
        		}
        		title = title.substr(startIndex);
        		
                var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/tree.php?title=" + encodeURIComponent(title) + "&idprefix=" + (new Date().getTime()) + "@@<?php if(getArrayElement($_GET, "stemming")) { echo("&stemming=1"); } ?>";
				new Ajax.Request(
					url, 
					{
						method: 'get',
					  	onSuccess: function(transport) {
					  		var json = transport.responseText;
					    	var subtree = eval("(" + json + ")");
						    onComplete.onComplete(nodeId, subtree); 
				  		}	
					}
				);
           	};
    })();
    
    
    var infovis = document.getElementById('infovis');
    var w = infovis.offsetWidth, h = infovis.offsetHeight;
    //init canvas
    //Create a new canvas instance.
    var canvas = new Canvas('mycanvas', {
        'injectInto': 'infovis',
        'width': w,
        'height': h,
        'top' : '-20px',
        'backgroundColor': '#FFFFFF'
    });
    //end
    
    
    //Implement a node rendering function called 'nodeline' that plots a straight line
    //when contracting or expanding a subtree.
    ST.Plot.NodeTypes.implement({
        'nodeline': function(node, canvas, animating) {
            if(animating === 'expand' || animating === 'contract') {
                var pos = node.pos.getc(true), nconfig = this.node, data = node.data;
                var width  = nconfig.width, height = nconfig.height;
                var algnPos = this.getAlignedPos(pos, width, height);
                var ctx = canvas.getCtx(), ort = this.config.orientation;
                ctx.beginPath();
                if(ort == 'left' || ort == 'right') {
                    ctx.moveTo(algnPos.x, algnPos.y + height / 2);
                    ctx.lineTo(algnPos.x + width, algnPos.y + height / 2);
                } else {
                    ctx.moveTo(algnPos.x + width / 2, algnPos.y);
                    ctx.lineTo(algnPos.x + width / 2, algnPos.y + height);
                }
                ctx.stroke();
            } 
        }
    });

    //init st
    //Create a new ST instance
    var st = new ST(canvas, {
   		siblingOffset: 0,  
    	orientation: "top",  
        //set duration for the animation
        duration: 200,
        //set animation transition type
        transition: Trans.Quart.easeInOut,
        //set distance between node and its children
        levelDistance: 30,
        //set max levels to show. Useful when used with
        //the request method for requesting trees of specific depth
        levelsToShow: 2,
        //set node and edge styles
        //set overridable=true for styling individual
        //nodes or edges
        Node: {
            height: 20,
            width: 80,
            //use a custom
            //node rendering function
            type: 'nodeline',
            color:'#6B8F00',
            lineWidth: 2,
            align:"center",
            overridable: true
        },
        
        Edge: {
            type: 'bezier',
            lineWidth: 2,
            color:'#6B8F00',
            overridable: true
        },
        
        //Add a request method for requesting on-demand json trees. 
        //This method gets called when a node
        //is clicked and its subtree has a smaller depth
        //than the one specified by the levelsToShow parameter.
        //In that case a subtree is requested and is added to the dataset.
        //This method is asynchronous, so you can make an Ajax request for that
        //subtree and then handle it to the onComplete callback.
        //Here we just use a client-side tree generator (the getTree function).
        request: function(nodeId, level, onComplete) {
          	readTree(nodeId, level, onComplete);
        },
        
        onBeforeCompute: function(node){
            Log.write("loading " + node.name);
        },
        
        onAfterCompute: function() {
            Log.write("");
            var node = Graph.Util.getClosestNodeToOrigin(st.graph, "pos");
           	
           	if (computeCounter>2) {
           		updateContent(node.name);
           	}
           	computeCounter++;
           	
           	var output = "<a href='javascript:;' onclick='updateContent(\"" + node.name + "\");magicTree.onClick(\"" + node.id + "\");'>" + node.name + "</a>";
           	var parents = Graph.Util.getParents(node);
           	while (parents.length > 0) {
           		output = "<a href='javascript:;' onclick='updateContent(\"" + parents[0].name + "\");magicTree.onClick(\"" + parents[0].id + "\");'>" + parents[0].name + "</a>" + " &raquo; " + output;
           		parents = Graph.Util.getParents(parents[0]);
           	}
           	$('tree_path').update(output);
        },
        onCreateLabel: function(label, node){
            label.id = node.id;            
            label.innerHTML = node.name;
            var isTopNode = label.innerHTML == "<?php echo(strtolower(getArrayElement($_GET, "title"))) ?>";
            if (label.innerHTML.length > 14 && !isTopNode) {
            	label.innerHTML = label.innerHTML.substring(0, 14) + "...";
            }
            label.onclick = function(){
                st.onClick(node.id);
            };
            //set label styles
            var style = label.style;
            if (isTopNode) {
            	style.width = 860 + 'px';
            	style.marginLeft = '-390px';
                style.border = 'none';
                style.backgroundImage = 'none';
                style.fontSize = "14px";
                style.fontWeight = "bold";
            } 
            label.title = node.name;
        },
        
        //This method is called right before plotting
        //a node. It's useful for changing an individual node
        //style properties before plotting it.
        //The data properties prefixed with a dollar
        //sign will override the global node style properties.
        onBeforePlotNode: function(node){
            //add some color to the nodes in the path between the
            //root node and the selected node.
            if (node.selected) {
                node.data.$color = "#ff7";
            } else {
                delete node.data.$color;
            }
        },
        
        //This method is called right before plotting
        //an edge. It's useful for changing an individual edge
        //style properties before plotting it.
        //Edge data proprties prefixed with a dollar sign will
        //override the Edge global style properties.
        onBeforePlotLine: function(adj){
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#000";
                adj.data.$lineWidth = 4;
            } else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
        }
    });
    //load json data
    st.loadJSON(json);
    //compute node positions and layout
    st.compute();
    //emulate a click on the root node.
    st.onClick(st.root);
    //end
    //Add event handlers to switch spacetree orientation.
   	function get(id) {
    	return document.getElementById(id);  
    };
    
    magicTree = st;
  
    //end

}
