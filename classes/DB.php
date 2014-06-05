<?php

class DB {
	private $this->handler;
	public function __construct($handler) { 
		$this->handler = $handler;
		/* Make sure this is in init file.
		try {
			
			// ian's version $this->handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
			$this->handler = new PDO('mysql:host=127.0.0.1;dbname=cite', 'root', 'root');
			$this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo $e->getMessage();
			die("sorry, database problem");
		}
		*/
	}	


	public function put($table, $conditions = array()) {
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
			$insert = rtrim($insert, ",");
			$values = rtrim($values, ",");

		}
		$sql = "INSERT INTO links ($insert) VALUES ($values)";
		 
		//example $sql = "INSERT INTO links (deeplink, name, email, orcid, description, datesubmitted, uniquecode) 
		// VALUES (:deeplink, :name, :email, :orcid, :description, NOW(), :uniquecode)";
		echo $sql;
		
		// this should work
		$query->execute($sql);
		
		
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

	/* 
	* The get() method limited to just one search field at the moment. 
	* Perhaps we will need more in the future
	*/
	public function get($table, $field, $code) { 
		$query = $this->handler->query("SELECT * FROM $table WHERE $field = '$code'");
		while ($r = $query->fetchAll(PDO::FETCH_ASSOC)) {
			return $this->r = $r;
		}
	}


	/*
	* You need to run get() method before running the getFirst() method
	*/
	public function getFirst($object) {
		return $this->r[0][$object];
	}

	public function change($table, $conditions = array()) {
		
	}

	/*
	* Count the number of records from a declared search.
	* Limited to one search field.
	*/
	public function count($table, $field, $code) {
		$query = $this->handler->query("SELECT * FROM $table WHERE $field = '$code'");
		return $query->rowCount();
	}


}
/* 


?>
