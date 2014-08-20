<?php

require_once("class-basebar.php");

class Postbar extends Basebar {

		function __construct($paged, $max_page) {
				parent::__construct($paged, $max_page);
				$this->div_name = "pagebar";
				$this->display();
		}  // function __construct()
		
		
		function Postbar($paged, $max_page) {
				$this->__construct($paged, $max_page);
		}
		// -------------------------------------------------------------------------
		
		function leave() {
				if ($this->max_page <= 1) // only one page -> don't display postbar
				  return 1;
				return 0;
		}
	
		// -------------------------------------------------------------------------	

} //class Postbar

?>