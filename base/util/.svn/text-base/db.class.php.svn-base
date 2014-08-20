<?php
class DB {
	
	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
	private $mysqli;
	private $result;
	
	
	// ---------------------------------------------------------------------
	// ----- Konstruktoren -------------------------------------------------
	// ---------------------------------------------------------------------
	public function &getInstance() {
		static $instance;
		if (!isset($instance)) {
			$instance = new DB();
			try {
				$instance->mysqli = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			} catch(Exception $exception) {
				echo("Connect failed: " . mysqli_connect_error() . "<br />\n");
			}
			if (mysqli_connect_errno()) {
			    echo("Connect failed: " . mysqli_connect_error() . "<br />\n");
			}
		}
		return $instance;
	}
	
	
	public function __destruct() {
		if ($this->result != null) {
			$this->result->close();
		}
		$this->mysqli->close();
	}
	
	function query($inSQL) {
		$this->result = $this->mysqli->query(removeShy($inSQL));
		return $this->result;
	}
	
	
	public function execute($inSQL) {
		$this->mysqli->query(removeShy($inSQL));
		return $this->mysqli->insert_id;
	}
	
	
	public function getNextResult() {
		return $this->result->fetch_array();
	}
	
	
	public function realEscapeString($inText) {
		return $this->mysqli->real_escape_string($inText);
	}
}