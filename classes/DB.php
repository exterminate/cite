<?php

class DB {
	private $handler;
	public function __construct($handler) { 
		$this->handler = $handler;
	}	


	public function put($table, $stub) {

		 $sql = "INSERT INTO links (stubId, firstName, surname, email, orcid, description, datesubmitted, deepLink) 
		 VALUES (:stubId, :firstName, :surname, :email, :orcid, :description, :datesubmitted, :deepLink)";
	
		$query = $this->handler->prepare($sql);
		$query->execute(array(
			':stubId' 		=> $stub->stubId,
			':firstName' 	=> $stub->firstName,
			':surname' 		=> $stub->surname,
			':email' 		=> $stub->email,
			':orcid'		=> $stub->orcid,
			':description' 	=> $stub->description,
			':datesubmitted'=> $stub->datesubmitted,
			':deepLink'		=> $stub->deepLink
		));	
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

	public function getUniqueCode($type) { //create a string, and checks it doesn't exist in database

		if($type == "stubId") {
			$length = 8;
		} elseif($type == "deepLink") {
			$length = 12;
		} else {
			die("You have not entered a valid variable.");
		}

		// generate random string
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }


		//GETTING ROW COUNT
		$query = $this->handler->query("SELECT $type FROM links WHERE $type = '$randomString'");
		
		while($query->rowCount() == 0) {
			return $randomString;
		}

	}

}


?>
