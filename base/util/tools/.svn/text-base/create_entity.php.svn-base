<?php

require_once("../inc.php");
/*
 * Created at 01.06.2007
 *
 * @author Markus Moeller - Twick.it
 */
function _findAttributes() {
	global $tableName, $hasLanguageCode, $sortIndexAttribute, $zuordnung;

	$attr = array();
	$db =& DB::getInstance();
	$db->query("DESCRIBE $tableName");
	while ($result = $db->getNextResult()) {
		$fieldName = $result["Field"];
		array_push($attr, $fieldName);
		if (strcasecmp($fieldName, "folge")==0 || strcasecmp($fieldName, "sort_index")==0 || strcasecmp($fieldName, "sort_id")==0 || strcasecmp($fieldName, "sort_order")==0) {
			$sortIndexAttribute = $fieldName;
		} else if (strcasecmp($fieldName, "language_code")==0) {
			$hasLanguageCode = true;
		} else if (strcasecmp($fieldName, "zuordnung")==0 || strcasecmp($fieldName, "zuorder")==0 || strcasecmp($fieldName, "menu_id")==0 || strcasecmp($fieldName, "site_id")==0) {
			$zuordnung = $fieldName;
		}
	}
	return $attr;
}




$tableName = $_GET["table"];
$moduleName = getArrayElement($_GET, "module");
$hasTranslator = isset($_GET["translator"]);
$tableShortName = $tableName;
if ($moduleName) {
	$tableShortName = substr($tableName, strlen($moduleName)+1);
}
$tableNameWithoutPrefix = strpos($tableShortName, "tbl_")===0 ? substr($tableShortName, 4) : $tableShortName;


$className = toCamelWord($tableNameWithoutPrefix);
if (!isset($_GET["isSingular"]) && substr($className, strlen($className)-1) == "s") {
	$className = substr($className, 0, strlen($className)-1);
}
$variableName = toCamelWord(strtolower($className), false);
$fileName = "$className.class.php";
$sortIndexAttribute = "";
$hasLanguageCode = false;
$zuordnung = false;
$attributes = _findAttributes();






$code = "<?php
/*
 * Created at " . date("d.m.Y") . "
 *
 * @author Markus Moeller - Twick.it
 */
\n";
$code .= "class $className" . "Stub extends AbstractDatabaseObject {\n\n";

$code .= "\t// ---------------------------------------------------------------------\n";
$code .= "\t// ----- Getter/Setter -------------------------------------------------\n";
$code .= "\t// ---------------------------------------------------------------------\n";
foreach($attributes as $attribute) {
	$code .= "\tpublic function get" . toCamelWord($attribute) . "() {\n";
	$code .= "\t\treturn \$this->_getValueForKey(\"$attribute\");\n";
	$code .= "\t}\n\n";

	$code .= "\tpublic function set" . toCamelWord($attribute) . "(\$in" . toCamelWord($attribute) . ") {\n";
	$code .= "\t\t\$this->_setValueForKey(\"$attribute\", \$in" .toCamelWord($attribute) . ");\n";
	$code .= "\t}\n\n\n";
}


if ($hasTranslator) {
	$code .= "\t/* TODO: Lokalisierte Attribute einfuegen!!! */\n";
	$code .= "\tpublic function getDUMMY(\$inLangCode=\"\") {\n";
	$code .= "\t\t\$translator = $className::getTranslator();\n";
	$code .= "\t\treturn \$translator->translate(\$this->getId(), \"__DUMMY__\", \$inLangCode);\n";
	$code .= "\t}\n\n";

	$code .= "\tpublic function setDUMMY(\$inDUMMY, \$inLangCode=\"\") {\n";
	$code .= "\t\t\$translator = $className::getTranslator();\n";
	$code .= "\t\t\$translator->setTranslation(\$this->getId(), \"__DUMMY__\", \$inLangCode, \$inDUMMY);\n";
	$code .= "\t}\n\n\n";
}



$code .= "\t// ---------------------------------------------------------------------\n";
$code .= "\t// ----- Oeffentliche Methoden -----------------------------------------\n";
$code .= "\t// ---------------------------------------------------------------------\n";

if($sortIndexAttribute) {
	$code .= "\tpublic function change" . toCamelWord($sortIndexAttribute) . "(\$inNewSortIndex) {\n";
	$code .= "\t\t\$oldSortIndex = \$this->get" . toCamelWord($sortIndexAttribute) . "();\n";
	$code .= "\t\tif (\$inNewSortIndex < \$oldSortIndex) {\n";
	
	$additionalSQL = "";
	if ($zuordnung) {
		$additionalSQL .= " AND $zuordnung=\" . \$this->get" . toCamelWord($zuordnung) . "() . \"";
	}
	if ($hasLanguageCode) {
		$additionalSQL .= " AND language_code='\" . \$this->getLanguageCode() . \"'";
	}
	
	$code .= "\t\t\texecuteSQL(\"UPDATE \" . $className::_getDatabaseName() . \" SET $sortIndexAttribute=$sortIndexAttribute+1 WHERE $sortIndexAttribute>=\$inNewSortIndex AND $sortIndexAttribute<\$oldSortIndex$additionalSQL\");\n";
	$code .= "\t\t} else if (\$inNewSortIndex > \$oldSortIndex) {\n";
	$code .= "\t\t\texecuteSQL(\"UPDATE \" . $className::_getDatabaseName() . \" SET $sortIndexAttribute=$sortIndexAttribute-1 WHERE $sortIndexAttribute>\$oldSortIndex AND $sortIndexAttribute<=\$inNewSortIndex$additionalSQL\");\n";
	$code .= "\t\t} else {\n";
	$code .= "\t\t\treturn;\n";
	$code .= "\t\t}\n";
	$code .= "\t\t\$this->set" . toCamelWord($sortIndexAttribute) . "(\$inNewSortIndex);\n";
	$code .= "\t\t\$this->save();\n";
	$code .= "\t}\n\n\n";
}


$code .= "\tpublic public function fetchById(\$inId) {\n";
$code .= "\t\treturn array_pop($className::fetch(array(\"id\"=>\$inId)));\n";
$code .= "\t}\n\n\n";

if ($zuordnung) {
	$code .= "\tpublic public function fetchBySiteId(\$inSiteId) {\n";
	$code .= "\t\treturn $className::fetch(array(\"$zuordnung\"=>\$inSiteId));\n";
	$code .= "\t}\n\n\n";
}

$code .= "\tpublic public function fetchAll(\$inOptions=array()) {\n";
$code .= "\t\treturn $className::fetch(array(), " . ($hasLanguageCode ? "false, " : "") . "\$inOptions);\n";
$code .= "\t}\n\n\n";

$code .= "\tpublic public function fetch(\$inBindings" . ($hasLanguageCode ? ", \$inAllLanguages=false" : "") . ", \$inOptions=array()) {\n";
$code .= "\t\treturn $className::_fetch(AbstractDatabaseObject::_buildSQL($className::_getDatabaseName(), \$inBindings, \$inOptions)" . ($hasLanguageCode ? ", \$inAllLanguages" : "") . ");\n";
$code .= "\t}\n\n\n";

$code .= "\tpublic public function fetchBySQL(\$inSQL" . ($hasLanguageCode ? ", \$inAllLanguages=false" : "") . ") {\n";
$code .= "\t\treturn $className::_fetch(\"SELECT * FROM \" . $className::_getDatabaseName() . \" WHERE \$inSQL\"" . ($hasLanguageCode ? ", \$inAllLanguages" : "") . ");\n";
$code .= "\t}\n\n\n";


if ($sortIndexAttribute || $hasTranslator) {
	$code .= "\tpublic function delete() {\n";
	$code .= "\t\tparent::delete();\n\n";
	if ($sortIndexAttribute) {
		$code .= "\t\t/* Nachfolger rutschen eins nach vorne */\n";
		$code .= "\t\t\$this->_updateSiblingOrder();\n\n";
	}
	if($hasTranslator) {
		$code .= "\t\t/* Uebersetzungen loeschen */\n";
		$code .= "\t\t\$translator = \$this->getTranslator();\n";
		$code .= "\t\t\$translator->delete(\$this->getId());\n\n";
	}
	$code .= "\t\t/* TODO: Hier evtl. noch weitere Aufraeumarbeiten durchfuehren! */\n";
	$code .= "\t}\n\n\n";
}


if ($zuordnung && $sortIndexAttribute) {
	$code .= "\tpublic function move(\$inNewSiteId) {\n";
	$code .= "\t\t\$newSortIndex = sizeof($className::fetchBy" . toCamelWord($zuordnung) . "(\$inNewSiteId)) + 1;\n";
	$code .= "\t\t\$this->_updateSiblingOrder();\n";
	$code .= "\t\t\$this->set" . toCamelWord($zuordnung) . "(\$inNewSiteId);\n";
	$code .= "\t\t\$this->set" . toCamelWord($sortIndexAttribute) . "(\$newSortIndex);\n";
	$code .= "\t\t\$this->save();\n";
	$code .= "\t}\n\n\n";
}


if ($hasTranslator) {
	$code .= "\tpublic function getTranslator() {\n";
	$code .= "\t\treturn new Translator(\"$className\");\n";
	$code .= "\t}\n\n\n";
}

$code .= "\t// ---------------------------------------------------------------------\n";
$code .= "\t// ----- Private Methoden ----------------------------------------------\n";
$code .= "\t// ---------------------------------------------------------------------\n";
$code .= "\tprotected function _getDatabaseName() {\n";
$code .= "\t\treturn \"$tableName\";\n";
$code .= "\t}\n\n\n";


$code .= "\tprotected function _fetch(\$inSQL" . ($hasLanguageCode ? ", \$inAllLanguages=false" : "") . ") {\n";
$code .= "\t\t\$objects = array();\n";

if ($hasLanguageCode) {
	$code .= "\t\tif (!\$inAllLanguages) {\n";
	$code .= "\t\t\tif (preg_match(\"/^(.*)\s*WHERE\s*(.*?)(ORDER BY .*)?$/\", \$inSQL, \$matches)) {\n";
	$code .= "\t\t\t\t\$select = \$matches[1];\n";
	$code .= "\t\t\t\t\$originalSQL = \$matches[2];\n";
	$code .= "\t\t\t\t\$orderBy = sizeof(\$matches)==4 ? \$matches[3] : \"\";\n";
	$code .= "\t\t\t\t\$inSQL = \$select . \" WHERE (language_code='\" . getLanguage() . \"') AND (\" . \$originalSQL . \") \$orderBy\";\n";
	$code .= "\t\t\t} else {\n";
	$code .= "\t\t\t\t\$inSQL .= \" WHERE language_code='\" . getLanguage() . \"'\";\n";
	$code .= "\t\t\t}\n";
	$code .= "\t\t}\n\n";
}
if (!$sortIndexAttribute) {
	$code .= "/*\n";
}
$code .= "\t\tif (!preg_match(\"/\s*ORDER\sBY\s*/\", \$inSQL)) {\n";
$code .= "\t\t\t\$inSQL .= \" ORDER BY $sortIndexAttribute ASC\";\n";
$code .= "\t\t}\n";
if (!$sortIndexAttribute) {
	$code .= "*/\n";
}
$code .= "\t\t\$db =& DB::getInstance();\n";
$code .= "\t\t\$db->query(\$inSQL);\n";
$code .= "\t\twhile (\$result = \$db->getNextResult()) {\n";
$code .= "\t\t\tarray_push(\$objects, $className::_createFromDB(\$result));\n";
$code .= "\t\t}\n\n";
$code .= "\t\tAbstractDatabaseObject::_setCachedResult(\$inSQL, \$objects);\n";
$code .= "\t\treturn \$objects;\n";
$code .= "\t}\n\n\n";


$code .= "\tprivate function _createFromDB(\$inResult) {\n";
$code .= "\t\t\$$variableName = new $className();\n";
$code .= "\t\t\${$variableName}->_setDatabaseValues(\$inResult);\n";
$code .= "\t\treturn $$variableName;\n";
$code .= "\t}\n\n\n";



if ($sortIndexAttribute) {
	$code .= "\tprivate function _updateSiblingOrder() {\n";
	$code .= "\t\texecuteSQL(\"UPDATE \" . $className::_getDatabaseName() . \" SET $sortIndexAttribute=$sortIndexAttribute-1 WHERE $zuordnung='\" . \$this->get" . toCamelWord($zuordnung) . "() . \"'";
	if ($hasLanguageCode) {
		$code .= " AND language_code='\" . \$this->getLanguageCode() . \"'";
	}
	$code .= " AND $sortIndexAttribute>\" . \$this->get" . toCamelWord($sortIndexAttribute) . "());\n";
	$code .= "\t}\n\n\n";
}


$code .= "}\n?>";





$code .= "\n\n\n\n\n";




$code .= "<?php
/*
 * Created at " . date("d.m.Y") . "
 *
 * @author Markus Moeller - Twick.it
 */

require DOCUMENT_ROOT .\"/entity/stubs/" . $className . "Stub.class.php\";
\n";
$code .= "class $className extends $className" . "Stub {\n\n";

$code .= "\t// ---------------------------------------------------------------------\n";
$code .= "\t// ----- Oeffentliche Methoden -----------------------------------------\n";
$code .= "\t// ---------------------------------------------------------------------\n";

$code .= "}\n?>";













echo("<h1>$fileName</h1>");
echo("<pre>");
if (isset($_GET["highlight"])) {
	highlight_string($code);
} else {
	echo htmlentities($code);
}
echo("</pre>")

?>
