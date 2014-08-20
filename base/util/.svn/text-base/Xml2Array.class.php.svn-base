<?php
class Xml2Array {
	
	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
	var $path;
    var $result;


    // ---------------------------------------------------------------------
	// ----- Konstruktor ---------------------------------------------------
	// ---------------------------------------------------------------------
    function Xml2Array($data, $encoding="utf-8") {
        $this->path = "\$this->result";
        $this->index = 0;
      
        $xml_parser = xml_parser_create($encoding);
        xml_set_object($xml_parser, $this);
        xml_set_element_handler($xml_parser, '_startElement', '_endElement');
        xml_set_character_data_handler($xml_parser, '_characterData');

        xml_parse($xml_parser, $data, true);
        xml_parser_free($xml_parser);
    }
  
    
    // ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	function getArray() {
    	return $this->result;
    }
    
    
    // ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
    function _startElement($inParser, $inTag, $inAttributeList) {
        $this->path .= "->".$inTag;
        eval("\$data = ".$this->path.";");
        if (is_array($data)) {
            $index = sizeof($data);
            $this->path .= "[".$index."]";
        } else if (is_object($data)) {
            eval($this->path." = array(".$this->path.");");
            $this->path .= "[1]";
        }

        /*foreach($inAttributeList as $name => $value) {
        	$clean = Xml2Array::_cleanString($value);
       		eval($this->path."->".$name. " = '".$clean."';");
        }*/
    }
    
  
    function _endElement($inParser, $inTag) {
        $this->path = substr($this->path, 0, strrpos($this->path, "->"));
    }
  
    
    function _characterData($inParser, $inData) {
        if (strlen($inData = Xml2Array::_cleanString($inData)))
            eval($this->path." .= '$inData';");
    }
    
    
    function _cleanString($inString) {
        return trim(str_replace("'", "&#39;", $inString));
    }
    
}
?>