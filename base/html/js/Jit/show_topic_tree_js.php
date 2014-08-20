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
var canvas = new Canvas('mycanvas', {
'injectInto': 'infovis',
'width': w,
'height': h,
'top' : '-20px',
'backgroundColor': '#FFFFFF'
});
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
var st = new ST(canvas, {
siblingOffset: 0,
orientation: "top",
duration: 200,
transition: Trans.Quart.easeInOut,
levelDistance: 30,
levelsToShow: 2,
Node: {
height: 20,
width: 80,
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
var style = label.style;
if (isTopNode) {
style.width = 860 + 'px';
style.marginLeft = '-390px';
style.border = "none";
style.backgroundImage = "none";
style.fontSize = "14px";
style.fontWeight = "bold";
} 
label.title = node.name;
},
onBeforePlotNode: function(node){
if (node.selected) {
node.data.$color = "#ff7";
} else {
delete node.data.$color;
}
},
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
st.loadJSON(json);
st.compute();
st.onClick(st.root);
function get(id) {
return document.getElementById(id);
};

magicTree = st;
}