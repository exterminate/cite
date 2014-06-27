<?php
class DB {
	private $rootURL = "http://localhost/git/cite/";
	private $handler;
	public function __construct($handler) { 
		$this->handler = $handler;
	}	

	public function put($table, $stub) { // use get_class_vars
		
		//delete next two lines if it works
		//$sql = "INSERT INTO links (stubId, stubTitle, firstName, surname, email, orcid, description, datesubmitted, stubTitle) 
		//VALUES (:stubId, :stubTitle, :firstName, :surname, :email, :orcid, :description, :datesubmitted, :stubTitle)";
		
		$stubClassVars = get_class_vars(get_class($stub));

		$sql = "INSERT INTO " . $table . "(";
		foreach($stubClassVars as $k=>$field) 
			$sql .= $k .= ",";
		// remove trainling comma
		$sql = rtrim($sql,",");
		$sql .= ") VALUES (";
		foreach($stubClassVars as $k=>$field) 
			$sql .= ":" . $k . ",";
		// remove trainling comma
		$sql = rtrim($sql,",");	
		$sql .= ")";
		$query = $this->handler->prepare($sql);
		$execArray = array();
		foreach($stubClassVars as $k=>$field) {
			if(is_array($stub->$k))
				$stub->$k = serialize($stub->$k);
			$execArray[':'.$k] = $stub->$k;
		}

		$query->execute($execArray);
		
		/* old
		$query->execute(array(
			':stubId' 	=> $stub->stubId,
			':stubTitle'	=> $stub->stubTitle,
			':firstName' 	=> $stub->firstName,
			':surname' 	=> $stub->surname,
			':email' 	=> $stub->email,
			':orcid'	=> $stub->orcid,
			':description' 	=> $stub->description,
			':datesubmitted'=> $stub->datesubmitted
		));*/	
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
		
		//interestedEmails is an array so we need to turn it into a string first
		if($field = "interestedEmails"){
			$stub->interestedEmails = serialize($stub->interestedEmails);
		}
		$query->execute(array($stub->$field,$stub->stubId));
	}
	
	public function updateNew($table, $field1, $input1, $field2, $input2) {
		
		$sql = "UPDATE $table SET $field1 = ? WHERE $field2 = ?";
		$query = $this->handler->prepare($sql);
		$query->execute(array($input1,$input2));		
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
			$r = $query->fetch(PDO::FETCH_OBJ);
			if($r->accessLevel != "unverified"){
			
				if($r->password == md5($password)) { 
					//password ok
					
					if($r->password == md5($password)) { 
						//great let's start the session
						$sql = "UPDATE users SET lastLogin = NOW() AND secretCode = ? WHERE email = ?";
						$query = $this->handler->prepare($sql);
						$secretCode = md5(date('Y-m-d H:i:s')).md5($email);
						$query->execute(array($secretCode, $email));
						
						//session_start();
						$_SESSION['name'] = $r->firstName." ".$r->surname;
						$_SESSION['secretCode'] = $secretCode;
						$_SESSION['email'] = $email;
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
		if($this->getUser('email', $user->email) == null){
			// validate email, orcid and password before it comes here
			$sql = "INSERT INTO users (email, lastLogin, password, deepLink, firstName, surname, orcid, accessLevel) 
			 VALUES (:email, NOW(), :password, :deepLink, :firstName, :surname,  :orcid, :accessLevel)";
	
			$query = $this->handler->prepare($sql);
			$uniqueCode = $this->getUniqueCode('deepLink', 'users');
			
			$query->execute(array(
				':email' 	=> $user->email,
				':password'	=> md5($password),
				':deepLink'	=> $uniqueCode,
				':firstName' 	=> $user->firstName, // need to make this work = ORCID CLASS?
				':surname'	=> $user->surname, // need to make this work = ORCID CLASS?
				':orcid'	=> $user->orcid,
				':accessLevel'	=> 'unverified',
			));
			
			// if ok, send email with deep link
			$emailHandler = new EmailHandler();
			$emailHandler->sendEmail(
			$user->email,
			"Thank you for registering with Cite",
			"Thank you for registering with Cite\n\nPlease click on the link below to verify your account\n\n".$this->rootURL."verification.php?dl=".$uniqueCode."&em=".$user->email."\n\nYou can then submit a stub."
			);
		} else {
			die("A user with this email address already exists.");
		}
	}
	
	public function getUser($field, $search) {
		$query = $this->handler->query("SELECT * FROM users WHERE $field = '$search'");		
		$r = $query->fetch(PDO::FETCH_OBJ);
		return $r;

		$user = new User(
				$r->firstName,
				$r->surname,
				$r->orcid,
				$r->accessLevel,
				$r->email
				 );
		return $user;

	}
	
	public function verifyUser($email, $deepLink) {
		$user = $this->getUser('email', $email);
		if($user != null){
			if($user->deepLink == $deepLink) {
				if($user->accessLevel != 'user') {
					$sql = "UPDATE users SET lastLogin = NOW(), secretCode = ?, accessLevel = ? WHERE email = ?";
					$query = $this->handler->prepare($sql);
					$secretCode = md5(date('Y-m-d H:i:s')).md5($email);
					$query->execute(array($secretCode, 'user', $email));
					$_SESSION['name'] = $user->firstName." ".$user->surname;
					$_SESSION['secretCode'] = $secretCode;
					$_SESSION['email'] = $user->email;
				} else {
					die("You have already validated this account");
				}
			} else {
				die("I'm afraid your details don't match with out records. Please check the URL we sent you.");
			}
		} else {
			die("This user does not exist.");
		}
	}
}



?>
