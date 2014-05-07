<?php

class User {

	public function __construct($handler, $user, $password) {
		$this->handler = $handler;
		$this->user = $user;
		$this->password = md5($password);
	}

	public function login() {
		$query = $this->handler->query("SELECT * FROM users WHERE username = '$this->user'");
		if($query->rowCount() == 1) { // check user exists
			// Success user exists, is password ok?
			$r = $query->fetch(PDO::FETCH_OBJ);
			if($r->password == $this->password) { 
				//password ok
				if($r->password.$r->clue == $this->password.md5($this->username) { 
					//great let's start the session
					$sql = "UPDATE users SET lastlogin = NOW() WHERE username = ?";
					$query = $this->handler->prepare($sql);
					$query->execute(array($this->username));
					session_start();
					$_SESSION['username'] = $this->username;
					return $_SESSION['username'];
				}
			} else {
				//password fail
				die("This user exists but you got the wrong password!");
			}


		} else { // user don't exist
			die("This user doesn't exist!");
		}
	}

}