<?php 
require_once '../../../../../util/inc.php';

function printNode($inTitle, $inLevel=1) {
	?>{
        id: "<?php echo($inTitle) ?>",
        name: "<?php echo($inTitle) ?>",
        data: {},
        children: [
        	<?php
        	$topic = array_pop(Topic::fetchByTitle($inTitle));
        	if ($topic) {
        		$separator = "";
        		foreach($topic->getTags() as $tag=>$count) {
        			if ($tag != "" && $inLevel < 6) {
	        			echo($separator);
	        			printNode($tag, $inLevel+1);
	        			$separator = ",";
        			}
        		}
        	} 
        	?>
        ]
      }
<?php 
}
?>      

var Log = {
    elem: false,
    write: function(text){
        if (!this.elem) 
            this.elem = document.getElementById('log');
        this.elem.innerHTML = text;
        this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
    }
};

function addEvent(obj, type, fn) {
    if (obj.addEventListener) obj.addEventListener(type, fn, false);
    else obj.attachEvent('on' + type, fn);
};


function init(){
    //init data
    var json = <?php printNode("rss") ?>;
    //end
    
    var infovis = document.getElementById('infovis');
    var w = infovis.offsetWidth, h = infovis.offsetHeight;
    
    //init canvas
    //Create a new canvas instance.
    var canvas = new Canvas('mycanvas', {
        //Where to append the canvas widget
        'injectInto': 'infovis',
        'width': w,
        'height': h,
        
        //Optional: create a background canvas and plot
        //concentric circles in it.
        'backgroundCanvas': {
            'styles': {
                'strokeStyle': '#555'
            },
            
            'impl': {
                'init': function(){},
                'plot': function(canvas, ctx){
                    var times = 6, d = 100;
                    var pi2 = Math.PI * 2;
                    for (var i = 1; i <= times; i++) {
                        ctx.beginPath();
                        ctx.arc(0, 0, i * d, 0, pi2, true);
                        ctx.stroke();
                        ctx.closePath();
                    }
                }
            }
        }
    });
    //end
    //init RGraph
    var rgraph = new RGraph(canvas, {
        //Set Node and Edge colors.
        Node: {
            color: '#ccddee'
        },
        
        Edge: {
            color: '#772277'
        },


        onBeforeCompute: function(node) {
            Log.write("centering " + node.name + "...");
        },
        
        onAfterCompute: function(){
            Log.write("done");
        },
        //Add the name of the node in the correponding label
        //and a click handler to move the graph.
        //This method is called once, on label creation.
        onCreateLabel: function(domElement, node){
            domElement.innerHTML = node.name;
            domElement.onclick = function(){
                rgraph.onClick(node.id);
            };
        },
        //Change some label dom properties.
        //This method is called each time a label is plotted.
        onPlaceLabel: function(domElement, node){
            var style = domElement.style;
            style.display = '';
            style.cursor = 'pointer';

            if (node._depth <= 1) {
                style.fontSize = "0.8em";
                style.color = "#ccc";
            
            } else if(node._depth == 2){
                style.fontSize = "0.7em";
                style.color = "#494949";
            
            } else {
                style.display = 'none';
            }

            var left = parseInt(style.left);
            var w = domElement.offsetWidth;
            style.left = (left - w / 2) + 'px';
        }
    });
    
    //load JSON data
    rgraph.loadJSON(json);
    //compute positions and make the first plot
    rgraph.refresh();
    //end
    
}
