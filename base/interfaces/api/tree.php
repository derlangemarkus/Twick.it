<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

header("Content-Type: application/json; charset=utf-8"); 
$idPrefix = getArrayElement($_GET, "idprefix", "");
$title = getArrayElement($_GET, "title");
$prettyPrint = getArrayElement($_GET, "prettyPrint", 0) == 1;
$level = getArrayElement($_GET, "level");

$topic = array_pop(Topic::fetchByTitle($title));
if ($topic) {
	$title = $topic->getTitle();
	$tags = array_keys($topic->getTags());
} else {
	$tags = array();
}

if (!$prettyPrint) {
	ob_start("uglyPrint");
}

?>
{
	id:"<?php jecho($title) ?>",
    name:"<?php jecho($title) ?>",
    level:"<?php jecho($level) ?>",
    data:{},
    children: [
    <?php 
    $separator = "";
    foreach($tags as $tag) {
    	if ($tag == ""){
    		continue;
    	}
    	echo($separator);
    ?>
    	{
        	id:"<?php jecho($idPrefix.$tag) ?>",
            name:"<?php jecho($tag) ?>",
            level:"<?php jecho($level+1) ?>",
            data:{},
            children:[]
        }
    <?php 
    	$separator = ",";
    }
    ?>
    ]
}
<?php
ob_end_flush();
?>