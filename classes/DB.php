<?php

class DB {

	public function __construct() {
		try {
			// ian's version $this->handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
			$this->handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
			$this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo $e->getMessage();
			die("sorry, database problem");
		}
	}	


	public function write($table, $conditions = array()) {
		if(count($conditions) % 2 == 0) {
			$insert = "";
			$values = "";
			$iterate = 1;
			foreach ($conditions as $condition) {
				if($iterate % 2 != 0) {
					$insert .= $condition.",";
				} else {
					$values .= $condition.",";				
				}
			}
			// remove trailing commas

		}
		$sql = "INSERT INTO links ($insert) VALUES ($values)";
		 
		//example $sql = "INSERT INTO links (deeplink, name, email, orcid, description, datesubmitted, uniquecode) 
		// VALUES (:deeplink, :name, :email, :orcid, :description, NOW(), :uniquecode)";
		echo $sql;
		/*	
		$query = $this->handler->prepare($sql);
		$query->execute(array(
			':deeplink' 	=> $deeplink,
			':name' 		=> $name,
			':email' 		=> $email,
			':orcid'		=> $orcid,
			':description' 	=> $description,
			':uniquecode'	=> $uniquecode
		));
		*/
	}

	public function read($table, $field, $code) {	
		$query = $this->handler->query("SELECT * FROM $table WHERE $field = '$code'");
		while ($r = $query->fetchAll(PDO::FETCH_ASSOC)) {
			return $this->r = $r;
		}
	}

	public function first($object) {
		return $this->r[0][$object];
	}
/*
	public function edit($table, $conditions = array()) {
		
	}
*/
	public function count($table, $field, $code) {
		$query = $this->handler->query("SELECT * FROM $table WHERE $field = '$code'");
		return $query->rowCount();
	}


}
/* 
*  COLUMNS NEEDED
*  id, linkid, name, email, orcid (required), datesubmitted, doi, datedoi
*  any more?
*/

?>