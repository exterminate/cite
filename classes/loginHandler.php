<?php
class loginHandler {
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
		
	
}

?>
