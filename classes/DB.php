<?php
class DB {
	private $handler;
	public function __construct($handler) { 
		$this->handler = $handler;
	}	


	public function put($table, $stub) {

		 $sql = "INSERT INTO links (stubId, stubTitle, firstName, surname, email, orcid, description, datesubmitted, deepLink) 
		 VALUES (:stubId, :stubTitle, :firstName, :surname, :email, :orcid, :description, :datesubmitted, :deepLink)";

		$query = $this->handler->prepare($sql);
		$query->execute(array(
			':stubId' 		=> $stub->stubId,
			':stubTitle'	=> $stub->stubTitle,
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
	public function getStubs($table, $field, $operator, $code){ 		
		$query = $this->handler->query("SELECT * FROM $table WHERE $field $operator '$code'");
		while ($r = $query->fetchAll(PDO::FETCH_ASSOC)) {
			
			$stubs = array();
			foreach($r as $stub){
				array_push($stubs, new Stub($stub));
			}		
			
			return $stubs;
		}
	}


	/*
	* You need to run get() method before running the getFirst() method
	*/
	public function getStub($field, $code) {

		$query = $this->handler->query("SELECT * FROM links WHERE $field = '$code'");

		while ($r = $query->fetchAll(PDO::FETCH_ASSOC)) {
			
			if($r[0] != null){
				return new Stub($r[0]);			
			} else{
				return null;
			}
		}	
	}

	public function update($table, $field, $stub) {
		$sql = "UPDATE $table SET $field = ? WHERE stubId = ?";
		$query = $this->handler->prepare($sql);		
		$query->execute(array($stub->$field,$stub->stubId));
	}

	/*
	* Count the number of records from a declared search.
	* Limited to one search field.
	*/
	public function count($table, $field, $operator, $code) {
		$query = $this->handler->query("SELECT * FROM $table WHERE $field $operator '$code'");
		return $query->rowCount();
	}

	public function getUniqueCode($type, $table) { //create a string, and checks it doesn't exist in database

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
		$query = $this->handler->query("SELECT $type FROM $table WHERE $type = '$randomString'");
		
		while($query->rowCount() == 0) {
			return $randomString;
		}

	}

	public function incrementViews($stub){
		$query = $this->handler->query("SELECT views FROM links WHERE stubId = '$stub->stubId'");
		$r = $query->fetch(PDO::FETCH_OBJ);
		$newViews = $r->views + 1;		
		$sql = "UPDATE links SET views = ? WHERE stubId = ?";
		$query = $this->handler->prepare($sql);
		$query->execute(array($newViews,$stub->stubId));
	}

	public function deleteStub($stubId) {
		try{
			$sql = "DELETE FROM links WHERE stubId = ?";
			$query = $this->handler->prepare($sql);
			$query->execute(array($stubId));
			
		}catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getRecentStubs($table, $n){
		$query = $this->handler->query("SELECT * FROM $table ORDER BY datesubmitted LIMIT $n");

		while ($r = $query->fetchAll(PDO::FETCH_ASSOC)) {
			
			$stubs = array();
			foreach($r as $stub){
				array_push($stubs, new Stub($stub));
			}		
			
			return $stubs;
		}
	}
	
	public function login($email, $password) {
		// Validate before login                  		
		$query = $this->handler->query("SELECT * FROM users WHERE email = '$email'");
		if($query->rowCount() == 1) { // check user exists
			// Success user exists, is password ok?
			if($r->accessLevel != "unverified"){
			
				$r = $query->fetch(PDO::FETCH_OBJ);
				if($r->password == md5($password)) { 
					//password ok
					
					if($r->password == md5($password)) { 
						//great let's start the session
						$sql = "UPDATE users SET lastLogin = NOW() AND secretCode = ? WHERE email = ?";
						$query = $this->handler->prepare($sql);
						$secretCode = md5(date('Y-m-d H:i:s')).md5($email);
						$query->execute(array($secretCode, $this->email));
						
						session_start();
						$_SESSION['name'] = $r->firstName." ".$r->surname;
						$_SESSION['secretCode'] = $secretCode;
					}
				} else {
					//password fail
					die("This user exists but you got the wrong password!");
				}
				
			} else {
				die("You need to verify your account, please check you email for a verification link.");
			}


		} else { // user doesn't exist
			die("This user doesn't exist!");
		}
	}
	
	public function registerUser($user, $password) {
		// validate email, orcid and password before it comes here
		$sql = "INSERT INTO user (email, lastLogin, password, deepLink, firstName, surname, orcid, accessLevel) 
		 VALUES (:email, NOW(), :password, :deepLink, :firstName, :surname,  :orcid, :accessLevel)";

		$query = $this->handler->prepare($sql);
		$query->execute(array(
			':email' 	=> $user->email,
			':password'	=> md5($password),
			':deepLink'	=> $this->handler->getUniqueCode('deepLink', 'users'),
			':firstName' 	=> $user->firstName, // need to make this work = ORCID CLASS?
			':surname'	=> $user->surname, // need to make this work = ORCID CLASS?
			':orcid'	=> $user->orcid,
			':accessLevel'	=> 'user',
		));	
		
	}
	
	public function getUser($secretCode) {
		$query = $this->handler->query("SELECT * FROM users WHERE secretCode = '$secretCode'");
		$r = $query->fetch(PDO::FETCH_OBJ);
		return $r;
	}
}


?>
