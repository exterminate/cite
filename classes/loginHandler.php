<?php
class LoginHandler {
	
	//these are useless
	public $sessionName, $sessionSecretCode, $sessionEmail;
	
	public function login($email, $password, $dbHandler) {
		// Validate before login                  		
		$user = $dbHandler->getUser('email', $email);
		if($dbHandler->count('users', 'email', '=', $email) == 1) { // check user exists
			// Success user exists, is password ok?
			if($user->password == md5($password)) {
				// has the user verified their account?
				if($user->accessLevel != "unverified"){
					// let's add the time they last logged in i.e., now
					$dbHandler->updateNew('users', 'lastLogin', date('Y-m-d H:i:s'), 'email', $email); //check lastLoning camel case
					
					// ok, let's start a session
					$_SESSION['name'] = $user->firstName." ".$user->surname;
					$this->sessionName = $_SESSION['name'];
					$_SESSION['secretCode'] = md5(date('Y-m-d H:i:s')).md5($email);
					$this->sessionSecretCode = $_SESSION['secretCode'];
					$_SESSION['email'] = $email;
					$this->sessionEmail = $_SESSION['email'];
				} else {
					$_SESSION['error'] = "You need to verify your account, please check you email for a verification link.";
				}
			} else {
				//password fail
				$_SESSION['error'] = "This user exists but you got the wrong password!";
			}
		} else { // user doesn't exist
			$_SESSION['error'] = "This user doesn't exist!";
		}
		
	}
	
	public function isLoggedIn() {
		// we need to have these as sessions otherwise when you go to another page it unsets the variables we create on line 4
		if(isset($_SESSION['name']) && isset($_SESSION['secretCode']) && isset($_SESSION['email']))
			return True;
		else
			return False;
	}
	
	public function logOut($rootURL) {
		unset($this->sessionName);
		unset($this->sessionSecretCode);
		unset($this->sessionEmail);
		session_destroy();
		header("Location: ". $rootURL);
		exit();
	}
	
	
}

?>
