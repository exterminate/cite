<?php

class User {
	
	public function __construct($handler) {
		$this->handler = $handler;
	}

	public function login($email, $password) {
		// Validate before login                  
		die("yay");
		$query = $this->handler->query("SELECT * FROM users WHERE email = '$email'");
		
		if($query->rowCount() == 1) { // check user exists
			// Success user exists, is password ok?
			$r = $query->fetch(PDO::FETCH_OBJ);
			if($r->password == md5($password)) { 
				//password ok
				
				if($r->password == md5($password)) { 
					//great let's start the session
					$sql = "UPDATE users SET lastLogin = NOW() WHERE email = ?";
					$query = $this->handler->prepare($sql);
					$query->execute(array($this->email));
					echo $r->firstName." ".$r->surname;
					session_start();
					$_SESSION['name'] = $r->firstName." ".$r->surname;
				}
			} else {
				//password fail
				die("This user exists but you got the wrong password!");
			}


		} else { // user doesn't exist
			die("This user doesn't exist!");
		}
	}
	
	public function register($orcid, $password, $email) {
		// validate email, orcid and password before it comes here
		$sql = "INSERT INTO user (email, lastLogin, password, deepLink, firstName, surname,  orcid) 
		 VALUES (:email, NOW(), :password, :deepLink, :firstName, :surname,  :orcid)";

		$query = $this->handler->prepare($sql);
		$query->execute(array(
			':email' 	=> $email,
			':password'	=> md5($password),
			':deepLink'	=> $this->handler->getUniqueCode('deepLink', 'users'),
			':firstName' 	=> $stub->firstName, // need to make this work = ORCID CLASS?
			':surname'	=> $stub->surname, // need to make this work = ORCID CLASS?
			':orcid'	=> $orcid
		));	
		
	}

	
}