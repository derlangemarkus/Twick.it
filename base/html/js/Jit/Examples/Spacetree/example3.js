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
    var infovis = document.getElementById('infovis');
    var w = infovis.offsetWidth, h = infovis.offsetHeight;
    //init data
    var json = {
        id: "node02",
        name: "0.2",
        data: {},
        children: [
            {
	            id: "node13",
	            name: "1.3",
	            data: {},
	            children: []
	        },
	        {
	            id: "node14",
	            name: "1.4",
	            data: {},
	            children: []
	        }
        ]
    };
    //end
    var removing = false;
    //init canvas
    //Create a new canvas instance.
    var canvas = new Canvas('mycanvas', {
        'injectInto': 'infovis',
        'width': w,
        'height': h,
        'backgroundColor': '#1a1a1a'
    });
    //end
    
    //init st
    //Create a new ST instance
    var st = new ST(canvas, {
        //add styles/shapes/colors
        //to nodes and edges
        
        //set overridable=true if you want
        //to set styles for nodes individually 
        Node: {
          overridable: true,
          width: 60,
          height: 20,
          color: '#ccc'  
        },
        //change the animation/transition effect
        transition: Trans.Quart.easeOut,
        
        onBeforeCompute: function(node){
            Log.write("loading " + node.name);
        },
        
        onAfterCompute: function(node){
            Log.write("done");
        },

        //This method is triggered on label
        //creation. This means that for each node
        //this method is triggered only once.
        //This method is useful for adding event
        //handlers to each node label.
        onCreateLabel: function(label, node){
            //add some styles to the node label
            var style = label.style;
            label.id = node.id;
            style.color = '#333';
            style.fontSize = '0.8em';
            style.textAlign = 'center';
            style.width = "60px";
            style.height = "20px";
            label.innerHTML = node.name;
            //Delete the specified subtree 
            //when clicking on a label.
            //Only apply this method for nodes
            //in the first level of the tree.
            if(node._depth == 1) {
                style.cursor = 'pointer';
                label.onclick = 
                	function() {
                        subtree = {
                        		id: "node13",
                	            name: "1.3",
                	            data: {},
                	            children: [
                                    {
                        	            id: "neu13",
                        	            name: "n1.3",
                        	            data: {},
                        	            children: []
                        	        },
                        	        {
                        	            id: "neu14",
                        	            name: "n1.4",
                        	            data: {},
                        	            children: []
                        	        }
                                ]
                            };
                        st.op.sum(subtree, {  
                        	   type: 'fade:seq',  
                        	   duration: 1000,  
                        	   hideLabels: false,  
                        	   transition: Trans.Quart.easeOut  
                        	 });
                    };
            };
        },
        //This method is triggered right before plotting a node.
        //This method is useful for adding style 
        //to a node before it's being rendered.
        onBeforePlotNode: function(node) {
            if (node._depth == 1) {
                node.data.$color = '#f77';
            }
        }
    });
    //load json data
    st.loadJSON(json);
    //compute node positions and layout
    st.compute();
    //optional: make a translation of the tree
    st.geom.translate(new Complex(-200, 0), "startPos");
    //Emulate a click on the root node.
    st.onClick(st.root);
    //end
    
}
